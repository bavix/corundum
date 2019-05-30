@extends('layouts.app')

@section('content')
    <div class="col-md-4 offset-md-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h3>Reset Password</h3>
                </div>

                <form method="POST" action="{{ route('password.request') }}">
                    
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
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}"
                               class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                               id="password_confirmation" placeholder="Confirm Password" />

                        @if ($errors->has('password_confirmation'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-block btn-primary">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
@endsection
