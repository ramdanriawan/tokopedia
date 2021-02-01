@extends('layouts.app')
@section('content')
<table class="table" id='dataTable'>
    <thead>
        <tr>
            <th>Jabatan Id</th><th>No Pendaftar</th><th>NIK</th><th>Nama</th><th>Tanggal Lahir</th><th>Tempat Lahir</th><th>Jenis Kelamin</th><th>Agama</th><th>Alamat</th><th>No Telepon</th><th>Status</th><th>Dibuat</th>
        </tr>
    </thead>
    <tbody>
        <tr data-id='{{ $rekrutmen->id }}'>
            <td>{{ $item->jabatan_id }}</td><td>{{ $item->no_pendaftar }}</td><td>{{ $item->nik }}</td><td>{{ $item->nama }}</td><td>{{ $item->tanggal_lahir }}</td><td>{{ $item->tempat_lahir }}</td><td>{{ $item->jenis_kelamin }}</td><td>{{ $item->agama }}</td><td>{{ $item->alamat }}</td><td>{{ $item->no_telepon }}</td><td>{{ $item->status }}</td><td>{{ $item->dibuat }}</td>
        </tr>
    </tbody>
</table>
@endsection