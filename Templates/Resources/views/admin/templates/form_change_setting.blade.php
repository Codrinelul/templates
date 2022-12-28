<link rel="stylesheet" href="{{ URL::asset('admin/js/jsTree/themes/default/style.min.css') }}"/>
<script type="text/javascript" src="{{ URL::asset('js/collapsible.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('admin/js/jsTree/jstree.min.js') }}"></script>
<?php
$designerClass = ' is_editable_designer';
$otpClass = ' is_editable_otp';
$brochureClass = ' is_editable_brochure';

?>
@if(session('error'))
    <div class="alert alert-danger">
        <strong>Error </strong> {{ session('error') }}
    </div>
@endif
{!! Form::open(['files' => true, 'route' => 'admin.templates.changeSetting.update','class'=>'templateForm']) !!}

<input type="hidden" name="lastTab" id="lastTabId" value="<?php if (isset($lastTab))
    echo $lastTab; else echo '#default';?>"/>
<input type="hidden" name="template_ids" id="template_ids" value="<?php if (isset($template_ids))
echo implode(',', $template_ids); else echo '';?>"/>
<input type="hidden" name="except_ids" id="except_ids" value="<?php if (isset($except_ids))
echo implode(',', $except_ids); else echo '';?>"/>
<input type="hidden" id="engine" value="designotp" />
<input type="hidden" id="query_params" name="query_params" value="<?php if (isset($query_params))
echo $query_params; else echo '';?>" />


<div class="row position-relative">
    <div class="col-md-10 sticky-form-body">
        <div class="col px-0 mb-4 m-0">
            <ul class="nav nav-tabs topMenuTemplate" data-role="tablist">
                <li class="nav-item presentation_element" role="presentation">
                    <a href="#setup" role="tab" data-toggle="tab" class="nav-link active">{{__('Setup')}}</a>
                </li>
                <li class="nav-item presentation_element options_otp_designer" role="presentation">
                    <a href="#global_editable_options" role="tab" data-toggle="tab"
                       class="nav-link">{{__('Options')}}</a>
                </li>
            </ul>
            <div class="card-body collapse show border border-top-0 p-0 p-4" id="details-body">

                <div id="setup" role="tabpanel" class="template_section active">
                    <div class="form-group row">
                        <?php $liveTemplatesConfig = getLiveTemplates()?>
                        {!! Form::label('psd_template', __('Live Template:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::select('psd_template', $liveTemplatesConfig, 'test.psd', ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_psd_template', __('Change')) !!}
                            {!!Form::checkbox('setup[psd_template]', '1',false, ['id' => 'setup_psd_template'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('svg_live_template', __('SVG Live Template:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::select('svg_live_template', $personalization_svg_live_template_files, 'test.svg', ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_svg_live_template', __('Change')) !!}
                            {!!Form::checkbox('setup[svg_live_template]', '1',false, ['id' => 'setup_svg_live_template'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('preview_type', __('Preview Type:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::select('preview_type', array('basic'=>'Basic Preview','tdpreview'=>'3D Preview','videopreview'=>'Video Preview','live'=>'Live Preview','svg_live'=>'SVG Live Preview'), 'basic', ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_preview_type', __('Change')) !!}
                            {!!Form::checkbox('setup[preview_type]', '1',false, ['id' => 'setup_preview_type'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('preview_resolution', __('Preview Resolution:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('preview_resolution', '150', ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_preview_resolution', __('Change')) !!}
                            {!!Form::checkbox('setup[preview_resolution]', '1',false, ['id' => 'setup_preview_resolution'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('preview_high_resolution', __('Preview High Resolution:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('preview_high_resolution', '300', ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_preview_high_resolution', __('Change')) !!}
                            {!!Form::checkbox('setup[preview_high_resolution]', '1',false, ['id' => 'setup_preview_high_resolution'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('file_output', __('File Output:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::select('file_output', array('jpeg'=>'JPEG','png16m'=>'PNG','pngalpha'=>'PNG TRANSPARENCY'), 'jpeg', ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_file_output', __('Change')) !!}
                            {!!Form::checkbox('setup[file_output]', '1',false, ['id' => 'setup_file_output'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('trim_box', __('Trimbox:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::select('trim_box', array('0'=>__('No'),'1'=>__('Yes')), 0, ['class' => 'form-control', 'style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_trim_box', __('Change')) !!}
                            {!!Form::checkbox('setup[trim_box]', '1',false, ['id' => 'setup_trim_box'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('confirm_checkbox', __('Enable confirm Checkbox:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::select('confirm_checkbox', array('0'=>__('No'),'1'=>__('Yes')), 0, ['class' => 'form-control', 'style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_confirm_checkbox', __('Change')) !!}
                            {!!Form::checkbox('setup[confirm_checkbox]', '1',false, ['id' => 'setup_confirm_checkbox'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('allow_save_load', __('Allow Personalization Save/Load:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::select('allow_save_load', array('0'=>__('No'),'1'=>__('Yes')), 0, ['class' => 'form-control', 'style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_allow_save_load', __('Change')) !!}
                            {!!Form::checkbox('setup[allow_save_load]', '1',false, ['id' => 'setup_allow_save_load'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('allow_download_pdf', __('Allow Download pdf:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::select('allow_download_pdf', array('0'=>__('No'),'1'=>__('Yes')), 0, ['class' => 'form-control', 'style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_allow_download_pdf', __('Change')) !!}
                            {!!Form::checkbox('setup[allow_download_pdf]', '1',false, ['id' => 'setup_allow_download_pdf'])!!}
                        </div>
                    </div>

                    <div class="form-group row">
                        {!! Form::label('personalization_pages', __('Personalization Pages:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('personalization_pages', '0', ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_personalization_pages', __('Change')) !!}
                            {!!Form::checkbox('setup[personalization_pages]', '1',false, ['id' => 'setup_personalization_pages'])!!}
                        </div>
                    </div>
                    <div class="form-group row" style="display:none">
                        {!! Form::label('project_default_title', __('Project Personalization Default Title:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('project_default_title', '', ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_project_default_title', __('Change')) !!}
                            {!!Form::checkbox('setup[project_default_title]', '1',false, ['id' => 'setup_project_default_title'])!!}
                        </div>
                    </div>

                    <div class="form-group row">
                        {!! Form::label('project_default_text', __('Project Personalization Default Id:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('project_default_text', '', ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_project_default_text', __('Change')) !!}
                            {!!Form::checkbox('setup[project_default_text]', '1',false, ['id' => 'setup_project_default_text'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('project_default_desc', __('Project Personalization Default Description:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('project_default_desc', '', ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_project_default_desc', __('Change')) !!}
                            {!!Form::checkbox('setup[project_default_desc]', '1',false, ['id' => 'setup_project_default_desc'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('subtitle_note', __('Project Personalization Subtitle Note:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('subtitle_note', 'default', ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_subtitle_note', __('Change')) !!}
                            {!!Form::checkbox('setup[subtitle_note]', '1',false, ['id' => 'setup_subtitle_note'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('watermark', __('Watermark:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::select('watermark', array('0'=>__('No'),'1'=>__('Yes')), 0, ['class' => 'form-control', 'style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_watermark', __('Change')) !!}
                            {!!Form::checkbox('setup[watermark]', '1',false, ['id' => 'setup_watermark'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('show_wtm_in_preview', __('Watermark in preview:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::select('show_wtm_in_preview', array('0'=>__('No'),'1'=>__('Yes')), 0, ['class' => 'form-control', 'style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_show_wtm_in_preview', __('Change')) !!}
                            {!!Form::checkbox('setup[show_wtm_in_preview]', '1',false, ['id' => 'setup_show_wtm_in_preview'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('watermark_size', __('Watermark Size:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('watermark_size', '400', ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_watermark_size', __('Change')) !!}
                            {!!Form::checkbox('setup[watermark_size]', '1',false, ['id' => 'setup_watermark_size'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('watermark_text', __('Watermark Text:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('watermark_text', 'Watermark', ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_watermark_text', __('Change')) !!}
                            {!!Form::checkbox('setup[watermark_text]', '1',false, ['id' => 'setup_watermark_text'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('watermark_color', __('Watermark Color:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('watermark_color', '0 0 0', ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_watermark_color', __('Change')) !!}
                            {!!Form::checkbox('setup[watermark_color]', '1',false, ['id' => 'setup_watermark_color'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('watermark_opacity', __('Watermark Opacity:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('watermark_opacity', '5', ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_watermark_opacity', __('Change')) !!}
                            {!!Form::checkbox('setup[watermark_opacity]', '1',false, ['id' => 'setup_watermark_opacity'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('auto_preview', __('Auto preview:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::select('auto_preview', array('0'=>__('No'),'1'=>__('Yes')), 0, ['class' => 'form-control', 'style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_auto_preview', __('Change')) !!}
                            {!!Form::checkbox('setup[auto_preview]', '1',false, ['id' => 'setup_auto_preview'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('use_small_images', __('Use Resized Images For Preview:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::select('use_small_images', array('0'=>__('No'),'1'=>__('Yes')), 0, ['class' => 'form-control', 'style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_use_small_images', __('Change')) !!}
                            {!!Form::checkbox('setup[use_small_images]', '1',false, ['id' => 'setup_use_small_images'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('allow_save_data', __('Enable customer personalization data save:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::select('allow_save_data', array('0'=>__('No'),'1'=>__('Yes')), 0, ['class' => 'form-control', 'style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_allow_save_data', __('Change')) !!}
                            {!!Form::checkbox('setup[allow_save_data]', '1',false, ['id' => 'setup_allow_save_data'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('allow_article_load', __('Allow  Article Load:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::select('allow_article_load', array('0'=>__('No'),'1'=>__('Yes')), 0, ['class' => 'form-control', 'style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_allow_article_load', __('Change')) !!}
                            {!!Form::checkbox('setup[allow_article_load]', '1',false, ['id' => 'setup_allow_article_load'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <?php $articleLoadConfig = getArticleLoadFilesFromRepository()?>
                        {!! Form::label('article_load_file', __('Article Load File:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::select('article_load_file', $articleLoadConfig, 'addresen.xls', ['class' => 'form-control','style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_article_load_file', __('Change')) !!}
                            {!!Form::checkbox('setup[article_load_file]', '1',false, ['id' => 'setup_article_load_file'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('activate_white_underprint', __('Activate White Underprint:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::select('activate_white_underprint', array('0'=>__('No'),'1'=>__('Yes')), 0, ['class' => 'form-control', 'style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_activate_white_underprint', __('Change')) !!}
                            {!!Form::checkbox('setup[activate_white_underprint]', '1',false, ['id' => 'setup_activate_white_underprint'])!!}
                        </div>
                    </div>
                    <div class="form-group row" style="display:none">
                        {!! Form::label('activate_white_underprint_per_block', __('Activate White Underprint Per Block:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::select('activate_white_underprint_per_block', array('0'=>__('No'),'1'=>__('Yes')), 0, ['class' => 'form-control', 'style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! Form::label('setup_activate_white_underprint_per_block', __('Change')) !!}
                            {!!Form::checkbox('setup[activate_white_underprint_per_block]', '1',false, ['id' => 'setup_activate_white_underprint_per_block'])!!}
                        </div>
                    </div>
                    {!! Form::text('id', '0', ['id'=>'inEditTemplateId','class' => 'form-control','style'=>'display:none;']) !!}
                </div>

                <div role="tabpanel" class="template_section" id="global_editable_options">
                    <div class="row d-flex justify-content-around">
                        <?php
                        $editable_options = getYesNoPersonalizationOptions();
                        $yes_no_options = array();
                        $count = count($editable_options);
                        $middle = floor($count/2);
                        $i = 0;
                        ?>
                        <div class="d-flex flex-column col-md-6 col-xs-12 px-3 ">
                        @foreach ($editable_options as $tab=>$options)
                            @if($i++ == $middle)
                            </div><div class="d-flex flex-column col-md-6 col-xs-12 px-3 ">
                            @endif
                            <div
                                class="<?php if (isset($options['designer']) && $options['designer']) echo 'is_editable_designer';?>
                                <?php if (isset($options['otp']) && $options['otp']) echo 'is_editable_otp';?>
                                    editable_opt editableProductOptions " >
                                <div class="px-0 border-0 mb-2 card"
                                     id='{{$tab}}'>
                                    <a href="#tab-{{$tab}}-body" data-toggle="collapse"
                                       class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 border bg-light mb-0 h6 text-decoration-none">
                                        {!! $options['title'] !!}
                                    </a>

                                    <div class="card-body collapse show border border-top-0 p-4" id="tab-{{$tab}}-body">
                                        <div class="form-group row editable-option-section">
                                            <div class="editable_option_title">
                                                {!! tooltip_icon('form', 'templates.enable_standard_selection') !!} <span
                                                    style="font-weight: 700;">{!! __('Enable Standard Selection:') !!}</span>
                                            </div>
                                            {!! Form::label('setAllNo_'.$tab, __('No')) !!}
                                            {!!Form::radio($tab.'_setAll', '0',false, array('class' => 'setAll','id'=>'setAllNo_'.$tab,'data-tab'=>$tab))!!}
                                            {!! Form::label('setAllYes_'.$tab, __('Yes')) !!}
                                            {!!Form::radio($tab.'_setAll', '1',false, array('class' => 'setAll','id'=>'setAllYes_'.$tab,'data-tab'=>$tab))!!}
                                            {!! Form::label('setAllCheck_'.$tab, __('Change All')) !!}
                                            {!!Form::checkbox($tab.'_setAllCheck', '1',false, ['id' => 'setAllCheck_' . $tab, 'class' => 'changeAll', 'data-tab' => $tab])!!}
                                        </div>
                                        @foreach ($options['fields'] as $key => $value)
                                            <div
                                                class="form-group row  <?php echo(isset($value['additional_class']) ? $value['additional_class'] :'') ?> <?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?> editable_opt  <?php if (isset($value['has_options']) && 1 == $value['has_options'])
                                                    echo 'has_options' ?> editable-option-section"
                                                <?php if( isset($value['has_options']) && 1 == $value['has_options'] ): ?>
                                                data-target="<?php echo $value['options_id'];
                                                echo isset($value['scope']) ? '.' . $value['scope'] : ''; ?> "
                                            <?php endif ?>>
                                                <div class="editable_option_title">
                                                    {!! tooltip_icon('form', 'templates.' . $key) !!} <span style="font-weight: 700;">{!! $value['title'] !!}</span>
                                                       @if(isset($value['note']))
                                                    <small style="width:100%;display:inline-block;clear:both;"><?php echo $value['note'] ?></small>
                                                           @endif
                                                </div>
                                                @if(isset($yes_no_options[$key]))
                                                    {!! Form::label('editable_'.$key.'_no', __('No')) !!}
                                                    <?php $no__input_options = array('id' => 'editable_' . $key . '_no')  ?>
                                                    @if(isset($value['has_options']) && 1 == $value['has_options'])
                                                        <?php $no__input_options['onclick'] = "jQuery('#global_editable_options').find('" . $value['options_id'] . ((isset($value['scope']) && $value['scope'] != '') ? ('.' . $value['scope']) : '') . " ').hide()"?>
                                                    @endif
                                                    @if(isset($value['default']) && 0 == (int)$value['default'])
                                                        <?php $no__input_options['class'] = "standard-selection"?>
                                                    @endif
                                                    <?php
                                                    if ($key == 'allow_pantones') {
                                                        $no__input_options['onclick'] .= '; jQuery(".max_color_pantone_nr_value").removeClass("show")';
                                                    }
                                                    ?>
                                                    {!!Form::radio('editable_options['.$key.']', '0', (isset($yes_no_options[$key]) && $yes_no_options[$key] == '0' ) ? true : false, $no__input_options)!!}

                                                    {!! Form::label('editable_'.$key.'_yes', __('Yes')) !!}
                                                    <?php $yes_input_options = array('id' => 'editable_' . $key . '_yes')  ?>
                                                    @if(isset($value['has_options']) && 1 == $value['has_options'])
                                                        <?php $yes_input_options['onclick'] = "jQuery('#global_editable_options').find('" . $value['options_id'] . ((isset($value['scope']) && $value['scope'] != '') ? ('.' . $value['scope']) : '') . " ').show()"?>
                                                    @endif
                                                    @if(isset($value['default']) && 1 == (int)$value['default'])
                                                        <?php $no__input_options['class'] = "standard-selection"?>
                                                    @endif
                                                    {!!Form::radio('editable_options['.$key.']', '1',(isset($yes_no_options[$key]) && $yes_no_options[$key] == '1' ) ? true : false, $yes_input_options)!!}
                                                    {!! Form::label('editable_'.$key.'_check', __('Change')) !!}
                                                    {!!Form::checkbox('editable_options_check['.$key.']', '1',false, ['id' => 'editable_' . $key . '_check'])!!}
                                                @else
                                                    {!! Form::label('editable_'.$key.'_no', __('No')) !!}
                                                    <?php $no__input_options = array('id' => 'editable_' . $key . '_no')  ?>
                                                    @if(isset($value['has_options']) && 1 == $value['has_options'])
                                                        <?php $no__input_options['onclick'] = "jQuery('#global_editable_options').find('" . $value['options_id'] . ((isset($value['scope']) && $value['scope'] != '') ? ('.' . $value['scope']) : '') . " ').hide()"?>
                                                    @endif
                                                    @if(isset($value['default']) && 0 == (int)$value['default'])
                                                        <?php $no__input_options['class'] = "standard-selection"?>
                                                    @endif
                                                    <?php
                                                    if ($key == 'allow_pantones') {
                                                        $no__input_options['onclick'] .= '; jQuery(".max_color_pantone_nr_value").removeClass("show")';
                                                    }
                                                    ?>
                                                    {!!Form::radio('editable_options['.$key.']', '0', (isset($value['default']) && $value['default'] == '0' ) ? true : false, $no__input_options)!!}
                                                    {!! Form::label('editable_'.$key.'_yes', __('Yes')) !!}

                                                    <?php $yes_input_options = array('id' => 'editable_' . $key . '_yes')  ?>
                                                    @if(isset($value['has_options']) && 1 == $value['has_options'])
                                                        <?php $yes_input_options['onclick'] = "jQuery('#global_editable_options').find('" . $value['options_id'] . ((isset($value['scope']) && $value['scope'] != '') ? ('.' . $value['scope']) : '') . " ').show()"?>
                                                    @endif
                                                    @if(isset($value['default']) && 1 == (int)$value['default'])
                                                        <?php $yes_input_options['class'] = "standard-selection"?>
                                                    @endif
                                                    {!!Form::radio('editable_options['.$key.']', '1',(isset($value['default']) && $value['default'] == '1' ) ? true : false, $yes_input_options)!!}
                                                    {!! Form::label('editable_'.$key.'_check', __('Change')) !!}
                                                    {!!Form::checkbox('editable_options_check['.$key.']', '1',false, ['id' => 'editable_' . $key . '_check'])!!}
                                                @endif
                                            </div>
                                            @if(isset($value['has_options']) && 1 == $value['has_options'] )
                                                @if( '.tabAllowedFonts' == $value['options_id'] )
                                                    <?php $fieldName = 'use_font_sets_' . $value['option_field']; ?>
                                                    <?php $fontSelectName = 'font_set_' . $value['option_field']; ?>
                                                    <div class="tabAllowedFonts {{$value['scope']}}">
                                                        <div class="form-group row">
                                                            <div class="editable_option_title ">
                                                                {!! tooltip_icon('form', 'templates.use_font_sets') !!} <span style="font-weight: 700;">{{__('Use Font Sets')}}</span>
                                                            </div>
                                                            {!! Form::label('editable_'.$fieldName.'_no', __('No')) !!}
                                                            <?php $no__input_options = array('id' => 'editable_' . $fieldName . '_no') ?>
                                                            <?php $no__input_options['onclick'] = "jQuery('#global_editable_options').find('." . $fieldName . "font_set_select').hide();" .
                                                                "jQuery('#global_editable_options').find('." . $fieldName . "fonts_select').show();" ?>
                                                            {!!Form::radio('editable_options['.$fieldName.']', '0', isset($yes_no_options[$fieldName]) ? $yes_no_options[$fieldName] == '0' : true, $no__input_options)!!}
                                                            {!! Form::label('editable_'.$fieldName.'_yes', __('Yes')) !!}
                                                            <?php $yes_input_options = array('id' => 'editable_' . $fieldName . '_yes') ?>
                                                            <?php $yes_input_options['onclick'] = "jQuery('#global_editable_options').find('." . $fieldName . "font_set_select').show();" .
                                                                "jQuery('#global_editable_options').find('." . $fieldName . "fonts_select').hide();" ?>
                                                            {!!Form::radio('editable_options['.$fieldName.']', '1', isset($yes_no_options[$fieldName]) ? $yes_no_options[$fieldName] == '1' : false, $yes_input_options)!!}
                                                            {!! Form::label('editable_'.$fieldName.'_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check['.$fieldName.']', '1',false, ['id' => 'editable_' . $fieldName . '_check'])!!}
                                                        </div>
                                                        <?php
                                                        $use_font_sets = isset($yes_no_options[$fieldName]) ? ($yes_no_options[$fieldName] == 0 ? false : true) : false;
                                                        $allow_fonts = isset($yes_no_options['allow_fonts']) ? ($yes_no_options['allow_fonts'] == 0 ? 'none' : 'block') : (0 == $value['default'] ? 'none' : 'block');
                                                        ?>
                                                        <div
                                                            class="form-group {{$fieldName}}fonts_select ignore_js_toggle <?php if ($value['designer']) echo $designerClass;
                                                            if ($value['otp']) echo $otpClass; ?> {{$value['scope']}}"
                                                            style="display:<?php echo $allow_fonts && !$use_font_sets ? 'block' : 'none' ?>;"
                                                        >
                                                            <div class="editable_option_title">
                                                                {!! tooltip_icon('form', 'templates.allowed_fonts') !!} <span
                                                                    style="font-weight: 700;">{{__('Allowed Fonts:')}}</span>
                                                            </div>
                                                            <div class="float-right">
                                                                {!! Form::label('editable_'.$value['option_field'].'_check', __('Change')) !!}
                                                                {!!Form::checkbox('editable_options_check['.$value['option_field'].']', '1',false, ['id' => 'editable_' . $value['option_field'] . '_check'])!!}
                                                            </div>
                                                            @php
                                                                $font_value = isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '';
                                                                if ($font_value == '' && !isset($model)) {
                                                                    $font_value = $preselected_fonts;
                                                                }
                                                            @endphp
                                                            {!! Form::select('editable_options['.$value['option_field'].'][]', $template_fonts, $font_value,['multiple'=>'multiple','class' => 'form-control multiselect_template']) !!}
                                                        </div>
                                                        <div
                                                            class="form-group {{$fieldName}}font_set_select ignore_js_toggle <?php if ($value['designer']) echo $designerClass;
                                                            if ($value['otp']) echo $otpClass; ?>"
                                                            style="display:<?php echo $allow_fonts && $use_font_sets ? 'block' : 'none' ?>;"
                                                        >
                                                            <div class="editable_option_title">
                                                                {!! tooltip_icon('form', 'templates.font_set') !!} <span
                                                                    style="font-weight: 700;">{{__('Font Set:')}}</span>
                                                            </div>
                                                            <div class="float-right">
                                                                {!! Form::label('editable_'.$fontSelectName.'_check', __('Change')) !!}
                                                                {!!Form::checkbox('editable_options_check['.$fontSelectName.']', '1',false, ['id' => 'editable_' . $fontSelectName . '_check'])!!}
                                                            </div>
                                                            @php
                                                                $font_sets_value = isset($yes_no_options[$fontSelectName]) ? $yes_no_options[$fontSelectName] : '';
                                                                if ($font_sets_value == '' && !isset($model)) {
                                                                    $font_sets_value = $preselected_font_sets;
                                                                }
                                                            @endphp
                                                            {!! Form::select("editable_options[".$fontSelectName."]", $font_sets, $font_sets_value, ['class' => 'form-control cool_select', 'placeholder' =>'-'.__('none').'-']) !!}
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                            @if(isset($value['has_options']) && 1 == $value['has_options'] )
                                                @if( '.tabAllowedTexts' == $value['options_id'] )
                                                    <?php $fieldName = 'use_text_sets_' . $value['option_field']; ?>
                                                    <?php $textSelectName = 'text_set_' . $value['option_field']; ?>
                                                    <div class="tabAllowedTexts {{$value['scope']}}">
                                                        <div class="form-group row">
                                                            <div class="editable_option_title ">
                                                                {!! tooltip_icon('form', 'templates.use_text_sets') !!} <span style="font-weight: 700;">{{__('Use Text Sets')}}</span>
                                                            </div>
                                                            {!! Form::label('editable_'.$fieldName.'_no', __('No')) !!}
                                                            <?php $no__input_options = array('id' => 'editable_' . $fieldName . '_no') ?>
                                                            <?php $no__input_options['onclick'] = "jQuery('#global_editable_options').find('." . $fieldName . "text_set_select').hide();" .
                                                                "jQuery('#global_editable_options').find('." . $fieldName . "texts_select').show();" ?>
                                                            {!!Form::radio('editable_options['.$fieldName.']', '0', isset($yes_no_options[$fieldName]) ? $yes_no_options[$fieldName] == '0' : true, $no__input_options)!!}
                                                            {!! Form::label('editable_'.$fieldName.'_yes', __('Yes')) !!}
                                                            <?php $yes_input_options = array('id' => 'editable_' . $fieldName . '_yes') ?>
                                                            <?php $yes_input_options['onclick'] = "jQuery('#global_editable_options').find('." . $fieldName . "text_set_select').show();" .
                                                                "jQuery('#global_editable_options').find('." . $fieldName . "texts_select').hide();" ?>
                                                            {!!Form::radio('editable_options['.$fieldName.']', '1', isset($yes_no_options[$fieldName]) ? $yes_no_options[$fieldName] == '1' : false, $yes_input_options)!!}
                                                        </div>
                                                        <?php
                                                        $use_text_sets = isset($yes_no_options[$fieldName]) ? ($yes_no_options[$fieldName] == 0 ? false : true) : false;
                                                        $allow_texts = isset($yes_no_options['allow_texts']) ? ($yes_no_options['allow_texts'] == 0 ? 'none' : 'block') : (0 == $value['default'] ? 'none' : 'block');
                                                        ?>
                                                        <div
                                                            class="form-group {{$fieldName}}texts_select ignore_js_toggle <?php if ($value['designer']) echo $designerClass;if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?> {{$value['scope']}}"
                                                            style="display:<?php echo $allow_texts && !$use_text_sets ? 'block' : 'none' ?>;"
                                                        >
                                                            <div class="editable_option_title">
                                                                {!! tooltip_icon('form', 'templates.allowed_texts') !!} <span
                                                                    style="font-weight: 700;">{{__('Allowed Texts:')}}</span>
                                                            </div>
                                                            @php
                                                                $text_value = isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '';
                                                            @endphp
                                                            @php
                                                                $text_value = isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '';
                                                                if ($text_value == '' && !isset($model)) {
                                                                    $text_value = $preselected_texts;
                                                                }
                                                            @endphp
                                                            {!! Form::select('editable_options['.$value['option_field'].'][]', $template_texts, $text_value,['multiple'=>'multiple','class' => 'form-control multiselect_template']) !!}
                                                        </div>
                                                        <div
                                                            class="form-group {{$fieldName}}text_set_select ignore_js_toggle <?php if ($value['designer']) echo $designerClass;
                                                            if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass; ?>"
                                                            style="display:<?php echo $allow_texts && $use_text_sets ? 'block' : 'none' ?>;"
                                                        >
                                                            <div class="editable_option_title">
                                                                {!! tooltip_icon('form', 'templates.text_set') !!} <span
                                                                    style="font-weight: 700;">{{__('Text Set:')}}</span>
                                                            </div>
                                                            @php
                                                                $text_sets_value = isset($yes_no_options[$textSelectName]) ? $yes_no_options[$textSelectName] : '';
                                                                if ($text_sets_value == '' && !isset($model)) {
                                                                    $text_sets_value = $preselected_text_sets;
                                                                }
                                                            @endphp
                                                            {!! Form::select("editable_options[".$textSelectName."]", $text_sets, isset($yes_no_options[$textSelectName]) ? $yes_no_options[$textSelectName] : null, ['class' => 'form-control cool_select', 'placeholder' =>'-'.__('none').'-']) !!}
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                            @if(isset($value['has_options']) && 1 == $value['has_options'] )
                                                @if( '.tabShowHelperManual' == $value['options_id'] )

                                                    <div
                                                        class="tabShowHelperManual form-group <?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?>"
                                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                                        @endif
                                                        @elseif( 0 == $value['default']) style="display:none"
                                                        @endif >
                                                        <div class="editable_option_title" >
                                                            {!! tooltip_icon('form', 'templates.cms_helper_data') !!} <span
                                                                style="font-weight: 700;">{{__('CMS Helper Data:')}}</span>
                                                        </div>
                                                        <div class="float-right">
                                                            {!! Form::label('editable_'.$value['option_field'].'_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check['.$value['option_field'].']', '1',false, ['id' => 'editable_' . $value['option_field'] . '_check'])!!}
                                                        </div>
                                                        {!! Form::select('editable_options['.$value['option_field'].']', $template_cms, isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '',['multiple'=>false,'class' => 'form-control multiselect_template']) !!}
                                                    </div>
                                                @endif
                                            @endif
                                            @if(isset($value['has_options']) && 1 == $value['has_options'] )
                                                @if( '.tabAllowedColorsBackground' == $value['options_id'] )
                                                    <div class="tabAllowedColorsBackground {{$value['scope']}}">
                                                        <?php $fieldNameColorSet = 'use_color_sets_' . $value['option_field']; ?>
                                                        <?php $colorSelectName = 'color_set_' . $value['option_field']; ?>
                                                        <div class="form-group row">
                                                            <div class="editable_option_title ">
                                                                {!! tooltip_icon('form', 'templates.use_color_sets') !!} <span
                                                                    style="font-weight: 700;">{{__('Use Color Sets')}}</span>
                                                            </div>
                                                            {!! Form::label('editable_'.$fieldNameColorSet.'_no', __('No')) !!}
                                                            <?php $no__input_options = array('id' => 'editable_' . $fieldNameColorSet . '_no') ?>
                                                            <?php $no__input_options['onclick'] = "jQuery('#global_editable_options').find('." . $fieldNameColorSet . "_color_set_select').hide();" .
                                                                "jQuery('#global_editable_options').find('." . $fieldNameColorSet . "_colors_select').show();" ?>
                                                            {!!Form::radio('editable_options['.$fieldNameColorSet.']', '0', isset($yes_no_options[$fieldNameColorSet]) ? $yes_no_options[$fieldNameColorSet] == '0' : true, $no__input_options)!!}
                                                            {!! Form::label('editable_'.$fieldNameColorSet.'_yes', __('Yes')) !!}
                                                            <?php $yes_input_options = array('id' => 'editable_' . $fieldNameColorSet . '_yes') ?>
                                                            <?php $yes_input_options['onclick'] = "jQuery('#global_editable_options').find('." . $fieldNameColorSet . "_color_set_select').show();" .
                                                                "jQuery('#global_editable_options').find('." . $fieldNameColorSet . "_colors_select').hide();" ?>
                                                            {!!Form::radio('editable_options['.$fieldNameColorSet.']', '1', isset($yes_no_options[$fieldNameColorSet]) ? $yes_no_options[$fieldNameColorSet] == '1' : false , $yes_input_options)!!}
                                                            {!! Form::label('editable_'.$fieldNameColorSet.'_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check['.$fieldNameColorSet.']', '1',false, ['id' => 'editable_' . $fieldNameColorSet . '_check'])!!}
                                                        </div>
                                                        <?php
                                                        $use_font_sets = isset($yes_no_options[$fieldNameColorSet]) ? ($yes_no_options[$fieldNameColorSet] == 0 ? false : true) : false;
                                                        $allow_fonts = isset($yes_no_options['allow_fonts']) ? ($yes_no_options['allow_fonts'] == 0 ? 'none' : 'block') : (0 == $value['default'] ? 'none' : 'block');
                                                        ?>
                                                        <div
                                                            class="form-group {{$fieldNameColorSet}}_colors_select ignore_js_toggle <?php if ($value['designer']) echo $designerClass;
                                                            if ($value['otp']) echo $otpClass; ?>"
                                                            style="display:<?php echo $allow_fonts && !$use_font_sets ? 'block' : 'none' ?>;"
                                                        >
                                                            <div class="editable_option_title">
                                                                {!! tooltip_icon('form', 'templates.allowed') !!} <span
                                                                    style="font-weight: 700;">{{__('Allowed:')}}</span>
                                                            </div>
                                                            <div class="float-right">
                                                                {!! Form::label('editable_'.$value['option_field'].'_check', __('Change')) !!}
                                                                {!!Form::checkbox('editable_options_check['.$value['option_field'].']', '1',false, ['id' => 'editable_' . $value['option_field'] . '_check'])!!}
                                                            </div>
                                                            @php
                                                                $color_value = isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '';
                                                                if ($color_value == '' && !isset($model)) {
                                                                    $color_value = $preselected_colors;
                                                                }
                                                            @endphp
                                                            {!! Form::select('editable_options['.$value['option_field'].'][]', $template_colors, $color_value,['multiple'=>'multiple','class' => 'form-control multiselect_template']) !!}
                                                        </div>
                                                        <div
                                                            class="form-group {{$fieldNameColorSet}}_color_set_select ignore_js_toggle <?php if ($value['designer']) echo $designerClass;
                                                            if ($value['otp']) echo $otpClass; ?>"
                                                            style="display:<?php echo $allow_fonts && $use_font_sets ? 'block' : 'none' ?>;"
                                                        >
                                                            <div class="editable_option_title">
                                                                {!! tooltip_icon('form', 'templates.color_set') !!} <span
                                                                    style="font-weight: 700;">{{__('Color Set:')}}</span>
                                                            </div>
                                                            <div class="float-right">
                                                                {!! Form::label('editable_'.$colorSelectName.'_check', __('Change')) !!}
                                                                {!!Form::checkbox('editable_options_check['.$colorSelectName.']', '1',false, ['id' => 'editable_' . $colorSelectName . '_check'])!!}
                                                            </div>
                                                            @php
                                                                $color_sets_value = isset($yes_no_options[$colorSelectName]) ? $yes_no_options[$colorSelectName] : '';
                                                                if ($color_sets_value == '' && !isset($model)) {
                                                                    $color_sets_value = $preselected_color_sets;
                                                                }
                                                            @endphp
                                                            {!! Form::select("editable_options[".$colorSelectName."]", $color_sets, $color_sets_value, ['class' => 'form-control cool_select', 'placeholder' =>'-'.__('none').'-']) !!}
                                                        </div>
                                                    </div>
                                                @endif

                                            @endif
                                            @if(isset($value['has_options']) && 1 == $value['has_options'] )
                                                @if( '#tabAllowImageToShape' == $value['options_id'] )
                                                    <div
                                                        class="form-group row <?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?> "
                                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                                        @endif
                                                        @elseif( 0 == $value['default']) style="display:none"
                                                        @endif id="tabAllowImageToShape">
                                                        <div class="editable_option_title">
                                                            {!! tooltip_icon('form', 'templates.directly_convert_image_to_vector') !!} <span
                                                                style="font-weight: 700;">{{__('Directly Convert Image/Pdf to vector:')}}</span>
                                                        </div>
                                                        {!! Form::label('editable_allow_directly_convert_no', __('No')) !!}
                                                        {!!Form::radio('editable_options[allow_directly_convert]', '0', ((isset($yes_no_options['allow_directly_convert']) && $yes_no_options['allow_directly_convert'] == '0')||!isset($yes_no_options['allow_directly_convert']) ) ? true : false, ['class' => 'form-control'])!!}
                                                        {!! Form::label('editable_allow_directly_convert_yes', __('Yes')) !!}
                                                        {!!Form::radio('editable_options[allow_directly_convert]', '1', (isset($yes_no_options['allow_directly_convert']) && $yes_no_options['allow_directly_convert'] == '1' ) ? true : false, ['class' => 'form-control'])!!}
                                                        {!! Form::label('editable_allow_directly_convert_check', __('Change')) !!}
                                                        {!!Form::checkbox('editable_options_check[allow_directly_convert]', '1',false, ['id' => 'editable_allow_directly_convert_check'])!!}
                                                    </div>
                                                @endif
                                            @endif
                                            @if(isset($value['has_options']) && 1 == $value['has_options'] )
                                                @if( '.tabAllowedColors' == $value['options_id'] )
                                                    <div class="tabAllowedColors {{$value['scope']}}">
                                                        <?php $fieldNameColorSet = 'use_color_sets_' . $value['option_field']; ?>
                                                        <?php $colorSelectName = 'color_set_' . $value['option_field']; ?>
                                                        <div class="form-group row">
                                                            <div class="editable_option_title ">
                                                                {!! tooltip_icon('form', 'templates.use_color_sets') !!} <span
                                                                    style="font-weight: 700;">{{__('Use Color Sets')}}</span>
                                                            </div>
                                                            {!! Form::label('editable_'.$fieldNameColorSet.'_no', __('No')) !!}
                                                            <?php $no__input_options = array('id' => 'editable_' . $fieldNameColorSet . '_no') ?>
                                                            <?php $no__input_options['onclick'] = "jQuery('#global_editable_options').find('." . $fieldNameColorSet . "_color_set_select').hide();" .
                                                                "jQuery('#global_editable_options').find('." . $fieldNameColorSet . "_colors_select').show();" ?>
                                                            {!!Form::radio('editable_options['.$fieldNameColorSet.']', '0', isset($yes_no_options[$fieldNameColorSet]) ? $yes_no_options[$fieldNameColorSet] == '0' : true, $no__input_options)!!}
                                                            {!! Form::label('editable_'.$fieldNameColorSet.'_yes', __('Yes')) !!}
                                                            <?php $yes_input_options = array('id' => 'editable_' . $fieldNameColorSet . '_yes') ?>
                                                            <?php $yes_input_options['onclick'] = "jQuery('#global_editable_options').find('." . $fieldNameColorSet . "_color_set_select').show();" .
                                                                "jQuery('#global_editable_options').find('." . $fieldNameColorSet . "_colors_select').hide();" ?>
                                                            {!!Form::radio('editable_options['.$fieldNameColorSet.']', '1', isset($yes_no_options[$fieldNameColorSet]) ? $yes_no_options[$fieldNameColorSet] == '1' : false , $yes_input_options)!!}
                                                            {!! Form::label('editable_'.$fieldNameColorSet.'_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check['.$fieldNameColorSet.']', '1',false, ['id' => 'editable_' . $fieldNameColorSet . '_check'])!!}
                                                        </div>
                                                        <?php
                                                        $use_font_sets = isset($yes_no_options[$fieldNameColorSet]) ? ($yes_no_options[$fieldNameColorSet] == 0 ? false : true) : false;
                                                        $allow_fonts = isset($yes_no_options['allow_fonts']) ? ($yes_no_options['allow_fonts'] == 0 ? 'none' : 'block') : (0 == $value['default'] ? 'none' : 'block');
                                                        ?>
                                                        <div
                                                            class="form-group {{$fieldNameColorSet}}_colors_select ignore_js_toggle <?php if ($value['designer']) echo $designerClass;
                                                            if ($value['otp']) echo $otpClass; ?>"
                                                            style="display:<?php echo $allow_fonts && !$use_font_sets ? 'block' : 'none' ?>;"
                                                        >
                                                            <div class="editable_option_title">
                                                                {!! tooltip_icon('form', 'templates.allowed') !!} <span
                                                                    style="font-weight: 700;">{{__('Allowed:')}}</span>
                                                            </div>
                                                            <div class="float-right">
                                                                {!! Form::label('editable_'.$value['option_field'].'_check', __('Change')) !!}
                                                                {!!Form::checkbox('editable_options_check['.$value['option_field'].']', '1',false, ['id' => 'editable_' . $value['option_field'] . '_check'])!!}
                                                            </div>
                                                            @php
                                                                $color_value = isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '';
                                                                if ($color_value == '' && !isset($model)) {
                                                                    $color_value = $preselected_colors;
                                                                }
                                                            @endphp
                                                            {!! Form::select('editable_options['.$value['option_field'].'][]', $template_colors, $color_value,['multiple'=>'multiple','class' => 'form-control multiselect_template']) !!}
                                                        </div>
                                                        <div
                                                            class="form-group {{$fieldNameColorSet}}_color_set_select ignore_js_toggle <?php if ($value['designer']) echo $designerClass;
                                                            if ($value['otp']) echo $otpClass; ?>"
                                                            style="display:<?php echo $allow_fonts && $use_font_sets ? 'block' : 'none' ?>;"
                                                        >
                                                            <div class="editable_option_title">
                                                                {!! tooltip_icon('form', 'templates.color_set') !!} <span
                                                                    style="font-weight: 700;">{{__('Color Set:')}}</span>
                                                            </div>
                                                            <div class="float-right">
                                                                {!! Form::label('editable_'.$colorSelectName.'_check', __('Change')) !!}
                                                                {!!Form::checkbox('editable_options_check['.$colorSelectName.']', '1',false, ['id' => 'editable_' . $colorSelectName . '_check'])!!}
                                                            </div>
                                                            @php
                                                                $color_sets_value = isset($yes_no_options[$colorSelectName]) ? $yes_no_options[$colorSelectName] : '';
                                                                if ($color_sets_value == '' && !isset($model)) {
                                                                    $color_sets_value = $preselected_color_sets;
                                                                }
                                                            @endphp
                                                            {!! Form::select("editable_options[".$colorSelectName."]", $color_sets, $color_sets_value, ['class' => 'form-control cool_select', 'placeholder' =>'-'.__('none').'-']) !!}
                                                        </div>
                                                    </div>
                                                @endif

                                            @endif

                                            @if(isset($value['has_options']) && 1 == $value['has_options'] )
                                                @if( '.tabPantonesColor' == $value['options_id'] )
                                                    <div
                                                        class="tabPantonesColor text form-group<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?> {{$value['scope']}}"
                                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                                        @endif
                                                        @elseif( 0 == $value['default']) style="display:none"
                                                        @endif >
                                                        <div class="editable_option_title" >
                                                            {!! tooltip_icon('form', 'templates.default_pantone') !!} <span
                                                                style="font-weight: 700;">{{__('Default Pantone:')}}</span>
                                                        </div>
                                                        <div class="float-right">
                                                            {!! Form::label('editable_default_pantone_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check[default_pantone]', '1',false, ['id' => 'editable_default_pantone_check'])!!}
                                                        </div>
                                                        @php
                                                            $color_value = isset($yes_no_options['default_pantone']) ? $yes_no_options['default_pantone'] : '';
                                                            if ($color_value == '' && !isset($model)) {
                                                                $color_value = $preselected_colors;
                                                            }
                                                        @endphp
                                                        {!! Form::select('editable_options[default_pantone]', $template_colors, $color_value,['class' => 'multiselect_template form-control ']) !!}
                                                    </div>

                                                    <div class="tabPantonesColor text editable_option_title">
                                                        {!! tooltip_icon('form', 'templates.allow_max_number_of_pantone_colors') !!} <span
                                                            style="font-weight: 700;"><?php echo __('Allow max number of pantone colors');?></span>
                                                    </div>
                                                    <div class="tabPantonesColor text">
                                                        @if(isset($yes_no_options['allow_max_pantone_colors']))
                                                            {!! Form::label('editable_allow_max_pantone_colors_no', __('No')) !!}
                                                            <?php $no__input_options = array('id' => 'editable_allow_max_pantone_colors_no')  ?>
                                                            @if(isset($value['has_options']) && 1 == $value['has_options'])
                                                                <?php $no__input_options['onclick'] = "jQuery('#global_editable_options').find('.max_color_pantone_nr_value').removeClass('show')"?>
                                                            @endif
                                                            @if(isset($value['default']) && 0 == (int)$value['default'])
                                                                <?php $no__input_options['class'] = "standard-selection"?>
                                                            @endif
                                                            {!!Form::radio('editable_options[allow_max_pantone_colors]', '0', (isset($yes_no_options['allow_max_pantone_colors']) && $yes_no_options['allow_max_pantone_colors'] == '0' ) ? true : false, $no__input_options)!!}

                                                            {!! Form::label('editable_allow_max_pantone_colors_yes', __('Yes')) !!}
                                                            <?php $yes_input_options = array('id' => 'editable_allow_max_pantone_colors_yes')  ?>
                                                            @if(isset($value['has_options']) && 1 == $value['has_options'])
                                                                <?php $yes_input_options['onclick'] = "jQuery('#global_editable_options').find('.max_color_pantone_nr_value').addClass('show')"?>
                                                            @endif
                                                            @if(isset($value['default']) && 1 == (int)$value['default'])
                                                                <?php $no__input_options['class'] = "standard-selection"?>
                                                            @endif
                                                            {!!Form::radio('editable_options[allow_max_pantone_colors]', '1',(isset($yes_no_options['allow_max_pantone_colors']) && $yes_no_options['allow_max_pantone_colors'] == '1' ) ? true : false, $yes_input_options)!!}
                                                            {!! Form::label('editable_allow_max_pantone_colors_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check[allow_max_pantone_colors]', '1',false, ['id' => 'editable_allow_max_pantone_colors_check'])!!}
                                                        @else
                                                            {!! Form::label('editable_max_color_pantone_nr_no', __('No')) !!}
                                                            <?php $no__input_options = array('id' => 'editable_max_color_pantone_nr_no')  ?>
                                                            @if(isset($value['has_options']) && 1 == $value['has_options'])
                                                                <?php $no__input_options['onclick'] = "jQuery('#global_editable_options').find('.max_color_pantone_nr_value').removeClass('show')"?>
                                                            @endif
                                                            @if(isset($value['default']) && 0 == (int)$value['default'])
                                                                <?php $no__input_options['class'] = "standard-selection"?>
                                                            @endif
                                                            {!!Form::radio('editable_options[max_color_pantone_nr]', '0', (isset($value['default']) && $value['default'] == '0' ) ? true : false, $no__input_options)!!}
                                                            {!! Form::label('editable_max_color_pantone_nr_yes', __('Yes')) !!}

                                                            <?php $yes_input_options = array('id' => 'editable_max_color_pantone_nr_yes')  ?>
                                                            @if(isset($value['has_options']) && 1 == $value['has_options'])
                                                                <?php $yes_input_options['onclick'] = "jQuery('#global_editable_options').find('.max_color_pantone_nr_value').addClass('show')"?>
                                                            @endif
                                                            @if(isset($value['default']) && 1 == (int)$value['default'])
                                                                <?php $yes_input_options['class'] = "standard-selection"?>
                                                            @endif
                                                            {!!Form::radio('editable_options[max_color_pantone_nr]', '1',(isset($value['default']) && $value['default'] == '1' ) ? true : false, $yes_input_options)!!}
                                                            {!! Form::label('editable_max_color_pantone_nr_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check[max_color_pantone_nr]', '1',false, ['id' => 'editable_max_color_pantone_nr_check'])!!}
                                                        @endif
                                                    </div>
                                                    <div
                                                        class="<?php if (isset($yes_no_options['max_color_pantone_nr']) && $yes_no_options['max_color_pantone_nr']) echo 'show' ?>  tabPantonesColor text max_color_pantone_nr_value form-group<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?> ">
                                                        <div class="editable_option_title" >
                                                            {!! tooltip_icon('form', 'templates.max_number_of_pantone_colors') !!} <span
                                                                style="font-weight: 700;">{{__('Max number of pantone colors:')}}</span>
                                                        </div>
                                                        <div class="float-right">
                                                            {!! Form::label('editable_max_color_pantone_nr_value_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check[max_color_pantone_nr_value]', '1',false, ['id' => 'editable_max_color_pantone_nr_value_check'])!!}
                                                        </div>
                                                        {!! Form::text('editable_options[max_color_pantone_nr_value]', isset($yes_no_options['max_color_pantone_nr_value']) ? $yes_no_options['max_color_pantone_nr_value'] : '4', ['class' => 'form-control' ]) !!}
                                                    </div>
                                                @endif
                                            @endif

                                            @if(isset($value['has_options']) && 1 == $value['has_options'] )
                                                @if( '.tabAllowedShapeColors' == $value['options_id'] )

                                                    <div class="tabAllowedShapeColors {{$value['scope']}}">
                                                        <?php $fieldNameColorSet = 'use_color_sets_' . $value['option_field']; ?>
                                                        <?php $colorSelectName = 'color_set_' . $value['option_field']; ?>
                                                        <div class="form-group row">
                                                            <div class="editable_option_title ">
                                                                {!! tooltip_icon('form', 'templates.use_color_sets') !!} <span
                                                                    style="font-weight: 700;">{{__('Use Color Sets')}}</span>
                                                            </div>
                                                            {!! Form::label('editable_'.$fieldNameColorSet.'_no', __('No')) !!}
                                                            <?php $no__input_options = array('id' => 'editable_' . $fieldNameColorSet . '_no') ?>
                                                            <?php $no__input_options['onclick'] = "jQuery('#global_editable_options').find('." . $fieldNameColorSet . "_color_set_select').hide();" .
                                                                "jQuery('#global_editable_options').find('." . $fieldNameColorSet . "_colors_select').show();" ?>
                                                            {!!Form::radio('editable_options['.$fieldNameColorSet.']', '0', isset($yes_no_options[$fieldNameColorSet]) ? $yes_no_options[$fieldNameColorSet] == '0' : true, $no__input_options)!!}
                                                            {!! Form::label('editable_'.$fieldNameColorSet.'_yes', __('Yes')) !!}
                                                            <?php $yes_input_options = array('id' => 'editable_' . $fieldNameColorSet . '_yes') ?>
                                                            <?php $yes_input_options['onclick'] = "jQuery('#global_editable_options').find('." . $fieldNameColorSet . "_color_set_select').show();" .
                                                                "jQuery('#global_editable_options').find('." . $fieldNameColorSet . "_colors_select').hide();" ?>
                                                            {!!Form::radio('editable_options['.$fieldNameColorSet.']', '1', isset($yes_no_options[$fieldNameColorSet]) ? $yes_no_options[$fieldNameColorSet] == '1' : false , $yes_input_options)!!}
                                                            {!! Form::label('editable_'.$fieldNameColorSet.'_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check['.$fieldNameColorSet.']', '1',false, ['id' => 'editable_' . $fieldNameColorSet . '_check'])!!}
                                                        </div>
                                                        <?php
                                                        $use_font_sets = isset($yes_no_options[$fieldNameColorSet]) ? ($yes_no_options[$fieldNameColorSet] == 0 ? false : true) : false;
                                                        $allow_fonts = isset($yes_no_options['allow_fonts']) ? ($yes_no_options['allow_fonts'] == 0 ? 'none' : 'block') : (0 == $value['default'] ? 'none' : 'block');
                                                        ?>
                                                        <div
                                                            class="form-group {{$fieldNameColorSet}}_colors_select ignore_js_toggle <?php if ($value['designer']) echo $designerClass;
                                                            if ($value['otp']) echo $otpClass; ?>"
                                                            style="display:<?php echo $allow_fonts && !$use_font_sets ? 'block' : 'none' ?>;"
                                                        >
                                                            <div class="editable_option_title" >
                                                                {!! tooltip_icon('form', 'templates.allowed_shape_colors') !!} <span
                                                                    style="font-weight: 700;">{{__('Allowed Shape Colors:')}}</span>
                                                            </div>
                                                            <div class="float-right">
                                                                {!! Form::label('editable_'.$value['option_field'].'_check', __('Change')) !!}
                                                                {!!Form::checkbox('editable_options_check['.$value['option_field'].']', '1',false, ['id' => 'editable_' . $value['option_field'] . '_check'])!!}
                                                            </div>
                                                            @php
                                                                $color_value = isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '';
                                                                if ($color_value == '' && !isset($model)) {
                                                                    $color_value = $preselected_colors;
                                                                }
                                                            @endphp
                                                            {!! Form::select('editable_options['.$value['option_field'].'][]', $template_colors, $color_value,['multiple'=>'multiple','class' => 'form-control multiselect_template']) !!}
                                                        </div>
                                                        <div
                                                            class="form-group {{$fieldNameColorSet}}_color_set_select ignore_js_toggle <?php if ($value['designer']) echo $designerClass;
                                                            if ($value['otp']) echo $otpClass; ?>"
                                                            style="display:<?php echo $allow_fonts && $use_font_sets ? 'block' : 'none' ?>;"
                                                        >
                                                            <div class="editable_option_title" >
                                                                {!! tooltip_icon('form', 'templates.color_set') !!} <span
                                                                    style="font-weight: 700;">{{__('Color Set:')}}</span>
                                                            </div>
                                                            <div class="float-right">
                                                                {!! Form::label('editable_'.$colorSelectName.'_check', __('Change')) !!}
                                                                {!!Form::checkbox('editable_options_check['.$colorSelectName.']', '1',false, ['id' => 'editable_' . $colorSelectName . '_check'])!!}
                                                            </div>
                                                            @php
                                                                $color_sets_value = isset($yes_no_options[$colorSelectName]) ? $yes_no_options[$colorSelectName] : '';
                                                                if ($color_sets_value == '' && !isset($model)) {
                                                                    $color_sets_value = $preselected_color_sets;
                                                                }
                                                            @endphp
                                                            {!! Form::select("editable_options[".$colorSelectName."]", $color_sets, $color_sets_value, ['class' => 'form-control cool_select', 'placeholder' =>'-'.__('none').'-']) !!}
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                            @if(isset($value['has_options']) && 1 == $value['has_options'] )
                                                @if( '#tabAllowZoomer' == $value['options_id'] )
                                                    <div
                                                        class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?> {{$value['scope']}}"
                                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                                        @endif
                                                        @elseif( 0 == $value['default']) style="display:none"
                                                        @endif id="tabAllowZoomer">
                                                        <div class="editable_option_title" >
                                                            {!! tooltip_icon('form', 'templates.zoomer_default_value') !!} <span
                                                                style="font-weight: 700;">{{__('Zoomer Default Value:')}}</span>
                                                        </div>
                                                        <div class="float-right">
                                                            {!! Form::label('editable_'.$value['option_field'].'_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check['.$value['option_field'].']', '1',false, ['id' => 'editable_' . $value['option_field'] . '_check'])!!}
                                                        </div>
                                                        {!! Form::text('editable_options['.$value['option_field'].']', isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '200', ['class' => 'form-control']) !!}
                                                    </div>
                                                @endif
                                            @endif

                                            @if(isset($value['has_options']) && 1 == $value['has_options'] )
                                                @if( '#tabPreviewMagnifier' == $value['options_id'] )
                                                    <div
                                                        class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?> "
                                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                                        @endif
                                                        @elseif( 0 == $value['default']) style="display:none"
                                                        @endif id="tabPreviewMagnifier">
                                                        <div class="editable_option_title" >
                                                            {!! tooltip_icon('form', 'templates.magnifier_value') !!} <span
                                                                style="font-weight: 700;">{{__('Magnifier value:')}}</span>
                                                        </div>
                                                        <div class="float-right">
                                                            {!! Form::label('editable_magnifier_value_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check[magnifier_value]', '1',false, ['id' => 'editable_magnifier_value_check'])!!}
                                                        </div>
                                                        {!! Form::text('editable_options[magnifier_value]', isset($yes_no_options['magnifier_value']) ? $yes_no_options['magnifier_value'] : '200', ['class' => 'form-control' ]) !!}
                                                    </div>
                                                @endif
                                            @endif

                                            @if(isset($value['has_options']) && 1 == $value['has_options'] )
                                                @if( '#tabMultiplierValue' == $value['options_id'] )
                                                    <div
                                                        class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?> {{$value['scope']}}"
                                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                                        @endif
                                                        @elseif( 0 == $value['default']) style="display:none"
                                                        @endif id="tabMultiplierValue">
                                                        <div class="editable_option_title" style="float:left">
                                                            {!! tooltip_icon('form', 'templates.3d_image_quality_multiplier') !!} <span
                                                                style="font-weight: 700;">{{__('3D Image Quality Multiplier (values between 0.5 and 2):')}}</span>
                                                        </div>
                                                        <div class="float-right">
                                                            {!! Form::label('editable_'.$value['option_field'].'_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check['.$value['option_field'].']', '1',false, ['id' => 'editable_' . $value['option_field'] . '_check'])!!}
                                                        </div>
                                                        {!! Form::number('editable_options['.$value['option_field'].']', isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '1', ['class' => 'form-control quality_image_td_input', 'step'=>'0.1','min'=>'0.5','max'=>'2', 'style'=>'width: 400px;display: inline-block;']) !!}
                                                    </div>
                                                @endif
                                            @endif


                                            @if(isset($value['has_options']) && 1 == $value['has_options'] )
                                                @if( '#tabAllowMinimumFontsize' == $value['options_id'] )
                                                    <div
                                                        class=" form-group<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?> "
                                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                                        @endif
                                                        @elseif( 0 == $value['default']) style="display:none"
                                                        @endif id="tabAllowMinimumFontsize">
                                                        <div class="editable_option_title" >
                                                            {!! tooltip_icon('form', 'templates.minimum_font_size_value') !!} <span
                                                                style="font-weight: 700;">{{__('Minimum font size value:')}}</span>
                                                        </div>
                                                        <div class="float-right">
                                                            {!! Form::label('editable_allow_minimum_fontsize_value_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check[allow_minimum_fontsize_value]', '1',false, ['id' => 'editable_allow_minimum_fontsize_value_check'])!!}
                                                        </div>
                                                        {!! Form::text('editable_options[allow_minimum_fontsize_value]', isset($yes_no_options['allow_minimum_fontsize_value']) ? $yes_no_options['allow_minimum_fontsize_value'] : '72', ['class' => 'form-control']) !!}
                                                        pt
                                                    </div>
                                                @endif
                                            @endif

                                            @if(isset($value['has_options']) && 1 == $value['has_options'] )
                                                @if( '#tabAllowDefaultFont' == $value['options_id'] )
                                                    <div
                                                        class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?> {{$value['scope']}}"
                                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                                        @endif
                                                        @elseif( 0 == $value['default']) style="display:none"
                                                        @endif id="tabAllowDefaultFont">
                                                        <div class="editable_option_title" >
                                                            {!! tooltip_icon('form', 'templates.allowed_fonts') !!} <span
                                                                style="font-weight: 700;">{{__('Allowed Fonts')}}</span>
                                                        </div>
                                                        <div class="float-right">
                                                            {!! Form::label('editable_'.$value['option_field'].'_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check['.$value['option_field'].']', '1',false, ['id' => 'editable_' . $value['option_field'] . '_check'])!!}
                                                        </div>
                                                        @php
                                                            $font_value = isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '';
                                                            if ($font_value == '' && !isset($model)) {
                                                                $font_value = $preselected_fonts;
                                                            }
                                                        @endphp
                                                        {!! Form::select('editable_options['.$value['option_field'].']', $template_fonts, $font_value,['class' => 'form-control multiselect_template']) !!}
                                                    </div>
                                                @endif
                                            @endif

                                            @if(isset($value['has_options']) && 1 == $value['has_options'] )
                                                @if( '#tabAllowDefaultText' == $value['options_id'] )
                                                    <div
                                                        class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?> {{$value['scope']}}"
                                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                                        @endif
                                                        @elseif( 0 == $value['default']) style="display:none"
                                                        @endif id="tabAllowDefaultText">
                                                        <div class="editable_option_title" >
                                                            {!! tooltip_icon('form', 'templates.default_text') !!} <span
                                                                style="font-weight: 700;">{{__('Default Text')}}</span>
                                                        </div>
                                                        <div class="float-right">
                                                            {!! Form::label('editable_'.$value['option_field'].'_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check['.$value['option_field'].']', '1',false, ['id' => 'editable_' . $value['option_field'] . '_check'])!!}
                                                        </div>
                                                        {!! Form::text('editable_options['.$value['option_field'].']', isset($yes_no_options[$value['option_field']]) ?
                                                        $yes_no_options[$value['option_field']] : 'I am default text!', ['class' => 'form-control']) !!}
                                                    </div>
                                                @endif
                                            @endif


                                            @if(isset($value['has_options']) && 1 == $value['has_options'] )
                                                @if( '#tabBackgrounds' == $value['options_id'] )
                                                    <div
                                                        class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?>"
                                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                                        @endif
                                                        @elseif( 0 == $value['default']) style="display:none"
                                                        @endif id="tabBackgrounds">
                                                        <div class="editable_option_title" >
                                                            {!! tooltip_icon('form', 'templates.backgrounds') !!} <span
                                                                style="font-weight: 700;">{{__('Backgrounds:')}}</span>
                                                        </div>
                                                        <div class="float-right">
                                                            {!! Form::label('editable_allowed_backgrounds_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check[allowed_backgrounds]', '1',false, ['id' => 'editable_allowed_backgrounds_check'])!!}
                                                        </div>
                                                        @php
                                                            $background_value = isset($yes_no_options['allowed_backgrounds']) ? $yes_no_options['allowed_backgrounds'] : '';
                                                            if ($background_value == '' && !isset($model)) {
                                                                $background_value = $preselected_colors;
                                                            }
                                                        @endphp
                                                        {!! Form::select("editable_options[allowed_backgrounds][]", $template_backgrounds, $background_value,['multiple'=>'multiple','class' => 'form-control multiselect_template']) !!}
                                                    </div>
                                                @endif
                                            @endif

                                            @if(isset($value['has_options']) && 1 == $value['has_options'] )
                                                @if( '.tabSubmodels' == $value['options_id'] )
                                                    <div
                                                        class="tabSubmodels form-group<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?>"
                                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                                        @endif
                                                        @elseif( 0 == $value['default']) style="display:none"
                                                        @endif >
                                                        <div class="editable_option_title" >
                                                            {!! tooltip_icon('form', 'templates.submodels') !!} <span style="font-weight: 700;">{{__('Submodels:')}}</span>
                                                        </div>
                                                        <div class="float-right">
                                                            {!! Form::label('editable_allowed_submodels_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check[allowed_submodels]', '1',false, ['id' => 'editable_allowed_submodels_check'])!!}
                                                        </div>
                                                        {!! Form::select("editable_options[allowed_submodels][]", $template_submodels, isset($yes_no_options['allowed_submodels']) ? $yes_no_options['allowed_submodels'] : '',['multiple'=>'multiple','class' => 'form-control multiselect_template']) !!}
                                                    </div>
                                                    <div
                                                        class="tabSubmodels form-group<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?>"
                                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                                        @endif
                                                        @elseif( 0 == $value['default']) style="display:none"
                                                        @endif >
                                                        <div class="editable_option_title" >
                                                            {!! tooltip_icon('form', 'templates.default_submodel') !!} <span
                                                                style="font-weight: 700;">{{__('Default Submodel:')}}</span>
                                                        </div>
                                                        <div class="float-right">
                                                            {!! Form::label('editable_default_submodel_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check[default_submodel]', '1',false, ['id' => 'editable_default_submodel_check'])!!}
                                                        </div>
                                                        {!! Form::select("editable_options[default_submodel][]", $template_submodels, isset($yes_no_options['default_submodel']) ? $yes_no_options['default_submodel'] : '',['multiple'=>false,'class' => 'form-control multiselect_template']) !!}
                                                    </div>
                                                @endif
                                            @endif

                                            @if(isset($value['has_options']) && 1 == $value['has_options'] )
                                                @if( '.tabShapes' == $value['options_id'] )
                                                    <div class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?>"
                                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                                        @endif
                                                        @elseif( 0 == $value['default']) style="display:none"
                                                        @endif >
                                                        <div class="tabShapes">
                                                            <div class="form-group row">
                                                                <div class="editable_option_title ">
                                                                    {!! tooltip_icon('form', 'templates.use_shape_sets') !!} <span
                                                                    style="font-weight: 700;">{{__('Use Shape Sets')}}</span>
                                                                </div>
                                                                {!! Form::label('editable_'.'use_shape_sets'.'_no', __('No')) !!}
                                                                <?php $no__input_options = array('id' => 'editable_' . 'use_shape_sets' . '_no') ?>
                                                                <?php $no__input_options['onclick'] = "jQuery('#global_editable_options').find('.shape_set_select').hide();" .
                                                                    "jQuery('#global_editable_options').find('.shapes_select').show();" ?>
                                                                {!!Form::radio('editable_options['.'use_shape_sets'.']', '0', isset($yes_no_options['use_shape_sets']) ? $yes_no_options['use_shape_sets'] == '0' : true, $no__input_options)!!}
                                                                {!! Form::label('editable_'.'use_shape_sets'.'_yes', __('Yes')) !!}
                                                                <?php $yes_input_options = array('id' => 'editable_' . 'use_shape_sets' . '_yes') ?>
                                                                <?php $yes_input_options['onclick'] = "jQuery('#global_editable_options').find('.shape_set_select').show();" .
                                                                    "jQuery('#global_editable_options').find('.shapes_select').hide();" ?>
                                                                {!!Form::radio('editable_options['.'use_shape_sets'.']', '1', isset($yes_no_options['use_shape_sets']) ? $yes_no_options['use_shape_sets'] == '1' : false, $yes_input_options)!!}
                                                                {!! Form::label('editable_use_shape_sets_check', __('Change')) !!}
                                                                {!!Form::checkbox('editable_options_check[use_shape_sets]', '1',false, ['id' => 'editable_use_shape_sets_check'])!!}
                                                            </div>
                                                            <?php
                                                            $use_shape_sets = isset($yes_no_options['use_shape_sets']) ? ($yes_no_options['use_shape_sets'] == 0 ? false : true) : false;
                                                            $allow_shapes = isset($yes_no_options['allow_shapes']) ? ($yes_no_options['allow_shapes'] == 0 ? 'none' : 'block') : (0 == $value['default'] ? 'none' : 'block');
                                                            ?>
                                                            <div
                                                                class="form-group shapes_select ignore_js_toggle <?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; ?>"
                                                                style="display:<?php echo $allow_shapes && !$use_shape_sets ? 'block' : 'none' ?>;" {{$allow_shapes && !$use_shape_sets ? 'yes' : 'no'}}
                                                            >
                                                                <div class="editable_option_title" >
                                                                    {!! tooltip_icon('form', 'templates.shapes') !!} <span style="font-weight: 700;">{{__('Shapes:')}}</span>
                                                                </div>
                                                                <div class="float-right">
                                                                    {!! Form::label('editable_allowed_shapes_check', __('Change')) !!}
                                                                    {!!Form::checkbox('editable_options_check[allowed_shapes]', '1',false, ['id' => 'editable_allowed_shapes_check'])!!}
                                                                </div>
                                                                @php
                                                                    $shape_value = isset($yes_no_options['allowed_shapes']) ? $yes_no_options['allowed_shapes'] : '';
                                                                    if ($shape_value == '' && !isset($model)) {
                                                                        $shape_value = $preselected_shapes;
                                                                    }
                                                                @endphp
                                                                {!! Form::select("editable_options[allowed_shapes][]", $template_shapes, $shape_value,['multiple'=>'multiple','class' => 'form-control multiselect_template']) !!}
                                                            </div>
                                                            <div
                                                                class="form-group shape_set_select ignore_js_toggle <?php if ($value['designer']) echo $designerClass;if ($value['otp']) echo $otpClass; ?>"
                                                                style="display:<?php echo $allow_shapes && $use_shape_sets ? 'block' : 'none' ?>;" {{$allow_shapes && $use_shape_sets ? 'yes' : 'no'}}
                                                            >
                                                                <div class="editable_option_title" >
                                                                    {!! tooltip_icon('form', 'templates.shape_set') !!} <span
                                                                    style="font-weight: 700;">{{__('Shape Set:')}}</span>
                                                                </div>
                                                                <div class="float-right">
                                                                    {!! Form::label('editable_shape_set_check', __('Change')) !!}
                                                                    {!!Form::checkbox('editable_options_check[shape_set]', '1',false, ['id' => 'editable_shape_set_check'])!!}
                                                                </div>
                                                                @php
                                                                    $shape_sets_value = isset($yes_no_options['shape_set']) ? $yes_no_options['shape_set'] : '';
                                                                    if ($shape_sets_value == '' && !isset($model)) {
                                                                        $shape_sets_value = $preselected_shape_sets;
                                                                    }
                                                                @endphp
                                                                {!! Form::select("editable_options[shape_set]", $shape_sets, $shape_sets_value,['class' => 'form-control cool_select', 'placeholder' =>'-'.__('none').'-']) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                            @if(isset($value['has_options']) && 1 == $value['has_options'] )
                                                @if( '#tabAllowArticleLoad' == $value['options_id'] )
                                                    <div
                                                        class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?>"
                                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                                        @endif
                                                        @elseif( 0 == $value['default']) style="display:none"
                                                        @endif id="tabAllowArticleLoad">
                                                        <div class="editable_option_title" >
                                                            {!! tooltip_icon('form', 'templates.article_load_file') !!} <span
                                                                style="font-weight: 700;">{{__('Article load file:')}}</span>
                                                        </div>
                                                        <div class="float-right">
                                                            {!! Form::label('editable_allowed_article_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check[allowed_article]', '1',false, ['id' => 'editable_allowed_article_check'])!!}
                                                        </div>
                                                        {!! Form::select("editable_options[allowed_article][]", $article_files, isset($yes_no_options['allowed_article']) ? $yes_no_options['allowed_article'] : '',['class' => 'form-control allowed_file']) !!}
                                                    </div>
                                                @endif
                                            @endif     @if(isset($value['has_options']) && 1 == $value['has_options'] )

                                                @if( '#tabAllowNumberOfItems' == $value['options_id'] )
                                                    <div
                                                        class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?>"
                                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                                        @endif
                                                        @elseif( 0 == $value['default']) style="display:none"
                                                        @endif id="tabAllowNumberOfItems">
                                                        <div class="editable_option_title" >
                                                            {!! tooltip_icon('form', 'templates.number_of_items_in_sidebar') !!} <span
                                                                style="font-weight: 700;">{{__('Number of items in Sidebar:')}}</span>
                                                        </div>
                                                        <div class="float-right">
                                                            {!! Form::label('editable_'.$value['option_field'].'_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check['.$value['option_field'].']', '1',false, ['id' => 'editable_'.$value['option_field'].'_check'])!!}
                                                        </div>
                                                        {!! Form::text('editable_options['.$value['option_field'].']', isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '4', ['class' => 'form-control']) !!}
                                                    </div>
                                                @endif
                                            @endif

                                            @if(isset($value['has_options']) && 1 == $value['has_options'] )
                                                @if( '#tabAllowedLayouts' == $value['options_id'] )
                                                    <div
                                                        class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?>"
                                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                                        @endif
                                                        @elseif( 0 == $value['default']) style="display:none"
                                                        @endif id="tabAllowedLayouts">
                                                        <div class="editable_option_title" >
                                                            {!! tooltip_icon('form', 'templates.allowed_layouts') !!} <span
                                                                style="font-weight: 700;">{{__('Allowed Layouts:')}}</span>
                                                        </div>
                                                        <div class="float-right">
                                                            {!! Form::label('editable_'.$value['option_field'].'_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check['.$value['option_field'].']', '1',false, ['id' => 'editable_'.$value['option_field'].'_check'])!!}
                                                        </div>
                                                        {!! Form::select('editable_options['.$value['option_field'].'][]', $template_layouts, isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '',['multiple'=>'multiple','class' => 'form-control multiselect_template']) !!}
                                                    </div>
                                                @endif
                                            @endif

                                            @if(isset($value['has_options']) && 1 == $value['has_options'] )
                                                @if( '#tabFxTypes' == $value['options_id'] )
                                                    <div
                                                        class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?>"
                                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                                        @endif
                                                        @elseif( 0 == $value['default']) style="display:none"
                                                        @endif id="tabFxTypes">
                                                        <div class="editable_option_title" >
                                                            {!! tooltip_icon('form', 'templates.fxeffects') !!} <span style="font-weight: 700;">{{__('FxEffects:')}}</span>
                                                        </div>
                                                        <div class="float-right">
                                                            {!! Form::label('editable_allowed_fx_types_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check[allowed_fx_types]', '1',false, ['id' => 'editable_allowed_fx_types_check'])!!}
                                                        </div>
                                                        {!! Form::select("editable_options[allowed_fx_types][]", $refinements_template, isset($yes_no_options['allowed_fx_types']) ? $yes_no_options['allowed_fx_types'] : '',['multiple'=>'multiple','class' => 'form-control multiselect_template']) !!}
                                                    </div>
                                                @endif
                                            @endif

                                            @if(isset($value['has_options']) && 1 == $value['has_options'] )
                                                @if( '#tabRotationAngle' == $value['options_id'] )
                                                    <div
                                                        class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?> {{$value['scope']}}"
                                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                                        @endif
                                                        @elseif( 0 == $value['default']) style="display:none"
                                                        @endif id="tabRotationAngle">
                                                        <div class="editable_option_title" style="float:left">
                                                            {!! tooltip_icon('form', 'templates.rotation_angle_default_value') !!} <span
                                                                style="font-weight: 700;">{{__('Rotation angle default value')}}</span>
                                                        </div>
                                                        <div class="float-right">
                                                            {!! Form::label('editable_'.$value['option_field'].'_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check['.$value['option_field'].']', '1',false, ['id' => 'editable_'.$value['option_field'].'_check'])!!}
                                                        </div>
                                                        {!! Form::select('editable_options['.$value['option_field'].']', array('0'=>__('0 degree'),'90'=>__('90 degrees'),'180'=>__('180 degrees'),'270'=>__('270 degrees')), isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '0',['class' => 'form-control multiselect_template']) !!}
                                                    </div>
                                                @endif
                                            @endif

                                            @if(isset($value['has_options']) && 1 == $value['has_options'] )
                                                @if( '.tabWatermark' == $value['options_id'] )
                                                    <div
                                                        class=" tabWatermark form-group <?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?>"
                                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                                        @endif
                                                        @elseif( 0 == $value['default']) style="display:none"
                                                        @endif >
                                                        <div class="editable_option_title" >
                                                            {!! tooltip_icon('form', 'templates.allow_watermark_in_preview') !!} <span
                                                                style="font-weight: 700;">{{__('Allow watermark in Preview:')}}</span>
                                                        </div>
                                                        {!! Form::label('editable_allow_watermark_preview_no', __('No')) !!}
                                                        {!!Form::radio('editable_options[allow_watermark_preview]', '0', ((isset($yes_no_options['allow_watermark_preview']) && $yes_no_options['allow_watermark_preview'] == '0')||!isset($yes_no_options['allow_watermark_preview']) ) ? true : false, ['class' => 'form-control'])!!}
                                                        {!! Form::label('editable_allow_watermark_preview_yes', __('Yes')) !!}
                                                        {!!Form::radio('editable_options[allow_watermark_preview]', '1', (isset($yes_no_options['allow_watermark_preview']) && $yes_no_options['allow_watermark_preview'] == '1' ) ? true : false, ['class' => 'form-control'])!!}
                                                        {!! Form::label('editable_allow_watermark_preview_check', __('Change')) !!}
                                                        {!!Form::checkbox('editable_options_check[allow_watermark_preview]', '1',false, ['id' => 'editable_allow_watermark_preview_check'])!!}
                                                    </div>

                                                    <div
                                                        class=" tabWatermark form-group <?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?>"
                                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                                        @endif
                                                        @elseif( 0 == $value['default']) style="display:none"
                                                        @endif >
                                                        <div class="editable_option_title" >
                                                            {!! tooltip_icon('form', 'templates.watermark_text') !!} <span
                                                                style="font-weight: 700;">{{__('Watermark text:')}}</span>
                                                        </div>
                                                        <div class="float-right">
                                                            {!! Form::label('editable_watermark_text_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check[watermark_text]', '1',false, ['id' => 'editable_watermark_text_check'])!!}
                                                        </div>
                                                        {!! Form::text('editable_options[watermark_text]', isset($yes_no_options['watermark_text']) ? $yes_no_options['watermark_text'] : 'Watermark', ['class' => 'form-control']) !!}
                                                    </div>
                                                    <div
                                                        class=" tabWatermark form-group<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?> "
                                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                                        @endif
                                                        @elseif( 0 == $value['default']) style="display:none"
                                                        @endif >
                                                        <div class="editable_option_title" >
                                                            {!! tooltip_icon('form', 'templates.watermark_color') !!} <span
                                                                style="font-weight: 700;">{{__('Watermark color:')}}</span>
                                                        </div>
                                                        <div class="float-right">
                                                            {!! Form::label('editable_watermark_color_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check[watermark_color]', '1',false, ['id' => 'editable_watermark_color_check'])!!}
                                                        </div>
                                                        {!! Form::text('editable_options[watermark_color]', isset($yes_no_options['watermark_color']) ? $yes_no_options['watermark_color'] : '0 0 0 0', ['class' => 'form-control']) !!}
                                                    </div>
                                                    <div
                                                        class=" tabWatermark form-group<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?> <?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?>"
                                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                                        @endif
                                                        @elseif( 0 == $value['default']) style="display:none"
                                                        @endif >
                                                        <div class="editable_option_title" >
                                                            {!! tooltip_icon('form', 'templates.watermark_opaciy') !!} <span
                                                                style="font-weight: 700;">{{__('Watermark opacity:')}}</span>
                                                        </div>
                                                        <div class="float-right">
                                                            {!! Form::label('editable_watermark_opacity_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check[watermark_opacity]', '1',false, ['id' => 'editable_watermark_opacity_check'])!!}
                                                        </div>
                                                        {!! Form::text('editable_options[watermark_opacity]', isset($yes_no_options['watermark_opacity']) ? $yes_no_options['watermark_opacity'] : '0.9', ['class' => 'form-control']) !!}
                                                    </div>
                                                    <div class=" tabWatermark form-group "
                                                         @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                                         @endif
                                                         @elseif( 0 == $value['default']) style="display:none"
                                                        @endif >
                                                        <div class="editable_option_title" >
                                                            {!! tooltip_icon('form', 'templates.watermark_font_size') !!} <span
                                                                style="font-weight: 700;">{{__('Watermark font size:')}}</span>
                                                        </div>
                                                        <div class="float-right">
                                                            {!! Form::label('editable_watermark_size_check', __('Change')) !!}
                                                            {!!Form::checkbox('editable_options_check[watermark_size]', '1',false, ['id' => 'editable_watermark_size_check'])!!}
                                                        </div>
                                                        {!! Form::text('editable_options[watermark_size]', isset($yes_no_options['watermark_size']) ? $yes_no_options['watermark_size'] : '250', ['class' => 'form-control']) !!}
                                                    </div>
                                                @endif
                                            @endif

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2 form-sticky-sidebar">
        <div class="card-body form-buttons border">
            {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
            <a href="{!! route('admin.templates.index') !!}" class="btn btn-warning">{{__('Back')}}</a>
        </div>
    </div>

</div>

{!! Form::close() !!}

<script type="text/javascript">
    jQuery(document).ready(function () {
        var template_type = jQuery('.template_type').val();
        if (template_type == 'indesign' || template_type == 'pdf') {
            $('.engine_selectbox').show();
        } else {
            $('.engine_selectbox').hide();
        }
        $('.template_type').on('change', function () {
            var template_type = $('.template_type').val();
            if (template_type == 'indesign' || template_type == 'pdf') {
                $('.engine_selectbox').show();
            } else {
                $('.engine_selectbox').hide();
            }
        });
    });
</script>

<style>

    .svgPageTemplateDesigner {
        display: none;
    }

    .btn.addPage {
        display: inline-block !important;
    }

    .btn.editPersonalization {
        display: inline-block !important;
    }


    .max_color_pantone_nr_value {
        display: none !important;
    }

    .max_color_pantone_nr_value.show {
        display: block !important;
    }
</style>
<script type="text/javascript">
    var translateStrings = {
        'page': "<?php  echo __('Page '); ?>",
        'label': "<?php  echo __(' Label '); ?>"
    }
    $('.addPage').off('click').on('click', (function () {
        return function () {
            var template = $('.svgPageTemplateDesigner');
            var pageNumbers = $('.pagesContainer .pageItem').length;
            $(template).find('.current_page_nr').attr('value', pageNumbers);
            $(template).find('.preview_image').attr('data-page', pageNumbers);
            var pageTableLabels = $('.pagelabelsTable');
            var templatelabel = $($('.pageItemTemplate tbody').html());
            var pageTableImages = $('.pageImagesTable');
            var templateImage = $($('.pageItemPreviewImageTemplate tbody').html());

            templatelabel.attr('data-page', pageNumbers).data('page', pageNumbers);
            templateImage.attr('data-page', pageNumbers).data('page', pageNumbers);

            $(template).find('.pageItem').attr('data-page', pageNumbers).data('page', pageNumbers);
            $(template).find('.page_number_title').html(++pageNumbers);

            $('.pagesContainer').append(template.html().replace(/@{{page_index}}/g, pageNumbers));

            templatelabel.find('.title').html('Page ' + pageNumbers + ' Label');
            templatelabel.find('input').val('Page ' + pageNumbers);

            templateImage.find('th.name').html(translateStrings['page'] + pageNumbers);

            pageTableLabels.append(templatelabel);

            pageTableImages.append(templateImage);


        }
    })())


    $('.templateForm').submit(function () {


        var template_type = $('.template_type').val();
        if (template_type == 'svg') {
            $('.tableContent').remove();
        } else {
            $('.tableContentSVG').remove();
        }
    });

</script>
<script type="text/javascript">
    $(document).ready(function () {
        var activeTab = $('#lastTabId').val();
        if (activeTab != '#default') {
            $('.topMenuTemplate').children().each(function () {
                if ($(this).data('target') == activeTab) {
                    $('.topMenuTemplate .active').removeClass('active');
                    $(this).addClass('active');
                }
            })

            $('.template_section').each(function () {
                if ($(this).hasClass(activeTab)) {
                    $('.template_section.active').removeClass('active');
                    $(this).addClass('active');
                }
            })
        }

        $(".changeAll").off('click ifChanged').on('click ifChanged', function() {
            var tab = $(this).data('tab');
            if ($(this).is(':checked')) {
                $("#" + tab).find('input[type="checkbox"]').iCheck('check');
            } else {
                $("#" + tab).find('input[type="checkbox"]').iCheck('uncheck');
            }
        })
    });
</script>

