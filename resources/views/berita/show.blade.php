@extends('layouts.app')
@section('content')
<table class="table" id='dataTable'>
    <thead>
        <tr>
            <th>Judul</th><th>Isi</th><th>Lampiran</th>
        </tr>
    </thead>
    <tbody>
        <tr data-id='{{ $berita->id }}'>
            <td>{{ $item->judul }}</td><td>{{ $item->isi }}</td><td>{{ $item->lampiran }}</td>
        </tr>
    </tbody>
</table>
@endsection