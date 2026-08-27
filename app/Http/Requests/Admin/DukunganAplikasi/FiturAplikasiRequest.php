<?php

namespace App\Http\Requests\Admin\DukunganAplikasi;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FiturAplikasiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->isMethod('post') && !$this->route('id')) {
            return auth()->user()->can('create dukunganaplikasi/fitur-aplikasi') || auth()->user()->hasRole('superadmin');
        }

        return auth()->user()->can('update dukunganaplikasi/fitur-aplikasi') || auth()->user()->hasRole('superadmin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('id') ?? $this->input('id');

        return [
            'kode_fitur' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-Z0-9_-]+$/',
                Rule::unique('fitur_aplikasi', 'kode_fitur')->ignore($id),
            ],
            'nama_fitur' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:100',
            'status' => 'nullable|boolean',
            'urutan' => 'nullable|integer',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'kode_fitur' => 'Kode Fitur',
            'nama_fitur' => 'Nama Fitur',
            'kategori' => 'Kelompok / Kategori',
            'deskripsi' => 'Deskripsi Fitur',
            'icon' => 'Ikon Fitur',
            'status' => 'Status Aktif',
            'urutan' => 'Urutan Tampil',
        ];
    }

    /**
     * Custom messages for validation.
     */
    public function messages(): array
    {
        return [
            'kode_fitur.regex' => 'Kode Fitur hanya boleh berisi huruf, angka, tanda hubung (-), dan garis bawah (_).',
            'kode_fitur.unique' => 'Kode Fitur ini sudah digunakan oleh fitur lain.',
        ];
    }
}
