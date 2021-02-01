@extends('layouts.app')
@section('content')
<table class="table" id='dataTable'>
    <thead>
        <tr>
            <th>Bagian Id</th><th>Nama</th>
        </tr>
    </thead>
    <tbody>
        <tr data-id='{{ $sub_bagian->id }}'>
            <td>{{ $item->bagian_id }}</td><td>{{ $item->nama }}</td>
        </tr>
    </tbody>
</table>
@endsection