<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KonversiObatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $obatId = $this->route('obat')?->id ?? $this->obat_id;

        return [

            'satuan_id' => [
                'required',
                'exists:satuans,id',

                Rule::unique('konversi_obats')
                    ->where(fn ($q) => $q->where('obat_id', $obatId))
                    ->ignore($this->route('konversi')),
            ],

            'rasio_turun' => [
                'nullable',
                'integer',
                'min:1'
            ],

            'harga_jual' => [
                'required',
                'numeric',
                'min:0'
            ],

            'is_default' => [
                'nullable',
                'boolean'
            ],

        ];
    }

    public function messages(): array
    {
        return [

            'satuan_id.required' => 'Satuan wajib dipilih.',

            'satuan_id.unique' => 'Satuan tersebut sudah digunakan.',

            'rasio_turun.integer' => 'Rasio turun harus berupa angka.',

            'rasio_turun.min' => 'Rasio turun minimal 1.',

            'harga_jual.required' => 'Harga jual wajib diisi.',

        ];
    }
}
