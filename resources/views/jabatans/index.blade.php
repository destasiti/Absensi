@extends('patrial.template')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('jabatans.create') }}" class="btn btn-primary">Buat Data Jabatan</a>
    </div>

    <form action="{{ route('jabatans.index') }}" method="GET">
        <div class="input-group mb-3">
            <input type="text" name="search" class="form-control" placeholder="Cari Data Jabatan" value="{{ request('search') }}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </div>
    </form>

    <div class="table-responsive mt-4">
        <table class="table table-bordered text-center">
            <thead class="bg-primary text-white">
                <tr>
                    <th style="font-weight: bold;">No</th>
                    <th style="font-weight: bold;">Nama Jabatan</th>
                    <th style="font-weight: bold;">Deskripsi</th>
                    <th style="font-weight: bold;">Departemen</th>
                    <th style="font-weight: bold;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jabatans as $jabatan)
                    <tr>
                        <td>{{ $loop->iteration + ($jabatans->currentPage() - 1) * $jabatans->perPage() }}</td>
                        <td>{{ $jabatan->NamaJabatan }}</td>
                        <td>{{ $jabatan->Keterangan }}</td>
                        <td>
                            {{ $jabatan->departemens ? $jabatan->departemens->NamaDepartemen : '' }}
                        </td>
                        <td>
                            <a href="{{ route('jabatans.edit', $jabatan->JabatanID) }}" class="btn btn-sm btn-info" title="Edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('jabatans.destroy', $jabatan->JabatanID) }}" method="POST" class="d-inline">
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
                        <td colspan="5">Tidak Ada Data Jabatan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3 d-flex justify-content-between align-items-center">
        <div>
            {{ $jabatans->links('pagination::bootstrap-4') }} <!-- Memastikan pagination menggunakan Bootstrap -->
        </div>
        <p class="mt-2">Menampilkan {{ $jabatans->count() }} dari {{ $jabatans->total() }} data Jabatan.</p>
    </div>
</div>

<style>
    thead th {
        background-color: rgba(0, 123, 255, 0.5); /* Biru transparan */
        color: white; /* Teks berwarna putih */
    }
</style>
@endsection
