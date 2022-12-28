<?php
	
	namespace Modules\Templates\Http\Validation;
	
	use  App\Http\Validation\Validator;
	
	class Create extends Validator
	{
		
		protected $rules
			= [
				'name'        => 'required',
				'code'        => 'required'
    ];
		
		public function rules()
		{
			return $this->rules;
		}
	}
