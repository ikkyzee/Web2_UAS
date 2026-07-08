<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penerimaan;
use App\Models\PenerimaanRoll;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $barangs = Barang::with(['penerimaan', 'penerimaanRoll', 'kategori'])
            ->when(auth()->user()->role === 'admin_toko', function($query) {
                $query->where('status', 'di_gudang');
            })
            ->when($search, function($query) use ($search) {
                $query->where('kode_barang', 'like', "%{$search}%")
                      ->orWhereHas('kategori', function($q) use ($search) {
                          $q->where('nama_kategori', 'like', "%{$search}%");
                      })
                      ->orWhereHas('penerimaan', function($q) use ($search) {
                          $q->where('kode_oc', 'like', "%{$search}%");
                      })
                      ->orWhereHas('penerimaanRoll', function($q) use ($search) {
                          $q->where('nomor_roll', 'like', "%{$search}%");
                      });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        if ($request->ajax()) {
            return view('barang.index', compact('barangs', 'search'))->renderSections()['content'];
        }

        return view('barang.index', compact('barangs', 'search'));
    }

    public function create()
    {
        // Ambil OC yang MASIH memiliki roll yang belum dikatalogkan
        $ocs = Penerimaan::whereHas('penerimaanRolls', function($query) {
            $query->where('is_cataloged', false);
        })->latest()->get();

        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('barang.form', compact('ocs', 'kategoris'));
    }

    public function getRollsByOc($ocId)
    {
        $penerimaan = Penerimaan::findOrFail($ocId);
        $rolls = PenerimaanRoll::where('penerimaan_id', $ocId)
                               ->where('is_cataloged', false)
                               ->get(['id', 'nomor_roll', 'kiloan']);
                               
        return response()->json([
            'kategori_id' => $penerimaan->kategori_id,
            'warna' => $penerimaan->warna,
            'rolls' => $rolls
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'penerimaan_id' => 'required|exists:penerimaans,id',
            'penerimaan_roll_id' => 'required|exists:penerimaan_rolls,id|unique:barangs,penerimaan_roll_id',
            'kategori_id' => 'required|exists:kategoris,id',
            'kode_barang' => 'required|string',
            'warna' => 'required|string',
        ], [
            'penerimaan_roll_id.unique' => 'Fisik Roll ini sudah didaftarkan ke katalog sebelumnya.',
        ]);

        try {
            DB::beginTransaction();

            Barang::create([
                'penerimaan_id' => $request->penerimaan_id,
                'penerimaan_roll_id' => $request->penerimaan_roll_id,
                'kategori_id' => $request->kategori_id,
                'kode_barang' => $request->kode_barang,
                'warna' => $request->warna,
                'status' => 'di_gudang'
            ]);

            // Update status is_cataloged pada roll
            PenerimaanRoll::where('id', $request->penerimaan_roll_id)->update(['is_cataloged' => true]);

            DB::commit();
            return redirect()->route('barangs.index')->with('success', 'Barang berhasil didaftarkan ke Katalog Resmi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Barang $barang)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        // Hanya warna dan kategori yang masuk akal di-edit, fisik roll (OC & nomor_roll) tidak bisa diedit setelah diregistrasi
        return view('barang.form', compact('barang', 'kategoris'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'kode_barang' => 'required|string',
            'warna' => 'required|string',
        ]);

        $barang->update([
            'kategori_id' => $request->kategori_id,
            'kode_barang' => $request->kode_barang,
            'warna' => $request->warna,
        ]);

        return redirect()->route('barangs.index')->with('success', 'Data Master Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        try {
            DB::beginTransaction();
            // Lepaskan status is_cataloged dari roll
            PenerimaanRoll::where('id', $barang->penerimaan_roll_id)->update(['is_cataloged' => false]);
            $barang->delete();
            DB::commit();
            return back()->with('success', 'Data Master Barang berhasil dihapus dari Katalog. Fisik Roll dikembalikan ke Staging.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
