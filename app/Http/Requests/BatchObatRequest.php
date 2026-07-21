<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BatchObatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $batch = $this->route('batch');

        return [

            'gudang_id' => [
                'required',
                'exists:gudangs,id'
            ],

            'ruangan_id' => [
                'required',
                'exists:ruangans,id'
            ],

            'nomor_batch' => [
                'required',
                'string',
                'max:100',
                Rule::unique('batch_obats', 'nomor_batch')
                    ->ignore($batch?->id)
                    ->where(function ($query) {
                        return $query->where(
                            'obat_id',
                            $this->route('obat')?->id ?? $this->route('batch')?->obat_id
                        );
                    }),
            ],

            'stok' => [
                'required',
                'integer',
                'min:1'
            ],

            'harga_beli' => [
                'required',
                'numeric',
                'min:1'
            ],

            'tanggal_kadaluarsa' => [
                'required',
                'date',
                'after_or_equal:today'
            ],

        ];
    }

    public function messages(): array
    {
        return [

            'gudang_id.required' => 'Gudang wajib dipilih.',

            'gudang_id.exists' => 'Gudang tidak ditemukan.',

            'ruangan_id.required' => 'Ruangan wajib dipilih.',

            'ruangan_id.exists' => 'Ruangan tidak ditemukan.',

            'nomor_batch.required' => 'Nomor batch wajib diisi.',

            'nomor_batch.unique' => 'Nomor batch sudah digunakan untuk obat ini.',

            'stok.required' => 'Jumlah stok wajib diisi.',

            'stok.integer' => 'Stok harus berupa angka.',

            'stok.min' => 'Stok minimal 1.',

            'harga_beli.required' => 'Harga beli wajib diisi.',

            'harga_beli.numeric' => 'Harga beli harus berupa angka.',

            'harga_beli.min' => 'Harga beli minimal 1.',

            'tanggal_kadaluarsa.required' => 'Tanggal kadaluarsa wajib diisi.',

            'tanggal_kadaluarsa.after' => 'Tanggal kadaluarsa harus lebih besar dari hari ini.',

        ];
    }
}
