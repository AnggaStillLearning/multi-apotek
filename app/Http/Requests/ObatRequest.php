<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ObatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [

        'apotek_id'=>'nullable|exists:apoteks,id',

        'kategori_id'=>'required|exists:kategoris,id',

        'jenis_obat_id'=>'required|exists:jenis_obats,id',

        'tipe_produk'=>'required|in:obat,alat_kesehatan',

        'satuan_dasar_id'=>'required|exists:satuans,id',

        'nama_obat'=>'required|max:255',

        'harga_beli_default'=>'required|numeric|min:0',

        'stok_minimum'=>'required|integer|min:0',

        'deskripsi'=>'nullable'

    ];
}
}
