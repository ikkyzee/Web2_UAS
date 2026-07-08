<?php

namespace App\Http\Controllers;

use App\Models\Penerimaan;
use App\Models\Supplier;
use App\Models\Barang;
use App\Models\Roll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenerimaanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $penerimaans = Penerimaan::with(['supplier', 'rolls.barang'])
            ->when($search, function ($query, $search) {
                return $query->where('kode_batch', 'like', "%{$search}%")
                             ->orWhereHas('supplier', function ($q) use ($search) {
                                 $q->where('nama_supplier', 'like', "%{$search}%");
                             });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
            
        $suppliers = Supplier::all();
        $barangs = Barang::all();
            
        return view('penerimaan.index', compact('penerimaans', 'search', 'suppliers', 'barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'tanggal_masuk' => 'required|date',
            'kode_batch' => 'required|string|unique:penerimaans,kode_batch',
            'barang_id' => 'required|array|min:1',
            'barang_id.*' => 'required|exists:barangs,id',
            'nomor_roll' => 'required|array|min:1',
            'nomor_roll.*' => 'required|string|unique:rolls,nomor_roll',
            'berat_kg' => 'required|array|min:1',
            'berat_kg.*' => 'required|numeric|min:0.01',
        ]);

        DB::beginTransaction();
        try {
            $penerimaan = Penerimaan::create([
                'supplier_id' => $request->supplier_id,
                'tanggal_masuk' => $request->tanggal_masuk,
                'kode_batch' => $request->kode_batch,
            ]);

            $rolls = [];
            foreach ($request->barang_id as $key => $barangId) {
                $rolls[] = [
                    'penerimaan_id' => $penerimaan->id,
                    'barang_id' => $barangId,
                    'nomor_roll' => $request->nomor_roll[$key],
                    'berat_kg' => $request->berat_kg[$key],
                    'status' => 'di_gudang',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Roll::insert($rolls);

            DB::commit();
            return redirect()->route('penerimaans.index')->with('success', 'Data penerimaan dan fisik roll berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Penerimaan $penerimaan)
    {
        $penerimaan->delete();
        return redirect()->route('penerimaans.index')->with('success', 'Data penerimaan berhasil dihapus.');
    }
}
