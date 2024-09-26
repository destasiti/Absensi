<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi Karyawan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #003366;
            color: white;
        }
    </style>
</head>
<body>
    <h2>Laporan Absensi Karyawan Pustipanda</h2>

<table border="1" cellspacing="0" cellpadding="5">
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
            <td>{{ $item->Tanggal }}</td>
            <td>{{ $item->WaktuMasuk }}</td>
            <td>{{ $item->WaktuKeluar }}</td>
            <td>{{ $item->Keterangan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
