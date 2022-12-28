@extends($layout)

@section('title', __('Templates') )

@section('admin-searchbar' )
@overwrite
@section('content-header')
	<h1>{{__('Templates')}}</h1>
@endsection
@section('content')
	{!! $grid !!}
@stop

@section('before_body_end')
	@include('grid::grid.grid-scripts')
@stop
