<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UsernameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('post'))
            return ['name' => 'required|min:2|unique:users'];

        return [];
    }
}
