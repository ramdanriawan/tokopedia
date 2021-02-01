@extends('layouts.app')
@section('content')
<table class="table">
    <thead>
        <tr>
            <th>Nama</th>
        </tr>
    </thead>
    <tbody>
        <tr data-id='{{ $bagian->id }}'>
            <td>{{ $item->nama }}</td>
        </tr>
    </tbody>
</table>


<h1 class="page-head-line">Sub Bagian</h1>
<table class="table" id='dataTable'>
    <thead>
        <tr>
            <th width=2>#</th>
            <th>Nama</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sub_bagian as $item)
        <tr data-id='{{ $item->id }}'>
            <td>
                {{ $loop->iteration }}
            </td>

            <td>{{ $item->nama }}</td>

            <td class="text-center">
                <a class="label label-primary"
                    href="{{ url('/sub_bagian/' . $item->id . '/edit') }}">Edit</a>
                <form action="{{ url('/sub_bagian' . '/' . $item->id) }}"
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
    const locationHrefHapusSemua = "{{ url('sub_bagian/hapus_semua') }}";
    const locationHrefAktifkanSemua = "{{ url('sub_bagian/aktifkan_semua') }}";
    const locationHrefCreate = '{{ url("sub_bagian/create?bagian_id=$bagian->id") }}';
    var columnOrders = [{{ $sub_bagian_count - 1 }}];
    var urlSearch = "{{ url('sub_bagian') }}";
    var q = "{{ $_GET['q'] ?? '' }}";
    var placeholder = "Filter...";
    var tampilkan_buttons = true;
    var button_manual = true;
</script>
@endsection