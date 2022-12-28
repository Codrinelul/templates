<div class="@if(!(isset($custom_rules) && $custom_rules)) d-flex flex-column col-md-6 col-xs-12 px-3 @else col-12 @endif">
    @foreach ($editable_options as $tab=>$options)
        @if(!(isset($custom_rules) && $custom_rules) && $i++ == $middle)
        </div><div class="d-flex flex-column col-md-6 col-xs-12 px-3 ">
        @endif
        @if((isset($custom_rules) && $custom_rules) && !count($options['fields']))
            @php
                continue;
            @endphp
        @endif
        <div
            class="<?php if (isset($options['designer']) && $options['designer']) echo 'is_editable_designer';?>
            <?php if (isset($options['otp']) && $options['otp']) echo 'is_editable_otp';?>
            <?php if (isset($options['brochure']) && $options['brochure']) echo 'is_editable_brochure';?>
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
                    </div>
                    @foreach ($options['fields'] as $key => $value)
                        @php
                            $global_editable_options = isset($customRuleEditableOption) ? $customRuleEditableOption : "#custom_rule_editable_options";
                        @endphp
                        <div
                            class="form-group row  <?php echo(isset($value['additional_class']) ? $value['additional_class'] :'') ?> <?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?> editable_opt  <?php if (isset($value['has_options']) && 1 == $value['has_options'])
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
                                    <?php $no__input_options['onclick'] = "jQuery('" . $global_editable_options . "').find('" . $value['options_id'] . ((isset($value['scope']) && $value['scope'] != '') ? ('.' . $value['scope']) : '') . " ').hide()"?>
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
                                    <?php $yes_input_options['onclick'] = "jQuery('" . $global_editable_options . "').find('" . $value['options_id'] . ((isset($value['scope']) && $value['scope'] != '') ? ('.' . $value['scope']) : '') . " ').show()"?>
                                @endif
                                @if(isset($value['default']) && 1 == (int)$value['default'])
                                    <?php $yes_input_options['class'] = "standard-selection"?>
                                @endif
                                {!!Form::radio('editable_options['.$key.']', '1',(isset($yes_no_options[$key]) && $yes_no_options[$key] == '1' ) ? true : false, $yes_input_options)!!}
                            @else
                                {!! Form::label('editable_'.$key.'_no', __('No')) !!}
                                <?php $no__input_options = array('id' => 'editable_' . $key . '_no')  ?>
                                @if(isset($value['has_options']) && 1 == $value['has_options'])
                                    <?php $no__input_options['onclick'] = "jQuery('" . $global_editable_options . "').find('" . $value['options_id'] . ((isset($value['scope']) && $value['scope'] != '') ? ('.' . $value['scope']) : '') . " ').hide()"?>
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
                                    <?php $yes_input_options['onclick'] = "jQuery('" . $global_editable_options . "').find('" . $value['options_id'] . ((isset($value['scope']) && $value['scope'] != '') ? ('.' . $value['scope']) : '') . " ').show()"?>
                                @endif
                                @if(isset($value['default']) && 1 == (int)$value['default'])
                                    <?php $yes_input_options['class'] = "standard-selection"?>
                                @endif
                                {!!Form::radio('editable_options['.$key.']', '1',(isset($value['default']) && $value['default'] == '1' ) ? true : false, $yes_input_options)!!}
                            @endif
                        </div>
                        @if(isset($value['has_options']) && 1 == $value['has_options'] &&    $global_editable_options =="#custom_rule_editable_options" )
                             <?php continue; ?>;
                            @endif
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
                                        <?php $no__input_options['onclick'] = "jQuery('$customRuleEditableOption').find('." . $fieldName . "font_set_select').hide();" .
                                            "jQuery('$customRuleEditableOption').find('." . $fieldName . "fonts_select').show();" ?>
                                        {!!Form::radio('editable_options['.$fieldName.']', '0', isset($yes_no_options[$fieldName]) ? $yes_no_options[$fieldName] == '0' : true, $no__input_options)!!}
                                        {!! Form::label('editable_'.$fieldName.'_yes', __('Yes')) !!}
                                        <?php $yes_input_options = array('id' => 'editable_' . $fieldName . '_yes') ?>
                                        <?php $yes_input_options['onclick'] = "jQuery('$customRuleEditableOption').find('." . $fieldName . "font_set_select').show();" .
                                            "jQuery('$customRuleEditableOption').find('." . $fieldName . "fonts_select').hide();" ?>
                                        {!!Form::radio('editable_options['.$fieldName.']', '1', isset($yes_no_options[$fieldName]) ? $yes_no_options[$fieldName] == '1' : false, $yes_input_options)!!}
                                    </div>
                                    <?php
                                    $use_font_sets = isset($yes_no_options[$fieldName]) ? ($yes_no_options[$fieldName] == 0 ? false : true) : false;
                                    $allow_fonts = isset($yes_no_options['allow_fonts']) ? ($yes_no_options['allow_fonts'] == 0 ? 'none' : 'block') : (0 == $value['default'] ? 'none' : 'block');
                                    ?>
                                    <div
                                        class="form-group {{$fieldName}}fonts_select ignore_js_toggle <?php if ($value['designer']) echo $designerClass;if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?> {{$value['scope']}}"
                                        style="display:<?php echo $allow_fonts && !$use_font_sets ? 'block' : 'none' ?>;"
                                    >
                                        <div class="editable_option_title">
                                            {!! tooltip_icon('form', 'templates.allowed_fonts') !!} <span
                                                style="font-weight: 700;">{{__('Allowed Fonts:')}}</span>
                                        </div>
                                        @php
                                            $font_value = isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '';
                                            if ($font_value == '' && !isset($model)) {
                                                $font_value = $preselected_fonts;
                                            }
                                        @endphp
                                        {!! Form::select('editable_options['.$value['option_field'].'][]', $template_fonts, $font_value,['multiple'=>'multiple','class' => 'select2-js form-control multiselect_template']) !!}
                                    </div>
                                    <div
                                        class="form-group {{$fieldName}}font_set_select ignore_js_toggle <?php if ($value['designer']) echo $designerClass;
                                        if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass; ?>"
                                        style="display:<?php echo $allow_fonts && $use_font_sets ? 'block' : 'none' ?>;"
                                    >
                                        <div class="editable_option_title">
                                            {!! tooltip_icon('form', 'templates.font_set') !!} <span
                                                style="font-weight: 700;">{{__('Font Set:')}}</span>
                                        </div>
                                        @php
                                            $font_sets_value = isset($yes_no_options[$fontSelectName]) ? $yes_no_options[$fontSelectName] : '';
                                            if ($font_sets_value == '' && !isset($model)) {
                                                $font_sets_value = $preselected_font_sets;
                                            }
                                        @endphp
                                        {!! Form::select("editable_options[".$fontSelectName."]", $font_sets, $font_sets_value, ['class' => 'select2-js form-control cool_select', 'placeholder' =>'-'.__('none').'-']) !!}
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
                                        <?php $no__input_options['onclick'] = "jQuery('" . $global_editable_options . "').find('." . $fieldName . "text_set_select').hide();" .
                                            "jQuery('" . $global_editable_options . "').find('." . $fieldName . "texts_select').show();" ?>
                                        {!!Form::radio('editable_options['.$fieldName.']', '0', isset($yes_no_options[$fieldName]) ? $yes_no_options[$fieldName] == '0' : true, $no__input_options)!!}
                                        {!! Form::label('editable_'.$fieldName.'_yes', __('Yes')) !!}
                                        <?php $yes_input_options = array('id' => 'editable_' . $fieldName . '_yes') ?>
                                        <?php $yes_input_options['onclick'] = "jQuery('" . $global_editable_options . "').find('." . $fieldName . "text_set_select').show();" .
                                            "jQuery('" . $global_editable_options . "').find('." . $fieldName . "texts_select').hide();" ?>
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
                                    class="tabShowHelperManual form-group <?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?>"
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif >
                                    <div class="editable_option_title" >
                                        {!! tooltip_icon('form', 'templates.cms_helper_data') !!} <span
                                            style="font-weight: 700;">{{__('CMS Helper Data:')}}</span>
                                    </div>
                                    {!! Form::select('editable_options['.$value['option_field'].']', $template_cms, isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '',['multiple'=>false,'class' => 'select2-js form-control multiselect_template']) !!}
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
                                        <?php $no__input_options['onclick'] = "jQuery('$customRuleEditableOption').find('." . $fieldNameColorSet . "_color_set_select').hide();" .
                                            "jQuery('$customRuleEditableOption').find('." . $fieldNameColorSet . "_colors_select').show();" ?>
                                        {!!Form::radio('editable_options['.$fieldNameColorSet.']', '0', isset($yes_no_options[$fieldNameColorSet]) ? $yes_no_options[$fieldNameColorSet] == '0' : true, $no__input_options)!!}
                                        {!! Form::label('editable_'.$fieldNameColorSet.'_yes', __('Yes')) !!}
                                        <?php $yes_input_options = array('id' => 'editable_' . $fieldNameColorSet . '_yes') ?>
                                        <?php $yes_input_options['onclick'] = "jQuery('$customRuleEditableOption').find('." . $fieldNameColorSet . "_color_set_select').show();" .
                                            "jQuery('$customRuleEditableOption').find('." . $fieldNameColorSet . "_colors_select').hide();" ?>
                                        {!!Form::radio('editable_options['.$fieldNameColorSet.']', '1', isset($yes_no_options[$fieldNameColorSet]) ? $yes_no_options[$fieldNameColorSet] == '1' : false , $yes_input_options)!!}
                                    </div>
                                    <?php
                                    $use_font_sets = isset($yes_no_options[$fieldNameColorSet]) ? ($yes_no_options[$fieldNameColorSet] == 0 ? false : true) : false;
                                    $allow_fonts = isset($yes_no_options['allow_fonts']) ? ($yes_no_options['allow_fonts'] == 0 ? 'none' : 'block') : (0 == $value['default'] ? 'none' : 'block');
                                    ?>
                                    <div
                                        class="form-group {{$fieldNameColorSet}}_colors_select ignore_js_toggle <?php if ($value['designer']) echo $designerClass;
                                        if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass; ?>"
                                        style="display:<?php echo $allow_fonts && !$use_font_sets ? 'block' : 'none' ?>;"
                                    >
                                        <div class="editable_option_title">
                                            {!! tooltip_icon('form', 'templates.allowed') !!} <span
                                                style="font-weight: 700;">{{__('Allowed:')}}</span>
                                        </div>
                                        @php
                                            $color_value = isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '';
                                            if ($color_value == '' && !isset($model)) {
                                                $color_value = $preselected_colors;
                                            }
                                        @endphp
                                        {!! Form::select('editable_options['.$value['option_field'].'][]', $template_colors, $color_value,['multiple'=>'multiple','class' => 'select2-js form-control multiselect_template']) !!}
                                    </div>
                                    <div
                                        class="form-group {{$fieldNameColorSet}}_color_set_select ignore_js_toggle <?php if ($value['designer']) echo $designerClass;
                                        if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass; ?>"
                                        style="display:<?php echo $allow_fonts && $use_font_sets ? 'block' : 'none' ?>;"
                                    >
                                        <div class="editable_option_title">
                                            {!! tooltip_icon('form', 'templates.color_set') !!} <span
                                                style="font-weight: 700;">{{__('Color Set:')}}</span>
                                        </div>
                                        @php
                                            $color_sets_value = isset($yes_no_options[$colorSelectName]) ? $yes_no_options[$colorSelectName] : '';
                                            if ($color_sets_value == '' && !isset($model)) {
                                                $color_sets_value = $preselected_color_sets;
                                            }
                                        @endphp
                                        {!! Form::select("editable_options[".$colorSelectName."]", $color_sets, $color_sets_value, ['class' => 'select2-js form-control cool_select', 'placeholder' =>'-'.__('none').'-']) !!}
                                    </div>
                                </div>
                            @endif

                        @endif
                        @if(isset($value['has_options']) && 1 == $value['has_options'] )
                            @if( '#tabAllowImageToShape' == $value['options_id'] )
                                <div
                                    class="form-group row <?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?> "
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
                                </div>
                            @endif
                        @endif
			@if(isset($value['has_options']) && 1 == $value['has_options'] )
                                                @if( '#tabDesignerPdfvtField' == $value['options_id'] )
                                                    <div
                                                        class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;  if ($value['brochure']) echo $brochureClass;?> "
                                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                                        @endif
                                                        @elseif( 0 == $value['default']) style="display:none"
                                                        @endif id="tabDesignerPdfvtField">
                                                        <div class="editable_option_title" style="float:left">
                                                            {!! tooltip_icon('form', 'templates.pdf_vt_tooltip_designer') !!} <span
                                                                style="font-weight: 700;">{{__('Pdf VT Tooltip Designer:')}}</span>
                                                        </div>
                                                        {!! Form::text('editable_options[allow_designer_pdfvt_customtooltip_value]', isset($yes_no_options['allow_designer_pdfvt_customtooltip_value']) ? $yes_no_options['allow_designer_pdfvt_customtooltip_value'] : '', ['class' => 'form-control','style'=>'width: 400px;display: inline-block;']) !!}
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
                                        <?php $no__input_options['onclick'] = "jQuery('$customRuleEditableOption').find('." . $fieldNameColorSet . "_color_set_select').hide();" .
                                            "jQuery('$customRuleEditableOption').find('." . $fieldNameColorSet . "_colors_select').show();" ?>
                                        {!!Form::radio('editable_options['.$fieldNameColorSet.']', '0', isset($yes_no_options[$fieldNameColorSet]) ? $yes_no_options[$fieldNameColorSet] == '0' : true, $no__input_options)!!}
                                        {!! Form::label('editable_'.$fieldNameColorSet.'_yes', __('Yes')) !!}
                                        <?php $yes_input_options = array('id' => 'editable_' . $fieldNameColorSet . '_yes') ?>
                                        <?php $yes_input_options['onclick'] = "jQuery('$customRuleEditableOption').find('." . $fieldNameColorSet . "_color_set_select').show();" .
                                            "jQuery('$customRuleEditableOption').find('." . $fieldNameColorSet . "_colors_select').hide();" ?>
                                        {!!Form::radio('editable_options['.$fieldNameColorSet.']', '1', isset($yes_no_options[$fieldNameColorSet]) ? $yes_no_options[$fieldNameColorSet] == '1' : false , $yes_input_options)!!}
                                    </div>
                                    <?php
                                    $use_font_sets = isset($yes_no_options[$fieldNameColorSet]) ? ($yes_no_options[$fieldNameColorSet] == 0 ? false : true) : false;
                                    $allow_fonts = isset($yes_no_options['allow_fonts']) ? ($yes_no_options['allow_fonts'] == 0 ? 'none' : 'block') : (0 == $value['default'] ? 'none' : 'block');
                                    ?>
                                    <div
                                        class="form-group {{$fieldNameColorSet}}_colors_select ignore_js_toggle <?php if ($value['designer']) echo $designerClass;
                                        if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass; ?>"
                                        style="display:<?php echo $allow_fonts && !$use_font_sets ? 'block' : 'none' ?>;"
                                    >
                                        <div class="editable_option_title">
                                            {!! tooltip_icon('form', 'templates.allowed') !!} <span
                                                style="font-weight: 700;">{{__('Allowed:')}}</span>
                                        </div>
                                        @php
                                            $color_value = isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '';
                                            if ($color_value == '' && !isset($model)) {
                                                $color_value = $preselected_colors;
                                            }
                                        @endphp
                                        {!! Form::select('editable_options['.$value['option_field'].'][]', $template_colors, $color_value,['multiple'=>'multiple','class' => 'select2-js form-control multiselect_template']) !!}
                                    </div>
                                    <div
                                        class="form-group {{$fieldNameColorSet}}_color_set_select ignore_js_toggle <?php if ($value['designer']) echo $designerClass;
                                        if ($value['otp']) echo $otpClass;  if ($value['brochure']) echo $brochureClass; ?>"
                                        style="display:<?php echo $allow_fonts && $use_font_sets ? 'block' : 'none' ?>;"
                                    >
                                        <div class="editable_option_title">
                                            {!! tooltip_icon('form', 'templates.color_set') !!} <span
                                                style="font-weight: 700;">{{__('Color Set:')}}</span>
                                        </div>
                                        @php
                                            $color_sets_value = isset($yes_no_options[$colorSelectName]) ? $yes_no_options[$colorSelectName] : '';
                                            if ($color_sets_value == '' && !isset($model)) {
                                                $color_sets_value = $preselected_color_sets;
                                            }
                                        @endphp
                                        {!! Form::select("editable_options[".$colorSelectName."]", $color_sets, $color_sets_value, ['class' => 'select2-js form-control cool_select', 'placeholder' =>'-'.__('none').'-']) !!}
                                    </div>
                                </div>
                            @endif

                        @endif

                        @if(isset($value['has_options']) && 1 == $value['has_options'] )
                            @if( '.tabPantonesColor' == $value['options_id'] )
                                <div
                                    class="tabPantonesColor text form-group<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?> {{$value['scope']}}"
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif >
                                    <div class="editable_option_title" >
                                        {!! tooltip_icon('form', 'templates.default_pantone') !!} <span
                                            style="font-weight: 700;">{{__('Default Pantone:')}}</span>
                                    </div>
                                    @php
                                        $color_value = isset($yes_no_options['default_pantone']) ? $yes_no_options['default_pantone'] : '';
                                        if ($color_value == '' && !isset($model)) {
                                            $color_value = $preselected_colors;
                                        }
                                    @endphp
                                    {!! Form::select('editable_options[default_pantone]', $template_colors, $color_value,['class' => 'select2-js multiselect_template form-control ']) !!}
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
                                            <?php $no__input_options['onclick'] = "jQuery('$customRuleEditableOption').find('.max_color_pantone_nr_value').removeClass('show')"?>
                                        @endif
                                        @if(isset($value['default']) && 0 == (int)$value['default'])
                                            <?php $no__input_options['class'] = "standard-selection"?>
                                        @endif
                                        {!!Form::radio('editable_options[allow_max_pantone_colors]', '0', (isset($yes_no_options['allow_max_pantone_colors']) && $yes_no_options['allow_max_pantone_colors'] == '0' ) ? true : false, $no__input_options)!!}

                                        {!! Form::label('editable_allow_max_pantone_colors_yes', __('Yes')) !!}
                                        <?php $yes_input_options = array('id' => 'editable_allow_max_pantone_colors_yes')  ?>
                                        @if(isset($value['has_options']) && 1 == $value['has_options'])
                                            <?php $yes_input_options['onclick'] = "jQuery('$customRuleEditableOption').find('.max_color_pantone_nr_value').addClass('show')"?>
                                        @endif
                                        @if(isset($value['default']) && 1 == (int)$value['default'])
                                            <?php $no__input_options['class'] = "standard-selection"?>
                                        @endif
                                        {!!Form::radio('editable_options[allow_max_pantone_colors]', '1',(isset($yes_no_options['allow_max_pantone_colors']) && $yes_no_options['allow_max_pantone_colors'] == '1' ) ? true : false, $yes_input_options)!!}
                                    @else
                                        {!! Form::label('editable_max_color_pantone_nr_no', __('No')) !!}
                                        <?php $no__input_options = array('id' => 'editable_max_color_pantone_nr_no')  ?>
                                        @if(isset($value['has_options']) && 1 == $value['has_options'])
                                            <?php $no__input_options['onclick'] = "jQuery('$customRuleEditableOption').find('.max_color_pantone_nr_value').removeClass('show')"?>
                                        @endif
                                        @if(isset($value['default']) && 0 == (int)$value['default'])
                                            <?php $no__input_options['class'] = "standard-selection"?>
                                        @endif
                                        {!!Form::radio('editable_options[max_color_pantone_nr]', '0', (isset($value['default']) && $value['default'] == '0' ) ? true : false, $no__input_options)!!}
                                        {!! Form::label('editable_max_color_pantone_nr_yes', __('Yes')) !!}

                                        <?php $yes_input_options = array('id' => 'editable_max_color_pantone_nr_yes')  ?>
                                        @if(isset($value['has_options']) && 1 == $value['has_options'])
                                            <?php $yes_input_options['onclick'] = "jQuery('$customRuleEditableOption').find('.max_color_pantone_nr_value').addClass('show')"?>
                                        @endif
                                        @if(isset($value['default']) && 1 == (int)$value['default'])
                                            <?php $yes_input_options['class'] = "standard-selection"?>
                                        @endif
                                        {!!Form::radio('editable_options[max_color_pantone_nr]', '1',(isset($value['default']) && $value['default'] == '1' ) ? true : false, $yes_input_options)!!}
                                    @endif
                                </div>
                                <div
                                    class="<?php if (isset($yes_no_options['max_color_pantone_nr']) && $yes_no_options['max_color_pantone_nr']) echo 'show' ?>  tabPantonesColor text max_color_pantone_nr_value form-group<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass;?> ">
                                    <div class="editable_option_title" >
                                        {!! tooltip_icon('form', 'templates.max_number_of_pantone_colors') !!} <span
                                            style="font-weight: 700;">{{__('Max number of pantone colors:')}}</span>
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
                                        <?php $no__input_options['onclick'] = "jQuery('$customRuleEditableOption').find('." . $fieldNameColorSet . "_color_set_select').hide();" .
                                            "jQuery('$customRuleEditableOption').find('." . $fieldNameColorSet . "_colors_select').show();" ?>
                                        {!!Form::radio('editable_options['.$fieldNameColorSet.']', '0', isset($yes_no_options[$fieldNameColorSet]) ? $yes_no_options[$fieldNameColorSet] == '0' : true, $no__input_options)!!}
                                        {!! Form::label('editable_'.$fieldNameColorSet.'_yes', __('Yes')) !!}
                                        <?php $yes_input_options = array('id' => 'editable_' . $fieldNameColorSet . '_yes') ?>
                                        <?php $yes_input_options['onclick'] = "jQuery('$customRuleEditableOption').find('." . $fieldNameColorSet . "_color_set_select').show();" .
                                            "jQuery('$customRuleEditableOption').find('." . $fieldNameColorSet . "_colors_select').hide();" ?>
                                        {!!Form::radio('editable_options['.$fieldNameColorSet.']', '1', isset($yes_no_options[$fieldNameColorSet]) ? $yes_no_options[$fieldNameColorSet] == '1' : false , $yes_input_options)!!}
                                    </div>
                                    <?php
                                    $use_font_sets = isset($yes_no_options[$fieldNameColorSet]) ? ($yes_no_options[$fieldNameColorSet] == 0 ? false : true) : false;
                                    $allow_fonts = isset($yes_no_options['allow_fonts']) ? ($yes_no_options['allow_fonts'] == 0 ? 'none' : 'block') : (0 == $value['default'] ? 'none' : 'block');
                                    ?>
                                    <div
                                        class="form-group {{$fieldNameColorSet}}_colors_select ignore_js_toggle <?php if ($value['designer']) echo $designerClass;
                                        if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass; ?>"
                                        style="display:<?php echo $allow_fonts && !$use_font_sets ? 'block' : 'none' ?>;"
                                    >
                                        <div class="editable_option_title" >
                                            {!! tooltip_icon('form', 'templates.allowed_shape_colors') !!} <span
                                                style="font-weight: 700;">{{__('Allowed Shape Colors:')}}</span>
                                        </div>
                                        @php
                                            $color_value = isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '';
                                            if ($color_value == '' && !isset($model)) {
                                                $color_value = $preselected_colors;
                                            }
                                        @endphp
                                        {!! Form::select('editable_options['.$value['option_field'].'][]', $template_colors, $color_value,['multiple'=>'multiple','class' => 'select2-js form-control multiselect_template']) !!}
                                    </div>
                                    <div
                                        class="form-group {{$fieldNameColorSet}}_color_set_select ignore_js_toggle <?php if ($value['designer']) echo $designerClass;
                                        if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass; ?>"
                                        style="display:<?php echo $allow_fonts && $use_font_sets ? 'block' : 'none' ?>;"
                                    >
                                        <div class="editable_option_title" >
                                            {!! tooltip_icon('form', 'templates.color_set') !!} <span
                                                style="font-weight: 700;">{{__('Color Set:')}}</span>
                                        </div>
                                        @php
                                            $color_sets_value = isset($yes_no_options[$colorSelectName]) ? $yes_no_options[$colorSelectName] : '';
                                            if ($color_sets_value == '' && !isset($model)) {
                                                $color_sets_value = $preselected_color_sets;
                                            }
                                        @endphp
                                        {!! Form::select("editable_options[".$colorSelectName."]", $color_sets, $color_sets_value, ['class' => 'select2-js form-control cool_select', 'placeholder' =>'-'.__('none').'-']) !!}
                                    </div>
                                </div>
                            @endif
                        @endif
    
    @if(isset($value['has_options']) && 1 == $value['has_options'] )
                            @if( '#tabAddpagesSteps' == $value['options_id'] )
                                <div
                                        class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?> {{$value['scope']}}"
                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                        @endif
                                        @elseif( 0 == $value['default']) style="display:none"
                                        @endif id="tabAddpagesSteps">
                                    <div class="editable_option_title" style="float:left">
                                        {!! tooltip_icon('form', 'templates.step_value') !!} <span
                                                style="font-weight: 700;">{{__('Step value:')}}</span>
                                    </div>
                                    {!! Form::text('editable_options['.$value['option_field'].']', isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '1', ['class' => 'form-control','style'=>'width: 400px;display: inline-block;']) !!}
                                </div>
                            @endif
                        @endif

                        @if(isset($value['has_options']) && 1 == $value['has_options'] )
                            @if( '#tabAddpagesMax' == $value['options_id'] )
                                <div
                                        class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?> {{$value['scope']}}"
                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                        @endif
                                        @elseif( 0 == $value['default']) style="display:none"
                                        @endif id="tabAddpagesMax">
                                    <div class="editable_option_title" style="float:left">
                                        {!! tooltip_icon('form', 'templates.maximum_pages') !!} <span
                                                style="font-weight: 700;">{{__('Maximum Pages:')}}</span>
                                    </div>
                                    {!! Form::text('editable_options['.$value['option_field'].']', isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '100', ['class' => 'form-control','style'=>'width: 400px;display: inline-block;']) !!}
                                </div>
                            @endif
                        @endif
                        @if(isset($value['has_options']) && 1 == $value['has_options'] )
                            @if( '#tabAllowZoomer' == $value['options_id'] )
                                <div
                                    class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?> {{$value['scope']}}"
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif id="tabAllowZoomer">
                                    <div class="editable_option_title" >
                                        {!! tooltip_icon('form', 'templates.zoomer_default_value') !!} <span
                                            style="font-weight: 700;">{{__('Zoomer Default Value:')}}</span>
                                    </div>
                                    {!! Form::text('editable_options['.$value['option_field'].']', isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '200', ['class' => 'form-control']) !!}
                                </div>
                            @endif
                        @endif

                        @if(isset($value['has_options']) && 1 == $value['has_options'] )
                            @if( '#tabPreviewMagnifier' == $value['options_id'] )
                                <div
                                    class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?> "
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif id="tabPreviewMagnifier">
                                    <div class="editable_option_title" >
                                        {!! tooltip_icon('form', 'templates.magnifier_value') !!} <span
                                            style="font-weight: 700;">{{__('Magnifier value:')}}</span>
                                    </div>
                                    {!! Form::text('editable_options[magnifier_value]', isset($yes_no_options['magnifier_value']) ? $yes_no_options['magnifier_value'] : '200', ['class' => 'form-control' ]) !!}
                                </div>
                            @endif
                        @endif

                        @if(isset($value['has_options']) && 1 == $value['has_options'] )
                            @if( '#tabMultiplierValue' == $value['options_id'] )
                                <div
                                    class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?> {{$value['scope']}}"
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif id="tabMultiplierValue">
                                    <div class="editable_option_title" style="float:left">
                                        {!! tooltip_icon('form', 'templates.3d_image_quality_multiplier') !!} <span
                                            style="font-weight: 700;">{{__('3D Image Quality Multiplier (values between 0.5 and 2):')}}</span>
                                    </div>
                                    {!! Form::number('editable_options['.$value['option_field'].']', isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '1', ['class' => 'form-control quality_image_td_input', 'step'=>'0.1','min'=>'0.5','max'=>'2', 'style'=>'width: 400px;display: inline-block;']) !!}
                                </div>
                            @endif
                        @endif


                        @if(isset($value['has_options']) && 1 == $value['has_options'] )
                            @if( '#tabAllowMinimumFontsize' == $value['options_id'] )
                                <div
                                    class=" form-group<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?> "
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif id="tabAllowMinimumFontsize">
                                    <div class="editable_option_title" >
                                        {!! tooltip_icon('form', 'templates.minimum_font_size_value') !!} <span
                                            style="font-weight: 700;">{{__('Minimum font size value:')}}</span>
                                    </div>
                                    {!! Form::text('editable_options[allow_minimum_fontsize_value]', isset($yes_no_options['allow_minimum_fontsize_value']) ? $yes_no_options['allow_minimum_fontsize_value'] : '72', ['class' => 'form-control']) !!}
                                    pt
                                </div>
                            @endif
                        @endif

                        @if(isset($value['has_options']) && 1 == $value['has_options'] )
                            @if( '#tabAllowDefaultFont' == $value['options_id'] )
                                <div
                                    class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?> {{$value['scope']}}"
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif id="tabAllowDefaultFont">
                                    <div class="editable_option_title" >
                                        {!! tooltip_icon('form', 'templates.allowed_fonts') !!} <span
                                            style="font-weight: 700;">{{__('Allowed Fonts')}}</span>
                                    </div>
                                    @php
                                        $font_value = isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '';
                                        if ($font_value == '' && !isset($model)) {
                                            $font_value = $preselected_fonts;
                                        }
                                    @endphp
                                    {!! Form::select('editable_options['.$value['option_field'].']', $template_fonts, $font_value,['class' => 'select2-js form-control multiselect_template']) !!}
                                </div>
                            @endif
                        @endif

                        @if(isset($value['has_options']) && 1 == $value['has_options'] )
                            @if( '#tabAllowDefaultText' == $value['options_id'] )
                                <div
                                    class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?> {{$value['scope']}}"
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif id="tabAllowDefaultText">
                                    <div class="editable_option_title" >
                                        {!! tooltip_icon('form', 'templates.default_text') !!} <span
                                            style="font-weight: 700;">{{__('Default Text')}}</span>
                                    </div>
                                    {!! Form::text('editable_options['.$value['option_field'].']', isset($yes_no_options[$value['option_field']]) ?
                                    $yes_no_options[$value['option_field']] : 'I am default text!', ['class' => 'form-control']) !!}
                                </div>
                            @endif
                        @endif


                        @if(isset($value['has_options']) && 1 == $value['has_options'] )
                            @if( '#tabBackgrounds' == $value['options_id'] )
                                <div
                                    class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?>"
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif id="tabBackgrounds">
                                    <div class="editable_option_title" >
                                        {!! tooltip_icon('form', 'templates.backgrounds') !!} <span
                                            style="font-weight: 700;">{{__('Backgrounds:')}}</span>
                                    </div>
                                    @php
                                        $background_value = isset($yes_no_options['allowed_backgrounds']) ? $yes_no_options['allowed_backgrounds'] : '';
                                        if ($background_value == '' && !isset($model)) {
                                            $background_value = $preselected_colors;
                                        }
                                    @endphp
                                    {!! Form::select("editable_options[allowed_backgrounds][]", $template_backgrounds, $background_value,['multiple'=>'multiple','class' => 'select2-js form-control multiselect_template']) !!}
                                </div>
                            @endif
                        @endif

                        @if(isset($value['has_options']) && 1 == $value['has_options'] )
                            @if( '.tabSubmodels' == $value['options_id'] )
                                <div
                                    class="tabSubmodels form-group<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?>"
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif >
                                    <div class="editable_option_title" >
                                        {!! tooltip_icon('form', 'templates.submodels') !!} <span style="font-weight: 700;">{{__('Submodels:')}}</span>
                                    </div>
                                    {!! Form::select("editable_options[allowed_submodels][]", $template_submodels, isset($yes_no_options['allowed_submodels']) ? $yes_no_options['allowed_submodels'] : '',['multiple'=>'multiple','class' => 'select2-js form-control multiselect_template']) !!}
                                </div>
                                <div
                                    class="tabSubmodels form-group<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?>"
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif >
                                    <div class="editable_option_title" >
                                        {!! tooltip_icon('form', 'templates.default_submodel') !!} <span
                                            style="font-weight: 700;">{{__('Default Submodel:')}}</span>
                                    </div>
                                    {!! Form::select("editable_options[default_submodel][]", $template_submodels, isset($yes_no_options['default_submodel']) ? $yes_no_options['default_submodel'] : '',['multiple'=>false,'class' => 'select2-js form-control multiselect_template']) !!}
                                </div>
                            @endif
                        @endif

                        @if(isset($value['has_options']) && 1 == $value['has_options'] )
                            @if( '.tabShapes' == $value['options_id'] )
                                <div class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?>"
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
                                            <?php $no__input_options['onclick'] = "jQuery('$customRuleEditableOption').find('.shape_set_select').hide();" .
                                                "jQuery('$customRuleEditableOption').find('.shapes_select').show();" ?>
                                            {!!Form::radio('editable_options['.'use_shape_sets'.']', '0', isset($yes_no_options['use_shape_sets']) ? $yes_no_options['use_shape_sets'] == '0' : true, $no__input_options)!!}
                                            {!! Form::label('editable_'.'use_shape_sets'.'_yes', __('Yes')) !!}
                                            <?php $yes_input_options = array('id' => 'editable_' . 'use_shape_sets' . '_yes') ?>
                                            <?php $yes_input_options['onclick'] = "jQuery('$customRuleEditableOption').find('.shape_set_select').show();" .
                                                "jQuery('$customRuleEditableOption').find('.shapes_select').hide();" ?>
                                            {!!Form::radio('editable_options['.'use_shape_sets'.']', '1', isset($yes_no_options['use_shape_sets']) ? $yes_no_options['use_shape_sets'] == '1' : false, $yes_input_options)!!}
                                        </div>
                                        <?php
                                        $use_shape_sets = isset($yes_no_options['use_shape_sets']) ? ($yes_no_options['use_shape_sets'] == 0 ? false : true) : false;
                                        $allow_shapes = isset($yes_no_options['allow_shapes']) ? ($yes_no_options['allow_shapes'] == 0 ? 'none' : 'block') : (0 == $value['default'] ? 'none' : 'block');
                                        ?>
                                        <div
                                            class="form-group shapes_select ignore_js_toggle <?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass; ?>"
                                            style="display:<?php echo $allow_shapes && !$use_shape_sets ? 'block' : 'none' ?>;" {{$allow_shapes && !$use_shape_sets ? 'yes' : 'no'}}
                                        >
                                            <div class="editable_option_title" >
                                                {!! tooltip_icon('form', 'templates.shapes') !!} <span style="font-weight: 700;">{{__('Shapes:')}}</span>
                                            </div>
                                            @php
                                                $shape_value = isset($yes_no_options['allowed_shapes']) ? $yes_no_options['allowed_shapes'] : '';
                                                if ($shape_value == '' && !isset($model)) {
                                                    $shape_value = $preselected_shapes;
                                                }
                                            @endphp
                                            {!! Form::select("editable_options[allowed_shapes][]", $template_shapes, $shape_value,['multiple'=>'multiple','class' => 'select2-js form-control multiselect_template']) !!}
                                        </div>
                                        <div
                                            class="form-group shape_set_select ignore_js_toggle <?php if ($value['designer']) echo $designerClass;if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass; ?>"
                                            style="display:<?php echo $allow_shapes && $use_shape_sets ? 'block' : 'none' ?>;" {{$allow_shapes && $use_shape_sets ? 'yes' : 'no'}}
                                        >
                                            <div class="editable_option_title" >
                                                {!! tooltip_icon('form', 'templates.shape_set') !!} <span
                                                style="font-weight: 700;">{{__('Shape Set:')}}</span>
                                            </div>
                                            @php
                                                $shape_sets_value = isset($yes_no_options['shape_set']) ? $yes_no_options['shape_set'] : '';
                                                if ($shape_sets_value == '' && !isset($model)) {
                                                    $shape_sets_value = $preselected_shape_sets;
                                                }
                                            @endphp
                                            {!! Form::select("editable_options[shape_set]", $shape_sets, $shape_sets_value,['class' => 'select2-js form-control cool_select', 'placeholder' =>'-'.__('none').'-']) !!}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                        @if(isset($value['has_options']) && 1 == $value['has_options'] )
                            @if( '#tabAllowArticleLoad' == $value['options_id'] )
                                <div
                                    class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?>"
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif id="tabAllowArticleLoad">
                                    <div class="editable_option_title" >
                                        {!! tooltip_icon('form', 'templates.article_load_file') !!} <span
                                            style="font-weight: 700;">{{__('Article load file:')}}</span>
                                    </div>
                                    {!! Form::select("editable_options[allowed_article][]", $article_files, isset($yes_no_options['allowed_article']) ? $yes_no_options['allowed_article'] : '',['class' => 'select2-js form-control allowed_file']) !!}
                                </div>
                            @endif
                        @endif
                        
                        @if(isset($value['has_options']) && 1 == $value['has_options'] )

                            @if( '#tabAllowNumberOfItems' == $value['options_id'] )
                                <div
                                    class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?>"
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif id="tabAllowNumberOfItems">
                                    <div class="editable_option_title" >
                                        {!! tooltip_icon('form', 'templates.number_of_items_in_sidebar') !!} <span
                                            style="font-weight: 700;">{{__('Number of items in Sidebar:')}}</span>
                                    </div>
                                    {!! Form::text('editable_options['.$value['option_field'].']', isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '4', ['class' => 'form-control']) !!}
                                </div>
                            @endif
                        @endif

                        @if(isset($value['has_options']) && 1 == $value['has_options'] )
                            @if( '#tabAllowedLayouts' == $value['options_id'] )
                                <div
                                    class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?>"
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif id="tabAllowedLayouts">
                                    <div class="editable_option_title" >
                                        {!! tooltip_icon('form', 'templates.allowed_layouts') !!} <span
                                            style="font-weight: 700;">{{__('Allowed Layouts:')}}</span>
                                    </div>
                                    {!! Form::select('editable_options['.$value['option_field'].'][]', $template_layouts, isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '',['multiple'=>'multiple','class' => 'select2-js form-control multiselect_template']) !!}
                                    @if(isset($value['option_field_extra']))
                                        <div class="editable_option_title" style="float:left">
                                            {!! tooltip_icon('form', 'templates.default_content_layout') !!} <span style="font-weight: 700;">{{__('Default Content Layout:')}}</span>
                                        </div>
                                        {!! Form::select('editable_options['.$value['option_field_extra'].'][]', $template_layouts, isset($yes_no_options[$value['option_field_extra']]) ? $yes_no_options[$value['option_field_extra']] : '',['class' => 'select2-js form-control multiselect_template']) !!}
                                    @endif
                                </div>
                            @endif
                        @endif
    
    @if(isset($value['has_options']) && 1 == $value['has_options'] )
                            @if( '#tabAllowedLayoutsHeader' == $value['options_id'] )
                                <div
                                        class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?>"
                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                        @endif
                                        @elseif( 0 == $value['default']) style="display:none"
                                        @endif id="tabAllowedLayoutsHeader">
                                    <div class="editable_option_title" style="float:left">
                                        {!! tooltip_icon('form', 'templates.allowed_header_layouts') !!} <span
                                                style="font-weight: 700;">{{__('Allowed Header Layouts:')}}</span>
                                    </div>
                                    {!! Form::select('editable_options['.$value['option_field'].'][]', $template_layouts_header, isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '',['multiple'=>'multiple','class' => 'select2-js form-control multiselect_template']) !!}
                                    @if(isset($value['option_field_extra']))
                                    <div class="editable_option_title" style="float:left">
                                        {!! tooltip_icon('form', 'templates.default_header_layout') !!} <span style="font-weight: 700;">{{__('Default Header Layout:')}}</span>
                                    </div>
                                    {!! Form::select('editable_options['.$value['option_field_extra'].'][]', $template_layouts_header, isset($yes_no_options[$value['option_field_extra']]) ? $yes_no_options[$value['option_field_extra']] : '',['class' => 'select2-js form-control multiselect_template']) !!}
                                    @endif
                                </div>
                            @endif
                        @endif
    
    @if(isset($value['has_options']) && 1 == $value['has_options'] )
                            @if( '#tabAllowedLayoutsFooter' == $value['options_id'] )
                                <div
                                        class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?>"
                                        @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                        @endif
                                        @elseif( 0 == $value['default']) style="display:none"
                                        @endif id="tabAllowedLayoutsFooter">
                                    <div class="editable_option_title" style="float:left">
                                        {!! tooltip_icon('form', 'templates.allowed_footer_layouts') !!} <span
                                                style="font-weight: 700;">{{__('Allowed Footer Layouts:')}}</span>
                                    </div>
                                    {!! Form::select('editable_options['.$value['option_field'].'][]', $template_layouts_footer, isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '',['multiple'=>'multiple','class' => 'select2-js form-control multiselect_template']) !!}
                                    @if(isset($value['option_field_extra']))
                                    <div class="editable_option_title" style="float:left">
                                        {!! tooltip_icon('form', 'templates.default_footer_layout') !!} <span style="font-weight: 700;">{{__('Default Footer Layout:')}}</span>
                                    </div>
                                    {!! Form::select('editable_options['.$value['option_field_extra'].'][]', $template_layouts_footer, isset($yes_no_options[$value['option_field_extra']]) ? $yes_no_options[$value['option_field_extra']] : '',['class' => 'select2-js form-control multiselect_template']) !!}
                                    @endif
                                </div>
                            @endif
                        @endif

                        @if(isset($value['has_options']) && 1 == $value['has_options'] )
                            @if( '#tabFxTypes' == $value['options_id'] )
                                <div
                                    class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?>"
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif id="tabFxTypes">
                                    <div class="editable_option_title" >
                                        {!! tooltip_icon('form', 'templates.fxeffects') !!} <span style="font-weight: 700;">{{__('FxEffects:')}}</span>
                                    </div>
                                    {!! Form::select("editable_options[allowed_fx_types][]", $refinements_template, isset($yes_no_options['allowed_fx_types']) ? $yes_no_options['allowed_fx_types'] : '',['multiple'=>'multiple','class' => 'select2-js form-control multiselect_template']) !!}
                                </div>
                            @endif
                        @endif

                        @if(isset($value['has_options']) && 1 == $value['has_options'] )
                            @if( '#tabRotationAngle' == $value['options_id'] )
                                <div
                                    class="form-group row<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?> {{$value['scope']}}"
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif id="tabRotationAngle">
                                    <div class="editable_option_title" style="float:left">
                                        {!! tooltip_icon('form', 'templates.rotation_angle_default_value') !!} <span
                                            style="font-weight: 700;">{{__('Rotation angle default value')}}</span>
                                    </div>
                                    {!! Form::select('editable_options['.$value['option_field'].']', array('0'=>__('0 degree'),'90'=>__('90 degrees'),'180'=>__('180 degrees'),'270'=>__('270 degrees')), isset($yes_no_options[$value['option_field']]) ? $yes_no_options[$value['option_field']] : '0',['class' => 'select2-js form-control multiselect_template']) !!}
                                </div>
                            @endif
                        @endif

                        @if(isset($value['has_options']) && 1 == $value['has_options'] )
                            @if( '.tabWatermark' == $value['options_id'] )
                                <div
                                    class=" tabWatermark form-group <?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?>"
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
                                </div>

                                <div
                                    class=" tabWatermark form-group <?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?>"
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif >
                                    <div class="editable_option_title" >
                                        {!! tooltip_icon('form', 'templates.watermark_text') !!} <span
                                            style="font-weight: 700;">{{__('Watermark text:')}}</span>
                                    </div>
                                    {!! Form::text('editable_options[watermark_text]', isset($yes_no_options['watermark_text']) ? $yes_no_options['watermark_text'] : 'Watermark', ['class' => 'form-control']) !!}
                                </div>
                                <div
                                    class=" tabWatermark form-group<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?> "
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif >
                                    <div class="editable_option_title" >
                                        {!! tooltip_icon('form', 'templates.watermark_color') !!} <span
                                            style="font-weight: 700;">{{__('Watermark color:')}}</span>
                                    </div>
                                    {!! Form::text('editable_options[watermark_color]', isset($yes_no_options['watermark_color']) ? $yes_no_options['watermark_color'] : '0 0 0 0', ['class' => 'form-control']) !!}
                                </div>
                                <div
                                    class=" tabWatermark form-group<?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?> <?php if ($value['designer']) echo $designerClass; if ($value['otp']) echo $otpClass; if ($value['brochure']) echo $brochureClass;?>"
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif >
                                    <div class="editable_option_title" >
                                        {!! tooltip_icon('form', 'templates.watermark_opacity') !!} <span
                                            style="font-weight: 700;">{{__('Watermark opacity:')}}</span>
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
                                    {!! Form::text('editable_options[watermark_size]', isset($yes_no_options['watermark_size']) ? $yes_no_options['watermark_size'] : '250', ['class' => 'form-control']) !!}
                                </div>
                            @endif
                        @endif
    
    @if(isset($value['has_options']) && 1 == $value['has_options'] )
                            @if( '.tabAllowColumn' == $value['options_id'] )
                                <div class=" tabAllowColumn form-group row"
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif >
                                    <div class="editable_option_title" style="float:left">
                                        {!! tooltip_icon('form', 'templates.columns_spacing') !!} <span
                                            style="font-weight: 700;">{{__('Columns Spacing (mm):')}}</span>
                                    </div>
                                    {!! Form::text('editable_options[columns_spacing]', isset($yes_no_options['columns_spacing']) ? $yes_no_options['columns_spacing'] : '0', ['class' => 'form-control','style'=>'width: 400px;display: inline-block;']) !!}
                                </div>
                                <div class=" tabAllowColumn form-group row"
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif >
                                    <div class="editable_option_title" style="float:left">
                                        <span
                                            style="font-weight: 700;">{{__('Columns Number:')}}</span>
                                    </div>
                                    {!! Form::text('editable_options[columns_no]', isset($yes_no_options['columns_no']) ? $yes_no_options['columns_no'] : '0', ['class' => 'form-control','style'=>'width: 400px;display: inline-block;']) !!}
                                </div>
                            @endif
                        @endif

                        @if(isset($value['has_options']) && 1 == $value['has_options'] )
                            @if( '.tabAllowHeader' == $value['options_id'] )
                                <div class=" tabAllowHeader form-group row"
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif >
                                    <div class="editable_option_title" style="float:left">
                                        {!! tooltip_icon('form', 'templates.active_on') !!} <span
                                            style="font-weight: 700;">{{__('Active On:')}}</span>
                                    </div>
                                    {!! Form::select("editable_options[header_active_on][]", ['inner'=>__('Inner Pages'),'all'=>__('All pages')], isset($yes_no_options['header_active_on']) ? $yes_no_options['header_active_on'] : 'inner',['class' => 'form-control']) !!}
                                </div>
                                <div class=" tabAllowHeader form-group row"
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif >
                                    <div class="editable_option_title" style="float:left">
                                        {!! tooltip_icon('form', 'templates.mirrored') !!} <span
                                            style="font-weight: 700;">{{__('Mirrored:')}}</span>
                                    </div>
                                    {!! Form::select("editable_options[header_mirrored][]", ['0'=>__('No'), '1' => __('Yes')], isset($yes_no_options['header_mirrored']) ? $yes_no_options['header_mirrored'] : '1',['class' => 'form-control']) !!}
                                </div>
                                <div class=" tabAllowHeader form-group row"
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif >
                                    <div class="editable_option_title" style="float:left">
                                        {!! tooltip_icon('form', 'templates.height') !!} <span
                                            style="font-weight: 700;">{{__('Height:')}}</span>
                                    </div>
                                    {!! Form::text('editable_options[header_height]', isset($yes_no_options['header_height']) ? $yes_no_options['header_height'] : '50', ['class' => 'form-control','style'=>'width: 400px;display: inline-block;']) !!}
                                </div>
                            @endif
                        @endif

                        @if(isset($value['has_options']) && 1 == $value['has_options'] )
                            @if( '.tabAllowFooter' == $value['options_id'] )
                                <div class=" tabAllowFooter form-group row"
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif >
                                    <div class="editable_option_title" style="float:left">
                                        {!! tooltip_icon('form', 'templates.active_on') !!} <span
                                            style="font-weight: 700;">{{__('Active On:')}}</span>
                                    </div>
                                    {!! Form::select("editable_options[footer_active_on][]", ['inner'=>__('Inner Pages'),'all'=>__('All pages')], isset($yes_no_options['footer_active_on']) ? $yes_no_options['footer_active_on'] : 'inner',['class' => 'form-control']) !!}
                                </div>
                                <div class=" tabAllowFooter form-group row"
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif >
                                    <div class="editable_option_title" style="float:left">
                                        {!! tooltip_icon('form', 'templates.mirrored') !!} <span
                                            style="font-weight: 700;">{{__('Mirrored:')}}</span>
                                    </div>
                                    {!! Form::select("editable_options[footer_mirrored][]", ['0'=>__('No'), '1' => __('Yes')], isset($yes_no_options['footer_mirrored']) ? $yes_no_options['footer_mirrored'] : '1',['class' => 'form-control']) !!}
                                </div>
                                <div class=" tabAllowFooter form-group row"
                                    @if(isset($yes_no_options[$key])) @if($yes_no_options[$key] == 0) style="display:none"
                                    @endif
                                    @elseif( 0 == $value['default']) style="display:none"
                                    @endif >
                                    <div class="editable_option_title" style="float:left">
                                        {!! tooltip_icon('form', 'templates.height') !!} <span
                                            style="font-weight: 700;">{{__('Height:')}}</span>
                                    </div>
                                    {!! Form::text('editable_options[footer_height]', isset($yes_no_options['footer_height']) ? $yes_no_options['footer_height'] : '50', ['class' => 'form-control','style'=>'width: 400px;display: inline-block;']) !!}
                                </div>
                            @endif
                        @endif

                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
