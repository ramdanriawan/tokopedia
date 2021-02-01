@extends('layouts.app')

@section('content')
<div class="col-md-6">
    <form class="form-horizontal form-material" action="{{ route('user.profile.update', auth()->id()) }}" method="post"
        enctype="multipart/form-data">
        @method('put')
        @csrf

        <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
            <label for="name" class="control-label">{{ 'Name' }}</label>

            <div class="col-md-12">
                <input placeholder="name" class="form-control form-control-line @error('name') is-invalid @enderror"
                    name="name" type="text" id="name" value="{{ isset($user->name) ? $user->name : old('name') }}"
                    required>

                @error('name')
                <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
            <label for="email" class="control-label">{{ 'Email' }}</label>

            <div class="col-md-12">
                <input placeholder="email" class="form-control form-control-line @error('email') is-invalid @enderror"
                    name="email" type="email" id="email" value="{{ isset($user->email) ? $user->email : old('email') }}"
                    required>

                @error('email')
                <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
            <label for="password" class="control-label">{{ 'Password' }}</label>

            <div class="col-md-12">
                <input type="password" class="form-control form-control-line" name='password' id="password" required>
                @error('password')
                <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : ''}}">
            <label for="password_confirmation" class="control-label">{{ 'Password Confirmation' }}</label>

            <div class="col-md-12">
                <input type="password" class="form-control form-control-line" name='password_confirmation'
                    id="password_confirmation" required>
                @error('password_confirmation')
                <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12">
                <button class="btn btn-success" type="submit">Simpan</button>
            </div>
        </div>
    </form>
</div>
@endsection