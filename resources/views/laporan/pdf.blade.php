<!DOCTYPE html>
<html>
<head>
    <title>Laporan Arus Kas</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #f2f2f2; }
        h3 { margin-bottom: 5px; }
    </style>
</head>
<body>

<h3>Laporan Arus Kas</h3>
<p>
    Periode:
    {{ $tanggalMulai ?? '-' }} s/d {{ $tanggalSelesai ?? '-' }}
</p>

<h4>Ringkasan</h4>
<ul>
    <li>Total Kas Masuk: Rp {{ number_format($totalMasuk, 0, ',', '.') }}</li>
    <li>Total Kas Keluar: Rp {{ number_format($totalKeluar, 0, ',', '.') }}</li>
    <li>Saldo: Rp {{ number_format($saldo, 0, ',', '.') }}</li>
</ul>

<h4>Kas Masuk</h4>
<table>
    <tr>
        <th>Tanggal</th>
        <th>Sumber</th>
        <th>Jumlah</th>
    </tr>
    @foreach($kasMasuk as $item)
    <tr>
        <td>{{ $item->tanggal }}</td>
        <td>{{ $item->sumber }}</td>
        <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
    </tr>
    @endforeach
</table>

<h4>Kas Keluar</h4>
<table>
    <tr>
        <th>Tanggal</th>
        <th>Tujuan</th>
        <th>Jumlah</th>
    </tr>
    @foreach($kasKeluar as $item)
    <tr>
        <td>{{ $item->tanggal }}</td>
        <td>{{ $item->tujuan }}</td>
        <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
    </tr>
    @endforeach
</table>

</body>
</html>
