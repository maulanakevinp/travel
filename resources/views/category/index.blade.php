@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            @include('layouts.components.alert')
            <div class="card bg-dark">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold float-left">Category</h5>
                    <a id="tambah" href="#modal" title="Tambah" class="btn btn-sm btn-success float-right" data-toggle="modal"><i class="fas fa-plus"></i></a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-white">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            <a href="#modal" title="ubah" data-toggle="modal"
                                                data-id="{{ $category->id }}" class="btn btn-sm btn-success ubah"><i
                                                    class="fas fa-edit"></i></a>
                                            <button class="btn btn-sm btn-danger hapus" data-id="{{ $category->id }}"
                                                title="Hapus"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="color: black">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formCategory" method="POST">
                @csrf @method('post')
                <div class="modal-body">
                    <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama kategori">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $("#tambah").click(function(){
                $("#modalLabel").html('Tambah Kategori');
                $("#formCategory")[0].reset();
                $("#formCategory").attr('action', baseURL + "/category");
                $("#formCategory > input[name='_method']").val('post');
            });

            $(".ubah").click(function(){
                $("#modalLabel").html('Ubah Kategori');
                $("#formCategory")[0].reset();
                $("#formCategory").attr('action', baseURL + "/category/" + $(this).data('id'));
                $("#formCategory > input[name='_method']").val('put');
                $.getJSON(baseURL + "/category/" + $(this).data('id'), function(data){
                    $("#name").val(data.name);
                });
            });

            $(".hapus").click(function () {
                const id = $(this).data('id');
                let name;
                $.getJSON(baseURL + "/category/" + id, function(data){
                    name = data.name;
                    swal({
                        title: "Apakah anda yakin?",
                        text: "Setelah dihapus, " + name + " tidak akan dapat dipulihkan",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: baseURL + '/category/' + id,
                                type: 'delete',
                                data: {
                                    _token: _token,
                                },
                                success: function(result){
                                    if (result.success) {
                                        swal(result.message, {
                                            icon: "success",
                                        }).then((reload) => {
                                            location.reload();
                                        });
                                    } else {
                                        swal(result.message, {
                                            icon: "error",
                                        });
                                    }
                                }
                            });
                        } else {
                            swal.close();
                        }
                    });
                });
            });
        });
    </script>
@endpush
