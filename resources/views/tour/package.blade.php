@extends('layouts.app')
@section('title',$package->name)

@section('styles')
    <link rel="stylesheet" href="{{ asset("css/News-Cards.css") }}">
    <link rel="stylesheet" href="{{ asset("css/mystyle.css") }}">
@endsection

@section('content')
<div class="container">
    <h1 class="font-weight-bold">{{ $package->name }}</h1>
    <div class="card-columns">
        @foreach ($tours as $tour)
            <a title="Detail" class="card-link" href="{{ route('tour.show',['tour' => $tour , 'slug' => Str::slug($tour->name)]) }}">
                <div class="card shadow mt-3 bg-dark ">
                    <img class="card-img-top w-100 d-block" src="{{asset(Storage::url($tour->galleries[0]->image))}}">
                    <div class="card-body text-white">
                        <h4 class="card-title block-with-text font-weight-bold" style="height: 40px">
                            {{$tour->name}}
                        </h4>
                        <div class="card-text block-with-text" style="height: 50px">{!! $tour->description !!}</div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    {{ $tours->links() }}
</div>
@endsection
