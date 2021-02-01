@extends('layouts.app')

@section('content')
    <div class="col-md-6">
        <form class="form-horizontal form-material" action="{{ url('/surat_keluar') }}"
            method="post" enctype="multipart/form-data">
            @csrf

            @include ('surat_keluar.form', ['formMode' => 'create'])
        </form>
    </div>
@endsection