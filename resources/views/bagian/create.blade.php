@extends('layouts.app')

@section('content')
    <div class="col-md-6">
        <form class="form-horizontal form-material" action="{{ url('/bagian') }}"
            method="post" enctype="multipart/form-data">
            @csrf

            @include ('bagian.form', ['formMode' => 'create'])
        </form>
    </div>
@endsection