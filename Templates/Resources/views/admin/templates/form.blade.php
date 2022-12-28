<script>
    var template_edit_id = parseInt('<?php echo isset($model) && $model && !$model->use_as_default_template ? $model->id : 0 ?>');
</script>
<link rel="stylesheet" href="{{ URL::asset('admin/js/jsTree/themes/default/style.min.css') }}"/>
<script type="text/javascript" src="{{ URL::asset('js/collapsible.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('admin/js/jsTree/jstree.min.js') }}"></script>
<?php
$designerClass = ' is_editable_designer';
$otpClass = ' is_editable_otp';
$brochureClass = ' is_editable_brochure';
$pdfs = [];
$tmp = [];

if (is_array($personalization_pdfs) && count($personalization_pdfs)) {
    $index = 0;
    foreach ($personalization_pdfs as $key => $value) {
        $founds = array_filter($tmp, function ($v) use ($value) {
            return $v == $value;
        });

        $finds = count($founds);
        $pdfs[$key] = $value . ($finds ? "(" . $finds . ")" : '');
        $tmp[] = $value;
    }
}
?>
@if(session('error'))
    <div class="alert alert-danger">
        <strong>Error </strong> {{ session('error') }}
    </div>
@endif
@if(isset($model) )
    @if(!$model->use_as_default_template)
        {!! Form::model($model, ['method' => 'PUT', 'files' => true, 'class'=>'templateForm','route' => ['admin.templates.update', $model->id]]) !!}
    @else
        {!! Form::model($model, ['method' => 'POST', 'files' => true, 'class'=>'templateForm','route' => ['admin.templates.store']]) !!}
    @endif
@else
    {!! Form::open(['files' => true, 'route' => 'admin.templates.store','class'=>'templateForm']) !!}
@endif

<input type="hidden" name="lastTab" id="lastTabId" value="<?php if (isset($lastTab))
    echo $lastTab; else echo '#default';?>"/>
<input type="hidden" name="variable_order" class="variable_order" value="{{ isset($model) ? $model->variable_order : null }}">


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
                <li class="nav-item presentation_element td_preview" role="presentation">
                    <a href="#td_preview" role="tab" data-toggle="tab" class="nav-link">{{__('3D Preview')}}</a>
                </li>
                <li class="nav-item presentation_element video_preview" role="presentation">
                    <a href="#video_preview" role="tab" data-toggle="tab" class="nav-link">{{__('Video Preview')}}</a>
                </li>
                <li class="nav-item presentation_element svg" role="presentation">
                    <a href="#svg_area" role="tab" data-toggle="tab" class="nav-link">{{__('CUSTOM')}}</a>
                </li>
                @if($enableApi)
                    <li class="nav-item presentation_element api" role="presentation">
                        <a href="#api_area" role="tab" data-toggle="tab" class="nav-link">{{__('API')}}</a>
                    </li>
                @endif
                <li class="nav-item presentation_element pdf" role="presentation">
                    <a href="#pdf_area" role="tab" data-toggle="tab" class="nav-link">{{__('PDF')}}</a>
                </li>
                <li class="nav-item presentation_element indesign" role="presentation">
                    <a href="#indesign_area" role="tab" data-toggle="tab" class="nav-link">{{__('Indesign')}}</a>
                </li>
                <li class="nav-item presentation_element thumbnail_image" role="presentation">
                    <a href="#thumbnail_image" role="tab" data-toggle="tab" class="nav-link">{{__('Thumbnail')}}</a>
                </li>
                <li class="nav-item presentation_element variables" role="presentation">
                    <a href="#variables" role="tab" data-toggle="tab" class="nav-link">{{__('Variables')}}</a>
                </li>
            </ul>
            <div class="card-body collapse show border border-top-0 p-0 p-4" id="details-body">

                <div id="setup" role="tabpanel" class="template_section active">
                    <div class="form-group row">
                        {!! Form::label('name', __('Name:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('name', '<div class="text-danger">:message</div>') !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('code', __('Code:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('code', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('code', '<div class="text-danger">:message</div>') !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('description', __('Description:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::textarea('description', isset($model) ? $model->description : null, ['class' => 'form-control','id' => 'ckeditor','rows'=>'5']) !!}
                            {!! $errors->first('description', '<div class="text-danger">:message</div>') !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('template_type', __('Template Type:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('template_type',
                                array('svg'=>'CUSTOM','pdf'=>'PDF', 'indesign' => 'Indesign Package'), isset($model) ? $model->template_type : 'svg',['class' => 'template_type form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('template_source', __('Template Source:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('template_source',
                                array('Own'=>'Own','Api'=>'Api'), isset($model) ? $model->template_source : 'Own',['class' => 'template_source form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row engine_selectbox">
                        {!! Form::label('engine', __('Engine:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('engine', array('designer'=>'Designer','otp'=>'OTP','formular'=>'Formular','pdf_vt'=>'PDF/VT','brochure'=>'Brochure Editor'), isset($model) ? $model->engine : 'designer', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row image_qc_values">
                        {!! Form::label('engine', __('DPI steps for image quality check:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            <div class="image_dpi_steps">
                                {!! Form::number('default_dpi_step_0', 0, ['class' => 'form-control', 'disabled'=>true]) !!}
                                <div class="smiley bad">
                                    <i class="fa fa-frown-o"></i>
                                </div>
                                {!! Form::number('default_dpi_step_1', isset($model) ? $model->default_image_dpi_steps['meh']['low'] : 120, ['class' => 'form-control', 'min'=>0, 'max'=>999, 'step'=>1, 'id'=>'default_dpi_step_1']) !!}
                                <div class="smiley meh">
                                    <i class="fa fa-meh-o"></i>
                                </div>
                                {!! Form::number('default_dpi_step_2', isset($model) ? $model->default_image_dpi_steps['good']['low'] : 250, ['class' => 'form-control', 'min'=>0, 'max'=>999, 'step'=>1, 'id'=>'default_dpi_step_2']) !!}
                                <div class="smiley smile good">
                                    <i class="fa fa-smile-o"></i>
                                </div>
                                {!! Form::number('default_dpi_step_4',  99999, ['class' => 'form-control', 'disabled'=>true]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <?php $liveTemplatesConfig = getLiveTemplates()?>
                        {!! Form::label('psd_template', __('Live Template:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('psd_template', $liveTemplatesConfig, isset($model) ? $model->psd_template : 'test.psd', ['class' => 'select2-js form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('svg_live_template', __('SVG Live Template:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('svg_live_template', $personalization_svg_live_template_files, isset($model) ? $model->svg_live_template : 'test.svg', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('preview_type', __('Preview Type:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('preview_type', array('basic'=>'Basic Preview','tdpreview'=>'3D Preview','videopreview'=>'Video Preview','live'=>'Live Preview','svg_live'=>'SVG Live Preview'), isset($model) ? $model->preview_type : 'basic', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('preview_resolution', __('Preview Resolution:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('preview_resolution', isset($model) ? $model->preview_resolution : '150', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row formular_options">
                        {!! Form::label('preview_high_resolution', __('Preview High Resolution:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('preview_high_resolution', isset($model) ? $model->preview_high_resolution : '300', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('file_output', __('File Output:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('file_output', array('jpeg'=>'JPEG','png16m'=>'PNG','pngalpha'=>'PNG TRANSPARENCY'), isset($model) ? $model->file_output : 'jpeg', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('trim_box', __('Trimbox:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('trim_box', array('0'=>__('No'),'1'=>__('Yes')), isset($model) ? $model->trim_box : 0, ['class' => 'form-control', 'style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                    </div>
                    <div class="form-group row general_options">
                        {!! Form::label('confirm_checkbox', __('Enable confirm Checkbox:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('confirm_checkbox', array('0'=>__('No'),'1'=>__('Yes')), isset($model) ? $model->confirm_checkbox : 0, ['class' => 'form-control', 'style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('allow_save_load', __('Allow Personalization Save/Load:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('allow_save_load', array('0'=>__('No'),'1'=>__('Yes')), isset($model) ? $model->allow_save_load : 0, ['class' => 'form-control', 'style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('allow_download_pdf', __('Allow Download pdf:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('allow_download_pdf', array('0'=>__('No'),'1'=>__('Yes')), isset($model) ? $model->allow_download_pdf : 0, ['class' => 'form-control', 'style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                    </div>

                    <div class="form-group row formular_options">
                        {!! Form::label('personalization_pages', __('Personalization Pages:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('personalization_pages', isset($model) ? $model->personalization_pages : '0', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row formular_options" style="display:none">
                        {!! Form::label('project_default_title', __('Project Personalization Default Title:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('project_default_title', isset($model) ? $model->project_default_title : '', ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row formular_options">
                        {!! Form::label('project_default_text', __('Project Personalization Default Id:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('project_default_text', isset($model) ? $model->project_default_text : '', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row formular_options">
                        {!! Form::label('project_default_desc', __('Project Personalization Default Description:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('project_default_desc', isset($model) ? $model->project_default_desc : '', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row formular_options">
                        {!! Form::label('subtitle_note', __('Project Personalization Subtitle Note:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('subtitle_note', isset($model) ? $model->subtitle_note : 'default', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('watermark', __('Watermark:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('watermark', array('0'=>__('No'),'1'=>__('Yes')), isset($model) ? $model->watermark : 0, ['class' => 'form-control', 'style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('show_wtm_in_preview', __('Watermark in preview:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('show_wtm_in_preview', array('0'=>__('No'),'1'=>__('Yes')), isset($model) ? $model->show_wtm_in_preview : 0, ['class' => 'form-control', 'style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('watermark_size', __('Watermark Size:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('watermark_size', isset($model) ? $model->watermark_size : '400', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('watermark_text', __('Watermark Text:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('watermark_text', isset($model) ? $model->watermark_text : 'Watermark', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('watermark_color', __('Watermark Color:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('watermark_color', isset($model) ? $model->watermark_color : '0 0 0', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('watermark_opacity', __('Watermark Opacity:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('watermark_opacity', isset($model) ? $model->watermark_opacity : '5', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row formular_options">
                        {!! Form::label('auto_preview', __('Auto preview:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('auto_preview', array('0'=>__('No'),'1'=>__('Yes')), isset($model) ? $model->auto_preview : 0, ['class' => 'form-control', 'style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('use_small_images', __('Use Resized Images For Preview:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('use_small_images', array('0'=>__('No'),'1'=>__('Yes')), isset($model) ? $model->use_small_images : 0, ['class' => 'form-control', 'style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                    </div>
                    <div class="form-group row formular_options">
                        {!! Form::label('allow_save_data', __('Enable customer personalization data save:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('allow_save_data', array('0'=>__('No'),'1'=>__('Yes')), isset($model) ? $model->allow_save_data : 0, ['class' => 'form-control', 'style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('allow_article_load', __('Allow  Article Load:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('allow_article_load', array('0'=>__('No'),'1'=>__('Yes')), isset($model) ? $model->allow_article_load : 0, ['class' => 'form-control', 'style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <?php $articleLoadConfig = getArticleLoadFilesFromRepository()?>
                        {!! Form::label('article_load_file', __('Article Load File:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('article_load_file', $articleLoadConfig, isset($model) ? $model->article_load_file : 'addresen.xls', ['class' => 'select2-js form-control','style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                    </div>
                    <div class="form-group row designer_options">
                        {!! Form::label('activate_white_underprint', __('Activate White Underprint:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('activate_white_underprint', array('0'=>__('No'),'1'=>__('Yes')), isset($model) ? $model->activate_white_underprint : 0, ['class' => 'form-control', 'style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                    </div>
                    <div class="form-group row" style="display:none">
                        {!! Form::label('activate_white_underprint_per_block', __('Activate White Underprint Per Block:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('activate_white_underprint_per_block', array('0'=>__('No'),'1'=>__('Yes')), isset($model) ? $model->activate_white_underprint_per_block : 0, ['class' => 'form-control', 'style' => 'width:50%;display: inline-block;']) !!}
                        </div>
                    </div>
                    {!! Form::text('id', isset($model) ? $model->id : '0', ['id'=>'inEditTemplateId','class' => 'form-control','style'=>'display:none;']) !!}
                    <div class="form-group row">
                        @php
                            $store_selection_key = config('stores.store_selection_key');
                            if (isset($model)) {
                                $model->{$store_selection_key} = $model->webstores->pluck('store_id')->toArray();
                            }
                        @endphp
                        {!! Form::label($store_selection_key, __('Stores:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! \StoreSelection::toHtml() !!}
                        </div>
                    </div>
                </div>

                <div id="td_preview" role="tabpanel" class="template_section">
                    <div class="form-group row">
                        {!! Form::label('td_filename', __('3D Model:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('td_filename', getPersonalizationTdfiles(), null, ['class' => 'select2-js form-control']) !!}
                        </div>
                    </div>
                    <div class="col-sm-10 offset-sm-2 row px-0">
                        {!! Form::text('td_data', isset($model) ? $model->td_data : '300', ['id'=>'td_data','class' => 'd-none']) !!}
                        <table class="table table-bordered td_texture_table">
                            <thead class="thead-default">
                            <tr>
                                <th>{{__('Texture')}}</th>
                                <th>{{__('Assign PDF Page')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if( isset($model) ) {
                            $td_data = json_decode($model->td_data, true);
                            $td_data_no = is_array($td_data) ? count($td_data) : 0;
                            if( $td_data_no ) {
                            $row = 1;
                            for( $i = 0; $i < $td_data_no; $i += 2 ) {
                            ?>
                            <tr row="<?php echo $row; ?>">
                                <td>
                                    <input class="form-control texture" value="<?php echo $td_data[$i]; ?>"
                                           name="row-<?php echo $row; ?>-texture" type="text" id="name">
                                </td>
                                <td>
                                    <input class="form-control pdf_page" value="<?php echo $td_data[$i + 1]; ?>"
                                           name="row-<?php echo $row; ?>-pdf-page" type="text" id="name">
                                </td>
                                <td>
                                    <button type="button"
                                            class="btn btn-primary delete-row">{{__('Delete')}}</button>
                                </td>
                            </tr>
                            <?php
                            $row++;
                            }
                            }
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="4" class="a-right" style="text-align:right;">
                                    <button type="button"
                                            class="btn btn-primary addNewTDModelTexture">{{__('Add Row')}}</button>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div id="video_preview" role="tabpanel" class="template_section">
                    <div class="form-group row">
                        {!! Form::label('video_filename', __('Video Model:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('video_filename', getPersonalizationVideofiles(), null, ['class' => 'select2-js form-control']) !!}
                        </div>
                    </div>
                </div>

                <div id="svg_area" role="tabpanel" class="template_section">
                    <div class="pagesContainer">
                        <?php
                        $isSaved = 0;
                        $background_svg_content = array('dummy');
                        if (isset($model)) {
                            $isSaved = 1;
                            $background_svg_content = json_decode($model->custom_blocks_designer, true);

                        }

                        ?>
                        <?php
                        $background_svg_no = isset($background_svg_content) && is_array($background_svg_content) ? count($background_svg_content) : 0;
                        for($i = 0; $i < $background_svg_no; $i++): ?>
                        <div class="pageItem mb-2" data-page="<?php echo $i?>">
                            <a href="#page-{{$i}}-body" data-toggle="collapse"
                               class="d-flex justify-content-start flex-wrap flex-md-nowrap align-items-center p-3 border bg-light mb-0 h6 text-decoration-none">
                                <?php echo __('Page ')?>
                                <span class="page_number_title">&nbsp;<?php echo($i + 1);?></span>
                            </a>
                            <div class="border p-2" id="page-{{$i}}-body">
                                <div class="form-group row">
                                    {!! Form::label('unit', __('Unit'), ['class' => 'col-md-2 text-right col-form-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::select('unit[]', array('pt'=>'Points','mm'=>'Millimeters'), isset($model) ? $background_svg_content[$i]['unit'] : 'designer', ['class' => 'select2-js form-control unit_designer']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('width', __('Width'), ['class' => 'col-md-2 text-right col-form-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('width[]', isset($model) ?  $background_svg_content[$i]['width']: null, ['class' => 'form-control width_designer']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('height', __('Height'), ['class' => 'col-md-2 text-right col-form-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('height[]', isset($model) ?  $background_svg_content[$i]['height'] : null, ['class' => 'form-control height_designer']) !!}
                                    </div>
                                </div>
                                <div class="form-group row d-none">
                                    {!! Form::textarea('svg_content[]', $isSaved && isset($background_svg_content[$i]['svg_content']) && strlen($background_svg_content[$i]['svg_content']) ? $background_svg_content[$i]['svg_content'] : null, ['class' => 'form-control svg_content', 'rows'=>'5']) !!}
                                </div>
                                <input class="current_page_nr" name="current_page_nr[]" value="<?php echo $i;?>" hidden>
                                <input class="preview_image_input" name="preview_image[]"
                                       value="<?php echo $isSaved && isset($background_svg_content[$i]['preview_image']) && strlen($background_svg_content[$i]['preview_image']) ? $background_svg_content[$i]['preview_image'] : ''?>"
                                       hidden>
                                <div class="col-sm-10 offset-sm-2 px-0">
                                    <img class="preview_image" data-page="<?php echo $i;?>"
                                         src="<?php echo $isSaved && isset($background_svg_content[$i]['preview_image']) && strlen($background_svg_content[$i]['preview_image']) ? $background_svg_content[$i]['preview_image'] : url('/') . '/images/noimage.gif'?>">
                                    <?php if(isset($model)):?>
                                    <button type="button" class="btn btn-primary editPersonalization"><?php echo __('Edit SVG')?></button>
                                    <button type="button" class="btn btn-danger deleteContentPersonalization"><?php echo __('Delete Content')?></button>
                                    <?php endif ?>
                                    <button type="button"
                                            class="btn btn-danger deletePage">{{__('Delete Page')}}</button>
                                </div>
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>
                    <button type="button" class="btn btn-primary addPage mt-2">{{__('Add Page')}}</button>
                    <div class="card">
                        <a href="#custom-options-body" data-toggle="collapse"
                           class="d-flex justify-content-start flex-wrap flex-md-nowrap align-items-center p-3 border bg-light mb-0 h6 text-decoration-none">
                            <?php echo __('Options ')?>
                        </a>
                        <div class="card-body collapse show" id="custom-options-body">
                            <div class="tableContentSVG">
                                @if(isset($previews_svg))
                                    {!!$previews_svg!!}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if($enableApi)
                    <div id="api_area" role="tabpanel" class="template_section">
                        <div class="form-group row">
                            {!! Form::label('color_picker', __('Color picker'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::select('color_picker', array('0'=>__('No'),'1'=>__('Yes')), isset($model) ? $model->color_picker : 0, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('api_product_type', __('API Product Type'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::select('api_product_type', $apiProductTypes, isset($model) ? $model->api_product_type : 0, ['class' => 'select2-js form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('api_categories_q', __('Highlight'), ['class' => 'col-md-2 text-right col-form-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::text('api_categories_q', null, ['id'=>'api_categories_q','class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('api_product_type', __('API categories :'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::hidden('api_categories', isset($model) ? $model->api_categories : '', ['id'=>'api_categories','class' => 'form-control','style'=>'display:none;']) !!}
                                <div id="jstree_api_categories"></div>
                            </div>
                        </div>
                    </div>
                @endif

                <div id="pdf_area" role="tabpanel" class="template_section">
                    <div class="container-pad-15 pdf-form-group">
                        <div class="form-group row">
                            {!! Form::label('background_pdf', __('Background PDF:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                            <div class="col-sm-10 justify-content-between d-flex">
                                {!! Form::select('background_pdf', $pdfs, isset($model) && $model ? $model->background_pdf_uuid : null, ['class' => 'select2-js form-control col-sm-8']) !!}
                                <a id='download_pdf_file' href="javascript:void(0)">
                                    <button type="button" class="btn btn-primary">{{__('Download PDF')}}</button>
                                </a>
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('pdf', __('Select a PDF to upload'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                            <div class="col-sm-10">
                                <div class="custom-file">
                                    {!! Form::file('pdf', ['id' => 'pdf','title'=>__('Select a PDF to upload'), 'class' => 'custom-file-input']) !!}
                                    {!! Form::label('pdf', __('Choose file'), ['class' => 'custom-file-label']) !!}
                                </div>
                                <div class="admin__field-note">
                                    <span>{!! __('This will replace your current background PDF') !!}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('default_pdf', __('Select a Default PDF to upload'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                            <div class="col-sm-10">
                                <div class="custom-file">
                                    {!! Form::file('default_pdf', ['id' => 'default_pdf','title'=>__('Select a Default PDF to upload'), 'class' => 'custom-file-input']) !!}
                                    {!! Form::label('default_pdf', __('Choose file'), ['class' => 'custom-file-label']) !!}
                                </div>
                                <?php if($thumbnailDefaultPdfUrl):?>
                                <img src="<?php echo $thumbnailDefaultPdfUrl ?>" style="width:100px;height:auto"/>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('overwrite_pdf', __('Overwrite Current PDF:'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                            <div class="col-sm-10">
                                <input id="overwrite_pdf" name="overwrite_pdf" value="1"
                                       title="__('Overwrite Current PDF:')"
                                       class="form-control"
                                       type="checkbox">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2 text-right">
                                <button type="button" class="btn btn-small btn-primary toggle-blocks-info">
                                    {{__('Toggle Blocks Info')}}
                                </button>
                            </div>
                            <div class="col-sm-10">
                                <table id="blocksInfos" class="table table-bordered table-hover">
                                    <thead class="thead-dark">
                                        <tr id="heading">
                                            <th class="pdfs">{{__('Page')}}</th>
                                            <th class="pdfs">{{__('Name')}}</th>
                                            <th class="pdfs">{{__('Type')}}</th>
                                            <th class="pdfs">{{__('Custom options')}}</th>
                                            <th class="pdfs">{{__('Custom Rules')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="d-none"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <a href="#pdf_options-body" data-toggle="collapse"
                                     class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 border bg-light mb-0 h6 text-decoration-none">
                        {{ __('Options') }}
                    </a>

                    <div class="card-body collapse show border border-top-0 p-2" id="pdf_options-body">
                        <div class="tableContent">
                            @if(isset($previews))
                                {!!$previews!!}
                            @endif
                        </div>
                    </div>

                    @include('templates::admin.templates.allowed_custom_options')

                </div>

                <div id="indesign_area" role="tabpanel" class="template_section">
                    <?php
                    $indesignOptions = array('-1' => __('Please Select an Indesign Package...'));
                    $dataType = array('-1' => ['data-type' => '']);
                    if (count($template_indesignPackage)) {
                        foreach ($template_indesignPackage as $package) {
                            $indesignOptions[$package->id] = $package->name;
                            $dataType[$package->id] = ['data-type' => $package->editor_type];
                        }
                    }
                    $defaultOption = -1;
                    if (isset($model)) {
                        $defaultOption = $model->indesign_package_id;
                    }
                    ?>

                    <div class="row form-group">
                        {!! Form::label('indesignPackage', __('Indesign Package:'), ['class' =>'col-sm-2 text-right col-form-label' ]) !!}
                        <div class="col-sm-10">
                            {!! Form::select('indesignPackageId', $indesignOptions, $defaultOption, ['class' => 'select2-js form-control indesignPackage'], $dataType) !!}
                        </div>
                    </div>
                </div>

                <div id="thumbnail_image" role="tabpanel" class="template_section">
                    <div class="form-group row">
                        {!! Form::label('thumbnail_image', __('Select a Thumbnail image to upload'), ['class' => 'col-sm-2 text-right col-form-label']) !!}
                        <div class="col-sm-10">
                            <div class="custom-file">
                                {!! Form::file('thumbnail_image', ['id' => 'thumbnail_image','title'=>__('Select a Thumbnail image to upload'), 'class' => 'custom-file-input']) !!}
                                {!! Form::label('thumbnail_image', __('Choose file'), ['class' => 'custom-file-label']) !!}
                            </div>
                            <div class="admin__field-note">
                                <span>{!! __('This will replace your current Thumbnail Image') !!}</span>
                            </div>
                            <?php if($thumbnailUrl):?>
                                <img src="<?php echo $thumbnailUrl ?>" class="img img-responsive" style="width:100px;height:auto"/>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div role="tabpanel" class="template_section" id="global_editable_options">
                    <div class="row d-flex justify-content-around">
                        <?php
                        if (isset($model)) {
                            $editable_options = getYesNoPersonalizationOptions();

                            $yes_no_options = unserialize($model->editable_options);

                        } else {
                            $editable_options = getYesNoPersonalizationOptions();
                            $yes_no_options = array();
                        }
                        $count = count($editable_options);
                        $middle = floor($count/2);
                        $i = 0;
                        ?>
                        <div class="col-md-6"></div>
                        <div class="col-md-2">
                            <span style="font-weight: 700; line-height: 30px;">{{ __('Search Options:') }}</span>
                        </div>
                        <div class="col-md-4 mb-2 search_container">
                            <input type="text" class="search_options float-right form-control">
                            <i class="fa fa-times-circle clear_search"></i>
                            <ul class="dropdown-menu">
                            </ul>
                        </div>
                        @include('templates::admin.templates.editable_options')
                    </div>
                </div>
                <div id="variables" role="tabpanel" class="template_section">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2 form-sticky-sidebar">
        <div class="card-body form-buttons border">
            @if(isset($model))
                <button class="btn btn-primary saveTemplate previewTemplate" name="redirect" value="preview"
                        type="button">{{__('Preview')}}</button>
            @endif
            {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
            {!! Form::submit(__('Save and continue'), ['class' => 'btn btn-info', 'name'=> 'save_and_continue']) !!}
            <a href="{!! route('admin.templates.index') !!}" class="btn btn-warning">{{__('Back')}}</a>
        </div>
    </div>

</div>

{!! Form::close() !!}

<table class="pageItemPreviewImageTemplate" style="display:none;">
    <tr data-page="">
        <th scope="row" class="name"></th>
        <td>
            <div class="table_preview_images">
                {!! Form::label('preview_image_svg[]', __('Preview Image:')) !!}
                {!! Form::file('preview_image_svg[]') !!}
                <button type="button" style="margin-left: 15px;margin-bottom: 4px;" class="btn btn-primary"
                        onclick="jQuery(this).next().toggleClass('opened')">{{__('Toggle Preview')}}</button>
                <div style="display: none" class="preview_image"><img
                        src="<?php echo url('/') . '/personalization/previews/noimage.gif'?>" alt="{{ __('Preview Image')
                }}"/></div>
            </div>
            <div class="table_preview_images">
                {!! Form::label('thumbnail_image_svg[]', __('Thumbnail Image:')) !!}
                {!! Form::file('thumbnail_image_svg[]') !!}
                <button type="button" style="margin-left: 15px;margin-bottom: 4px;" class="btn btn-primary"
                        onclick="jQuery(this).next().toggleClass('opened')">{{__('Toggle Preview')}}</button>
                <div style="display: none" class="thumbnail_image"><img
                        src="<?php echo url('/') . '/personalization/previews/noimage.gif'?>"
                        alt="{{ __('Thumbnail Image') }}"/></div>
            </div>
        </td>
    </tr>
</table>

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

<div class="svgPageTemplateDesigner">
    <div class="pageItem mb-2" data-page="@{{page_index}}">
        <a href="#page-@{{page_index}}-body" data-toggle="collapse"
           class="d-flex justify-content-start flex-wrap flex-md-nowrap align-items-center p-3 border bg-light mb-0 h6 text-decoration-none">
            <?php echo __('Page ')?>&nbsp;<span class="page_number_title"></span>
        </a>
        <div class="border p-2 collapse show" id="page-@{{page_index}}-body">
            <div class="form-group row">
                {!! Form::label('unit', __('Unit'), ['class' => 'col-md-2 text-right col-form-label']) !!}
                <div class="col-sm-10">
                    {!! Form::select('unit[]', array('pt'=>'Points','mm'=>'Millimeters'), isset($model) ? $model->unit : 'designer', ['class' => 'form-control unit_designer']) !!}
                </div>
            </div>
            <div class="form-group row">
                {!! Form::label('width', __('Width'), ['class' => 'col-md-2 text-right col-form-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('width[]', 100, ['class' => 'form-control width_designer']) !!}
                </div>
            </div>
            <div class="form-group row">
                {!! Form::label('height', __('Height'), ['class' => 'col-md-2 text-right col-form-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('height[]', 100, ['class' => 'form-control height_designer']) !!}
                </div>
            </div>
            <div class="form-group row d-none">
                {!! Form::textarea('svg_content[]', null, ['class' => 'form-control svg_content', 'rows'=>'5']) !!}
            </div>

            <input class="current_page_nr" name="current_page_nr[]" value="<?php echo $i;?>" hidden>

            <div class="col-sm-10 offset-sm-2 px-0">
                <img class="preview_image" src="<?php echo url('/') . '/images/noimage.gif'?>">
                <input class="preview_image_input" name="preview_image[]" value="" hidden>
                <?php if(isset($model)):?>
                <button type="button" class="btn btn-primary editPersonalization"><?php echo __('Edit SVG')?></button>
                <button type="button" class="btn btn-danger deleteContentPersonalization"><?php echo __('Delete Content')?></button>
                <?php endif;?>
                <button type="button" class="btn btn-danger deletePage">{{__('Delete Page')}}</button>
            </div>
        </div>
    </div>
</div>
<table class="pageItemTemplate" style="display:none;">
    <tr>
        <th scope="row" class="title">{{__('Page ')}}</th>
        <td>
            <div class="table_preview_images">
                {!! Form::text('editor_options[page_labels][]','',['class' => 'form-control']) !!}
            </div>

        </td>
    </tr>
</table>
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
    $('.previewTemplate').off('click').on('click', (function () {
        return function () {
                <?php if( isset($model) && !$model->use_as_default_template ) { ?>
            var url = "{{ route('admin.templates.preview', $model->id)}}";
            ;
            window.open(url, '_blank');
            <?php } ?>
        }
    })())
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
    $('.pagesContainer').off('click', '.deletePage').on('click', '.deletePage', (function () {
        return function () {

            if ($('.pagesContainer .pageItem').length == 1) {
                alert("You can't delete all pages");
            } else {
                var pageItem = $(this).parents('.pageItem');
                var pageNumber = $(pageItem).data('page');
                $('.pageImagesTable').find('tr[data-page="' + pageNumber + '"]').remove();
                $('.pagelabelsTable').find('tr[data-page="' + pageNumber + '"]').remove();
                pageItem.remove();
                $.each($('.pageImagesTable tbody tr'), function (index, row) {
                    $(row).attr('data-page', index);
                    $(row).find('th.name').html(translateStrings['page'] + (index + 1));
                });

                $.each($('.pagelabelsTable tbody tr'), function (index, row) {
                    $(row).attr('data-page', index);
                    $(row).find('th.name').html(translateStrings['page'] + (index + 1) + translateStrings['label']);
                });

                var pages = $('.pagesContainer .pageItem');

                if (pages.length) {
                    $.each(pages, (function () {
                        return function (index, page) {
                            $(page).find('.page_number_title').html(index + 1);
                            $(page).find('.current_page_nr').val(index);
                            $(page).find('.preview_image').attr('data-page', index);
                            $(page).attr('data-page', index);
                        }
                    })())
                }
            }

        }
    })());

    $('.pagesContainer').off('keyup', '.width_designer,.height_designer').on('keyup', '.width_designer,.height_designer', (function () {
        return function () {
            var pageItem = $(this).parents('.pageItem');
            var pageNumber = $(pageItem).data('page');
            if ($(pageItem).find('.preview_image_input').val()) {
                alert('<?php echo __('Clear our existing content before changing this values') ?>')
            }
        }
    })());
    $('.pagesContainer').off('click', '.deleteContentPersonalization').on('click', '.deleteContentPersonalization', (function () {
        return function () {
            var pageItem = $(this).parents('.pageItem'),
                pageNumber = $(pageItem).data('page');

            $(pageItem).find('.svg_content').val('');
            $(pageItem).find('.preview_image_input').val('');
            $(pageItem).find('img.preview_image').attr('src', '<?php echo url('/') . '/images/noimage.gif'?>');

            if ($(pageItem).find('.preview_image_input').val()) {
                alert('<?php echo __('Clear our existing content before changing this values') ?>')
            }
        }
    })());


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
    });
</script>
@if($enableApi)
    <style>
        #jstree_api_categories {
            width: 50%;
        }

        .js-tree-noicon {
            display: none !important;
        }
    </style>
    <script type="text/javascript">
        $(function () {
            $('#jstree_api_categories')
                .on('changed.jstree', function (e, data) {
                    var values = data.selected;
                    if (values.indexOf("all") > 0) {
                        values = ["all"];
                    }
                    $('#api_categories').val(JSON.stringify(values));
                })
                .jstree({
                    'core': {
                        'data': [
                            {
                                'text': '{{__('All')}}',
                                'id': 'all',
                                'icon': 'js-tree-noicon',
                                'state': {
                                    'opened': false,
                                    'selected': false
                                },
                                'children': {!! json_encode($apiCategories) !!}
                            }
                        ]
                    },
                    "plugins": ["checkbox", "search"]
                });
            var to = false;
            $('#api_categories_q').keyup(function () {
                if (to) {
                    clearTimeout(to);
                }
                to = setTimeout(function () {
                    var v = $('#api_categories_q').val();
                    $('#jstree_api_categories').jstree(true).search(v);
                }, 250);
            });

            $('.quality_image_td_input').on('keyup',(function(){
                return function(){
                    var value = parseFloat($(this).val());
                    var _self = $(this);
                    setTimeout(function(){
                        var value = parseFloat($(_self).val());
                        if( value < 0.5){
                            _self.val(0.5);
                        }
                    },400);
                    if( value > 2){
                        $(this).val(2);
                    }
                }
            })());
        });
    </script>
@endif

