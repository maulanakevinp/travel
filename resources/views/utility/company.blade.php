@extends('layouts.app')
@section('title', 'Company')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>

    <style>
        #display-logo:hover{
            cursor: pointer;
            opacity: 0.5;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div id="alert">
        @include('layouts.components.alert')
    </div>
    <div class="card bg-dark">
        <div class="card-header">
            <h5 class="m-0 pt-1 font-weight-bold">Company</h5>
        </div>
        <div class="card-body">
            <form id="formCompany" method="post">
                @csrf @method('patch')
                <input type="hidden" name="id" value="{{ $company->id }}">
                <div class="row justify-content-center">
                    <div class="col-lg-4 mb-1">
                        <div class="form-group">
                            <label for="logo">logo</label><br>
                            <img title="ganti logo" onclick="document.getElementById('logo').click()" id="display-logo" src="{{ asset(Storage::url($company->logo)) }}" alt="{{ asset(Storage::url($company->logo)) }}" width="100px" height="100px">
                            <input type="file" name="logo" id="logo" style="display: none">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama perusahaan" value="{{ $company->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email perusahaan" value="{{ $company->email }}" required>
                        </div>
                        <div class="form-group">
                            <label for="nomor_telepon">Nomor Telepon</label>
                            <input onkeypress="return hanyaAngka(event)" type="text" name="nomor_telepon" id="nomor_telepon" class="form-control" placeholder="Masukkan nomor telepon perusahaan" value="{{ $company->phone }}" required>
                        </div>
                        <div class="form-group">
                            <label for="nomor_whatsapp">WhatsApp</label>
                            <input onkeypress="return hanyaAngka(event)" type="text" name="nomor_whatsapp" id="nomor_whatsapp" class="form-control" placeholder="Masukkan nomor WhatsApp perusahaan" value="{{ $company->whatsapp }}" required>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-1">
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea style="resize:none" class="form-control" name="alamat" id="alamat" rows="3"  placeholder="Masukkan alamat perusahaan" required>{{ $company->address }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea style="resize:none" class="form-control" name="deskripsi" id="deskripsi" rows="5"  placeholder="Masukkan deskripsi perusahaan" required>{{ $company->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="testimonial">Testimonial</label>
                            <textarea style="resize:none" class="form-control" name="testimonial" id="testimonial" rows="5"  placeholder="Masukkan deskripsi perusahaan" required>{{ $company->testimonial }}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-1">
                        <div class="form-group">
                            <label for="nomor_virtual_account">Nomor VA (Virtual Account)</label>
                            <input onkeypress="return hanyaAngka(event)" type="text" name="nomor_virtual_account" id="nomor_virtual_account" class="form-control" placeholder="Masukkan nomor nomor virtual account perusahaan" value="{{ $company->va }}" required>
                        </div>
                        <div class="form-group">
                            <label for="api_key">API Key</label>
                            <input type="text" name="api_key" id="api_key" class="form-control" placeholder="Masukkan api key perusahaan" value="{{ $company->api_key }}" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input class="form-control" type="text" name="latitude" id="latitude" value="{{ $company->latitude }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input class="form-control" type="text" name="longitude" id="longitude" value="{{ $company->longitude }}" required>
                                </div>
                            </div>
                            <div class="container">
                                <div id="mapid" style="height: 215px; width:100%; border: 1px solid white"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-3" id="simpan">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>

    <!-- location control -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol/dist/L.Control.Locate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol/dist/L.Control.Locate.min.js" charset="utf-8"></script>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/leaflet.js') }}"></script>
    <script>
        $(document).ready(function(){
            $("#logo").on('change', function(){
                if (this.files && this.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $("#display-logo").attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            function updateMarker(lat, lng) {
                marker
                .setLatLng([lat, lng])
                .bindPopup("Your location :  " + marker.getLatLng().toString())
                .openPopup();
                return false;
            };

            mymap.on('click', function(e) {
                let latitude = e.latlng.lat.toString().substring(0, 15);
                let longitude = e.latlng.lng.toString().substring(0, 15);
                $('#latitude').val(latitude);
                $('#longitude').val(longitude);
                updateMarker(latitude, longitude);
            });

            var updateMarkerByInputs = function() {
                return updateMarker( $('#latitude').val() , $('#longitude').val());
            }
            $('#latitude').on('input', updateMarkerByInputs);
            $('#longitude').on('input', updateMarkerByInputs);


            L.control.locate({
                position: "bottomright"
            }).addTo(mymap);
            $("#formCompany").on('submit',function(e){
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: baseURL + "/company/1",
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $("#simpan").html('Loading <img height="20px" src="'+ baseURL + '/storage/loading.gif' +'" alt="">');
                        $("#simpan").attr('disabled', 'disabled');
                    },
                    success: function (result) {
                        $("#simpan").html('Simpan');
                        $("#simpan").removeAttr('disabled');
                        if (result.success) {
                            swal({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Company berhasil diperbarui'
                            });
                            $("#logo").val('');

                        } else {
                            swal({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Company gagal diperbarui'
                            });
                            let alert = `
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <span class="alert-icon"><i class="fas fa-exclamation-triangle"></i> <strong>Gagal</strong></span>
                                    <span class="alert-text">
                                        <ul>

                            `;
                            $.each(result.message, function (i, e) {
                                alert += `
                                            <li>`+e+`</li>
                                `;
                                if ((e.replace(/ .*/, '')) == 'logo') {
                                    $("#display-logo").attr('src', $("#display-logo").attr('alt'));
                                    $("#logo").val('');
                                }
                            });
                            alert += `  </ul>
                                    </span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>`;
                            $("#alert").html(alert);
                        }
                    }
                })
            });
        });
    </script>
@endpush
