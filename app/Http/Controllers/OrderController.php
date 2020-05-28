<?php

namespace App\Http\Controllers;

use App\Company;
use App\Helpers\Ipaymu;
use App\Order;
use App\Tour;
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
            'tanggal_berangkat' => ['required', 'date', 'after:now'],
            'tanggal_pulang'    => ['required', 'date', 'after:tanggal_berangkat'],
            'quantity'          => ['required', 'numeric', 'min:1'],
            'paymentMethod'     => ['required', 'string', 'max:4'],
            'paymentChannel'    => ['required', 'string', 'max:8'],
            'asal'              => ['required', 'string'],
        ]);

        $this->ipaymu->setBuyer([
            'name'      => auth()->user()->name,
            'phone'     => auth()->user()->phone,
            'email'     => auth()->user()->email
        ]);

        $this->ipaymu->setCart([
            'amount'            => $tour->price * $request->quantity,
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
            'total'             => $tour->price * $request->quantity,
            'payment_no'        => $ipaymu['Data']['PaymentNo'],
            'expired'           => $ipaymu['Data']['Expired'],
            'status'            => 'Pending',
            'qty'               => $request->quantity,
            'asal'              => $request->asal,
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
        return view('order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
