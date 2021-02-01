@extends('layouts.app')

@section('content')
<table class="table" id='dataTable'>
    <thead>
        <tr>
            <th width=2>#</th>
            <th>Sifat Surat</th>
            <th>User Unit Kerja</th>
            <th>Waktu Masuk</th>
            <th>Nomor</th>
            <th>Pengirim</th>
            <th>Perihal</th>
            <th>Isi Ringkas</th>
            <th>Lampiran</th>

            @if(in_array(auth()->user()->level, ['Admin', 'Unit Kerja']))
            <th class="text-center">Aksi</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($surat_masuk as $item)
        <tr data-id='{{ $item->id }}'>
            <td>
                {{ $loop->iteration }}
            </td>

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

            @if(in_array(auth()->user()->level, ['Admin', 'Unit Kerja']))
            <td class="text-center">
                @if(!$item->disposisi)
                    <a class="label label-info" href="{{ url("/disposisi/create?surat_masuk_id=$item->id") }}">
                        <i for="" class="fa fa-share"></i>
                        Disposisikan
                    </a>
                @else
                <a class="label label-success" href="{{ url("/disposisi/{$item->disposisi->id}") }}">
                    <i for="" class="fa fa-share"></i>
                    Detail Disposisi
                </a>
                @endif
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
            @endif
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    const locationHrefHapusSemua = "{{ url('surat_masuk/hapus_semua') }}";
    const locationHrefAktifkanSemua = "{{ url('surat_masuk/aktifkan_semua') }}";
    const locationHrefCreate = "{{ url('surat_masuk/create') }}";
    
    var urlSearch = "{{ url('surat_masuk') }}";
    var q = "{{ $_GET['q'] ?? '' }}";
    var placeholder = "Filter...";

    var tampilkan_buttons = true;
    var button_manual = true;
    var columnOrders = [{{ $surat_masuk_count }}];
</script>
@endsection