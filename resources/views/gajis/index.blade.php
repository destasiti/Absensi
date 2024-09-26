@extends('patrial.template')

@section('content')
<div class="container">        
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('gajis.create') }}" class="btn btn-primary btn-action">
            <i class="fas fa-plus"></i> Buat Data Gaji
        </a>
    </div>

    <form action="{{ route('gajis.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari gaji" value="{{ request('search') }}">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </div>
    </form>

    <div class="table-responsive mt-4">
        <table class="table table-bordered text-center">
            <thead style="background-color: #5D87FF; color: white;">
                <tr>
                    <th style="font-weight: bold;">No</th>
                    <th style="font-weight: bold;">Nama Karyawan</th>
                    <th style="font-weight: bold;">No. Rekening</th>
                    <th style="font-weight: bold;">NPWP</th>
                    <th style="font-weight: bold;">Nominal</th>
                    <th style="font-weight: bold;">Aksi</th>
                </tr>
            </thead>
            <tbody>
    @forelse($gajis as $gaji)
        <tr>
            <td>{{ $loop->iteration + ($gajis->currentPage() - 1) * $gajis->perPage() }}</td>
            <td>{{ $gaji->user ? $gaji->user->name : 'Tidak ada' }}</td>
            <td>{{ $gaji->No_Rekening }}</td>
            <td>{{ $gaji->Npwp }}</td>
            <td>{{ number_format($gaji->Nominal, 2, ',', '.') }}</td>
            <td>
                <a href="{{ route('gajis.edit', $gaji->GajiID) }}" class="btn btn-sm btn-primary" title="Edit">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('gajis.show', $gaji->GajiID) }}" class="btn btn-sm" title="Lihat" style="background-color: #89CFF0; color: #fff;">
                    <i class="fas fa-eye"></i> Lihat
                </a>
                <form action="{{ route('gajis.destroy', $gaji->GajiID) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapusnya?')" title="Hapus">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center">Tidak Ada Data Gaji</td>
        </tr>
    @endforelse
</tbody>

        </table>
    </div>
    </div>
    <div class="mt-3 d-flex justify-content-between align-items-center">
        <div>
            {{ $gajis->links('pagination::bootstrap-4') }} <!-- Memastikan pagination menggunakan Bootstrap -->
        </div>
        <p class="mt-2">Menampilkan {{ $gajis->count() }} dari {{ $gajis->total() }} data Gaji.</p>
</div>

@endsection
