@extends('layouts.app')
@section('title', __('Gallery'))

@section('styles')
<link rel="stylesheet" href="{{ asset('css/jquery.fancybox.css') }}">
@endsection

@section('content')
<div class="container">
    <h1 class="font-weight-bold d-inline-block">{{ __('Gallery') }}</h1>
    <a href="{{ route('gallery.create') }}" class="btn btn-success float-right">{{ __('Add Gallery') }}</a>
    <div id="field-images" class="row mt-3"></div>
    <input type="file" name="image" id="input-image" style="display: none">
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/jquery.fancybox.js') }}"></script>
<script>
    function loadImages() {
        $.getJSON("{{ route('api.gallery') }}", function(result){
            $("#field-images").html('');
            $.each(result.data, function(i, data){
                let path = data.image;
                path = path.replace('public','storage');
                if (i == 0) {
                    $("#field-images").append(`
                        <div class="col-lg-4 col-sm-6 mb-3">
                            <a href="${baseURL}/${path}" data-fancybox>
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
                            <a href="${baseURL}/${path}" data-fancybox>
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
        });
    }

    $(document).ready(function(){
        loadImages();

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
                                button: false,
                                timer: 1000,
                            });

                            loadImages();
                        } else {
                            swal({
                                icon: 'error',
                                title: "{{ __('Fail') }}",
                                text: data.message,
                                button: false,
                                timer: 1000,
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
                            button: false,
                            timer: 1000,
                        });

                        loadImages();
                    } else {
                        swal({
                            icon: 'error',
                            title: "{{ __('Fail') }}",
                            text: data.message,
                            button: false,
                            timer: 1000,
                        });

                        loadImages();
                    }
                }
            });
        });
    });
</script>
@endpush
