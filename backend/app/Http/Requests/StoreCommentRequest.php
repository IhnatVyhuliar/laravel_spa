<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\StringValidationRule;

class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|regex:/^[a-zA-Z0-9]*$/|max:25|', StringValidationRule::class,
            'comment_text' => 'required|string',
            'home_page' => 'nullable|string|max:255',
            'txt_file' => 'nullable|image|mimes:txt|100',
            'photo_file' =>'nullable|image|mimes:jpg,gif,png|dimensions:max_width=320,max_height=240',
            'reply_id' => 'nullable|unique:comments'
        ];
    }
}
