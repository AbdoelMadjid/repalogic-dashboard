<?php

namespace App\Http\Requests\Admin\DukunganAplikasi;

use Illuminate\Foundation\Http\FormRequest;

class FiturAplikasiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('update dukunganaplikasi/fitur-aplikasi') || auth()->user()->hasRole('superadmin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'topbar_search_box' => 'nullable|boolean',
            'topbar_megamenu_header' => 'nullable|boolean',
            'topbar_megamenu_apps' => 'nullable|boolean',
            'topbar_theme_toggler' => 'nullable|boolean',
            'topbar_apps_dropdown' => 'nullable|boolean',
            'topbar_messages' => 'nullable|boolean',
            'topbar_notifications' => 'nullable|boolean',
            'topbar_fullscreen' => 'nullable|boolean',
            'topbar_monochrome' => 'nullable|boolean',
            'topbar_customizer' => 'nullable|boolean',
            'topbar_language' => 'nullable|boolean',
            'topbar_user_dropdown' => 'nullable|boolean',
            'menu_group_main' => 'nullable|boolean',
            'menu_group_apps' => 'nullable|boolean',
            'menu_group_custom_pages' => 'nullable|boolean',
            'menu_group_layouts' => 'nullable|boolean',
            'menu_group_components' => 'nullable|boolean',
            'menu_group_documentation' => 'nullable|boolean',
            'menu_group_menu_item' => 'nullable|boolean',
            'menu_special_menu' => 'nullable|boolean',
        ];
    }
}
