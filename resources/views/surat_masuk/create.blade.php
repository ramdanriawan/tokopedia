@extends('layouts.app')

@section('content')
    <div class="col-md-6">
        <form class="form-horizontal form-material" action="{{ url('/surat_masuk') }}"
            method="post" enctype="multipart/form-data">
            @csrf

            @include ('surat_masuk.form', ['formMode' => 'create'])
        </form>
    </div>
@endsection