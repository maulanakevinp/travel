<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\Package;
use App\Tour;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tours = Tour::orderBy('id', 'desc')->paginate(9);
        if ($request->key) {
            $tours = Tour::where('name','like','%'. $request->key . '%')
                            ->orderBy('id', 'desc')->paginate(9);
        }
        $packages = Package::all();
        $package = null;
        return view('tour.index', compact('package','tours','packages'));
    }

    public function package(Package $package, $slug)
    {
        $packages = Package::all();
        if ($slug == Str::slug($package->name)) {
            $tours = Tour::wherePackageId($package->id)->orderBy('id', 'desc')->paginate(9);
            return view('tour.index', compact('package','tours','packages'));
        }

        return abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packages = Package::all();
        return view('tour.create', compact('packages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'package'       => ['required'],
            'name'          => ['required','string','max:64'],
            'price'         => ['required', 'numeric', 'min:1000'],
            'description'   => ['required'],
            'images.*'      => ['required','image','max:2048']
        ]);

        $tour = Tour::create([
            'package_id'    => $request->package,
            'name'          => $request->name,
            'price'         => $request->price,
            'description'   => $request->description
        ]);

        $images = $request->file('images');
        foreach ($images as $image) {
            if ($image) {
                Gallery::create([
                    'image' => $image->store('public/gallery'),
                    'tour_id' => $tour->id
                ]);
            }
        }

        alert()->success(__('alert.success-create',['attribute' => 'Tour']), __('Success'));
        return redirect()->route('tour.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tour  $tour
     * @return \Illuminate\Http\Response
     */
    public function show(Tour $tour, $slug)
    {
        $tours = Tour::wherePackageId($tour->package_id)->orderBy('id','desc')->take(3);
        if (Str::slug($tour->name) == $slug) {
            return view('tour.show', compact('tour','tours'));
        }

        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tour  $tour
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Tour $tour)
    {
        $packages = Package::all();
        return view('tour.edit', compact('tour','packages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tour  $tour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tour $tour)
    {
        if($request->ajax()){
            $validator = Validator::make($request->all(),[
                'image' => ['required', 'image', 'max:2048']
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success'   => false,
                    'message'   => $validator->errors()->all()
                ]);
            }

            $data = [
                'tour_id'       => $tour->id,
                'is_portofolio' => $request->is_portofolio,
                'image'         => $request->image->store('public/gallery')
            ];

            Gallery::create($data);

            return response()->json([
                'success'   => true,
                'message'   => __('alert.success-create', ['attribute' => 'Image'])
            ]);
        }

        $data = $request->validate([
            'package_id'    => ['required'],
            'name'          => ['required','string','max:64', Rule::unique('tours','name')->ignore($tour)],
            'price'         => ['required', 'numeric', 'min:1000'],
            'description'   => ['required'],
        ]);

        $tour->update($data);
        alert()->success(__('alert.success-update', ['attribute' => 'Tour']), __('Success'));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tour  $tour
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tour $tour)
    {
        foreach ($tour->galleries as $gallery) {
            File::delete(storage_path('app/'.$gallery->image));
        }
        $tour->delete();
        alert()->success(__('alert.success-delete',['attribute' => $tour->name]), __('Success'));
        return redirect()->back();
    }
}
