@extends('layouts.app')

@section('content')
    <div class="col-md-6">
        <form class="form-horizontal form-material" action="{{ url('/sifat_surat') }}"
            method="post" enctype="multipart/form-data">
            @csrf

            @include ('sifat_surat.form', ['formMode' => 'create'])
        </form>
    </div>
@endsection