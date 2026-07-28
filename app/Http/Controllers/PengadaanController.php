<?php

namespace App\Http\Controllers;

use App\Http\Requests\PengadaanRequest;
use App\Models\Pengadaan;
use App\Models\Supplier;
use App\Models\Obat;
use App\Models\Gudang;
use App\Services\StokService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengadaanController extends Controller
{
    /**
     * Menampilkan daftar pengadaan.
     */
    public function index(Request $request)
    {
        $query = Pengadaan::with(['supplier', 'apotek', 'user'])
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nomor_pengadaan', 'like', "%{$search}%")
                  ->orWhereHas('supplier', function ($supplier) use ($search) {
                      $supplier->where('nama_supplier', 'like', "%{$search}%");
                  });
            });
        }

        $pengadaans = $query->paginate(10)->withQueryString();

        return view('pengadaans.index', compact('pengadaans'));
    }

    /**
     * Form tambah pengadaan.
     */
    public function create()
    {
        $suppliers = Supplier::where('status', 'aktif')
            ->orderBy('nama_supplier')
            ->get();

        return view('pengadaans.create', compact('suppliers'));
    }

    /**
     * Simpan header pengadaan.
     */
    public function store(PengadaanRequest $request)
    {
        $pengadaan = Pengadaan::create([
            'supplier_id' => $request->supplier_id,
            'apotek_id' => Auth::user()->apotek_id,
            'user_id' => Auth::id(),
            'nomor_pengadaan' => $this->generateNomorPengadaan(),
            'tanggal_pengadaan' => $request->tanggal_pengadaan,
            'subtotal' => 0,
            'grand_total' => 0,
            'status' => 'draft',
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('pengadaans.show', $pengadaan)
            ->with('success', 'Pengadaan berhasil dibuat. Silakan tambahkan item.');
    }

    /**
     * Detail pengadaan.
     */
    public function show(Pengadaan $pengadaan)
{
    $pengadaan->load([
        'supplier',
        'details.obat',
        'details.konversi.satuan',
        'details.gudang',
        'details.ruangan',
    ]);

    $obats = Obat::orderBy('nama_obat')->get();

    $gudangs = Gudang::where('apotek_id', $pengadaan->apotek_id)
    ->orderBy('nama_gudang')
    ->get();

    return view('pengadaans.show', compact(
        'pengadaan',
        'obats',
        'gudangs'
    ));
}

    public function edit(Pengadaan $pengadaan)
    {
        //
    }

    public function update(PengadaanRequest $request, Pengadaan $pengadaan)
    {
        //
    }

    public function destroy(Pengadaan $pengadaan)
    {
        if ($pengadaan->status !== 'draft') {
            return back()->with(
                'error',
                'Pengadaan yang sudah selesai/dibatalkan tidak dapat dihapus.'
            );
        }

        $pengadaan->delete();

        return redirect()
            ->route('pengadaans.index')
            ->with('success', 'Pengadaan berhasil dihapus.');
    }

    /**
     * Selesaikan pengadaan: kunci data & tambahkan stok ke batch obat.
     */
    public function selesaikan(Pengadaan $pengadaan)
    {
        if ($pengadaan->status !== 'draft') {
            return back()->with(
                'error',
                'Pengadaan ini sudah tidak berstatus draft.'
            );
        }

        if ($pengadaan->details()->count() === 0) {
            return back()->with(
                'error',
                'Tambahkan minimal satu item sebelum menyelesaikan pengadaan.'
            );
        }

        DB::transaction(function () use ($pengadaan) {

            $stokService = new StokService();

            foreach ($pengadaan->details as $detail) {

                $stokService->tambahStok([
                    'obat_id'            => $detail->obat_id,
                    'gudang_id'          => $detail->gudang_id,
                    'ruangan_id'         => $detail->ruangan_id,
                    'nomor_batch'        => $detail->nomor_batch,
                    'qty_dasar'          => $detail->qty_dasar,
                    'tanggal_kadaluarsa' => $detail->tanggal_kadaluarsa,
                    'harga_beli'         => $detail->harga_beli,
                ]);
            }

            $pengadaan->update([
                'status' => 'selesai',
            ]);
        });

        return redirect()
            ->route('pengadaans.show', $pengadaan)
            ->with('success', 'Pengadaan berhasil diselesaikan. Stok telah diperbarui.');
    }

    /**
     * Generate nomor pengadaan.
     */
    private function generateNomorPengadaan(): string
    {
        $tanggal = now()->format('Ymd');

        $last = Pengadaan::whereDate('created_at', today())
            ->count() + 1;

        return 'PGD-' . $tanggal . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);
    }
}
