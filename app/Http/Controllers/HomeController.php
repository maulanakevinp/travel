<?php

namespace App\Http\Controllers;

use App\Category;
use App\Company;
use App\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $testimonies = Order::whereRating(5)->get();
        $company = Company::find(1);
        return view('index',compact('categories', 'company', 'testimonies'))->with('alert', "success, Berhasil menambah kategori");
    }
}
