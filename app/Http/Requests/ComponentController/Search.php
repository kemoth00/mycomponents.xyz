<?php

namespace App\Http\Requests\ComponentController;

use Illuminate\Foundation\Http\FormRequest;

class Search extends FormRequest
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
            'needle' => 'nullable|string',
            'front_end_type' => 'nullable|string',
            'style_type' => 'nullable|string',
            'order' => 'string|in:popular,newest'
        ];
    }
}
