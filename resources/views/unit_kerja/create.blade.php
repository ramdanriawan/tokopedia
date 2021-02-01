@extends('layouts.app')

@section('content')
    <div class="col-md-6">
        <form class="form-horizontal form-material" action="{{ url('/unit_kerja') }}"
            method="post" enctype="multipart/form-data">
            @csrf

            @include ('unit_kerja.form', ['formMode' => 'create'])
        </form>
    </div>
@endsection