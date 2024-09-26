<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jabatans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search= $request->input('search');
        $users = User::with('jabatan')->when($search , function($query) use ($search)
        {
            return $query->where('name', 'like', '%'. $search .'%');
        })->paginate(5);
        return view('users.index', compact('users', 'search'));

    }

    public function create()
    {
        $jabatans = Jabatans::all(); 
        return view('users.create', compact('jabatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6', 
            'JabatanID' => 'required|exists:jabatans,JabatanID',
            'Tanggal_Lahir' => 'required|date',
            'Jenis_Kelamin' => 'required|in:Laki-laki,Perempuan',
            'No_Telp' => 'required|string|max:15',
            'Alamat' => 'required|string',
            'Tanggal_Bergabung' => 'required|date',
            'Status' => 'required|in:Aktif,Tidak Aktif',
            'role_as' => 'required|in:admin,user',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'JabatanID' => $request->JabatanID,
            'Tanggal_Lahir' => $request->Tanggal_Lahir,
            'Jenis_Kelamin' => $request->Jenis_Kelamin,
            'No_Telp' => $request->No_Telp,
            'Alamat' => $request->Alamat,
            'Tanggal_Bergabung' => $request->Tanggal_Bergabung,
            'Status' => $request->Status,
            'role_as' => $request->role_as,
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $jabatans = Jabatans::all();
        return view('users.edit', compact('user', 'jabatans'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->UserID . ',UserID', // Ganti dengan primary key yang benar
            'password' => 'nullable|min:6',
            'JabatanID' => 'required|exists:jabatans,JabatanID',
            'Tanggal_Lahir' => 'required|date',
            'Jenis_Kelamin' => 'required|in:Laki-laki,Perempuan',
            'No_Telp' => 'required|string|max:15',
            'Alamat' => 'required|string',
            'Tanggal_Bergabung' => 'required|date',
            'Status' => 'required|in:Aktif,Tidak Aktif',
            'role_as' => 'required|in:admin,user',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'JabatanID' => $request->JabatanID,
            'Tanggal_Lahir' => $request->Tanggal_Lahir,
            'Jenis_Kelamin' => $request->Jenis_Kelamin,
            'No_Telp' => $request->No_Telp,
            'Alamat' => $request->Alamat,
            'Tanggal_Bergabung' => $request->Tanggal_Bergabung,
            'Status' => $request->Status,
            'role_as' => $request->role_as,
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
