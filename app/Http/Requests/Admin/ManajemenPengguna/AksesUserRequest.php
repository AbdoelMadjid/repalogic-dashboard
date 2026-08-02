<?php

namespace App\Http\Requests\Admin\ManajemenPengguna;

use Illuminate\Foundation\Http\FormRequest;

class AksesUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', 'exists:roles,name'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ];
    }

    public function messages(): array
    {
        return [
            'roles.array' => 'Daftar role harus berupa array.',
            'roles.*.exists' => 'Role yang dipilih tidak valid di database.',
            'permissions.array' => 'Daftar permission harus berupa array.',
            'permissions.*.exists' => 'Permission yang dipilih tidak valid di database.',
        ];
    }
}
