<?php

namespace App\Http\Controllers;
use App\Models\Cuti;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
    public function notifikasi()
{
    $notifikasis = Notifikasi::where('UserID', auth()->user()->id) // Ambil notifikasi untuk admin yang sedang login
        ->where('dibaca', false)
        ->get();

    return view('admin.notifikasi.index', compact('notifikasis'));
}

}
