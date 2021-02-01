@extends('layouts.app')
@section('content')
<table class="table" id='dataTable'>
    <thead>
        <tr>
            <th>Sifat Surat Id</th><th>Waktu Keluar</th><th>Nomor</th><th>Pengirim</th><th>Perihal</th><th>Kepada</th><th>Isi Ringkas</th><th>Lampiran</th>
        </tr>
    </thead>
    <tbody>
        <tr data-id='{{ $surat_keluar->id }}'>
            <td>{{ $item->sifat_surat_id }}</td><td>{{ $item->waktu_keluar }}</td><td>{{ $item->nomor }}</td><td>{{ $item->pengirim }}</td><td>{{ $item->perihal }}</td><td>{{ $item->kepada }}</td><td>{{ $item->isi_ringkas }}</td><td>{{ $item->lampiran }}</td>
        </tr>
    </tbody>
</table>
@endsection