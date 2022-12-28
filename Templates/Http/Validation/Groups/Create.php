<?php

namespace Modules\Templates\Http\Validation\Groups;

use  App\Http\Validation\Validator;

class Create extends Validator
{
    
    protected $rules
        = [
            'name' => 'required',
            'code' => 'required',
            'templates' => 'required'
        ];
    
    public function rules()
    {
        return $this->rules;
    }
}
