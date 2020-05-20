<?php

use App\Helpers\Ipaymu;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('pembayaran');
});

Route::get('/cek', function (){
    // $ipaymu = Ipaymu::paymentDirect(
    //     'tes',
    //     'tes@gmail.com',
    //     '089089078907',
    //     '12588',
    //     'va',
    //     'mandiri',
    //     '1 paket wisata rembangan'
    // );
    return Ipaymu::checkTransaction('851420');
});

Route::post('/notify', function(Request $request){
    return response()->json([
        'TransactionID' => $request->trx_id,
        'RefereceID'    => $request->reference_id,
        'status'        => $request->status,
        'SessionID'     => $request->sid
    ]);
});
