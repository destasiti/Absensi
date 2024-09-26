<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cuti;
use Illuminate\Http\Request;
use App\Notifications\CutiSubmittedNotification;
use App\Notifications\UserCutiStatusUpdatedNotification;
use Illuminate\Support\Facades\Auth;

class CutiController extends Controller
{
    // Menampilkan pengajuan cuti user
    public function userIndex(Request $request)
    {
        $query = Cuti::where('UserID', auth()->user()->UserID);
    
        // Filter berdasarkan tanggal mulai jika ada input pencarian
        if ($request->has('tanggal_mulai') && $request->tanggal_mulai != null) {
            $query->whereDate('tanggal_mulai', '=', $request->tanggal_mulai);
        }
    
        $cutis = Cuti::orderBy('created_at', 'desc')->paginate(10);
    
        // Ambil notifikasi yang belum dibaca oleh user
        $notifications = auth()->user()->unreadNotifications;

        return view('cuti.index', compact('cutis', 'notifications'));
    }

    // Simpan pengajuan cuti oleh user dan kirim notifikasi ke admin
    public function store(Request $request)
    {
        $request->validate([
            'alasan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $cuti = Cuti::create([
            'UserID' => Auth::id(),
            'alasan' => $request->alasan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => 'pending',
        ]);

        return redirect()->route('cuti.index')->with('success', 'Pengajuan cuti berhasil dikirim.');
    }

    public function create()
    {
        return view('cuti.create');
    }
    // Menampilkan daftar pengajuan cuti untuk admin
    public function index(Request $request)
{
    $search = $request->query('search');
    
    $cutis = Cuti::with('user')
                 ->when($search, function ($query, $search) {
                     return $query->whereHas('user', function($q) use ($search) {
                         $q->where('name', 'like', "%{$search}%");
                     });
                 })
                 ->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal terbaru
                 ->paginate(10);

    return view('admin.cuti.index', compact('cutis'));
}


    // Update status cuti dan kirim notifikasi ke user
    public function updateStatus($id, $status)
    {
        $cuti = Cuti::findOrFail($id);
        $cuti->status = $status;
        $cuti->save();

        return redirect()->route('admin.cuti.index')->with('success', 'Status cuti berhasil diubah.');
    }
}
