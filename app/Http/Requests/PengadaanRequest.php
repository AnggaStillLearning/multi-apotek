<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengadaanRequest extends FormRequest
{
    /**
     * Tentukan apakah user boleh melakukan request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi.
     */
    public function rules(): array
    {
        return [

            'supplier_id' => [
                'required',
                'exists:suppliers,id'
            ],

            'tanggal_pengadaan' => [
                'required',
                'date'
            ],

            'keterangan' => [
                'nullable',
                'string'
            ],

        ];
    }

    public function messages(): array
    {
        return [

            'supplier_id.required' =>
                'Supplier wajib dipilih.',

            'supplier_id.exists' =>
                'Supplier tidak ditemukan.',

            'tanggal_pengadaan.required' =>
                'Tanggal pengadaan wajib diisi.',

            'tanggal_pengadaan.date' =>
                'Format tanggal tidak valid.',

        ];
    }
}
