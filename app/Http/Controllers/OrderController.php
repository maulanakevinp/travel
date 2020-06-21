<?php

namespace App\Http\Controllers;

use App\Company;
use App\Helpers\Ipaymu;
use App\Order;
use App\Rules\Tanggal;
use App\Tour;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $ipaymu;
    public function __construct() {
        $company = Company::find(1);
        $this->ipaymu = new Ipaymu($company->api_key,$company->va);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ipaymu = $this->ipaymu;
        if (request()->ajax()) {
            if (auth()->user()->role->name == 'Admin') {
                return datatables()->of(Order::with('tour')->get())
                    ->addColumn('tour_name', function($data){
                        return '<a href="'.route('tour.show',['tour' => $data->tour , 'slug' => Str::slug($data->tour->name)]).'">'.$data->tour->name.'</a>';
                    })
                    ->addColumn('nominal', function($data){
                        return 'Rp. '.substr(number_format($data->amount, 2, ',', '.'),0,-3);
                    })
                    ->addColumn('expired', function($data){
                        return date('d F Y, H:i:s', strtotime($data->expired));
                    })
                    ->addColumn('action', function($data){
                        return '<a href="'. route('order.show', $data->id) .'" title="'. __('Detail') .'" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>';
                    })
                    ->rawColumns(['action','tour_name', 'nominal', 'expired'])
                    ->make(true);
            } else {
                return datatables()->of(Order::with('tour')->where('user_id', auth()->user()->id)->get())
                    ->addColumn('tour_name', function($data){
                        return '<a href="'.route('tour.show',['tour' => $data->tour , 'slug' => Str::slug($data->tour->name)]).'">'.$data->tour->name.'</a>';
                    })
                    ->addColumn('nominal', function($data){
                        return 'Rp. '.substr(number_format($data->amount, 2, ',', '.'),0,-3);
                    })
                    ->addColumn('expired', function($data){
                        return date('d F Y, H:i:s', strtotime($data->expired));
                    })
                    ->addColumn('action', function($data){
                        return '<a href="'. route('order.show', $data->id) .'" title="'. __('Detail') .'" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>';
                    })
                    ->rawColumns(['action','tour_name', 'nominal', 'expired'])
                    ->make(true);
            }

        }
        return view('order.index', compact('ipaymu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Tour $tour, $slug)
    {
        if ($slug != Str::slug($tour->name)) {
            return abort(404);
        }
        return view('order.create', compact('tour'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tour $tour)
    {
        $request->validate([
            'tanggal_berangkat' => ['required', 'date', 'after:now', new Tanggal($request->tanggal_berangkat, $request->tanggal_pulang)],
            'tanggal_pulang'    => ['required', 'date', 'after:tanggal_berangkat', new Tanggal($request->tanggal_berangkat, $request->tanggal_pulang)],
            'quantity'          => ['required', 'numeric', 'min:1'],
            'paymentMethod'     => ['required', 'string', 'max:4'],
            'paymentChannel'    => ['required', 'string', 'max:8'],
            'asal'              => ['required', 'string'],
            'keterangan'        => ['nullable', 'string'],
        ]);

        $amount = $tour->price * $request->quantity * Carbon::parse($request->tanggal_pulang)->diffInDays(Carbon::parse($request->tanggal_berangkat));
        $this->ipaymu->setBuyer([
            'name'      => auth()->user()->name,
            'phone'     => auth()->user()->phone,
            'email'     => auth()->user()->email
        ]);

        $this->ipaymu->setCart([
            'amount'            => $amount,
            'description'       => $request->quantity.' Tiket '.$tour->name,
            'paymentMethod'     => $request->paymentMethod,
            'paymentChannel'    => $request->paymentChannel,
            'referenceId'       => date('YmdHis')
        ]);

        $ipaymu = $this->ipaymu->checkout();
        $order = Order::create([
            'user_id'           => auth()->user()->id,
            'tour_id'           => $tour->id,
            'transaction_id'    => $ipaymu['Data']['TransactionId'],
            'via'               => $request->paymentMethod,
            'channel'           => $request->paymentChannel,
            'total'             => $amount,
            'payment_no'        => $ipaymu['Data']['PaymentNo'],
            'expired'           => $ipaymu['Data']['Expired'],
            'status'            => 'Pending',
            'qty'               => $request->quantity,
            'asal'              => $request->asal,
            'keterangan'        => $request->keterangan,
            'tanggal_berangkat' => date('Y-m-d H:i:s',strtotime($request->tanggal_berangkat)),
            'tanggal_pulang'    => date('Y-m-d H:i:s',strtotime($request->tanggal_pulang)),
        ]);

        return redirect()->route('order.show', ['order' => $order]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        if (auth()->user()->role->name == "Admin" || auth()->user()->id == $order->user_id) {
            return view('order.show', compact('order'));
        }

        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        if(request()->ajax()){
            $order->paymentTime = $request->paymentTime;
            $order->status = $request->status;
            $order->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        alert()->success(__('alert.success-delete', ['attribute' => 'Order']), __('Success'));
        return redirect()->route('order.index');
    }

    public function checkTransaction($id)
    {
        return $this->ipaymu->checkTransaction($id);
    }
}
