<?php

namespace App\Http\Requests\ComponentController;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:250',
            'description' => 'nullable|string|max:1500',
            'front_end_type' => 'required|string',
            'style_type' => 'required|string',
            'image' => 'required|image|max:5000',
            'code' => 'required|string|max:20000',
        ];
    }
}
