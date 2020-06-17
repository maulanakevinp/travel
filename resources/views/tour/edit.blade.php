@extends('layouts.app')
@section('title', __('Edit Tour'))

@section('styles')
<link rel="stylesheet" href="{{ asset('css/lightbox.css') }}">

<style>
    .upload-image:hover{
        cursor: pointer;
        opacity: 0.7;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card bg-dark">
                <div class="card-header">
                    <h5 class="font-weight-bold d-inline-block pt-2">
                        {{ __('Edit Tour') }}
                    </h5>
                    <a href="{{ route('tour.index') }}" class="btn btn-secondary float-right ">{{ __('Back') }}</a>
                </div>
                <div class="card-body">
                    @include('layouts.components.alert')
                    <form class="mb-3" action="{{ route('tour.update',$tour) }}" enctype="multipart/form-data" method="POST">
                        @csrf @method('patch')
                        <div class="form-group">
                            <label for="package">{{ __('Package') }}</label>
                            <select name="package_id" id="package" class="form-control">
                                <option value="" selected disabled>{{ __('Select package') }}</option>
                                @foreach ($packages as $package)
                                    <option value="{{ $package->id }}" {{ old('package', $tour->package_id) == $package->id ? 'selected':'' }}>{{ $package->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name',$tour->name) }}">
                        </div>
                        <div class="form-group">
                            <label for="price">{{ __('Price') }} (Rp.)</label>
                            <input type="number" name="price" id="price" class="form-control" value="{{ old('price',$tour->price) }}">
                        </div>
                        <div class="form-group">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea name="description" class="form-control" id="description">{!! old('description',$tour->description) !!}</textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">{{ __('Save') }}</button>
                    </form>

                    <div class="form-group">
                        <label for="images">Images</label>
                        <div id="field-images" class="row"></div>
                        <input type="file" name="image" accept="image/*" id="input-image" style="display: none">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
<script src="{{ asset('js/lightbox.js') }}"></script>

<script>
    function loadImages() {
        $.getJSON("{{ route('tour.edit', $tour->id) }}", function(result){
            $("#field-images").html('');
            $.each(result.data, function(i, data){
                let path = data.image;
                path = path.replace('public','storage');
                if (i == 0) {
                    $("#field-images").append(`
                        <div class="col-lg-4 col-sm-6 mb-3">
                            <a href="${baseURL}/${path}" data-lightbox="image-1" data-title="Images">
                                <img id="img-image" class="mw-100" style="max-height: 300px" src="${baseURL}/${path}" alt="${baseURL}/${path}">
                            </a>
                            <button id="change-image" onclick="$('#input-image').click()" data-id="${data.id}" title="{{ __('Change Photo') }}" class="btn btn-dark ml-3" style="position: absolute; top: 0; z-index: 1; left: 0;">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                    `);
                } else {
                    $("#field-images").append(`
                        <div class="col-lg-4 col-sm-6 mb-3">
                            <a href="${baseURL}/${path}" data-lightbox="image-1" data-title="Images">
                                <img class="mw-100" style="max-height: 300px" src="${baseURL}/${path}" alt="">
                            </a>
                            <form class="mb-0 hapus-foto" data-id="${data.id}" action="javascript:;" method="post">
                                <input type="hidden" name="_token" value="${_token}">
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" title="{{ __('Delete') }}" class="btn btn-danger" style="position: absolute; top: 0; z-index: 1;" onclick="return confirm('Are you sure want to delete this image?');"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    `);
                }
            });
            $("#field-images").append(`
                <div class="col-lg-4 col-sm-6">
                    <img onclick="$(this).siblings('.images').click()" class="mw-100 upload-image" style="max-height: 300px" src="{{ asset('images/upload.jpg') }}" alt="">
                    <input id="input-add-image" type="file" name="images" accept="image/*" class="images" style="display: none">
                </div>
            `);
        });
    }

    CKEDITOR.replace( 'description' );

    $(document).ready(function(){
        loadImages();

        $(document).on('change','#input-add-image', function(){
            if (this.files && this.files[0]) {
                let formData = new FormData();
                let oFReader = new FileReader();
                formData.append("image", this.files[0]);
                formData.append("_method", "patch");
                formData.append("_token", _token);
                oFReader.readAsDataURL(this.files[0]);

                $.ajax({
                    url: "{{ route('tour.update', $tour->id) }}",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        $(this).siblings('img').attr('src', baseURL + '/storage/loading.gif');
                    },
                    success: function (data) {
                        if (data.success) {
                            swal({
                                icon: 'success',
                                title: "{{ __('Success') }}",
                                text: data.message,
                            });

                            loadImages();
                        } else {
                            swal({
                                icon: 'error',
                                title: "{{ __('Fail') }}",
                                text: data.message,
                            });

                            loadImages();
                        }
                    }
                });
            }
        });

        $('#input-image').on('change', function () {
            if (this.files && this.files[0]) {
                let formData = new FormData();
                let oFReader = new FileReader();
                formData.append("image", this.files[0]);
                formData.append("_method", "patch");
                formData.append("_token", _token);
                oFReader.readAsDataURL(this.files[0]);

                $.ajax({
                    url: baseURL + "/gallery/" + $("#change-image").data("id"),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        document.querySelector("#img-image").src = baseURL + '/storage/loading.gif';
                    },
                    success: function (data) {
                        if (data.success) {
                            swal({
                                icon: 'success',
                                title: "{{ __('Success') }}",
                                text: data.message,
                            });

                            loadImages();
                        } else {
                            swal({
                                icon: 'error',
                                title: "{{ __('Fail') }}",
                                text: data.message,
                            });

                            loadImages();
                        }
                    }
                });
            }
        });

        $(document).on('submit', ".hapus-foto",function(){
            $.ajax({
                url: baseURL+"/gallery/"+$(this).data('id'),
                type: 'POST',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success:function(data){
                    if (data.success) {
                        swal({
                            icon: 'success',
                            title: "{{ __('Success') }}",
                            text: data.message,
                        });

                        loadImages();
                    } else {
                        swal({
                            icon: 'error',
                            title: "{{ __('Fail') }}",
                            text: data.message,
                        });

                        loadImages();
                    }
                }
            });
        });
    });
</script>
@endpush
