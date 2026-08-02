<?php

namespace App\Http\Requests\Admin\DukunganAplikasi;

use Illuminate\Foundation\Http\FormRequest;

class BackupDbRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('create dukunganaplikasi/backup-db') 
            || auth()->user()->can('read dukunganaplikasi/backup-db') 
            || auth()->user()->hasRole('superadmin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'backup_type' => 'required|in:full,selective',
            'tables' => 'required_if:backup_type,selective|array',
            'tables.*' => 'string',
            'include_create_db' => 'nullable|boolean',
            'output_target' => 'required|in:download,save',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'backup_type.required' => 'Pilih jenis backup (Seluruh Database atau Tabel Pilihan).',
            'tables.required_if' => 'Pilih minimal satu tabel ketika menggunakan opsi Backup Tabel Pilihan.',
            'output_target.required' => 'Pilih aksi target backup (Download atau Simpan ke Storage).',
        ];
    }
}
