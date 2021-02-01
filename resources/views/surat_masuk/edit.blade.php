@extends('layouts.app')

@section('content')
    <div class="col-md-6">
        <form class="form-horizontal form-material" action="{{ url('/surat_masuk/' . $surat_masuk->id) }}"
            method="post" enctype="multipart/form-data">
            @method('put')
            @csrf

            @include ('surat_masuk.form', ['formMode' => 'edit'])
        </form>
    </div>
@endsection