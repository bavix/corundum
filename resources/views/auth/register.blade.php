@extends('auth.layout')

@section('title', 'Register')

@section('form')
    <form class="form-horizontal" method="POST" action="{{ route('register') }}">

        {{ csrf_field() }}

        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" name="email"
                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                   id="email" placeholder="Enter email" />

            @if ($errors->has('email'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        
        <div class="form-group">
            <label for="login">Login</label>
            <input type="text" name="login"
                   class="form-control{{ $errors->has('login') ? ' is-invalid' : '' }}"
                   id="login" placeholder="Enter your login" />

            @if ($errors->has('login'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('login') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password"
                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                   id="password" placeholder="Password" />

            @if ($errors->has('password'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <button type="submit" class="btn btn-block btn-danger">Register</button>

        <div class="form-group text-center">
            <small class="form-text text-muted">
                Registered? <a href="{{ route('login') }}">Login</a>
            </small>
        </div>

    </form>
@endsection
