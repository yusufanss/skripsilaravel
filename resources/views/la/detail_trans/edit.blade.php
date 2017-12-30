@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/detail_trans') }}">Detail tran</a> :
@endsection
@section("contentheader_description", $detail_tran->$view_col)
@section("section", "Detail trans")
@section("section_url", url(config('laraadmin.adminRoute') . '/detail_trans'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Detail trans Edit : ".$detail_tran->$view_col)

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
				{!! Form::model($detail_tran, ['route' => [config('laraadmin.adminRoute') . '.detail_trans.update', $detail_tran->id ], 'method'=>'PUT', 'id' => 'detail_tran-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'no_faktur')
					@la_input($module, 'kode_barang')
					@la_input($module, 'jumlah')
					@la_input($module, 'subtotal')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/detail_trans') }}">Cancel</a></button>
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
	$("#detail_tran-edit-form").validate({
		
	});
});
</script>
@endpush
