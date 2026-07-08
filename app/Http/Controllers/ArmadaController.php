<?php

namespace App\Http\Controllers;

use App\Models\Armada;
use Illuminate\Http\Request;

class ArmadaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $armadas = Armada::when($search, function ($query, $search) {
                return $query->where('plat_nomor', 'like', "%{$search}%")
                             ->orWhere('jenis_kendaraan', 'like', "%{$search}%")
                             ->orWhere('nama_supir', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
            
        return view('armada.index', compact('armadas', 'search'));
    }

    public function create()
    {
        return view('armada.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required|string|max:20|unique:armadas,plat_nomor',
            'jenis_kendaraan' => 'required|string|max:100',
            'nama_supir' => 'required|string|max:255',
        ]);

        Armada::create($request->all());
        return redirect()->route('armadas.index')->with('success', 'Armada berhasil ditambahkan.');
    }

    public function edit(Armada $armada)
    {
        return view('armada.form', compact('armada'));
    }

    public function update(Request $request, Armada $armada)
    {
        $request->validate([
            'plat_nomor' => 'required|string|max:20|unique:armadas,plat_nomor,'.$armada->id,
            'jenis_kendaraan' => 'required|string|max:100',
            'nama_supir' => 'required|string|max:255',
        ]);

        $armada->update($request->all());
        return redirect()->route('armadas.index')->with('success', 'Armada berhasil diperbarui.');
    }

    public function destroy(Armada $armada)
    {
        $armada->delete();
        return redirect()->route('armadas.index')->with('success', 'Armada berhasil dihapus.');
    }
}
