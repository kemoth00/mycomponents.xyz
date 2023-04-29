<?php

namespace App\Http\Requests\AuthController;

use Illuminate\Foundation\Http\FormRequest;

class Login extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
}
