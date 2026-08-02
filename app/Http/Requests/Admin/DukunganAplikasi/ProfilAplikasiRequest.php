<?php

namespace App\Http\Requests\Admin\DukunganAplikasi;

use Illuminate\Foundation\Http\FormRequest;

class ProfilAplikasiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('update dukunganaplikasi/profil-aplikasi') || auth()->user()->hasRole('superadmin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'app_name' => 'required|string|max:255',
            'app_short_name' => 'nullable|string|max:100',
            'app_version' => 'nullable|string|max:50',
            'logo_lg' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
            'logo_sm' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
            'favicon' => 'nullable|file|mimes:ico,png,jpg,jpeg,webp,svg|max:1024',
            'meta_description' => 'nullable|string|max:1000',
            'meta_keywords' => 'nullable|string|max:500',
            'meta_author' => 'nullable|string|max:255',
            'footer_text' => 'nullable|string|max:255',
            'created_year' => 'nullable|string|max:10',
            'developer_name' => 'nullable|string|max:255',
            'developer_url' => 'nullable|url|max:255',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'app_name' => 'Nama Aplikasi',
            'app_short_name' => 'Nama Singkat Aplikasi',
            'app_version' => 'Versi Aplikasi',
            'logo_lg' => 'Logo Besar',
            'logo_sm' => 'Logo Kecil',
            'favicon' => 'Favicon',
            'meta_description' => 'Deskripsi Meta',
            'meta_keywords' => 'Keywords Meta',
            'meta_author' => 'Author Meta',
            'footer_text' => 'Teks Footer',
            'created_year' => 'Tahun Dibuat',
            'developer_name' => 'Nama Pembuat',
            'developer_url' => 'Link Website Pembuat',
        ];
    }
}
