@extends('layouts.app')
@section('content')
<table class="table" id='dataTable'>
    <thead>
        <tr>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <tr data-id='{{ $sifat_surat->id }}'>
            <td>{{ $item->keterangan }}</td>
        </tr>
    </tbody>
</table>
@endsection