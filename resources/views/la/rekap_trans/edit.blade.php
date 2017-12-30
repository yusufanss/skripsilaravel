@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/rekap_trans') }}">Rekap tran</a> :
@endsection
@section("contentheader_description", $rekap_tran->$view_col)
@section("section", "Rekap trans")
@section("section_url", url(config('laraadmin.adminRoute') . '/rekap_trans'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Rekap trans Edit : ".$rekap_tran->$view_col)

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
				{!! Form::model($rekap_tran, ['route' => [config('laraadmin.adminRoute') . '.rekap_trans.update', $rekap_tran->id ], 'method'=>'PUT', 'id' => 'rekap_tran-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'kode_barang')
					@la_input($module, 'tanggal')
					@la_input($module, 'jumlah')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/rekap_trans') }}">Cancel</a></button>
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
	$("#rekap_tran-edit-form").validate({
		
	});
});
</script>
@endpush
