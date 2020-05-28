@extends('layouts.app')
@section('title','Daftar wisata')

@section('styles')
    <link rel="stylesheet" href="{{ asset("css/News-Cards.css") }}">
    <link rel="stylesheet" href="{{ asset("css/mystyle.css") }}">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 mb-3">
            <h1 class="font-weight-bold">Daftar Wisata</h1>
        </div>
        <div class="col-md-4 mb-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Cari" aria-label="Cari" aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">Cari</button>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="dropdown">
                <button class="btn btn-secondary btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Pilih Paket
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @foreach ($packages as $package)
                        <a class="dropdown-item" href="{{ route('tour.package',['package' => $package, 'slug' => Str::slug($package->name)]) }}">{{ $package->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <a href="{{ route('tour.create') }}" class="btn btn-success btn-block">Tambah wisata</a>
        </div>
    </div>
    <div class="card-columns">
        @foreach ($tours as $tour)
            <div class="card shadow mt-3 bg-dark ">
                <img class="card-img-top w-100 d-block" src="{{asset(Storage::url($tour->galleries[0]->image))}}">
                <div class="card-body">
                    <h4 class="card-title block-with-text font-weight-bold" style="height: 40px">
                        {{$tour->name}}
                    </h4>
                    <div class="card-text block-with-text" style="height: 50px">{{ $tour->description }}</div>
                    <div class="float-right mb-3">
                        <a title="Detail" class="btn btn-sm btn-info" href="{{ route('tour.show',['tour' => $tour , 'slug' => Str::slug($tour->name)]) }}"><i class="fas fa-eye"></i></a>
                        <a title="Ubah" class="btn btn-sm btn-success" href="{{ route('tour.edit',$tour) }}"><i class="fas fa-edit"></i></a>
                        <a title="Hapus" class="btn btn-sm btn-danger" href="{{ route('tour.destroy',$tour) }}"><i class="fas fa-trash"></i></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $tours->links() }}
</div>
@endsection
