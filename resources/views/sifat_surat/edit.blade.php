@extends('layouts.app')

@section('content')
    <div class="col-md-6">
        <form class="form-horizontal form-material" action="{{ url('/sifat_surat/' . $sifat_surat->id) }}"
            method="post" enctype="multipart/form-data">
            @method('put')
            @csrf

            @include ('sifat_surat.form', ['formMode' => 'edit'])
        </form>
    </div>
@endsection