@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/trans') }}">Tran</a> :
@endsection
@section("contentheader_description", $tran->$view_col)
@section("section", "Trans")
@section("section_url", url(config('laraadmin.adminRoute') . '/trans'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Trans Edit : ".$tran->$view_col)

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
				{!! Form::model($tran, ['route' => [config('laraadmin.adminRoute') . '.trans.update', $tran->id ], 'method'=>'PUT', 'id' => 'tran-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'no_faktur')
					@la_input($module, 'waktu')
					@la_input($module, 'total')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/trans') }}">Cancel</a></button>
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
	$("#tran-edit-form").validate({
		
	});
});
</script>
@endpush
