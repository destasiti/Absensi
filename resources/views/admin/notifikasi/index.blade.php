@extends('patrial.template')

@section('content')
<div class="container">
    <h2>Notifikasi</h2>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Pesan</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notifikasis as $index => $notifikasi)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <a href="{{ route('cuti.index') }}" class="text-decoration-none" onclick="markAsRead({{ $notifikasi->id }})">
                        {{ $notifikasi->pesan }}
                    </a>
                </td>
                <td>{{ $notifikasi->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function markAsRead(id) {
        fetch(`/notifikasi/${id}`, { method: 'PATCH' });
    }
</script>
@endsection
