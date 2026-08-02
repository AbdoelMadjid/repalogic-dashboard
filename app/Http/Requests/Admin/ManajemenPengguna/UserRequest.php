<?php

namespace App\Http\Requests\Admin\ManajemenPengguna;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user') ? (is_object($this->route('user')) ? $this->route('user')->id : $this->route('user')) : null;
        $isUpdate = !empty($userId);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email' . ($isUpdate ? ',' . $userId : '')],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', 'exists:roles,name'],
        ];

        if ($isUpdate) {
            $rules['password'] = ['nullable', 'string', 'min:8', 'confirmed'];
        } else {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap pengguna wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Alamat email sudah terdaftar di sistem.',
            'password.required' => 'Kata sandi wajib diisi untuk pengguna baru.',
            'password.min' => 'Kata sandi minimal berisi 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'roles.array' => 'Daftar role harus berupa array.',
            'roles.*.exists' => 'Role yang dipilih tidak valid.',
        ];
    }
}
