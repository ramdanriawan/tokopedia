@extends('layouts.app')

@section('content')
<table class="table" id='dataTable'>
    <thead>
        <tr>
            <th width=2>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Level</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($user as $item)
        <tr data-id='{{ $item->id }}'>
            <td>
                {{ $loop->iteration }}
            </td>

            <td>{{ $item->name }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->level }}</td>

            <td class="text-center">
                @if($item->level != 'Admin')
                <a class="label label-primary" href="{{ url('/user/' . $item->id . '/edit') }}">Edit</a>
                <form action="{{ url('/user' . '/' . $item->id) }}" method='post' style='display: inline;'
                    onsubmit="return confirm('Yakin akan menghapus data ini?')">
                    @method('DELETE')
                    @csrf
                    <label class="label label-danger" href="" for='btnSubmit-{{ $item->id }}'
                        style='cursor: pointer;'>Hapus</label>
                    <button type="submit" id='btnSubmit-{{ $item->id }}' style="display: none;"></button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
const locationHrefHapusSemua = "{{ url('user/hapus_semua') }}";
const locationHrefAktifkanSemua = "{{ url('user/aktifkan_semua') }}";
const locationHrefCreate = "{{ url('user/create') }}";
var columnOrders = [{{ $user_count - 1 }}];
var urlSearch = "{{ url('user') }}";
var q = "{{ $_GET['q'] ?? '' }}";
var placeholder = "Filter...";
var tampilkan_buttons = true;
var button_manual = true;
</script>
@endsection