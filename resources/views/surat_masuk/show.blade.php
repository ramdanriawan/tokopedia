@extends('layouts.app')
@section('content')
<table class="table" id='dataTable'>
    <thead>
        <tr>
            <th>Sifat Surat Id</th>
            <th>User Unit Kerja</th>
            <th>Waktu Masuk</th>
            <th>Nomor</th>
            <th>Pengirim</th>
            <th>Perihal</th>
            <th>Isi Ringkas</th>
            <th>Lampiran</th>
        </tr>
    </thead>
    <tbody>
        <tr data-id='{{ $surat_masuk->id }}'>
            <td>{{ $item->sifat_surat }}</td>
            <td>{{ $item->user_unit_kerja->name }}</td>
            <td>{{ $item->waktu_masuk }}</td>
            <td>{{ $item->nomor }}</td>
            <td>{{ $item->pengirim }}</td>
            <td>{{ $item->perihal }}</td>
            <td>{{ $item->isi_ringkas }}</td>
            <td>
                <a href="{{ url(Storage::url($item->lampiran)) }}" download='lampiran {{ $item->perihal }}'>
                    Lihat
                </a>
                
            </td>
        </tr>
    </tbody>
</table>
@endsection