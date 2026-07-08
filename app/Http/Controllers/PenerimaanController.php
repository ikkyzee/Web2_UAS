<?php

namespace App\Http\Controllers;

use App\Models\Penerimaan;
use App\Models\Supplier;
use App\Models\PenerimaanRoll;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenerimaanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $penerimaans = Penerimaan::with(['supplier', 'penerimaanRolls'])
            ->when($search, function($query) use ($search) {
                $query->where('kode_oc', 'like', "%{$search}%")
                      ->orWhereHas('supplier', function($q) use ($search) {
                          $q->where('nama_supplier', 'like', "%{$search}%");
                      });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $suppliers = Supplier::orderBy('nama_supplier')->get();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        if ($request->ajax()) {
            return view('penerimaan.index', compact('penerimaans', 'suppliers', 'kategoris'))->renderSections()['content'];
        }

        return view('penerimaan.index', compact('penerimaans', 'suppliers', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_oc' => 'required|string|unique:penerimaans,kode_oc',
            'tanggal_masuk' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'warna' => 'required|string',
            'nomor_roll' => 'required|array|min:1',
            'nomor_roll.*' => 'required|string|unique:penerimaan_rolls,nomor_roll',
            'kiloan' => 'required|array|min:1',
            'kiloan.*' => 'required|numeric|min:0.1'
        ], [
            'kode_oc.unique' => 'Nomor OC ini sudah ada di sistem. Mohon gunakan Nomor OC yang berbeda.',
            'nomor_roll.*.unique' => 'Salah satu nomor roll fisik yang Anda masukkan sudah terdaftar di sistem.',
        ]);

        try {
            DB::beginTransaction();

            $penerimaan = Penerimaan::create([
                'kode_oc' => $request->kode_oc,
                'tanggal_masuk' => $request->tanggal_masuk,
                'supplier_id' => $request->supplier_id,
                'kategori_id' => $request->kategori_id,
                'warna' => $request->warna,
            ]);

            $rollsData = [];
            foreach ($request->nomor_roll as $index => $nomor_roll) {
                $rollsData[] = [
                    'penerimaan_id' => $penerimaan->id,
                    'nomor_roll' => $nomor_roll,
                    'kiloan' => $request->kiloan[$index],
                    'is_cataloged' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            PenerimaanRoll::insert($rollsData);

            DB::commit();
            return redirect()->route('penerimaans.index')->with('success', 'Data Penerimaan OC berhasil ditambahkan. Silakan katalogkan Roll di menu Barang.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $penerimaan = Penerimaan::findOrFail($id);
            // Cascade delete will handle penerimaan_rolls and barangs
            $penerimaan->delete();
            DB::commit();
            return back()->with('success', 'Data Penerimaan OC berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
