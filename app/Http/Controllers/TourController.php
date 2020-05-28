<?php

namespace App\Http\Controllers;

use App\Package;
use App\Tour;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::all();
        $tours = Tour::orderBy('id', 'desc')->paginate(9);
        return view('tour.index', compact('tours','packages'));
    }

    public function package(Package $package, $slug)
    {
        if ($slug == Str::slug($package->name)) {
            $tours = Tour::wherePackageId($package->id)->orderBy('id', 'desc')->paginate(9);
            return view('tour.package', compact('package','tours'));
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
        return view('tour.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tour  $tour
     * @return \Illuminate\Http\Response
     */
    public function show(Tour $tour, $slug)
    {
        $tours = Tour::wherePackageId($tour->package_id)->orderBy('id','desc')->paginate(3);
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
    public function edit(Tour $tour)
    {
        return view('tour.edit', compact('tour'));
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
        //
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
        alert()->success('Wisata '. $tour->name .' berhasil dihapus', 'Berhasil');
        return redirect()->back();
    }
}
