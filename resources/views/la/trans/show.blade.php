@extends('la.layouts.app')

@section('htmlheader_title')
	Tran View
@endsection


@section('main-content')
<div id="page-content" class="profile2">
	<div class="bg-primary clearfix">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-3">
					<!--<img class="profile-image" src="{{ asset('la-assets/img/avatar5.png') }}" alt="">-->
					<div class="profile-icon text-primary"><i class="fa {{ $module->fa_icon }}"></i></div>
				</div>
				<div class="col-md-9">
					<h4 class="name">{{ $tran->$view_col }}</h4>
					<div class="row stats">
						
					</div>
					<p class="desc">Fktur</p>
				</div>
			</div>
		</div>
		
		
		<div class="col-md-1 actions">
			@la_access("Trans", "edit")
				<a href="{{ url(config('laraadmin.adminRoute') . '/trans/'.$tran->id.'/edit') }}" class="btn btn-xs btn-edit btn-default"><i class="fa fa-pencil"></i></a><br>
			@endla_access
			
			@la_access("Trans", "delete")
				{{ Form::open(['route' => [config('laraadmin.adminRoute') . '.trans.destroy', $tran->id], 'method' => 'delete', 'style'=>'display:inline']) }}
					<button class="btn btn-default btn-delete btn-xs" type="submit"><i class="fa fa-times"></i></button>
				{{ Form::close() }}
			@endla_access
		</div>
	</div>

	<ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
		<li class=""><a href="{{ url(config('laraadmin.adminRoute') . '/trans') }}" data-toggle="tooltip" data-placement="right" title="Back to Trans"><i class="fa fa-chevron-left"></i></a></li>
		<li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info"><i class="fa fa-bars"></i> General Info</a></li>
		<li class=""><a role="tab" data-toggle="tab" href="#tab-timeline" data-target="#tab-timeline"><i class="fa fa-clock-o"></i> Timeline</a></li>
	</ul>

	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
			<div class="tab-content">
				<div class="panel infolist">
					<div class="panel-default panel-heading">
						<h4>General Info</h4>
					</div>
					<div class="panel-body">
						@la_display($module, 'no_faktur')
						@la_display($module, 'waktu')
						@la_display($module, 'total')
						<div class="col-md-8 col-md-offset-2">
{!! Form::open(['action' => 'LA\Detail_transController@store', 'id' => 'detail_tran-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
                @php
						$detail = Module::get('Detail_trans');

				@endphp
				<input type="hidden" name="no_faktur" value="{{$tran->id}}">
					@la_input($detail, 'kode_barang')
					@la_input($detail, 'jumlah')
					<div class="form-group"><label for="harga_barang">harga :</label><input disabled class="form-control" placeholder="Harga Barang" name="harga_barang" type="number" value=""></div>
					@la_input($detail, 'subtotal')		
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				{!! Form::submit( 'Submit', ['class'=>'btn btn-success']) !!}
			
			</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	</div>
</div>
<div class="box box-success">
	<!--<div class="box-header"></div>-->
	<div class="box-body">
		<table id="example1" class="table table-bordered">
		<thead>
		<tr class="success">
			@foreach( $listing as $col )
			<th>{{ $module->fields[$col]['label'] or ucfirst($col) }}</th>
			@endforeach
			@if($show_actions)
			<th>Actions</th>
			@endif
		</tr>
		</thead>
		<tbody>
			
		</tbody>
		</table>
	</div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(function () {
	$("#example1").DataTable({
		processing: true,
        serverSide: true,
        ajax: "{{ url(config('laraadmin.adminRoute') . '/detail_tran_dt_ajax') }}",
		language: {
			lengthMenu: "_MENU_",
			search: "_INPUT_",
			searchPlaceholder: "Search"
		},
		@if($show_actions)
		columnDefs: [ { orderable: false, targets: [-1] }],
		@endif
	});
	$("#detail_tran-add-form").validate({
		
	});
});
</script>
@endpush
@push('scripts')
<script>
$(function () {
	$("[name='kode_barang']").on("change", function(e) { 
	$.get( "/admin/trans_ajax/"+this.value, function( data ) {
		$("[name='harga_barang']" ).val( data );
		});
	});
	$("[name='jumlah']").on("change", function(e) { 
	var hasil = $("[name='harga_barang']" ).val() * $("[name='jumlah']" ).val(); 
		$("[name='subtotal']" ).val( hasil );
	});
});
</script>
@endpush
