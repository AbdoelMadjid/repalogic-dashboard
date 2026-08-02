<?php

namespace App\Http\Requests\Admin\ManajemenPengguna;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
        return [
            'target' => 'required|string|max:255',
            'actions' => 'required|array|min:1',
            'actions.*' => 'required|string|in:create,read,update,delete',
            'menu_id' => 'nullable|exists:menus,id',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'target' => 'Target Modul / Fitur',
            'actions' => 'Tipe Aksi Permission',
            'menu_id' => 'Kaitan Menu Modul',
        ];
    }
}
