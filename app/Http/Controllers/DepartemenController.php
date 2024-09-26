<?php

namespace App\Http\Controllers;
use App\Models\Departemens;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function index(Request $request)
    {
        // Menerima pencarian jika ada
        $search = $request->input('search');
        $query = Departemens::query();
        
        // Melakukan filter berdasarkan pencarian
        if ($search) {
            $query->where('NamaDepartemen', 'like', '%' . $search . '%');
        }
        
        // Paginate 5 item per halaman
        $departemens =Departemens::orderBy('created_at', 'desc')->paginate(10); 
        return view('departemens.index', compact('departemens'));
    }

    public function create()
    {
        return view('departemens.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $this->validate($request, [
            'NamaDepartemen' => 'required|max:225',
        ]);
        
        // Menyimpan data departemen
        Departemens::create($request->all());

        // Redirect dengan pesan sukses
        return redirect()->route('departemens.index')->with('success', 'Berhasil Membuat Departemen');
    }

    public function edit($id)
    {
        $departemen = Departemens::findOrFail($id);
        return view('departemens.edit', compact('departemen'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $this->validate($request, [
            'NamaDepartemen' => 'required|max:225',
        ]);

        // Mengupdate data departemen
        $departemen = Departemens::findOrFail($id);
        $departemen->update($request->all());

        // Redirect dengan pesan sukses
        return redirect()->route('departemens.index')->with('success', 'Berhasil Memperbarui Data Departemen');
    }

    public function destroy($id)
    {
        $departemen = Departemens::findOrFail($id);
        $departemen->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('departemens.index')->with('success', 'Berhasil Menghapus Data Departemen');
    }
}
