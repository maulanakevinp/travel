@extends('layouts.app')
@section('title',$package->name)

@section('styles')
<link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
<link rel="stylesheet" href="{{ asset("css/mystyle.css") }}">
<link rel="stylesheet" href="{{ asset('css/lightbox.css') }}">
@endsection

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-dark">
            <li class="breadcrumb-item"><a
                    href="{{ route('package.category',['category' => $package->category, 'slug' => Str::slug($package->category->name)]) }}">{{ $package->category->name }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $package->name }}</li>
        </ol>
    </nav>
    <div class="row mt-5">
        <div class="col-lg-8 mb-3">
            <div class="card bg-dark shadow">
                <div class="card-body">
                    <div class="owl-carousel">
                        @foreach($package->galleries as $gallery)
                            <a href="{{ asset(Storage::url($gallery->image)) }}" data-lightbox="gallery"
                                data-title="{{ $package->name }}" @if($gallery->description)
                                data-alt="{{ $gallery->description }}" @endif>
                                <img src="{{ asset(Storage::url($gallery->image)) }}" class="mw-100"
                                    alt="Gambar {{ $package->name }} {{ $gallery->id }}">
                            </a>
                        @endforeach
                    </div>
                    <h1 class="font-weight-bold text-center my-3">{{ $package->name }}</h1>
                    <div id="description">
                        {!! $package->description !!}
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-4 mb-3">
            <div class="card bg-dark shadow mb-3">
                <div class="card-body">
                    <h4>Harga : Rp.
                        {{ substr(number_format($package->price, 2, ',', '.'),0,-3) }}
                    </h4>
                    <a href="{{ route('order.create',['package' => $package , 'slug' => Str::slug($package->name)]) }}" class="btn btn-success">Pesan Tiket</a>
                </div>
            </div>

            <div class="card bg-dark shadow mb-3">
                <div class="card-body">
                    <h4>Paket wisata lainnya</h4>
                    <ul class="list-unstyled">
                        @foreach($packages as $item)
                            @if($item->id != $package->id)
                                <hr>
                                <li class="media">
                                    <div class="mr-3"
                                        style="background-size: cover ;height: 64px; width: 64px;background-image: url('{{ asset(Storage::url($item->galleries[0]->image)) }}')">
                                    </div>
                                    <div class="media-body">
                                        <h5 class="mt-0 mb-1">{{ $item->name }}</h5>
                                        <div class="block-with-text">
                                            {!! $item->description !!}
                                        </div>
                                        <a href="{{ route('package.show',['package' => $item , 'slug' => Str::slug($item->name)]) }}"
                                            class="btn btn-sm btn-primary float-right">Lihat</a>
                                    </div>
                                </li>
                            @else
                                <h5 class="text-center mt-3">--- Paket tidak tersedia ---</h5>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/lightbox.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.owl-carousel').owlCarousel({
                loop: true,
                autoplay: true,
                autoplayTimeout: 2000,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }
                }
            });
        });

    </script>
@endpush
