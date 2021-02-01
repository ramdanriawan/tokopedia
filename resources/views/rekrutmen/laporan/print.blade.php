@extends('layouts.print')

@section('content')

<h3 align="center">LAPORAN REKRUTMEN</h3>

<table width="100%" border="1" style='margin-bottom: 250px;'>
    <thead>
        <tr>
            <th width=3>No.</th>
            <th>Jabatan Id</th>
            <th>No Pendaftar</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Tanggal Lahir</th>
            <th>Tempat Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Agama</th>
            <th>Alamat</th>
            <th>No Telepon</th>
            <th>Status</th>
            <th>Dibuat</th>
        </tr>
        <tbody>
        @foreach($rekrutmens as $rekrutmen)
        <tr>
            <td>{{ $loop->iteration }}.</td>
            <td>{{ $rekrutmen->jabatan_id }}</td>
            <td>{{ $rekrutmen->no_pendaftar }}</td>
            <td>{{ $rekrutmen->nik }}</td>
            <td>{{ $rekrutmen->nama }}</td>
            <td>{{ $rekrutmen->tanggal_lahir }}</td>
            <td>{{ $rekrutmen->tempat_lahir }}</td>
            <td>{{ $rekrutmen->jenis_kelamin }}</td>
            <td>{{ $rekrutmen->agama }}</td>
            <td>{{ $rekrutmen->alamat }}</td>
            <td>{{ $rekrutmen->no_telepon }}</td>
            <td>{{ $rekrutmen->status }}</td>
            <td>{{ $rekrutmen->dibuat }}</td>
        </tr>
        @endforeach
        </tbody>
</table>
@endsection