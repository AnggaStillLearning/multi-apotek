<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Menampilkan daftar supplier.
     */
    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($request->filled('search')) {
            $query->where('nama_supplier', 'like', '%' . $request->search . '%');
        }

        $suppliers = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Form tambah supplier.
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Simpan supplier.
     */
    public function store(SupplierRequest $request)
    {
        Supplier::create($request->validated());

        return redirect()
            ->route('suppliers.index')
            ->with(
                'success',
                'Supplier berhasil ditambahkan.'
            );
    }

    /**
     * Detail supplier.
     */
    public function show(Supplier $supplier)
    {
        return view(
            'suppliers.show',
            compact('supplier')
        );
    }

    /**
     * Form edit supplier.
     */
    public function edit(Supplier $supplier)
    {
        return view(
            'suppliers.edit',
            compact('supplier')
        );
    }

    /**
     * Update supplier.
     */
    public function update(
        SupplierRequest $request,
        Supplier $supplier
    ) {
        $supplier->update(
            $request->validated()
        );

        return redirect()
            ->route('suppliers.index')
            ->with(
                'success',
                'Supplier berhasil diperbarui.'
            );
    }

    /**
     * Hapus supplier.
     */
    public function destroy(Supplier $supplier)
    {
        // Nanti ketika modul Pengadaan sudah dibuat,
        // supplier yang memiliki transaksi tidak boleh dihapus.

        $supplier->delete();

        return redirect()
            ->route('suppliers.index')
            ->with(
                'success',
                'Supplier berhasil dihapus.'
            );
    }
}
