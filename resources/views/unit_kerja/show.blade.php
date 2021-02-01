@extends('layouts.app')
@section('content')
<table class="table" id='dataTable'>
    <thead>
        <tr>
            <th>Bagian Id</th><th>Nama</th><th>Jenis Kelamin</th><th>Alamat</th><th>No Telepon</th><th>Status</th><th>Dibuat</th>
        </tr>
    </thead>
    <tbody>
        <tr data-id='{{ $unit_kerja->id }}'>
            <td>{{ $item->bagian_id }}</td><td>{{ $item->nama }}</td><td>{{ $item->jenis_kelamin }}</td><td>{{ $item->alamat }}</td><td>{{ $item->no_telepon }}</td><td>{{ $item->status }}</td><td>{{ $item->dibuat }}</td>
        </tr>
    </tbody>
</table>
@endsection