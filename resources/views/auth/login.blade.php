@extends('layouts.sb-admin')

@section('title', 'Login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-4">Login</h3>
                </div>
                <div class="card-body">
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <!-- Email Address -->
                        <div class="form-floating mb-3">
                            <input 
                                id="email" 
                                class="form-control" 
                                type="email" 
                                name="email" 
                                placeholder="name@example.com" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus>
                            <label for="email">Email address</label>
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-floating mb-3">
                            <input 
                                id="password" 
                                class="form-control" 
                                type="password" 
                                name="password" 
                                placeholder="Password" 
                                required>
                            <label for="password">Password</label>
                            @error('password')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="form-check mb-3">
                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                            <label class="form-check-label" for="remember_me">Remember Password</label>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                            @if (Route::has('password.request'))
                                <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
                            @endif
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <div class="small">
                        <a href="{{ route('register') }}">Need an account? Sign up!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection