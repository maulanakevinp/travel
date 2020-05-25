<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = Company::find(1);
        return view('utility.company', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $validator = Validator::make($request->all(),[
            'logo'                  => ['nullable', 'image', 'max:2048'],
            'nama'                  => ['required', 'string', 'max:32'],
            'email'                 => ['required', 'email', 'max:32'],
            'deskripsi'             => ['required', 'string'],
            'alamat'                => ['required', 'string'],
            'testimonial'           => ['required', 'string'],
            'nomor_telepon'         => ['required', 'digits_between:6,13'],
            'nomor_whatsapp'        => ['required', 'digits_between:6,13'],
            'nomor_virtual_account' => ['required', 'digits:16'],
            'api_key'               => ['required', 'string', 'max:64'],
            'latitude'              => ['required', 'numeric'],
            'longitude'             => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'message'   => $validator->errors()->all(),
            ]);
        }

        if ($request->logo) {
            File::delete(storage_path('app/'. $company->logo));
            $company->logo = $request->logo->store('public/logo');
        }

        $company->name          = $request->nama;
        $company->email         = $request->email;
        $company->description   = $request->deskripsi;
        $company->address       = $request->alamat;
        $company->testimonial   = $request->testimonial;
        $company->phone         = $request->nomor_telepon;
        $company->whatsapp      = $request->nomor_whatsapp;
        $company->va            = $request->nomor_virtual_account;
        $company->latitude      = $request->latitude;
        $company->longitude     = $request->longitude;
        $company->api_key       = $request->api_key;
        $company->save();

        return response()->json([
            'success'   => true,
        ]);
    }
}
