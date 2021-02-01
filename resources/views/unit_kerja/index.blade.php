@extends('layouts.app')

@section('content')
<table class="table" id='dataTable'>
    <thead>
        <tr>
            <th width=2>#</th>
            <th>User Id</th>
            <th>Sub Bagian Id</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Alamat</th>
            <th>No Telepon</th>
            <th>Status</th>
            <th>Dibuat</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($unit_kerja as $item)
        <tr data-id='{{ $item->id }}'>
            <td>
                {{ $loop->iteration }}
            </td>

            <td>{{ $item->user->name }}</td>
            <td>{{ $item->sub_bagian->nama }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->jenis_kelamin }}</td>
            <td>{{ $item->alamat }}</td>
            <td>{{ $item->no_telepon }}</td>
            <td>{{ $item->status }}</td>
            <td>{{ $item->dibuat }}</td>

            <td class="text-center">
                <a class="label label-info" href="{{ url("user/$item->user_id/edit") }}">
                    Detail User
                    <i class="fa fa-eye" aria-hidden="true"></i>
                </a>
                <a class="label label-primary" href="{{ url('/unit_kerja/' . $item->id . '/edit') }}">Edit</a>
                <form action="{{ url('/unit_kerja' . '/' . $item->id) }}" method='post' style='display: inline;'
                    onsubmit="return confirm('Yakin akan menghapus data ini?')">
                    @method('DELETE')
                    @csrf
                    <label class="label label-danger" href="" for='btnSubmit-{{ $item->id }}'
                        style='cursor: pointer;'>Hapus</label>
                    <button type="submit" id='btnSubmit-{{ $item->id }}' style="display: none;"></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    const locationHrefHapusSemua = "{{ url('unit_kerja/hapus_semua') }}";
    const locationHrefAktifkanSemua = "{{ url('unit_kerja/aktifkan_semua') }}";
    const locationHrefCreate = "{{ url('unit_kerja/create') }}";
    var columnOrders = [{{ $unit_kerja_count }}];
    var urlSearch = "{{ url('unit_kerja') }}";
    var q = "{{ $_GET['q'] ?? '' }}";
    var placeholder = "Filter...";
    var tampilkan_buttons = true;
    var button_manual = true;
</script>
@endsection