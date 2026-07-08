<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $suppliers = Supplier::when($search, function ($query, $search) {
                return $query->where('nama_supplier', 'like', "%{$search}%")
                             ->orWhere('kontak_person', 'like', "%{$search}%")
                             ->orWhere('no_telepon', 'like', "%{$search}%")
                             ->orWhere('alamat', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
            
        return view('supplier.index', compact('suppliers', 'search'));
    }

    public function create()
    {
        return view('supplier.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'kontak_person' => 'nullable|string|max:255',
            'no_telepon' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
        ]);

        Supplier::create($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.form', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'kontak_person' => 'nullable|string|max:255',
            'no_telepon' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
        ]);

        $supplier->update($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus.');
    }
}
