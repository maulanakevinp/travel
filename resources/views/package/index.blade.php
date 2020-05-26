@extends('layouts.app')
@section('title','Daftar paket wisata')

@section('styles')
    <link rel="stylesheet" href="{{ asset("css/News-Cards.css") }}">
    <link rel="stylesheet" href="{{ asset("css/mystyle.css") }}">
@endsection

@section('content')
<div class="container">
    <h1 class="font-weight-bold">Daftar Paket Wisata</h1>
    <div class="card-columns">
        @foreach ($packages as $package)
            <div class="card shadow mt-3 bg-dark ">
                <img class="card-img-top w-100 d-block" src="{{asset(Storage::url($package->galleries[0]->image))}}">
                <div class="card-body">
                    <h4 class="card-title block-with-text font-weight-bold" style="height: 40px">
                        {{$package->name}}
                    </h4>
                    <div class="card-text block-with-text" style="height: 50px">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil, quasi. Cupiditate repudiandae non accusamus officiis sapiente similique eius voluptatibus culpa magni ducimus odit doloribus sit voluptas, ipsum dolore temporibus expedita officia a! Ducimus nesciunt obcaecati necessitatibus officiis ea harum debitis totam, eos beatae autem tempora laborum assumenda praesentium ipsa, ut et porro saepe quasi nobis. Deserunt dolores enim ipsa, dignissimos nam commodi hic tenetur facere, minima autem voluptates animi fuga ducimus eveniet? Consectetur, sequi, impedit quae repellat quaerat illo corrupti provident minima magni rem ipsa, ad cum! Ullam provident minima mollitia accusamus corporis, facilis voluptatem iure ex vel quas molestiae omnis qui temporibus impedit sed eius illum ea, laborum, enim exercitationem aspernatur recusandae magnam! Veritatis vitae nostrum, porro enim minima at voluptatibus eius debitis libero perferendis corrupti sed obcaecati, sapiente ad nemo, animi similique distinctio consequuntur fuga harum. Qui tempore laudantium debitis non totam voluptatibus maiores dolore eum facere cum aliquid enim nihil, sunt tenetur sequi nobis! Officiis voluptates deleniti velit eos rerum minima a ipsam animi vel aperiam autem molestiae et quas eum eaque, tenetur, doloremque nulla, voluptatibus recusandae nobis magnam. Cumque quisquam itaque, laboriosam magnam voluptatibus repellat, in architecto perferendis hic laborum natus explicabo corporis maiores quos maxime?</div>
                    <div class="float-right mb-3">
                        <a title="Detail" class="btn btn-sm btn-info" href="{{ route('package.show',['package' => $package , 'slug' => Str::slug($package->name)]) }}"><i class="fas fa-eye"></i></a>
                        <a title="Ubah" class="btn btn-sm btn-success" href="{{ route('package.edit',$package) }}"><i class="fas fa-edit"></i></a>
                        <a title="Hapus" class="btn btn-sm btn-danger" href="{{ route('package.destroy',$package) }}"><i class="fas fa-trash"></i></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $packages->links() }}
</div>
@endsection
