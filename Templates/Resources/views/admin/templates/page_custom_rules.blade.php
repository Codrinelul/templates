<form id="pageCustomRulesForm">
    @php
        $i = 0;
        $editable_options = getYesNoPersonalizationOptions([], ['type' => 'page','subtype'=>$data['subtype']]);
        $designerClass = ' is_editable_designer';
        $otpClass = ' is_editable_otp';
		$brochureClass = ' is_editable_brochure';
        $customRuleEditableOption = '#custom_rule_editable_options';
    @endphp

    <div id="custom_rule_editable_options">
        @include('templates::admin.templates.editable_options')
    </div>

    <input type="hidden" name="pageid" value="{{ $data['pageid'] }}">
	<input type="hidden" name="template_id" value="{{ $data['template_id'] }}" />
	<input type="hidden" name="page" value="{{ $data['page'] }}" />
    <button id="savePageRules" class="btn btn-primary" title="{{ __('Save Custom Rules') }}">
		<span>
			<span>
				<span>{{ __('Save Custom Rules') }}</span>
			</span>
		</span>
	</button>
    <button id="unbindPageRules" class="btn btn-primary" title="{{ __('Unbind Custom Rules') }}">
		<span>
			<span>
				<span>{{ __('Unbind Custom Rules') }}</span>
			</span>
		</span>
	</button>
</form>