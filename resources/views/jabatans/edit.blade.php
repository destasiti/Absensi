@extends('partials.template')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Edit Data Jabatan</h5>
            <form action="{{ route('jabatans.update', $jabatans->JabatanID) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="NamaJabatan" class="form-label">Nama Jabatan</label>
                    <input type="text" class="form-control" id="NamaJabatan" name="NamaJabatan" 
                           value="{{ old('NamaJabatan', $jabatans->NamaJabatan) }}" required>
                </div>
                <div class="mb-3">
                    <label for="Keterangan" class="form-label">Keterangan</label>
                    <input type="text" class="form-control" id="Keterangan" name="Keterangan" 
                           value="{{ old('Keterangan', $jabatans->Keterangan) }}" required>
                </div>
                <div class="mb-3">
                    <label for="DepartemenID" class="form-label">Departemen</label>
                    <select name="DepartemenID" id="DepartemenID" class="form-control" required>
                        <option value="">--Pilih Departemen--</option>
                        @foreach ($departemens as $departemen)
                            <option value="{{ $departemen->DepartemenID }}" 
                                    {{ $departemen->DepartemenID == $jabatans->DepartemenID ? 'selected' : '' }}>
                                {{ $departemen->NamaDepartemen }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Perbarui</button>
                <a href="{{ route('jabatans.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
