<?php

namespace App\Http\Controllers;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function markAsRead($id)
    {
        $notifikasi = Notifikasi::find($id);
        $notifikasi->dibaca = true;
        $notifikasi->save();
    
        return response()->json(['success' => true]);
    }
    
}
