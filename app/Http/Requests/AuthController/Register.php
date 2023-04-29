<?php

namespace App\Http\Requests\AuthController;

use Illuminate\Foundation\Http\FormRequest;

class Register extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'username' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5',
            'accept_terms' => 'required|accepted',
        ];
    }
}
