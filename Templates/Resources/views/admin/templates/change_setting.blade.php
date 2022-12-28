@extends($layout)

@section('title',__('Change Setting'))

@section('content')

    <h5 class="col-md-12 h5 pb-4 pl-0 mb-4 border-bottom">{{__('Change Setting')}}</h5>
    @include('templates::admin.templates.form_change_setting')
@stop
