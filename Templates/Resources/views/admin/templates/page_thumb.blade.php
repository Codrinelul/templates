<table class="preview_images_tab table table-bordered table-striped">
    <thead>
    <tr class="thead-dark"><th colspan="2"><h6 class="h6 mb-0">{{__('Preview Images') }}</h6></th> </tr>
    <tr>
        <th>{{__('Page #')}}</th>
        <th>{{__('Upload Options')}}</th>
    </tr>
    </thead>
    <tbody>
        @php
            $storage = app(\Modules\EditorFiles\Services\StorageService::class)->getInstance();
        @endphp
    @for ($i = 0; $i < $page_number; $i++)
        <tr>
            <th scope="row">{{__('Page ')}}{{$i+1}}</th>
            <td>
                @if(isset($pdfImages[$i]) && count($pdfImages[$i]))
                    @php
                        $working = $storage->url(preg_replace('/^(\/)?(media)?\//', '', $pdfImages[$i]['working']));
                        $thumb = $storage->url(preg_replace('/^(\/)?(media)?\//', '', $pdfImages[$i]['thumb']));
                    @endphp
                    <div class="table_preview_images">
                        {!! Form::label('preview_image['.$i.']', __('Preview Image:')) !!}
                        <button type="button" style="margin-left: 15px;margin-bottom: 4px;" class="btn btn-primary"
                                onclick="jQuery('#preview_image_{{$i}}').toggleClass('opened')">{{__('Toggle Preview')}}</button>
                        <div style="display: none" id="preview_image_{{$i}}" class="preview_image"><img
                                src="{{$working}}" alt="{{ __('Preview Image') }}"/></div>
                    </div>
                    <div class="table_preview_images">
                        {!! Form::label('thumbnail_image['.$i.']', __('Thumbnail Image:')) !!}
                        <button type="button" style="margin-left: 15px;margin-bottom: 4px;" class="btn btn-primary"
                                onclick="jQuery('#thumbnail_image_{{$i}}').toggleClass('opened')">{{__('Toggle Preview')}}</button>
                        <div style="display: none" id="thumbnail_image_{{$i}}" class="thumbnail_image"><img
                                src="{{$thumb}}" alt="{{ __('Thumbnail Image') }}"/></div>
                    </div>
                @endif
            </td>
        </tr>
    @endfor
    </tbody>
</table>

<table class="page_labels  table table-bordered table-striped">
    <thead>
    <tr class="thead-dark">
        <th colspan="2"><h6 class="h6 mb-0">{{__('Page Labels') }}</h6></th>
    </tr>
    <tr>
        <th>{{__('Page #')}}</th>
        <th>{{__('Labels')}}</th>
    </tr>
    </thead>
    <tbody>
    @for ($i = 0; $i < $page_number; $i++)
        <tr>
            <th scope="row">{{__('Page ')}}{{$i+1}}{{__(' Label')}}</th>
            <td>
                <div class="table_preview_images">
                    {!! Form::text('editor_options[page_labels]['.$i.']',isset($editor_options['page_labels']) && isset($editor_options['page_labels'][$i])? $editor_options['page_labels'][$i] :   __('Page '). ($i+1),['class' => 'form-control']) !!}
                </div>

            </td>
        </tr>
    @endfor
    </tbody>
</table>
<table class="page_helpers table table-bordered table-striped">
    <thead>
    <tr class="thead-dark">
        <th colspan="2"><h6 class="h6 mb-0">{{__('Page Helpers') }}</h6></th>
    </tr>
    <tr>
        <th><?php echo __('Page #') ?></th>
        <th><?php echo __('Helpers') ?></th>
    </tr>
    </thead>
    @for ($i = 0; $i < $page_number; $i++)
        <tbody>
        <tr @if ( !$i )class="gridshadow" @endif>
            <td>{{ __('Page ') . ($i + 1) . ' ' . __('Helpers')}}</td>
            <td>
                <select multiple="multiple" class="form-control" name="editor_options[pages_helpers][{{$i}}][]">
                    @foreach ( $helpers as $h )
                        @php $helperId = $h->id; @endphp
                        <option value="{{$helperId}}"
                                @if( isset($editor_options['pages_helpers'])
                                    && isset($editor_options['pages_helpers'][$i])
                                    && in_array($helperId,
                                    $editor_options['pages_helpers'][$i])
                                )
                                selected="selected"
                            @endif>
                            {{$h->name}}
                        </option>
                    @endforeach
                </select>
            </td>
        </tr>
        </tbody>
    @endfor
</table>
