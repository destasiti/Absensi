@extends('patrial.template')

@section('content')
<style>
    .container {
        margin-top: 20px;
    }

    h2 {
        text-align: center;
        color: #0088ff;
        margin-bottom: 40px;
        font-weight: bold;
        font-size: 28px;
    }

    .form-search {
        margin-bottom: 20px;
        display: flex;
        justify-content: flex-start; 
    }

    .form-search input[type="text"] {
        padding: 8px;
        font-size: 14px;
        border-radius: 5px;
        border: 1px solid #007bff;
        width: 300px;
        margin-right: 10px;
    }

    .form-search button {
        padding: 8px 15px;
        background-color: #007bff;
        border: none;
        color: white;
        font-size: 14px;
        cursor: pointer;
        border-radius: 5px;
    }

    .form-search button:hover {
        background-color: #0056b3;
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

    .btn-custom-success {
        background-color: #28a745;
        color: white;
        border: none;
    }

    .btn-custom-success:hover {
        background-color: #218838;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
        border: none;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .badge {
        padding: 8px;
        border-radius: 5px;
        font-size: 14px;
    }

    .badge.bg-warning {
        background-color: #ffc107;
        color: black;
    }

    .badge.bg-success {
        background-color: #28a745;
        color: white;
    }

    .badge.bg-danger {
        background-color: #dc3545;
        color: white;
    }
</style>

<div class="container">
    <h2>Daftar Pengajuan Cuti</h2>
    <p>&nbsp;</p>
    <!-- Form Pencarian -->
    <div class="form-search">
        <form action="{{ route('admin.cuti.index') }}" method="GET">
            <input type="text" name="search" placeholder="Cari berdasarkan nama..." value="{{ request()->query('search') }}">
            <button type="submit">Cari</button>
        </form>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
                <th>Alasan</th>
                <th>Aksi</th> <!-- Kolom Aksi -->
            </tr>
        </thead>
        <tbody>
            @foreach ($cutis as $index => $cuti)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $cuti->user->name }}</td>
                <td>{{ $cuti->tanggal_mulai }}</td>
                <td>{{ $cuti->tanggal_selesai }}</td>
                <td>
                    @if($cuti->status == 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @elseif($cuti->status == 'approved')
                        <span class="badge bg-success">Disetujui</span>
                    @elseif($cuti->status == 'rejected')
                        <span class="badge bg-danger">Ditolak</span>
                    @endif
                </td>
                <td>{{ $cuti->alasan }}</td>
                <td>
                    @if($cuti->status == 'pending')
                        <!-- Aksi Setujui dan Tolak -->
                        <form action="{{ route('admin.cuti.updateStatus', ['id' => $cuti->CutiID, 'status' => 'approved']) }}" method="POST" style="display:inline;" class="form-approval">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-custom-success">Setujui</button>
                        </form>
                        <form action="{{ route('admin.cuti.updateStatus', ['id' => $cuti->CutiID, 'status' => 'rejected']) }}" method="POST" style="display:inline;" class="form-rejection">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger">Tolak</button>
                        </form>
                    @else
                        <span>Tidak ada aksi</span> <!-- Jika status sudah disetujui atau ditolak -->
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
        <p class="mt-2">Menampilkan {{ $cutis->count() }} dari {{ $cutis->total() }} data Pengajuan Cuti.</p>
    </div>
<script>
    // Hilangkan tombol setelah diklik
    document.querySelectorAll('.form-approval, .form-rejection').forEach(form => {
        form.addEventListener('submit', function() {
            this.querySelector('button').disabled = true;
        });
    });
</script>

@endsection
