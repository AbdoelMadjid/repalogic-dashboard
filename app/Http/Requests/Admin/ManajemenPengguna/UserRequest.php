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
            'status' => ['nullable', 'string', 'in:active,pending,inactive,rejected'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'details' => ['nullable', 'array'],
            'details.nik' => ['nullable', 'string', 'max:30'],
            'details.telepon' => ['nullable', 'string', 'max:30'],
            'details.nama_ktp' => ['nullable', 'string', 'max:255'],
            'details.tempat_lahir' => ['nullable', 'string', 'max:255'],
            'details.tanggal_lahir' => ['nullable', 'date'],
            'details.jenis_kelamin' => ['nullable', 'string', 'max:50'],
            'details.golongan_darah' => ['nullable', 'string', 'max:10'],
            'details.agama' => ['nullable', 'string', 'max:50'],
            'details.status_perkawinan' => ['nullable', 'string', 'max:50'],
            'details.pekerjaan' => ['nullable', 'string', 'max:100'],
            'details.kewarganegaraan' => ['nullable', 'string', 'max:50'],
            'details.alamat_jalan' => ['nullable', 'string'],
            'details.rt' => ['nullable', 'string', 'max:10'],
            'details.rw' => ['nullable', 'string', 'max:10'],
            'details.blok' => ['nullable', 'string', 'max:20'],
            'details.desa_kelurahan' => ['nullable', 'string', 'max:100'],
            'details.kecamatan' => ['nullable', 'string', 'max:100'],
            'details.kabupaten_kota' => ['nullable', 'string', 'max:100'],
            'details.provinsi' => ['nullable', 'string', 'max:100'],
            'details.kode_pos' => ['nullable', 'string', 'max:10'],
            'details.foto_ktp' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
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
            'status.in' => 'Status akun pengguna tidak valid.',
            'avatar.image' => 'Berkas avatar harus berupa gambar.',
            'avatar.mimes' => 'Format avatar harus jpeg, jpg, png, atau webp.',
            'avatar.max' => 'Ukuran avatar maksimal 2MB.',
        ];
    }
}
