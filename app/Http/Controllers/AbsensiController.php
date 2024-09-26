<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AbsensiController extends Controller
{
    const JAM_MASUK = 8; // Jam masuk
    const JAM_KELUAR = 16; // Jam keluar

    // Fungsi untuk menampilkan halaman index absensi
    public function index()
    {
        if (auth()->check()) {
            $userID = auth()->user()->UserID; // Ambil UserID dari auth
            $currentDate = Carbon::now('Asia/Jakarta')->toDateString(); // Ambil tanggal hari ini

            // Ambil data absensi
            $absensi = Absensi::where('UserID', $userID)->orderBy('Tanggal', 'desc')->get();
            $absensiHariIni = Absensi::where('UserID', $userID)->where('Tanggal', $currentDate)->first();

            return view('absensi.index', compact('absensi', 'absensiHariIni'));
        }

        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Fungsi absen masuk
    public function absenMasuk()
    {
        if (auth()->check()) {
            $userID = auth()->user()->UserID;
            $currentDate = Carbon::now('Asia/Jakarta')->toDateString();
            $absensiHariIni = Absensi::where('UserID', $userID)->where('Tanggal', $currentDate)->first();

            if ($absensiHariIni && $absensiHariIni->WaktuMasuk) {
                return redirect()->back()->with('error', 'Anda sudah melakukan absen masuk hari ini.');
            }

            $absensi = new Absensi();
            $absensi->UserID = $userID;
            $absensi->Tanggal = $currentDate;

            $waktuSekarang = Carbon::now('Asia/Jakarta');
            $absensi->Hari = $waktuSekarang->locale('id')->translatedFormat('l'); // Hari dalam bahasa Indonesia
            $absensi->WaktuMasuk = $waktuSekarang->toTimeString();

            // Menentukan keterangan hadir atau terlambat
            $absensi->Keterangan = $waktuSekarang->gt(Carbon::createFromTime(self::JAM_MASUK, 0, 0, 'Asia/Jakarta')) ? 'Terlambat' : 'Hadir';

            $absensi->save(); // Simpan data absensi

            return redirect()->back()->with('success');
        }

        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Fungsi absen keluar
    public function absenKeluar($id)
    {
        if (auth()->check()) {
            $absensi = Absensi::find($id);

            if (!$absensi) {
                return redirect()->back()->with('error', 'Data absensi tidak ditemukan.');
            }

            $waktuSekarang = Carbon::now('Asia/Jakarta');
            $checkOutTime = Carbon::createFromTime(self::JAM_KELUAR, 0, 0, 'Asia/Jakarta');

            // Memeriksa waktu checkout
            if ($waktuSekarang->lt($checkOutTime)) {
                return redirect()->back()->with('error', 'Belum waktu absensi pulang.');
            }

            if (is_null($absensi->WaktuMasuk)) {
                return redirect()->back()->with('error', 'Anda belum melakukan absen masuk.');
            }

            if (!is_null($absensi->WaktuKeluar)) {
                return redirect()->back()->with('error', 'Anda sudah berhasil melakukan absen keluar.');
            }

            $absensi->WaktuKeluar = $waktuSekarang->toTimeString();
            $absensi->save();

            return redirect()->back()->with('success');
        }

        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Fungsi untuk melihat laporan absensi
    public function laporanAbsensi(Request $request)
    {
        if (auth()->user()->role_as !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk melihat laporan ini.');
        }

        // Validasi input
        $request->validate([
            'tanggal' => 'nullable|date',
            'bulan' => 'nullable|integer|between:1,12',
        ]);

        $query = Absensi::with('user');

        // Filter berdasarkan tanggal atau bulan
        if ($request->tanggal) {
            $query->whereDate('Tanggal', $request->tanggal);
        } elseif ($request->bulan) {
            $query->whereMonth('Tanggal', $request->bulan);
        }

        $dataAbsensi = $query->get();

        return view('absensi.laporan', compact('dataAbsensi'));
    }
  //  public function boot() {View::composer('partial.navbar', function ($view) {
        // Ambil pengajuan cuti yang berstatus pending
        //$pengajuanCutiBaru = Cuti::where('status', 'pending')->latest()->take(5)->get();
        //$view->with('pengajuanCutiBaru', $pengajuanCutiBaru);
    //});
//}
}