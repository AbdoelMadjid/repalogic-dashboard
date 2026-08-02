<?php

namespace App\Http\Requests\Admin\ManajemenPengguna;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
        $roleId = $this->route('role') ? (is_object($this->route('role')) ? $this->route('role')->id : $this->route('role')) : null;

        return [
            'name' => 'required|string|max:255|unique:roles,name,' . $roleId,
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'Nama Role',
            'permissions' => 'Hak Akses Permission',
        ];
    }
}
