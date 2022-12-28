<?php

namespace Modules\Templates\Http\Validation\Groups;

use  App\Http\Validation\Validator;

class Update extends Validator
{
    
    public function rules()
    {
        return [
            'name' => 'required',
            'code' => 'required',
            'templates' => 'required'
        ];
    }
}
