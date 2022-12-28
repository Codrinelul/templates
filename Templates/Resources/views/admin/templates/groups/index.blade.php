@extends($layout)

@section('content-header')
    @if( ! isOnPages())
        <h1>
            All Groups ({!! $groups->count() !!})
            &middot;
            <small>{!! link_to_route('admin.templatesgroups.create', __('Add New')) !!}</small>
        </h1>
    @else
        <h1>
            All Pages ({!! $groups->count() !!})
            &middot;
            <small>{!! link_to_route('admin.templatesgroups.create', __('Add New')) !!}</small>
        </h1>
    @endif
@stop

@section('content')

    <table class="table">
        <thead>
        <th>{{__('ID')}}</th>
        <th>{{__('Name')}}</th>
        <th>{{__('Code')}}</th>
        <th class="text-center">{{__('Actions')}}</th>
        </thead>
        <tbody>
        @foreach ($groups as $group)
            <tr>
                <td>{!! $group->id !!}</td>
                <td>{!! $group->name !!}</td>
                <td>{!! $group->code !!}</td>
                <td class="text-center">
                    <a href="{!! route('admin.templatesgroups.edit', $group->id) !!}">{{__('Edit')}}</a>
                    &middot;
                    @include('admin::partials.modal', ['data' => $group, 'name' => 'templatesgroups'])
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>

    <div class="text-center">
        @if(View::exists('admin/partials/perpage'))
            @include('admin/partials/perpage')
        @endif
        {!! pagination_links($groups) !!}
    </div>
@stop
