<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GudangRequest extends FormRequest
{
    /**
     * Tentukan apakah user boleh melakukan request ini.
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
        $rules = [

            'nama_gudang' => 'required|string|max:255',

            'alamat' => 'nullable|string',

            'keterangan' => 'nullable|string',

        ];

        // Super Admin wajib memilih apotek
        if (auth()->user()->isSuperAdmin()) {

            $rules['apotek_id'] = 'required|exists:apoteks,id';

        }

        return $rules;
    }

    /**
     * Pesan validasi.
     */
    public function messages(): array
    {
        return [

            'apotek_id.required' => 'Apotek wajib dipilih.',

            'apotek_id.exists' => 'Apotek tidak ditemukan.',

            'nama_gudang.required' => 'Nama gudang wajib diisi.',

            'nama_gudang.max' => 'Nama gudang maksimal 255 karakter.',

        ];
    }

    /**
     * Nama field yang lebih mudah dibaca.
     */
    public function attributes(): array
    {
        return [

            'apotek_id' => 'Apotek',

            'nama_gudang' => 'Nama Gudang',

            'alamat' => 'Alamat',

            'keterangan' => 'Keterangan',

        ];
    }
}
