<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\Toko;
use App\Models\Armada;
use App\Models\Barang;
use App\Models\DetailPengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PengirimanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $pengirimans = Pengiriman::with(['toko', 'armada', 'user'])
            ->when($search, function($query) use ($search) {
                $query->whereHas('toko', function($q) use ($search) {
                    $q->where('nama_toko', 'like', "%{$search}%");
                })->orWhere('id', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        if ($request->ajax()) {
            return view('pengiriman.index', compact('pengirimans', 'search'))->renderSections()['content'];
        }
            
        return view('pengiriman.index', compact('pengirimans', 'search'));
    }

    public function create()
    {
        $tokos = Toko::orderBy('nama_toko')->get();
        $armadas = Armada::orderBy('plat_nomor')->get();
        // Hanya ambil barang (yang mewakili 1 roll) yang status di_gudang
        $barangs = Barang::where('status', 'di_gudang')
                         ->with(['penerimaan', 'penerimaanRoll', 'kategori'])
                         ->get();

        return view('pengiriman.create', compact('tokos', 'armadas', 'barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'toko_id' => 'required|exists:tokos,id',
            'armada_id' => 'required|exists:armadas,id',
            'tanggal_kirim' => 'required|date',
            'barang_id' => 'required|array|min:1',
            'barang_id.*' => 'exists:barangs,id'
        ]);

        try {
            DB::transaction(function () use ($request) {
                // 1. Insert ke pengirimans
                $pengiriman = Pengiriman::create([
                    'user_id' => auth()->id(),
                    'toko_id' => $request->toko_id,
                    'armada_id' => $request->armada_id,
                    'tanggal_kirim' => $request->tanggal_kirim,
                    'status' => 'diproses'
                ]);

                // 2 & 3. Iterasi dan insert ke detail_pengirimans
                foreach ($request->barang_id as $barangId) {
                    DetailPengiriman::create([
                        'pengiriman_id' => $pengiriman->id,
                        'barang_id' => $barangId,
                    ]);
                }

                // 4. Update status barang
                Barang::whereIn('id', $request->barang_id)->update(['status' => 'dikirim']);
            });

            return redirect()->route('pengirimans.index')->with('success', 'Surat Jalan Pengiriman berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat pengiriman: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Pengiriman $pengiriman)
    {
        $pengiriman->load(['toko', 'armada', 'user', 'detailPengirimans.barang.penerimaanRoll', 'detailPengirimans.barang.kategori']);
        return view('pengiriman.show', compact('pengiriman'));
    }

    public function update(Request $request, Pengiriman $pengiriman)
    {
        $request->validate([
            'status' => 'required|in:dikirim,diterima'
        ]);

        $data = ['status' => $request->status];
        if ($request->status === 'diterima') {
            $data['tanggal_diterima'] = now();
        }

        $pengiriman->update($data);
        return back()->with('success', 'Status pengiriman diperbarui menjadi ' . ucfirst($request->status));
    }

    public function destroy(Pengiriman $pengiriman)
    {
        try {
            DB::beginTransaction();
            // Kembalikan status barang ke 'di_gudang'
            foreach ($pengiriman->detailPengirimans as $detail) {
                $detail->barang->update(['status' => 'di_gudang']);
            }
            $pengiriman->delete();
            DB::commit();
            return back()->with('success', 'Data pengiriman dihapus. Barang (Roll) dikembalikan ke gudang.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus pengiriman.');
        }
    }

    public function exportPdf()
    {
        $pengirimans = Pengiriman::with(['toko', 'armada', 'detailPengirimans.barang.penerimaanRoll'])->latest()->get();
        $pdf = Pdf::loadView('pengiriman.pdf', compact('pengirimans'));
        return $pdf->download('Laporan_Pengiriman_' . date('Y-m-d') . '.pdf');
    }
}
