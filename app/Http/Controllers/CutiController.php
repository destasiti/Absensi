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
    
        $cutis = $query->paginate(5);
    
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

        // Kirim notifikasi ke admin
        $admin = User::where('role_as', 'admin')->first();
        $admin->notify(new CutiSubmittedNotification($cuti));

        return redirect()->route('cuti.index')->with('success', 'Pengajuan cuti berhasil dikirim.');
    }

    // Menampilkan daftar pengajuan cuti untuk admin
    public function index(Request $request)
    {
        $search = $request->input('search');

        $cutis = Cuti::with('user')
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
            })
            ->paginate(5);

        $pengajuanCutiBaru = Cuti::where('status', 'pending')->latest()->take(5)->get();

        return view('admin.cuti.index', compact('cutis', 'pengajuanCutiBaru'));
    }

    // Update status cuti dan kirim notifikasi ke user
    public function updateStatus($id, $status)
    {
        $cuti = Cuti::findOrFail($id);
        $cuti->status = $status;
        $cuti->save();

        // Kirim notifikasi ke user
        $user = $cuti->user;
        $user->notify(new UserCutiStatusUpdatedNotification($cuti));

        return redirect()->route('admin.cuti.index')->with('success', 'Status cuti berhasil diubah.');
    }
}
