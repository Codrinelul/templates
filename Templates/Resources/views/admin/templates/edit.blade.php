@extends($layout)

@section('title',__('Edit ":template" template', ['template' => $template->name]))

@section('content')

    <h5 class="col-md-12 h5 pb-4 pl-0 mb-4 border-bottom">{{__('Edit ":template" template', ['template' => $template->name])}}</h5>
    @include('templates::admin.templates.form', array('model' => $template))
@stop
