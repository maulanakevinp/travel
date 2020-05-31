@extends('layouts.app')
@section('title','Checkout')

@section('content')
<div class="container">
    <form action="{{ route('order.store',$tour) }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-8 mb-3">
                <h1 class="font-weight-bold h3">Checkout</h1>
                @include('layouts.components.alert')
                <div class="card bg-dark shadow">
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="media">
                                <div class="mr-3"
                                    style="background-size: cover ;height: 64px; width: 64px;background-image: url('{{ asset(Storage::url($tour->galleries[0]->image)) }}')">
                                </div>
                                <div class="media-body">
                                    <h5 class="mt-0 mb-1">{{ $tour->name }}</h5>
                                    <h6 class="mt-0 mb-1">Harga : Rp. {{ substr(number_format($tour->price, 2, ',', '.'),0,-3) }}</h6>
                                    <div class="block-with-text">
                                        {!! $tour->description !!}
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="tanggal_berangkat">Tanggal Berangkat</label>
                                    <input type="datetime-local" id="tanggal_berangkat" class="form-control" name="tanggal_berangkat" value="{{ old('tanggal_berangkat', date('Y-m-d\TH:i', strtotime("+1 day"))) }}" min="{{ date('Y-m-d\TH:i') }}">
                                    <span class="text-muted">bulan/tanggal/tahun, jam:menit waktu</span>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="tanggal_pulang">Tanggal Pulang</label>
                                    <input type="datetime-local" id="tanggal_pulang" class="form-control" name="tanggal_pulang" value="{{ old('tanggal_pulang', date('Y-m-d\TH:i', strtotime("+2 day"))) }}" min="{{ date('Y-m-d\TH:i', strtotime("+1 day")) }}">
                                    <span class="text-muted">bulan/tanggal/tahun, jam:menit waktu</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity', 1) }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="asal">Asal</label>
                            <input type="text" name="asal" id="asal" class="form-control" value="{{ old('asal') }}" placeholder="Tempat anda berasal">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" rows="3" style="resize: none" placeholder="Keterangan tambahan">{{ old('keterangan') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <h3 class="font-weight-bold">Metode Pembayaran</h3>
                <div class="accordion" id="metodePembayaran">
                    <div class="card bg-dark shadow">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button id="va" class="btn btn-link text-white btn-block text-left" type="button" data-toggle="collapse"
                                    data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Virtual Account
                                </button>
                            </h2>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                            data-parent="#metodePembayaran">
                            <div class="card-body">
                                <div class="custom-control custom-radio mb-3">
                                    <input type="radio" id="paymentChannel1" name="paymentChannel" class="custom-control-input" checked="true" value="bni">
                                    <label class="custom-control-label" for="paymentChannel1"><img src="{{ asset('images/bni.png') }}" height="40px"></label>
                                </div>
                                <div class="custom-control custom-radio mb-3">
                                    <input type="radio" id="paymentChannel2" name="paymentChannel" class="custom-control-input" value="mandiri">
                                    <label class="custom-control-label" for="paymentChannel2"><img src="{{ asset('images/mandiri.png') }}" height="40px"></label>
                                </div>
                                <div class="custom-control custom-radio mb-3">
                                    <input type="radio" id="paymentChannel3" name="paymentChannel" class="custom-control-input" value="cimb">
                                    <label class="custom-control-label" for="paymentChannel3"><img src="{{ asset('images/cimb.png') }}" height="40px"></label>
                                </div>
                                <div class="custom-control custom-radio mb-3">
                                    <input type="radio" id="paymentChannel4" name="paymentChannel" class="custom-control-input" value="bag">
                                    <label class="custom-control-label" for="paymentChannel4"><img src="{{ asset('images/bag.png') }}" height="40px"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-dark shadow">
                        <div class="card-header" id="headingTwo">
                            <h2 class="mb-0">
                                <button id="qris" class="btn btn-link text-white btn-block text-left collapsed" type="button"
                                    data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                    aria-controls="collapseTwo">
                                    QRIS
                                </button>
                            </h2>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#metodePembayaran">
                            <div class="card-body">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="paymentChannel5" name="paymentChannel" class="custom-control-input" value="linkaja">
                                    <label class="custom-control-label" for="paymentChannel5"><img src="{{ asset('images/qris.png') }}" height="40px"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="text" name="paymentMethod" id="paymentMethod" style="display: none" value="va">
                <div class="card shadow bg-dark mt-3">
                    <div class="card-body">
                        <h4>Total : Rp. <span id="total">{{ $tour->price }}</span></h4>
                        <button class="btn btn-primary btn-block mt-3" type="submit">Bayar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    let days = 1;
    const price = parseInt($("#total").html());
    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
    }

    $(document).ready(function(){
        $("input:radio[name='paymentChannel']").change(function(){
            if ($(this).val() == 'bni' || $(this).val() == 'mandiri' || $(this).val() == 'cimb' || $(this).val() == 'bag') {
                $("#paymentMethod").val('va');
            } else {
                $("#paymentMethod").val('qris');
            }
        });

        $("#quantity").change(function(){
            if(this.value < 1){
                this.value = 1;
            }
            days = Math.ceil(Math.abs(new Date($("#tanggal_berangkat").val()) - new Date($("#tanggal_pulang").val())) / (1000 * 60 * 60 * 24));
            if (isNaN(days)) {
                days = 1;
            }
            $("#total").html(formatNumber($("#quantity").val() * price * days));
        });

        $("#tanggal_berangkat").change(function(){
            days = Math.ceil(Math.abs(new Date($("#tanggal_berangkat").val()) - new Date($("#tanggal_pulang").val())) / (1000 * 60 * 60 * 24));
            if (isNaN(days)) {
                days = 1;
            }
            $("#total").html(formatNumber($("#quantity").val() * price * days));
        });

        $("#tanggal_pulang").change(function(){
            days = Math.ceil(Math.abs(new Date($("#tanggal_berangkat").val()) - new Date($("#tanggal_pulang").val())) / (1000 * 60 * 60 * 24));
            if (isNaN(days)) {
                days = 1;
            }
            $("#total").html(formatNumber($("#quantity").val() * price * days));
        });

    });
</script>
@endpush
