@extends('layouts.app')
@section('content')
<table class="table" id='dataTable'>
    <thead>
        <tr>
            <th>Surat Masuk Id</th>
            <th>Unit Kerja Sub Bagian Id</th>
            <th>Rekrutmen Jabatan Id</th>
            <th>Waktu Disposisi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <tr data-id='{{ $disposisi->id }}'>
            <td>{{ $item->surat_masuk->perihal }}</td>
            <td>{{ $item->unit_kerja_sub_bagian->nama }}</td>
            <td>{{ $item->rekrutmen_jabatan->nama }}</td>
            <td>{{ $item->waktu_disposisi }}</td>

            <td class="text-center">
                <a class="label label-info"
                    href="{{ url("surat_masuk/$item->surat_masuk_id") }}">
                    Detail Surat
                    <i class="fa fa-eye" aria-hidden="true"></i>
                </a>

                @if($item->surat_masuk->user_unit_kerja_id == auth()->id() || auth()->user()->level == 'Admin')
                <a class="label label-primary"
                    href="{{ url('/disposisi/' . $item->id . "/edit?surat_masuk_id=$item->surat_masuk_id") }}">Edit</a>
                <form action="{{ url('/disposisi' . '/' . $item->id) }}"
                    method='post' style='display: inline;'
                    onsubmit="return confirm('Yakin akan menghapus data ini?')">
                    @method('DELETE')
                    @csrf
                    <label class="label label-danger" href="" for='btnSubmit-{{ $item->id }}'
                        style='cursor: pointer;'>Hapus</label>
                    <button type="submit" id='btnSubmit-{{ $item->id }}'
                        style="display: none;"></button>
                </form>
                @endif
            </td>
        </tr>
    </tbody>
</table>
@endsection