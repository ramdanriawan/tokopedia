@extends('layouts.app')

@section('content')
<table class="table" id='dataTable'>
    <thead>
        <tr>
            <th width=2>#</th>
            <th>Sifat Surat</th>
            <th>User Unit Kerja</th>
            <th>Waktu Keluar</th>
            <th>Nomor</th>
            <th>Pengirim</th>
            <th>Perihal</th>
            <th>Kepada</th>
            <th>Bagian</th>
            <th>Isi Ringkas</th>
            <th>Lampiran</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($surat_keluar as $item)
        <tr data-id='{{ $item->id }}'>
            <td>
                {{ $loop->iteration }}
            </td>

            <td>{{ $item->sifat_surat }}</td>
            <td>{{ $item->user_unit_kerja->name }}</td>
            <td>{{ $item->waktu_keluar }}</td>
            <td>{{ $item->nomor }}</td>
            <td>{{ $item->pengirim }}</td>
            <td>{{ $item->perihal }}</td>
            <td>{{ $item->kepada }}</td>
            <td>{{ $item->bagian }}</td>
            <td>{{ $item->isi_ringkas }}</td>
            <td>
                <a href="{{ url(Storage::url($item->lampiran)) }}" download='lampiran {{ $item->perihal }}'>
                    Lihat
                </a>
            </td>

            <td class="text-center">
                <a class="label label-primary" href="{{ url('/surat_keluar/' . $item->id . '/edit') }}">Edit</a>
                <form action="{{ url('/surat_keluar' . '/' . $item->id) }}" method='post' style='display: inline;'
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
    const locationHrefHapusSemua = "{{ url('surat_keluar/hapus_semua') }}";
    const locationHrefAktifkanSemua = "{{ url('surat_keluar/aktifkan_semua') }}";
    const locationHrefCreate = "{{ url('surat_keluar/create') }}";
    var columnOrders = [{{ $surat_keluar_count }}];
    var urlSearch = "{{ url('surat_keluar') }}";
    var q = "{{ $_GET['q'] ?? '' }}";
    var placeholder = "Filter...";
    var tampilkan_buttons = true;
    var button_manual = true;
</script>
@endsection