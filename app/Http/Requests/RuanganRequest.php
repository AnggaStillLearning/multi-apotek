<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RuanganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'gudang_id' => 'required|exists:gudangs,id',

            'nama_ruangan' => 'required|string|max:255',

            'keterangan' => 'nullable|string',

        ];
    }

    public function messages(): array
    {
        return [

            'gudang_id.required' => 'Gudang wajib dipilih.',

            'gudang_id.exists' => 'Gudang tidak ditemukan.',

            'nama_ruangan.required' => 'Nama ruangan wajib diisi.',

            'nama_ruangan.max' => 'Nama ruangan maksimal 255 karakter.',

        ];
    }

    public function attributes(): array
    {
        return [

            'gudang_id' => 'Gudang',

            'nama_ruangan' => 'Nama Ruangan',

            'keterangan' => 'Keterangan',

        ];
    }
}
