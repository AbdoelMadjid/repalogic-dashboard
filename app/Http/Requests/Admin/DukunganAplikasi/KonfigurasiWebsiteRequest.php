<?php

namespace App\Http\Requests\Admin\DukunganAplikasi;

use Illuminate\Foundation\Http\FormRequest;

class KonfigurasiWebsiteRequest extends FormRequest
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
        $action = $this->input('action_type', 'save_section');

        if ($action === 'save_theme') {
            return [
                'name' => 'required|string|max:255',
                'folder' => 'required|string|max:100',
                'description' => 'nullable|string',
            ];
        }

        return [
            'website_theme_id' => 'required|exists:website_themes,id',
            'section_name' => 'required|string|max:255',
            'section_file' => 'required|string|max:255',
            'nav_title' => 'nullable|string|max:100',
            'target_id' => 'nullable|string|max:100',
            'show_in_nav' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'orders' => 'nullable|integer',
        ];
    }
}
