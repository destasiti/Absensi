@extends('patrial.template')

@section('content')
<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('users.create') }}" class="btn btn-primary">Buat Data User</a>
    </div>

    <form action="{{ route('users.index') }}" method="GET">
        <div class="input-group mb-3">
            <input type="text" name="search" class="form-control" placeholder="Cari Data User" value="{{ request()->query('search') }}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </div>
    </form>

    <div class="table-responsive mt-4">
        <table class="table table-bordered text-center">
            <thead class="bg-primary text-white">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Jabatan</th>
                    <th>Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>No Telepon</th>
                    <th>Alamat</th>
                    <th>Tanggal Bergabung</th>
                    <th>Status</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->jabatan->NamaJabatan ?? 'Tidak ada' }}</td>
                        <td>{{ $user->Tanggal_Lahir->format('d-m-Y') }}</td>
                        <td>{{ $user->Jenis_Kelamin }}</td>
                        <td>{{ $user->No_Telp }}</td>
                        <td>{{ $user->Alamat }}</td>
                        <td>{{ $user->Tanggal_Bergabung->format('d-m-Y') }}</td>
                        <td>{{ $user->Status }}</td>
                        <td>{{ $user->role_as }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user->UserID) }}" class="btn btn-sm btn-info" title="Edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('users.show', $user->UserID) }}" class="btn btn-sm" title="Lihat" style="background-color: #89CFF0; color: #fff;">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                            <form action="{{ route('users.destroy', $user->UserID) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapusnya?')" title="Hapus">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center">Tidak Ada Data Karyawan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3 d-flex justify-content-between align-items-center">
            <div>
                {{ $users->links('pagination::bootstrap-4') }} <!-- Memastikan pagination menggunakan Bootstrap -->
            </div>
            <p class="mt-2">Menampilkan {{ $users->count() }} dari {{ $users->total() }} data Karyawan.</p>
        </div>
    </div>
</div>

<style>
    thead th {
        background-color: rgba(0, 123, 255, 0.5); /* Biru transparan */
        color: white; /* Teks berwarna putih */
    }
</style>
@endsection
