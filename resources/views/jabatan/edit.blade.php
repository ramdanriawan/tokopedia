@extends('layouts.app')

@section('content')
    <div class="col-md-6">
        <form class="form-horizontal form-material" action="{{ url('/jabatan/' . $jabatan->id) }}"
            method="post" enctype="multipart/form-data">
            @method('put')
            @csrf

            @include ('jabatan.form', ['formMode' => 'edit'])
        </form>
    </div>
@endsection