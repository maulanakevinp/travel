@extends('layouts.app')
@section('title', $user->name)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3 text-center">
            <div class="card shadow mt-5 bg-dark">
                <div class="card-body">
                    <div class="img-thumbnail mb-3">
                        <a href="#displayImageModal" data-toggle="modal">
                            <img id="img-avatar" class="mw-100" src="{{ asset(Storage::url($user->avatar)) }}"
                                alt="">
                        </a>
                        @auth
                            @if($user->id == auth()->user()->id)
                                <button id="btn-ganti-avatar" title="Ganti foto" class="btn btn-dark" style="position: absolute; right: 25px; top: 25px">
                                    <i class="fas fa-camera"></i>
                                </button>
                            @endif
                        @endauth
                    </div>
                    <h5 class="font-weight-bold">{{ $user->name }}</h5>
                    <a href="mailto:{{ $user->email }}" class="">{{ $user->email }}</a>
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
                                    <input id="nama" type="text" class="form-control" value="{{ $user->name }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="nohp" class="col-md-3 col-form-label pr-0">No. Hp :</label>
                                <div class="col-md-9">
                                    <input id="nohp" type="text" class="form-control" value="{{ $user->phone }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row mb-2">
                                <label for="alamat" class="col-md-3 col-form-label pr-0">Alamat :</label>
                                <div class="col-md-9">
                                    <textarea name="alamat" id="alamat" class="form-control" rows="3" disabled style="resize: none">{{ $user->address }}</textarea>
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

<div class="modal fade" id="displayImageModal" tabindex="-1" role="dialog" aria-labelledby="displayImageModalLabel" aria-hidden="true">
    <button type="button" class="close mr-3" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true" class="text-white h1">&times;</span>
    </button>
    <div class="modal-dialog modal-lg" role="document" style="">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img class="mw-100" id="imageDisplay" src="">
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $("#img-avatar").on('click', function () {
                $("#imageDisplay").attr('src', $("#img-avatar").attr('src'));
            });

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
