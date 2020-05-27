@extends('layouts.app')
@section('title','Pesanan')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-9 mb-4 align-self-center">
            <h1>Transaksi</h1>
        </div>

        <div class="col-xl-3 mb-4">
            <div class="card border-left-primary shadow bg-dark py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Saldo</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $ipaymu->cekSaldo()['Saldo'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card"></div>

</div>
@endsection
