<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;

class TokoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $tokos = Toko::when($search, function ($query, $search) {
                return $query->where('nama_toko', 'like', "%{$search}%")
                             ->orWhere('alamat_toko', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
            
        return view('toko.index', compact('tokos', 'search'));
    }

    public function create()
    {
        return view('toko.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat_toko' => 'required|string',
        ]);

        Toko::create($request->all());
        return redirect()->route('tokos.index')->with('success', 'Toko berhasil ditambahkan.');
    }

    public function edit(Toko $toko)
    {
        return view('toko.form', compact('toko'));
    }

    public function update(Request $request, Toko $toko)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat_toko' => 'required|string',
        ]);

        $toko->update($request->all());
        return redirect()->route('tokos.index')->with('success', 'Toko berhasil diperbarui.');
    }

    public function destroy(Toko $toko)
    {
        $toko->delete();
        return redirect()->route('tokos.index')->with('success', 'Toko berhasil dihapus.');
    }
}
