@extends($layout)

@section('title', __('Add Template') )
@section('content')

    <h5 class="col-md-12 h5 pb-4 pl-0 mb-4 border-bottom">{{__('Add Template')}}</h5>
    @include('templates::admin.templates.form', array('model' => $template))

@stop
