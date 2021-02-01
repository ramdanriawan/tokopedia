@extends('layouts.app')

@section('content')
<table class="table" id='dataTable'>
    <thead>
        <tr>
            <th width=2>#</th>
            <th>Sifat Surat Id</th>
            <th>Waktu Masuk</th>
            <th>Nomor</th>
            <th>Pengirim</th>
            <th>Perihal</th>
            <th>Isi Ringkas</th>
            <th>Lampiran</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($surat_masuk as $item)
        <tr data-id='{{ $item->id }}'>
            <td>
                {{ $loop->iteration }}
            </td>

            <td>{{ $item->sifat_surat_id }}</td>
            <td>{{ $item->waktu_masuk }}</td>
            <td>{{ $item->nomor }}</td>
            <td>{{ $item->pengirim }}</td>
            <td>{{ $item->perihal }}</td>
            <td>{{ $item->isi_ringkas }}</td>
            <td>{{ $item->lampiran }}</td>

            <td class="text-center">
                <a class="label label-primary" href="{{ url('/surat_masuk/' . $item->id . '/edit') }}">Edit</a>
                <form action="{{ url('/surat_masuk' . '/' . $item->id) }}" method='post' style='display: inline;'
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
    const locationHrefHapusSemua = "{{ url('surat_masuk/hapus_semua') }}";
    const locationHrefAktifkanSemua = "{{ url('surat_masuk/aktifkan_semua') }}";
    const locationHrefCreate = "{{ url('surat_masuk/create') }}";
    var columnOrders = [{{ $surat_masuk_count }}];
    var urlSearch = "{{ url('surat_masuk') }}";
    var q = "{{ $_GET['q'] ?? '' }}";
    var placeholder = "Filter...";
    var tampilkan_buttons = true;
    var button_manual = true;
</script>
@endsection