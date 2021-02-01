@extends('layouts.app')

@section('content')
<table class="table" id='dataTable'>
    <thead>
        <tr>
            <th width=2>#</th>
            <th>Judul</th>
            <th>Gambar Depan</th>
            <th>Isi</th>
            <th>Lampiran</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($berita as $item)
        <tr data-id='{{ $item->id }}'>
            <td>
                {{ $loop->iteration }}
            </td>

            <td>{{ $item->judul }}</td>
            <td>
                <a href="{{ Storage::url($item->gambar_depan) }}" target='_blank'>
                    <img src='{{ Storage::url($item->gambar_depan) }}' width='100' height='100'/>
                </a>
                
            </td>
            <td>
                <a href="{{ route('home.berita.show', $item->id) }}" target='_blank'>
                    {!!  Str::limit($item->isi, 25)  !!}
                </a>
            </td>
            <td>
                @if($item->lampiran)
                <a href="{{ Storage::url($item->lampiran) }}" target='_blank' download='lampiran {{ $item->judul }}'>
                    Download
                </a>
                @endif
            </td>

            <td class="text-center">
                <a class="label label-info" href="{{ url('/berita/' . $item->id) }}" style='margin-right: 3px;'>
                    <i class="fa fa-eye" aria-hidden="true"></i>
                    Lihat
                </a> 
                <a class="label label-primary" href="{{ url('/berita/' . $item->id . '/edit') }}">Edit</a>
                <form action="{{ url('/berita' . '/' . $item->id) }}" method='post' style='display: inline;'
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
    const locationHrefHapusSemua = "{{ url('berita/hapus_semua') }}";
    const locationHrefAktifkanSemua = "{{ url('berita/aktifkan_semua') }}";
    const locationHrefCreate = "{{ url('berita/create') }}";
    var columnOrders = [{{ $berita_count - 2}}];
    var urlSearch = "{{ url('berita') }}";
    var q = "{{ $_GET['q'] ?? '' }}";
    var placeholder = "Filter...";
    var tampilkan_buttons = true;
    var button_manual = true;
</script>
@endsection