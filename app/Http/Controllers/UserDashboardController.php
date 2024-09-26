<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $notifications = $user->notifications()->take(5)->get(); // Ambil 5 notifikasi terbaru
    
        return view('user.dashboard', compact('notifications'));    }
}
