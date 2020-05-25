@extends('layouts.app')
@section('title', 'Pengaturan')

@section('content')
    <div class="container mt-5">
        @include('layouts.components.alert')
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow bg-dark">
                    <div class="card-body">
                        <h4 class="text-center font-weight-bold">Pengaturan</h4>
                        <hr>
                        <form autocomplete="off" action="{{ route('update-pengaturan') }}" method="post">
                            @csrf @method('patch')
                            <h6 class="heading-small mb-4">Ubah Alamat Email</h6>
                            <div class="pl-lg-4">
                                <p class="mb-3" style="font-size: 12px;">Biarkan kosong jika tidak ingin mengubah email.</p>
                                <div class="form-group">
                                    <label class="form-control-label" for="email_lama">Email Lama</label>
                                    <input readonly class="form-control" type="email" value="{{ auth()->user()->email }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="email_baru">Email Baru</label>
                                    <p class="mb-3 text-sm" style="font-size: 12px;"><em>Agar dapat menerima email konfirmasi, harap masukkan alamat email yang aktif.</em></p>
                                    <input class="form-control" type="email" name="email" id="email" placeholder="Masukkan alamat email baru ..." value="{{ old('email') }}">
                                </div>
                            </div>
                            <hr>
                            <h6 class="heading-small mb-4">Ubah Password</h6>
                            <div class="pl-lg-4">
                                <p class="mb-3" style="font-size: 12px;">Biarkan kosong jika tidak ingin mengubah Password.</p>
                                <div class="form-group">
                                    <label class="form-control-label" for="password">Password Baru</label>
                                    <input class="form-control" type="password" name="password" id="password" placeholder="Masukkan password baru" value="{{ old('password') }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="password_confirmation">Konfirmasi Password Baru</label>
                                    <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Masukkan password baru" value="{{ old('password_confirmation') }}">
                                </div>
                            </div>
                            <div class="form-group mt-5">
                                <label class="form-control-label" for="password_lama">Password <span class="text-danger">*</span></label>
                                <input required class="form-control" type="password" name="password_lama" id="password_lama" placeholder="Masukkan password">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">PERBARUI</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
