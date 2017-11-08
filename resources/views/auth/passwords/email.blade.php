@extends('auth.layout')

@section('title', 'Reset Password')

@section('form')
    <form method="POST" action="{{ route('password.email') }}">

        {{ csrf_field() }}

        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                   id="email" placeholder="Enter email" value="{{ old('email') }}" />

            @if ($errors->has('email'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <button type="submit" class="btn btn-block btn-warning">Send Password Reset Link</button>

        <div class="form-group text-center">
            <small class="form-text text-muted">
                Not registered? <a href="{{ route('register') }}">Create an account</a>
            </small>
        </div>

    </form>
@endsection
