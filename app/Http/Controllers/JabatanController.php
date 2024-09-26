<?php

namespace App\Http\Controllers;
use App\Models\Jabatans;
use App\Models\Departemens;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index(Request $request)
    {
        $search= $request->input('search');
        $jabatans= Jabatans::with('departemens')->when($search , function($query) use ($search)
        {
            return $query->where('NamaJabatan', 'like', '%'. $search .'%');
        }) ->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal terbaru
        ->paginate(10);
        return view('jabatans.index', compact('jabatans', 'search'));
    }

    public function create (){
        $departemens =  Departemens::all();
        return view('jabatans.create', compact('departemens'));
    }
    public function store(Request $request)
    {
        $rules =[
        'NamaJabatan'=> 'required',
        'Keterangan'=> 'required',
        'DepartemenID'=> 'required|exists:departemens,DepartemenID',
        ];
        $this->validate($request , $rules );
        Jabatans::create($request->all());
        return redirect()->route('jabatans.index')->with('success', 'Data jabatan berhasil dibuat.');
    }

    public function edit($id)
    {
        $jabatans = Jabatans::findOrfail($id);
        $departemens = Departemens::all();
        return view('jabatans.edit', compact('jabatans', 'departemens'));
    }
    public function update(Request $request , $id)
    {
        $rules=[
            'NamaJabatan'=> 'required',
            'Keterangan'=> 'required',
            'DepartemenID'=> 'required|exists:departemens,DepartemenID',
        ];
        $this->validate($request , $rules);
        $jabatans = Jabatans::findOrfail($id);
        $jabatans->update($request->all());
        return redirect()->route('jabatans.index')->with('success','Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $jabatans = Jabatans::findOrfail($id);
        $jabatans->delete();
        return redirect()->route('jabatans.index')->with('success','Data berhasil dihapus. ');
    }
}
