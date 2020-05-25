@extends('layouts.app')
@section('title', auth()->user()->name)

@section('styles')
<link rel="stylesheet" href="{{ asset('css/lightbox.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3 text-center">
            <div class="card shadow mt-5 bg-dark">
                <div class="card-body">
                    <div class="img-thumbnail mb-3">
                        <a href="{{ asset(Storage::url(auth()->user()->avatar)) }}" data-lightbox="image-1" data-title="Foto Profil">
                            <img class="mw-100" src="{{ asset(Storage::url(auth()->user()->avatar)) }}" alt="">
                        </a>
                        <button id="btn-ganti-avatar" title="Ganti foto" class="btn btn-dark" style="position: absolute; right: 25px; top: 25px">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                    <h5 class="font-weight-bold">{{ auth()->user()->name }}</h5>
                    <a href="mailto:{{ auth()->user()->email }}" class="">{{ auth()->user()->email }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card shadow mt-5 bg-dark">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <h3>Profil</h3>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group row mb-2">
                                <label for="nama" class="col-md-3 col-form-label pr-0">Nama :</label>
                                <div class="col-md-9">
                                    <input id="nama" type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="nohp" class="col-md-3 col-form-label pr-0">No. Hp :</label>
                                <div class="col-md-9">
                                    <input id="nohp" type="text" class="form-control" value="{{ auth()->user()->phone }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row mb-2">
                                <label for="alamat" class="col-md-3 col-form-label pr-0">Alamat :</label>
                                <div class="col-md-9">
                                    <textarea name="alamat" id="alamat" class="form-control" rows="3" disabled style="resize: none">{{ auth()->user()->address }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('edit-profil') }}" class="btn btn-success mt-3 float-right"><i class="fas fa-edit"></i> Edit</a>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="file" name="avatar" id="input-avatar" style="display: none">
@endsection

@push('scripts')
<script src="{{ asset('js/lightbox.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#btn-ganti-avatar').on('click', function () {
                $('#input-avatar').click();
            });

            $('#input-avatar').on('change', function () {
                if (this.files && this.files[0]) {
                    let formData = new FormData();
                    let oFReader = new FileReader();
                    formData.append("avatar", this.files[0]);
                    formData.append("_token", _token);
                    oFReader.readAsDataURL(this.files[0]);

                    $.ajax({
                        url: baseURL + "/update-avatar",
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function () {
                            $('#img-avatar').attr('src', baseURL + '/storage/loading.gif');
                        },
                        success: function (data) {
                            if (data.error) {
                                swal({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: data.message,
                                });
                                let path = data.avatar;
                                if (path != 'noavatar.jpg') {
                                    path = path.replace('public', '/storage');
                                }
                                $('#img-avatar').attr('src', baseURL + path);
                            } else {
                                swal({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: data.message,
                                });
                                let path = data.avatar;
                                path = path.replace('public', '/storage');
                                $('#img-avatar').attr('src', baseURL + path);
                                $('#img-avatar-header').attr('src', baseURL + path);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
