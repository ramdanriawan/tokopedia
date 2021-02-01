@extends('layouts.app')

@section('content')
<table class="table" id='dataTable'>
    <thead>
        <tr>
            <th width=2>#</th>
            <th>Keterangan</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sifat_surat as $item)
        <tr data-id='{{ $item->id }}'>
            <td>
                {{ $loop->iteration }}
            </td>

            <td>{{ $item->keterangan }}</td>

            <td class="text-center">
                <a class="label label-primary"
                    href="{{ url('/sifat_surat/' . $item->id . '/edit') }}">Edit</a>
                <form action="{{ url('/sifat_surat' . '/' . $item->id) }}"
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
    const locationHrefHapusSemua = "{{ url('sifat_surat/hapus_semua') }}";
    const locationHrefAktifkanSemua = "{{ url('sifat_surat/aktifkan_semua') }}";
    const locationHrefCreate = "{{ url('sifat_surat/create') }}";
    var columnOrders = [{{ $sifat_surat_count }}];
    var urlSearch = "{{ url('sifat_surat') }}";
    var q = "{{ $_GET['q'] ?? '' }}";
    var placeholder = "Filter...";
    var tampilkan_buttons = true;
    var button_manual = true;
</script>
@endsection