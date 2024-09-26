@extends('layout.template')

@section('content')
<style>
    .container {
        margin-top: 30px;
        padding: 20px;
    }

    h2 {
        text-align: center;
        color: #343a40; /* Warna teks judul */
        margin-bottom: 30px;
        font-weight: bold;
    }

    .user-name {
        color: #007bff; /* Warna teks nama pengguna */
        font-size: 18px;
        margin-bottom: 20px;
        display: inline-block; /* Memungkinkan elemen berada di samping */
    }

    .alert {
        margin-bottom: 20px;
        text-align: center;
    }

    .table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
        border-radius: 8px;
        overflow: hidden;
    }

    .table th, .table td {
        padding: 15px;
        text-align: center;
        border: 1px solid #dee2e6;
    }

    .table th {
        background-color: #5D87FF; /* Warna latar belakang header tabel */
        color: white;
        font-weight: bold;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f2f2f2; /* Warna latar belakang untuk baris genap */
    }

    .table tbody tr:hover {
        background-color: #e2e6ea; /* Warna latar belakang saat hover */
    }

    .badge {
        padding: 8px;
        border-radius: 5px;
        font-size: 14px;
    }

    .badge.bg-success {
        background-color: #28a745;
        color: white;
    }

    .badge.bg-danger {
        background-color: #dc3545;
        color: white;
    }

    .badge.bg-warning {
        background-color: #ffc107;
        color: black;
    }
</style>
<div class="container">
    <h2>Daftar Pengajuan Cuti</h2>
    <!-- Tampilkan nama pengguna yang sedang login di kiri -->
    <div class="user-name">Selamat datang, {{ Auth::user()->name }}</div>

    <!-- Form pencarian berdasarkan tanggal mulai -->
    <form action="{{ route('cuti.index') }}" method="GET" class="mb-4">
        <label for="tanggal_mulai">Cari berdasarkan Tanggal Mulai:</label>
        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
        <button type="submit" class="btn btn-primary mt-2">Cari</button>
    </form>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Alasan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cutis as $index => $cuti)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $cuti->tanggal_mulai }}</td>
                <td>{{ $cuti->tanggal_selesai }}</td>
                <td>{{ $cuti->alasan }}</td>
                <td>
                    @if ($cuti->status == 'approved')
                        <span class="badge bg-success">Disetujui</span>
                    @elseif ($cuti->status == 'rejected')
                        <span class="badge bg-danger">Ditolak</span>
                    @else
                        <span class="badge bg-warning">Pending</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-3 d-flex justify-content-between align-items-center">
        <div>
            {{ $cutis->links('pagination::bootstrap-4') }} <!-- Memastikan pagination menggunakan Bootstrap -->
        </div>
        <p class="mt-2">Menampilkan {{ $cutis->count() }} dari {{ $cutis->total() }} data Pengajuan Cuti Anda.</p>
    </div>
@endsection
