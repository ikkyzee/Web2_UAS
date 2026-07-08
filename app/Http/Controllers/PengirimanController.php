<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\DetailPengiriman;
use App\Models\Toko;
use App\Models\Armada;
use App\Models\Roll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
// use Maatwebsite\Excel\Facades\Excel; // We'll add this later if needed

class PengirimanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->search;
        
        $query = Pengiriman::with(['toko', 'armada', 'user']);
        
        if ($user && $user->role === 'admin_toko') {
            $query->where('toko_id', $user->toko_id);
        }

        $pengirimans = $query->when($search, function ($query, $search) {
                return $query->where('id', 'like', "%{$search}%") // Assuming id or kode_pengiriman
                             ->orWhere('status', 'like', "%{$search}%")
                             ->orWhereHas('toko', function ($q) use ($search) {
                                 $q->where('nama_toko', 'like', "%{$search}%");
                             })
                             ->orWhereHas('armada', function ($q) use ($search) {
                                 $q->where('plat_nomor', 'like', "%{$search}%");
                             });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $tokos = Toko::all();
        $armadas = Armada::all();

        return view('pengiriman.index', compact('pengirimans', 'search', 'tokos', 'armadas', 'barangs'));
    }

    public function create()
    {
        $tokos = Toko::all();
        $armadas = Armada::all();
        $rolls = Roll::with('barang.kategori')->where('status', 'di_gudang')->get();
        return view('pengiriman.create', compact('tokos', 'armadas', 'rolls'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'toko_id' => 'required|exists:tokos,id',
            'armada_id' => 'required|exists:armadas,id',
            'tanggal_kirim' => 'required|date',
            'roll_id' => 'required|array|min:1',
            'roll_id.*' => 'exists:rolls,id',
        ]);

        DB::beginTransaction();
        try {
            $pengiriman = Pengiriman::create([
                'user_id' => Auth::id() ?? 1, // Fallback to 1 if not logged in (for testing)
                'toko_id' => $request->toko_id,
                'armada_id' => $request->armada_id,
                'tanggal_kirim' => $request->tanggal_kirim,
                'status' => 'diproses',
            ]);

            foreach ($request->roll_id as $id) {
                DetailPengiriman::create([
                    'pengiriman_id' => $pengiriman->id,
                    'roll_id' => $id,
                ]);
                
                // Ubah status roll menjadi dikirim
                $roll = Roll::find($id);
                if ($roll) {
                    $roll->status = 'dikirim';
                    $roll->save();
                }
            }
            DB::commit();
            return redirect()->route('pengirimans.index')->with('success', 'Pengiriman berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Pengiriman $pengiriman)
    {
        $user = Auth::user();
        if($user && $user->role === 'admin_toko' && $pengiriman->toko_id !== $user->toko_id) {
            abort(403);
        }
        $pengiriman->load(['toko', 'armada', 'user', 'detailPengirimans.roll.barang.kategori']);
        return view('pengiriman.show', compact('pengiriman'));
    }

    public function update(Request $request, Pengiriman $pengiriman)
    {
        $request->validate([
            'status' => 'required|in:diproses,dikirim,diterima'
        ]);

        $user = Auth::user();
        // admin toko can only update to diterima
        if($user && $user->role === 'admin_toko' && $request->status !== 'diterima') {
            return redirect()->back()->with('error', 'Admin toko hanya dapat mengubah status menjadi Diterima.');
        }

        $pengiriman->status = $request->status;
        if($request->status === 'diterima') {
            $pengiriman->tanggal_diterima = now();
        }
        $pengiriman->save();

        return redirect()->back()->with('success', 'Status pengiriman berhasil diperbarui.');
    }

    public function exportPdf()
    {
        $user = Auth::user();
        $query = Pengiriman::with(['toko', 'armada', 'user', 'detailPengirimans'])->latest();
        
        if ($user && $user->role === 'admin_toko') {
            $query->where('toko_id', $user->toko_id);
        }
        
        $pengirimans = $query->get();
        $pdf = Pdf::loadView('pengiriman.pdf', compact('pengirimans'));
        return $pdf->download('Laporan_Pengiriman_KT_Inventory.pdf');
    }

    public function exportExcel()
    {
        $user = Auth::user();
        $query = Pengiriman::with(['toko', 'armada', 'user', 'detailPengirimans.roll'])->latest();
        
        if ($user && $user->role === 'admin_toko') {
            $query->where('toko_id', $user->toko_id);
        }
        
        $pengirimans = $query->get();
        $filename = "Laporan_Pengiriman_" . date('Y-m-d') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['No', 'Tanggal', 'Toko Tujuan', 'Armada', 'Status', 'Total Barang (Kg)'];
        
        $callback = function() use($pengirimans, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            $no = 1;
            foreach ($pengirimans as $pengiriman) {
                $totalKg = $pengiriman->detailPengirimans->sum(function($dp) {
                    return $dp->roll->berat_kg ?? 0;
                });
                $row = [
                    $no++,
                    \Carbon\Carbon::parse($pengiriman->tanggal_kirim)->format('Y-m-d'),
                    $pengiriman->toko->nama_toko ?? '-',
                    $pengiriman->armada->plat_nomor ?? '-',
                    $pengiriman->status,
                    $totalKg
                ];
                fputcsv($file, $row);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
