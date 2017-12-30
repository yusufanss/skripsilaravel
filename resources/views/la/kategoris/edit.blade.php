@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/kategoris') }}">Kategori</a> :
@endsection
@section("contentheader_description", $kategori->$view_col)
@section("section", "Kategoris")
@section("section_url", url(config('laraadmin.adminRoute') . '/kategoris'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Kategoris Edit : ".$kategori->$view_col)

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
				{!! Form::model($kategori, ['route' => [config('laraadmin.adminRoute') . '.kategoris.update', $kategori->id ], 'method'=>'PUT', 'id' => 'kategori-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'nama_kategori')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/kategoris') }}">Cancel</a></button>
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
	$("#kategori-edit-form").validate({
		
	});
});
</script>
@endpush
