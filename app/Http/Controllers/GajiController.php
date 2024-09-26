<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Gaji;
use App\Models\User;

class GajiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        $gajis = Gaji::select('gajis.*') // Pilih kolom dari tabel gajis
            ->join('users', 'gajis.UserID', '=', 'users.UserID') // Gabungkan tabel users
            ->when($search, function($query) use ($search) {
                return $query->where('users.name', 'like', '%' . $search . '%'); // Cari berdasarkan nama pengguna
            })
            ->paginate(5); // Paginate hasil
    
        return view('gajis.index', compact('gajis', 'search'));
    }
    
        

    // Menampilkan form untuk menambahkan data gaji baru
    public function create()
    {
        $users =  User::all();
        return view('gajis.create', compact('users'));
    }
    

    // Menyimpan data gaji baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'UserID' => 'required|exists:users,UserID',
            'No_Rekening' => 'required|string',
            'Npwp' => 'required|string',
            'Nominal' => 'required|numeric',
        ]);

        Gaji::create([
            'UserID' => $request->UserID,
            'No_Rekening' => $request->No_Rekening,
            'Npwp' => $request->Npwp,
            'Nominal' => $request->Nominal,
        ]);

        return redirect()->route('gajis.index')->with('success', 'Data gaji berhasil ditambahkan.');
    }

    // Menampilkan detail data gaji berdasarkan ID
    public function show($id)
    {
        $gaji = Gaji::findOrFail($id);
        return view('gajis.show', compact('gaji'));
    }

    // Menampilkan form untuk mengedit data gaji
    public function edit($id)
    {
        $gaji = Gaji::findOrFail($id); // Menggunakan primary key yang benar
        $users = User::all(); // Mengambil semua data pengguna
        return view('gajis.edit', compact('gaji', 'users')); // Mengirimkan $gaji dan $users ke view
        }

        public function update(Request $request, $id)
        {
            $request->validate([
                'UserID' => 'required|exists:users,UserID',
                'No_Rekening' => 'required|string|max:50',
                'Npwp' => 'required|string|max:20',
                'Nominal' => 'required|numeric',
            ]);
        
            $gaji = Gaji::findOrFail($id);
            $gaji->update([
                'UserID' => $request->UserID,
                'No_Rekening' => $request->No_Rekening,
                'Npwp' => $request->Npwp,
                'Nominal' => $request->Nominal,
            ]);
        
            return redirect()->route('gajis.index')->with('success', 'Data gaji berhasil diperbarui.');
        }
        
    

    // Menghapus data gaji dari database
    public function destroy($id)
    {
        $gaji = Gaji::findOrFail($id);
        $gaji->delete();

        return redirect()->route('gajis.index')->with('success', 'Data gaji berhasil dihapus.');
    }
}

