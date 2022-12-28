<form id="blockCustomRulesForm">
    @php
        $i = 0;
        $blockType = isset($data['blocktype']) ? strtolower($data['blocktype']):"";
        if(($blockType) == "graphics"){
        	$blockType = "table";
        }
        $editable_options = getYesNoPersonalizationOptions([], ['type' => $blockType,'subtype'=>$data['subtype']]);
        $designerClass = ' is_editable_designer';
        $otpClass = ' is_editable_otp';
		$brochureClass = ' is_editable_brochure';
        $customRuleEditableOption = '#custom_rule_editable_options';
    @endphp

    <div id="custom_rule_editable_options">
        @include('templates::admin.templates.editable_options')
    </div>

    <input type="hidden" name="page" value="{{ $data['pageid'] }}">
    <input type="hidden" name="blockid" value="{{ $data['blockid'] }}">
	<input type="hidden" name="template_id" value="{{ $data['template_id'] }}" />
	<input type="hidden" name="block_index" value="{{ $data['blockid'] }}" />
	<input type="hidden" name="block_name" value="{{ $data['blockname'] }}" />
    <button id="saveBlockRules" class="btn btn-primary" title="{{ __('Save Custom Rules') }}">
		<span>
			<span>
				<span>{{ __('Save Custom Rules') }}</span>
			</span>
		</span>
	</button>
    <button id="unbindBlockRules" class="btn btn-primary" title="{{ __('Unbind Custom Rules') }}">
		<span>
			<span>
				<span>{{ __('Unbind Custom Rules') }}</span>
			</span>
		</span>
	</button>
</form>