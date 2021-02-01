@extends('layouts.app')

@section('content')
    <div class="col-md-6">
        <form class="form-horizontal form-material" action="{{ url('/unit_kerja/' . $unit_kerja->id) }}"
            method="post" enctype="multipart/form-data">
            @method('put')
            @csrf

            @include ('unit_kerja.form', ['formMode' => 'edit'])
        </form>
    </div>
@endsection