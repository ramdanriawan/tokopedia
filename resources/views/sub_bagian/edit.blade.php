@extends('layouts.app')

@section('content')
    <div class="col-md-6">
        <form class="form-horizontal form-material" action="{{ url('/sub_bagian/' . $sub_bagian->id) }}"
            method="post" enctype="multipart/form-data">
            @method('put')
            @csrf

            @include ('sub_bagian.form', ['formMode' => 'edit'])
        </form>
    </div>
@endsection