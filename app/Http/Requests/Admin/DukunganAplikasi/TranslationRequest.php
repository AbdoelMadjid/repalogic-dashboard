<?php

namespace App\Http\Requests\Admin\DukunganAplikasi;

use Illuminate\Foundation\Http\FormRequest;

class TranslationRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'key' => 'required|string|max:150|regex:/^[a-zA-Z0-9_\-\.]+$/',
            'text_id' => 'required|string',
            'text_en' => 'required|string',
            'original_key' => 'nullable|string',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'key' => 'Key Terjemahan',
            'text_id' => 'Terjemahan Bahasa Indonesia (ID)',
            'text_en' => 'Terjemahan Bahasa Inggris (EN)',
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'key.regex' => 'Key terjemahan hanya boleh berisi huruf, angka, strip (-), underscore (_), dan titik (.).',
        ];
    }
}
