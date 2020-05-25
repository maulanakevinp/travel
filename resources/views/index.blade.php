@extends('layouts.app')
@section('title','Home')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
<link href="{{ asset('css/Testimonials.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
<style>

    .wisata:hover {
        color: white;
        background-color: gray;
    }

</style>
@endsection

@section('content')
<div class="container">
    <div id="slider" class="carousel slide shadow" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#slider" data-slide-to="0" class="active"></li>
            <li data-target="#slider" data-slide-to="1"></li>
            <li data-target="#slider" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset(Storage::url($company->galleries[0]->image)) }}" class="d-block w-100"
                    alt="{{ $company->galleries[0]->description }}">
                @if($company->galleries[0]->description)
                    <div class="carousel-caption d-none d-md-block">
                        <p>{{ $company->galleries[0]->description }}</p>
                    </div>
                @endif
            </div>
            @for($i = 1; $i < count($company->galleries); $i++)
                <div class="carousel-item">
                    <img src="{{ asset(Storage::url($company->galleries[$i]->image)) }}"
                        class="d-block w-100" alt="{{ $company->galleries[$i]->description }}">
                    @if($company->galleries[$i]->description)
                        <div class="carousel-caption d-none d-md-block">
                            <p>{{ $company->galleries[$i]->description }}</p>
                        </div>
                    @endif
                </div>
            @endfor
        </div>
        <a class="carousel-control-prev" href="#slider" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#slider" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <section id="tentang-kami" class="mt-5">
        <div class="card bg-dark shadow p-5">
            <div class="card-body">
                <h2 class="text-center font-weight-bold mb-5">Tentang Kami</h2>
                <div class="container px-xl-5">
                    <p class="mt-3 text-center px-xl-5">
                        {{ $company->description }}
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section id="paket-wisata" class="mt-5">
        <div class="card bg-dark shadow p-5">
            <div class="card-body">
                <h2 class="text-center font-weight-bold mb-5">Paket Wisata</h2>
                <div class="row  justify-content-center">
                    @foreach($categories as $category)
                        <div class="col-lg-4 mb-3">
                            <a href="{{ url('/') }}" class="card-link">
                                <div class="card wisata">
                                    <div class="card-body text-center">
                                        <h3 class="mb-0">{{ $category->name }}</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @if($testimonies->count() > 2)
        <section id="testimoni" class="mt-5 people">
            <div class="pt-5">
                <h2 class="text-center font-weight-bold text-white mb-5 mt-3">Testimoni</h2>
                <div class="owl-carousel">
                    @foreach($testimonies as $testimony)
                        <div class="card bg-dark shadow testimonials-clean">
                            <div class="card-body">
                                <div class="item mb-0">
                                    <div class="box">
                                        @if($testimony->rating == 1)
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star.svg')) }}">
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star-empty.svg')) }}">
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star-empty.svg')) }}">
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star-empty.svg')) }}">
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star-empty.svg')) }}">
                                        @elseif($testimony->rating == 2)
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star.svg')) }}">
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star.svg')) }}">
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star-empty.svg')) }}">
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star-empty.svg')) }}">
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star-empty.svg')) }}">
                                        @elseif($testimony->rating == 3)
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star.svg')) }}">
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star.svg')) }}">
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star.svg')) }}">
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star-empty.svg')) }}">
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star-empty.svg')) }}">
                                        @elseif($testimony->rating == 4)
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star.svg')) }}">
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star.svg')) }}">
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star.svg')) }}">
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star.svg')) }}">
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star-empty.svg')) }}">
                                        @elseif($testimony->rating == 5)
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star.svg')) }}">
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star.svg')) }}">
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star.svg')) }}">
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star.svg')) }}">
                                            <img height="20px" class="mr-0" src="{{ asset(Storage::url('star.svg')) }}">
                                        @endif
                                        <br>
                                        <p class="description">{{ $testimony->testimoni }}</p>
                                    </div>
                                    <div class="author">
                                        <img class="rounded-circle" src="{{ asset(Storage::url($testimony->user->avatar)) }}">
                                        <h5 class="name text-white">{{ $testimony->user->name }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <section id="hubungi-kami" class="mt-5">
        <div class="pt-5">
            <h2 class="text-center font-weight-bold text-white mb-5 mt-3">Hubungi Kami</h2>
            <div class="row justify-content-center">
                <div class="col-md-4 mb-3">
                    <div class="card bg-dark shadow h-100 testimonials-clean">
                        <div class="card-body text-center text-white">
                            <h4>Alamat</h4>
                            <p class="text-white">{{ $company->address }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card bg-dark shadow h-100 testimonials-clean">
                        <div class="card-body text-center text-white">
                            <h4>Kontak</h4>
                            Telepon: <a href="tel:{{ $company->phone }}" class="text-white">{{ $company->phone }}</a><br>
                            Whatsapp: <a class="text-white" href="https://api.whatsapp.com/send?phone=62{{ substr($company->whatsapp,1) }}">{{ $company->whatsapp }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card bg-dark shadow h-100 testimonials-clean">
                        <div class="card-body text-center text-white">
                            <h4>Email</h4>
                            <a href="mailto{{ $company->email }}" class="text-white">{{ $company->email }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="mapid" style="width: 100%; height: 400px;" class="mt-5 shadow"></div>
        </div>
    </section>
</div>

@endsection

@push('scripts')
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
<script src="{{ asset('js/leaflet.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.owl-carousel').owlCarousel({
			loop: true,
            margin:10,
            responsive:{
				0:{
					items: 1
				},
				600:{
					items: 3
				},
				1000:{
					items: 3
				}
			}
        });
    });
</script>
@endpush
