@extends('patrial.template')

@section('content')
<style>
    .container {
        margin-top: 20px;
    }

    h1 {
        text-align: center;
        color: #0088ff; /* Ubah warna menjadi hitam */
        margin-bottom: 40px; /* Menambahkan jarak di bawah judul */
        font-weight: bold;
        font-size: 28px; /* Ukuran font lebih sedang */
    }

    .form-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    form {
        display: flex;
        align-items: center;
    }

    form label {
        margin-right: 10px;
        font-size: 14px; /* Ukuran font lebih kecil */
    }

    form input[type="date"] {
        padding: 8px;
        font-size: 14px; /* Ukuran font lebih kecil */
        border-radius: 5px;
        border: 1px solid #5D87FF;
        width: 200px; /* Lebar input yang lebih kecil */
    }

    form button {
        margin-left: 10px;
        padding: 8px 15px;
        background-color: #007bff;
        border: none;
        color: white;
        font-size: 14px; /* Ukuran font lebih kecil */
        cursor: pointer;
        border-radius: 5px;
    }

    form button:hover {
        background-color: #0056b3;
    }

    .btn-download {
        background-color: #28a745; /* Ubah warna menjadi hijau */
        color: white;
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
        border: none; /* Menghilangkan border */
        cursor: pointer;
        display: flex;
        align-items: center; /* Mengatur item dalam flex */
    }

    .btn-download:hover {
        background-color: #218838; /* Warna saat hover */
    }

    .btn-download i {
        margin-right: 5px; /* Jarak antara ikon dan teks */
    }

    .table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .table th, .table td {
        padding: 15px;
        text-align: center;
        border: 1px solid #ddd;
    }

    .table th {
        background-color: #5D87FF;
        color: white;
        font-weight: bold;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .table tbody tr:hover {
        background-color: #f1f1f1;
    }

    .table-container {
        margin-top: 20px; /* Menambahkan jarak di atas tabel */
    }
</style>

<!-- Tambahkan link Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="container">
    <h1>Laporan Absensi</h1>
    <div class="form-container">
        <form method="GET" action="{{ route('absensi.laporan') }}">
            <label for="tanggal">Pilih Tanggal:</label>
            <input type="date" id="tanggal" name="tanggal" value="{{ request()->tanggal }}">
            <button type="submit">Tampilkan</button>
        </form>

        <a href="{{ route('absensi.laporan.pdf', ['tanggal' => request()->tanggal]) }}" class="btn-download">
            <i class="fas fa-file-pdf"></i> Download PDF
        </a>
    </div>
&nbsp;</p>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Waktu Masuk</th>
                    <th>Waktu Keluar</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($absensi as $item)
                <tr>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->Tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $item->WaktuMasuk ?? 'Belum Absen' }}</td>
                    <td>{{ $item->WaktuKeluar ?? 'Belum Absen' }}</td>
                    <td>{{ $item->Keterangan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3 d-flex justify-content-between align-items-center">
        <div>
            {{ $absensi->links('pagination::bootstrap-4') }} <!-- Memastikan pagination menggunakan Bootstrap -->
        </div>
        <p class="mt-2">Menampilkan {{ $absensi->count() }} dari {{ $absensi->total() }} data Absensi.</p>
    </div>
@endsection
