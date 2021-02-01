@extends('layouts.app')

@section('content')
    <div class="col-md-6">
        <form class="form-horizontal form-material" action="{{ url('/sub_bagian') }}"
            method="post" enctype="multipart/form-data">
            @csrf

            @include ('sub_bagian.form', ['formMode' => 'create'])
        </form>
    </div>
@endsection