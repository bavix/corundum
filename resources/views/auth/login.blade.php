@extends('layouts.app')

@section('content')
    <div class="col-md-4 offset-md-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h3>Login</h3>
                </div>

                <form method="POST" action="{{ route('login') }}">

                    @csrf

                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                               id="email" placeholder="Enter email" />

                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" value="{{ old('password') }}"
                               class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                               id="password" placeholder="Password" />

                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif

                        <small class="form-text text-muted">
                            <a href="{{ route('password.request') }}">
                                Forgot Your Password?
                            </a>
                        </small>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                            <label class="custom-control-label" for="remember">Remember me</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-block btn-warning">Log In</button>

                    <div class="form-group text-center">
                        <small class="form-text text-muted">
                            Not registered? <a href="{{ route('register') }}">Create an account</a>
                        </small>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
