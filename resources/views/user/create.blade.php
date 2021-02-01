@extends('layouts.app')

@section('content')
    <div class="col-md-6">
        <form class="form-horizontal form-material" action="{{ url('/user') }}"
            method="post" enctype="multipart/form-data">
            @csrf

            @include ('user.form', ['formMode' => 'create'])

            <div class="form-group">
                <div class="col-sm-12">
                    <button class="btn btn-success" type="submit">Simpan</button>
                </div>
            </div>
        </form>
        
    </div>
@endsection