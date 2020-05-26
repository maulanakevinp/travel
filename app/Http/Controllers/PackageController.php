<?php

namespace App\Http\Controllers;

use App\Category;
use App\Package;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::orderBy('id', 'desc')->paginate(9);
        return view('package.index', compact('packages'));
    }

    public function category(Category $category, $slug)
    {
        if ($slug == Str::slug($category->name)) {
            $packages = Package::whereCategoryId($category->id)->orderBy('id', 'desc')->paginate(9);
            return view('package.category', compact('category','packages'));
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
        return view('package.create');
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
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package, $slug)
    {
        $packages = Package::whereCategoryId($package->category_id)->orderBy('id','desc')->paginate(3);
        if (Str::slug($package->name) == $slug) {
            return view('package.show', compact('package','packages'));
        }
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        return view('package.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        foreach ($package->galleries as $gallery) {
            File::delete(storage_path('app/'.$gallery->image));
        }
        $package->delete();
        alert()->success('Paket wisata '. $package->name .' berhasil dihapus', 'Berhasil');
        return redirect()->back();
    }
}
