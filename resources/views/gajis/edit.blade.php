@extends('patrial.template')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Data Gaji</h5>
            <form method="POST" action="{{ route('gajis.update', $gaji->GajiID) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="UserID" class="form-label">Nama Karyawan</label>
                    <select name="UserID" id="UserID" class="form-control" required>
                        <option value="">--Pilih Karyawan--</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->UserID }}" {{ $gaji->UserID == $user->UserID ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="No_Rekening" class="form-label">No. Rekening</label>
                    <input type="text" class="form-control" id="No_Rekening" name="No_Rekening" value="{{ old('No_Rekening', $gaji->No_Rekening) }}" required>
                </div>
                <div class="mb-3">
                    <label for="Npwp" class="form-label">NPWP</label>
                    <input type="text" class="form-control" id="Npwp" name="Npwp" value="{{ old('Npwp', $gaji->Npwp) }}" required>
                </div>
                <div class="mb-3">
                    <label for="Nominal" class="form-label">Nominal</label>
                    <input type="number" class="form-control" id="Nominal" name="Nominal" value="{{ old('Nominal', $gaji->Nominal) }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Memperbarui</button>
                <a href="{{ route('gajis.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
