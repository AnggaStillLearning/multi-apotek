<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules.
     */
    public function rules(): array
    {
        return [
            'nama_supplier' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
        ];
    }
}
