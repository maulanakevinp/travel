<?php

namespace App\Http\Controllers;

use App\Package;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::all();
        return view('package.index', compact('packages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => ['required', 'unique:packages,name']
        ]);

        Package::create($data);

        alert()->success('Paket '.$request->name.' berhasil ditambahkan', 'Berhasil');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        return response()->json($package);
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
        $data = $request->validate([
            'name'  => ['required', Rule::unique('packages', 'name')->ignore($package->name),]
        ]);

        $package->update($data);
        alert()->success('Paket '.$package->name.' berhasil diperbarui', 'Berhasil');
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        $package->delete();
        alert()->success('Paket '.$package->name.' berhasil dihapus', 'Berhasil');
        return redirect()->back();
    }
}
