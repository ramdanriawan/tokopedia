@extends('layouts.app')
@section('content')
<table class="table" id='dataTable'>
    <thead>
        <tr>
            <th>Name</th><th>Email</th><th>Password</th><th>Password Confirmation</th>
        </tr>
    </thead>
    <tbody>
        <tr data-id='{{ $user->id }}'>
            <td>{{ $item->name }}</td><td>{{ $item->email }}</td><td>{{ $item->password }}</td><td>{{ $item->password_confirmation }}</td>
        </tr>
    </tbody>
</table>
@endsection