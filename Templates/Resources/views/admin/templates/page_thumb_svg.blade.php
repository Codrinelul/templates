<table class="pagelabelsTable table table-bordered table-striped">
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
    <?php if(isset($background_svg_content) && is_array($background_svg_content) && count($background_svg_content)) {?>
    <?php
    foreach($background_svg_content as $i=>$page){?>

    <tr>
        <th scope="row">{{__('Page ')}}{{$i+1}}{{__(' Label')}}</th>
        <td>
            <div class="table_preview_images">
                {!! Form::text('editor_options[page_labels]['.$i.']',isset($editor_options['page_labels']) && isset($editor_options['page_labels'][$i])? $editor_options['page_labels'][$i] :   __('Page '). ($i+1),['class' => 'form-control']) !!}
            </div>

        </td>
    </tr>

    <?php
    }
    ?>
    <?php }
    else {
    ?>
    <tr>
        <th scope="row">{{__('Page 1')}}{{__(' Label')}}</th>
        <td>
            <div class="table_preview_images">
                {!! Form::text('editor_options[page_labels][0]',isset($editor_options['page_labels']) && isset($editor_options['page_labels'][0])? $editor_options['page_labels'][0] :   __('Page 1'),['class' => 'form-control']) !!}
            </div>

        </td>
    </tr>
    <?php }?>
    </tbody>
</table>
