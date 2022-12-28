@if(isset($model))
    {!! Form::model($model, ['method' => 'PUT', 'route' => ['admin.templatesgroups.update', $model->id]]) !!}
@else
    {!! Form::open(['files' => true, 'route' => 'admin.templatesgroups.store']) !!}
@endif
<div class="form-group">
    {!! Form::label('name', __('Name:')) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
    {!! $errors->first('name', '<div class="text-danger">:message</div>') !!}
</div>
<div class="form-group">
    {!! Form::label('code', __('Code:')) !!}
    {!! Form::text('code', null, ['class' => 'form-control']) !!}
    {!! $errors->first('code', '<div class="text-danger">:message</div>') !!}
</div>
<div class="form-group">
    {!! Form::label('description', __('Description:')) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}

</div>
<div class="form-group">
    {!! Form::label('templates', __('Templates:')) !!}
    <div>
        {!! Form::select('templates[]', $templates, isset($model) && $model ?explode(",",$model->templates) : null, ['multiple'=>'multiple' ,'class' => 'form-control multiselect', 'style' => 'width:50%;display: inline-block;']) !!}
        {!! $errors->first('templates', '<div class="text-danger">:message</div>') !!}
    </div>
</div>
<div class="form-group">
    {!! Form::submit(isset($model) ? __('Update') : __('Save'), ['class' => 'btn btn-primary']) !!}
</div>
{!! Form::close() !!}


