<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $barangs = Barang::with('kategori')
            ->when($search, function ($query, $search) {
                return $query->where('nama_barang', 'like', "%{$search}%")
                             ->orWhere('kode_barang', 'like', "%{$search}%")
                             ->orWhereHas('kategori', function ($q) use ($search) {
                                 $q->where('nama_kategori', 'like', "%{$search}%");
                             });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
            
        $kategoris = Kategori::all();
            
        return view('barang.index', compact('barangs', 'search', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('barang.form', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'kode_barang' => 'required|string|max:100|unique:barangs,kode_barang',
            'nama_barang' => 'required|string|max:255',
            'ukuran' => 'required|in:16s,20s,24s,30s,40s',
            'warna' => 'required|string|max:100',
        ]);

        Barang::create($request->all());
        return redirect()->route('barangs.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Barang $barang)
    {
        $kategoris = Kategori::all();
        return view('barang.form', compact('barang', 'kategoris'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'kode_barang' => 'required|string|max:100|unique:barangs,kode_barang,'.$barang->id,
            'nama_barang' => 'required|string|max:255',
            'ukuran' => 'required|in:16s,20s,24s,30s,40s',
            'warna' => 'required|string|max:100',
        ]);

        $barang->update($request->all());
        return redirect()->route('barangs.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('barangs.index')->with('success', 'Barang berhasil dihapus.');
    }
}
