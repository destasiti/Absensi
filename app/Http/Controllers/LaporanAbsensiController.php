<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Carbon\Carbon;
use PDF;

class LaporanAbsensiController extends Controller
{
    // Fungsi untuk menampilkan laporan berdasarkan tanggal tertentu
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal'); // Ambil input tanggal dari form

        // Pastikan tanggal tidak kosong
        if ($tanggal) {
            // Ambil data absensi pada tanggal tersebut dengan paginate
            $absensi = Absensi::whereDate('Tanggal', $tanggal)
                ->orderBy('Tanggal', 'desc')
                ->paginate(10); // Ganti get() dengan paginate()
        } else {
            // Tampilkan semua data jika tanggal tidak dipilih
            $absensi = Absensi::orderBy('Tanggal', 'desc')->paginate(10); // Ganti get() dengan paginate()
        }

        // Mengarahkan ke views/absensi/laporan/index.blade.php
        return view('absensi.laporan.index', compact('absensi', 'tanggal'));
    }

    // Fungsi untuk download PDF berdasarkan tanggal
    public function exportPdf(Request $request)
    {
        $tanggal = $request->input('tanggal');

        if ($tanggal) {
            // Ambil data absensi pada tanggal tersebut
            $absensi = Absensi::whereDate('Tanggal', $tanggal)
                ->orderBy('Tanggal', 'desc')
                ->get();
        } else {
            // Jika tanggal tidak dipilih, tampilkan semua data
            $absensi = Absensi::orderBy('Tanggal', 'desc')->get();
        }

        // Mengarahkan ke views/absensi/laporan/pdf.blade.php
        $pdf = PDF::loadView('absensi.laporan.pdf', compact('absensi'));
        return $pdf->download('laporan_absensi_' . $tanggal . '.pdf');
    }
    
    public function downloadPDF(Request $request)
    {
        if (auth()->user()->role_as !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mendownload laporan ini.');
        }
    
        $tanggal = $request->input('tanggal');
    
        // Ambil data absensi berdasarkan tanggal yang diberikan
        if ($tanggal) {
            $absensi = Absensi::whereDate('Tanggal', $tanggal)
                ->orderBy('Tanggal', 'desc')
                ->get();
        } else {
            $absensi = Absensi::orderBy('Tanggal', 'desc')->get();
        }
    
        // Mengarahkan ke views/absensi/laporan/pdf.blade.php
        $pdf = Pdf::loadView('absensi.laporan.pdf', compact('absensi'));
    
        return $pdf->download('laporan_absensi_' . $tanggal . '.pdf');
    }
}
