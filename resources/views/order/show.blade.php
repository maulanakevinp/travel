@extends('layouts.app')
@section('title','Detail transaksi #'.$order->transaction_id)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 mb-3">
            <div class="card bg-dark shadow">
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="media">
                            <div class="mr-3"
                                style="background-size: cover ;height: 64px; width: 64px;background-image: url('{{ asset(Storage::url($order->tour->galleries[0]->image)) }}')">
                            </div>
                            <div class="media-body">
                                <h5 class="mt-0 mb-1">{{ $order->tour->name }}</h5>
                                <h6 class="mt-0 mb-1">Harga : Rp. {{ substr(number_format($order->tour->price, 2, ',', '.'),0,-3) }}</h6>
                                <div class="block-with-text">
                                    {!! $order->tour->description !!}
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <div class="form-group">
                                <label for="tanggal_berangkat">Tanggal Berangkat</label>
                                <input disabled type="text" id="tanggal_berangkat" class="form-control" name="tanggal_berangkat" value="{{ date('d F Y H:i:s', strtotime($order->tanggal_berangkat)) }}">
                            </div>
                        </div>
                        <div class="col-md-5 mb-3">
                            <div class="form-group">
                                <label for="tanggal_pulang">Tanggal Pulang</label>
                                <input disabled type="text" id="tanggal_pulang" class="form-control" name="tanggal_pulang" value="{{ date('d F Y H:i:s', strtotime($order->tanggal_pulang)) }}">
                            </div>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input disabled type="number" name="quantity" id="quantity" class="form-control" value="{{ $order->qty }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="asal">Asal</label>
                        <input disabled type="text" name="asal" id="asal" class="form-control" value="{{ $order->asal }}" placeholder="Tempat anda berasal">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow bg-dark">
                <div class="card-body text-center">
                    <h4>Metode Pembayaran</h4>
                    @if ($order->via == 'qris')
                        <input id="qr" type="text" value="{{ $order->payment_no }}" style="display: none">
                        <p>Silahkan melakukan pembayaran melalui QRIS:</p>
                        <img src="{{ asset('images/qris.png') }}" height="30px">
                        <div class="py-3 my-3" style="background-color: white">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g id="qrcode"/>
                            </svg>
                        </div>
                    @else
                        <p>Silahkan melakukan pembayaran melalui virtual account:</p>
                        <img src="{{ asset('images/'.$order->channel.'.png') }}" height="30px">
                        <p>Kode pembayaran<br><h4 id="kode">{{ $order->payment_no }}</h4></p>
                    @endif
                    <p>Nominal<br><h4>Rp. {{ substr(number_format($order->total, 2, ',', '.'),0,-3) }}</h4></p>
                    <p>Batas waktu<br>{{ date('d/m/Y H:i:s', strtotime($order->expired)) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('js/qrcode.js') }}"></script>
    @if ($order->via == 'qris')
        <script type="text/javascript">
            const qrcode = new QRCode(document.getElementById('qrcode'),{
                useSVG: true
            });
            qrcode.makeCode($("#qr").val());
        </script>
    @endif
@endpush
