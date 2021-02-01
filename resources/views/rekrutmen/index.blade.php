@extends('layouts.app')

@section('content')
<table class="table" id='dataTable'>
    <thead>
        <tr>
            <th width=2>#</th>
            {{-- <th>User Id</th> --}}
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
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rekrutmen as $item)
        <tr data-id='{{ $item->id }}'>
            <td>
                {{ $loop->iteration }}
            </td>

            {{-- <td>{{ $item->user->name }}</td> --}}
            <td>{{ $item->jabatan->nama }}</td>
            <td>{{ $item->no_pendaftar }}</td>
            <td>{{ $item->nik }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->tanggal_lahir }}</td>
            <td>{{ $item->tempat_lahir }}</td>
            <td>{{ $item->jenis_kelamin }}</td>
            <td>{{ $item->agama }}</td>
            <td>{{ $item->alamat }}</td>
            <td>{{ $item->no_telepon }}</td>
            <td>{{ $item->status }}</td>
            <td>{{ $item->dibuat }}</td>

            <td class="text-center">
                <a class="label label-primary"
                    href="{{ url('/rekrutmen/' . $item->id . '/edit') }}">Edit</a>
                <form action="{{ url('/rekrutmen' . '/' . $item->id) }}"
                    method='post' style='display: inline;'
                    onsubmit="return confirm('Yakin akan menghapus data ini?')">
                    @method('DELETE')
                    @csrf
                    <label class="label label-danger" href="" for='btnSubmit-{{ $item->id }}'
                        style='cursor: pointer;'>Hapus</label>
                    <button type="submit" id='btnSubmit-{{ $item->id }}'
                        style="display: none;"></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    const locationHrefHapusSemua = "{{ url('rekrutmen/hapus_semua') }}";
    const locationHrefAktifkanSemua = "{{ url('rekrutmen/aktifkan_semua') }}";
    const locationHrefCreate = "{{ url('rekrutmen/create') }}";
    var columnOrders = [{{ $rekrutmen_count }}];
    var urlSearch = "{{ url('rekrutmen') }}";
    var q = "{{ $_GET['q'] ?? '' }}";
    var placeholder = "Filter...";
    var tampilkan_buttons = true;
    var button_manual = true;
</script>
@endsection