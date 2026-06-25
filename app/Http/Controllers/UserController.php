<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Apotek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('apotek')
        ->whereIn('role', [
        'admin_apotek',
        'kasir'
        ])
        ->latest()
        ->get();

        return view(
            'users.index',
            compact('users')
        );
    }

    public function create()
    {
        $apoteks = Apotek::all();

        return view(
            'users.create',
            compact('apoteks')
        );
    }

    public function store(Request $request)
{
    $request->validate([
        'name'       => 'required|string|max:255',
        'email'      => 'required|email|unique:users,email',
        'password'   => 'required|min:8',
        'role'       => 'required|in:admin_apotek,kasir',
        'apotek_id'  => 'required|exists:apoteks,id',
    ]);

    // Jika role Admin Apotek, cek apakah sudah ada admin pada apotek tersebut
    if ($request->role == 'admin_apotek') {

        $cekAdmin = User::where('role', 'admin_apotek')
            ->where('apotek_id', $request->apotek_id)
            ->exists();

        if ($cekAdmin) {

            return back()
                ->withErrors([
                    'apotek_id' => 'Apotek ini sudah memiliki Admin Apotek.'
                ])
                ->withInput();

        }

    }

    User::create([
        'name'       => $request->name,
        'email'      => $request->email,
        'password'   => Hash::make($request->password),
        'role'       => $request->role,
        'apotek_id'  => $request->apotek_id,
    ]);

    return redirect()
        ->route('users.index')
        ->with(
            'success',
            'Akun berhasil ditambahkan.'
        );
}
public function edit(User $user)
{
    $apoteks = Apotek::all();

    return view(
        'users.edit',
        compact(
            'user',
            'apoteks'
        )
    );
}
public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'role' => 'required|in:admin_apotek,kasir',
        'apotek_id' => 'required|exists:apoteks,id',
    ]);

    // Jika role Admin Apotek, pastikan belum ada admin lain
    if ($request->role == 'admin_apotek') {

        $cekAdmin = User::where('role', 'admin_apotek')
            ->where('apotek_id', $request->apotek_id)
            ->where('id', '!=', $user->id)
            ->exists();

        if ($cekAdmin) {

            return back()
                ->withErrors([
                    'apotek_id' => 'Apotek ini sudah memiliki Admin Apotek.'
                ])
                ->withInput();

        }
    }

    $user->name = $request->name;
    $user->email = $request->email;
    $user->role = $request->role;
    $user->apotek_id = $request->apotek_id;

    if ($request->filled('password')) {

        $user->password = Hash::make($request->password);

    }

    $user->save();

    return redirect()
        ->route('users.index')
        ->with(
            'success',
            'Data akun berhasil diperbarui.'
        );
}
public function destroy(User $user)
{
    $user->delete();

    return redirect()
        ->route('users.index')
        ->with(
            'success',
            'Data akun berhasil dihapus.'
        );
}
}
