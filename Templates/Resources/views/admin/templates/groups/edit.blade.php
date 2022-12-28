@extends($layout)

@section('content-header')
    <h1>
        Edit
        &middot;
        @if(isOnPages())
            <small>{!! link_to_route('admin.pages.index' , __('Back')) !!}</small>
        @else
            <small>{!! link_to_route('admin.templatesgroups.index' , __('Back')) !!}</small>
        @endif
    </h1>
@stop

@section('content')
    <div>
        @include('templates::admin.templates.groups.form', array('model' => $group))
    </div>

@stop
