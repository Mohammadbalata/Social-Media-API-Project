<?php

namespace App\Http\Requests;

use API;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'media' => 'nullable|array|max:5',
            'media.*' => 'mimes:jpeg,jpg,png,gif,mp4,mp3,pdf,docx|max:10240',
            'status' => 'in:public,archived,private',
        ];
    }
}
