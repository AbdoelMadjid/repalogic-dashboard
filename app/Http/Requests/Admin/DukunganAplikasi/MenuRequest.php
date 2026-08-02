<?php

namespace App\Http\Requests\Admin\DukunganAplikasi;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
        $menuId = $this->route('menu') ? $this->route('menu')->id : null;

        return [
            'name' => 'required|string|max:255',
            'main_menu_id' => 'nullable|exists:menus,id' . ($menuId ? "|different:id" : ''),
            'icon' => 'nullable|string|max:100',
            'route' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'actions' => 'nullable|array',
            'actions.*' => 'in:create,read,update,delete',
            'roles' => 'nullable|array',
            'roles.*' => 'string|exists:roles,name',
            'category' => 'nullable|string|max:255',
            'orders' => 'nullable|integer',
            'active' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'Nama Menu',
            'main_menu_id' => 'Main Menu Parent',
            'icon' => 'Icon Menu',
            'route' => 'Nama Route',
            'url' => 'URL Menu',
            'actions' => 'Aksi Spatie Permission',
            'roles' => 'Role Akses',
            'category' => 'Kategori / Header',
            'orders' => 'Urutan (Orders)',
            'active' => 'Status Aktif',
        ];
    }
}
