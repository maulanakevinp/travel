@extends('layouts.app')
@section('title',__('Transaction detail').' #'.$order->transaction_id)

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
                                <a href="{{ route('tour.show',['tour' => $order->tour , 'slug' => Str::slug($order->tour->name)]) }}" class="mt-0 mb-1 block-with-text h5 text-white font-weight-bold">{{ $order->tour->name }}</a>
                                <h6 class="mt-0 mb-1">{{ __('Price') }} : Rp. {{ substr(number_format($order->tour->price, 2, ',', '.'),0,-3) }}</h6>
                            </div>
                        </li>
                    </ul>
                    <div class="row">
                        <div class="col-md-5 mb-2">
                            <div class="form-group">
                                <label for="date_start">{{ __('Date Start')}}</label>
                                <input disabled type="text" id="date_start" class="form-control" name="date_start" value="{{ date('d F Y H:i:s', strtotime($order->date_start)) }}">
                            </div>
                        </div>
                        <div class="col-md-5 mb-2">
                            <div class="form-group">
                                <label for="date_end">{{ __('Date End') }}</label>
                                <input disabled type="text" id="date_end" class="form-control" name="date_end" value="{{ date('d F Y H:i:s', strtotime($order->date_end)) }}">
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="form-group">
                                <label for="quantity">{{ __('Quantity')}}</label>
                                <input disabled type="number" name="quantity" id="quantity" class="form-control" value="{{ $order->qty }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hometown">{{ __('Hometown') }}</label>
                        <input disabled type="text" name="hometown" id="hometown" class="form-control" value="{{ $order->hometown }}">
                    </div>
                    <div class="form-group">
                        <label for="note">{{ __('Note') }}</label>
                        <textarea name="note" id="note" class="form-control" rows="3" style="resize: none" disabled>{{ $order->note }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow bg-dark">
                <div class="card-body text-center">
                    <h4>{{ __('Payment Method') }}</h4>
                    @if ($order->via == 'qris')
                        <input id="qr" type="text" value="{{ $order->payment_no }}" style="display: none">
                        <p>{{ __('Please make payment via QRIS') }}:</p>
                        <img src="{{ asset('images/qris.png') }}" height="30px">
                        <div class="py-3 my-3" style="background-color: white">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g id="qrcode"/>
                            </svg>
                        </div>
                    @else
                        <p>{{ __('Please make payments through a virtual account') }}:</p>
                        <img src="{{ asset('images/'.$order->channel.'.png') }}" height="30px">
                        <p>{{ __('Payment Code') }}<br><h4 id="kode">{{ $order->payment_no }}</h4></p>
                    @endif
                    <p>{{ __('Nominal') }}<br><h4>Rp. {{ substr(number_format($order->amount, 2, ',', '.'),0,-3) }}</h4></p>
                    <p>{{ __('Deadline') }}<br>{{ date('d F Y, H:i:s', strtotime($order->expired)) }}</p>
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
