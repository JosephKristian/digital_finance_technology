@extends('layouts.sb-admin')

@section('title', 'Password Recovery')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-4">Password Recovery</h3>
                </div>
                <div class="card-body">
                    <div class="small mb-3 text-muted">
                        Enter your email address and we will send you a link to reset your password.
                    </div>
                    
                    <!-- Form Start -->
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        
                        <!-- Email Input -->
                        <div class="form-floating mb-3">
                            <input 
                                class="form-control" 
                                id="email" 
                                name="email" 
                                type="email" 
                                placeholder="name@example.com" 
                                required />
                            <label for="email">Email address</label>
                        </div>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        
                        <!-- Form Buttons -->
                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                            <a class="small" href="{{ route('login') }}">Return to login</a>
                            <button type="submit" class="btn btn-primary">
                                Email Password Reset Link
                            </button>
                        </div>
                    </form>
                    <!-- Form End -->
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
