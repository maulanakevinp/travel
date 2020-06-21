<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
        $request->validate([
            'logo'              => ['nullable', 'image', 'max:2048'],
            'name'              => ['required', 'string', 'max:32'],
            'email'             => ['required', 'email', 'max:32'],
            'description'       => ['required', 'string'],
            'address'           => ['required', 'string'],
            'testimonial'       => ['required', 'string'],
            'phone'             => ['required', 'digits_between:6,13'],
            'whatsapp'          => ['required', 'digits_between:6,13'],
            'virtual_account'   => ['required', 'digits:16'],
            'api_key'           => ['required', 'string', 'max:64'],
            'latitude'          => ['required', 'numeric'],
            'longitude'         => ['required', 'numeric'],
        ]);

        if ($request->logo) {
            File::delete(storage_path('app/'. $company->logo));
            $company->logo = $request->logo->store('public/logo');
        }

        $company->name          = $request->name;
        $company->email         = $request->email;
        $company->description   = $request->description;
        $company->address       = $request->address;
        $company->testimonial   = $request->testimonial;
        $company->phone         = $request->phone;
        $company->whatsapp      = $request->whatsapp;
        $company->va            = $request->virtual_account;
        $company->latitude      = $request->latitude;
        $company->longitude     = $request->longitude;
        $company->api_key       = $request->api_key;
        $company->save();

        alert()->success(__('Company has been updated'), __('Success'));
        return redirect()->back();
    }
}
