<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinuxCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            // 'parent_id' => 'required'
        ];
    }
}
