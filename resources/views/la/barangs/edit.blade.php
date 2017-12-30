@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/barangs') }}">Barang</a> :
@endsection
@section("contentheader_description", $barang->$view_col)
@section("section", "Barangs")
@section("section_url", url(config('laraadmin.adminRoute') . '/barangs'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Barangs Edit : ".$barang->$view_col)

@section("main-content")

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($barang, ['route' => [config('laraadmin.adminRoute') . '.barangs.update', $barang->id ], 'method'=>'PUT', 'id' => 'barang-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'kode_barang')
					@la_input($module, 'nama_barang')
					@la_input($module, 'stok')
					@la_input($module, 'kategori')
					@la_input($module, 'harga')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/barangs') }}">Cancel</a></button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#barang-edit-form").validate({
		
	});
});
</script>
@endpush
