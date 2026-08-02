<?php

namespace App\Http\Requests\Admin\ManajemenPengguna;

use Illuminate\Foundation\Http\FormRequest;

class AksesRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ];
    }

    public function messages(): array
    {
        return [
            'permissions.array' => 'Daftar permission harus berupa array.',
            'permissions.*.exists' => 'Permission yang dipilih tidak valid di database.',
        ];
    }
}
