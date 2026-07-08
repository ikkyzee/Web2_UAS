<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $users = User::with('toko')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%")
                             ->orWhere('role', 'like', "%{$search}%")
                             ->orWhereHas('toko', function ($q) use ($search) {
                                 $q->where('nama_toko', 'like', "%{$search}%");
                             });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
            
        $tokos = Toko::all();
            
        return view('user.index', compact('users', 'search', 'tokos'));
    }

    public function create()
    {
        $tokos = Toko::all();
        return view('user.form', compact('tokos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,petugas,admin_toko',
            'toko_id' => 'nullable|exists:tokos,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'toko_id' => $request->role === 'admin_toko' ? $request->toko_id : null,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $tokos = Toko::all();
        return view('user.form', compact('user', 'tokos'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,petugas,admin_toko',
            'toko_id' => 'nullable|exists:tokos,id',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'toko_id' => $request->role === 'admin_toko' ? $request->toko_id : null,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if($user->id === 1 || $user->role === 'admin') {
            // Protect main admin from accidental deletion
            return redirect()->route('users.index')->with('error', 'Admin utama tidak bisa dihapus.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
