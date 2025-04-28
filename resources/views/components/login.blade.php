@extends('layouts.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/components/login_register.css') }}">
@endpush

@section('content')
<div class="login-container">
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="login-card card border-0 shadow-lg">
                    <!-- Decorative Elements -->
                    <div class="card-decoration">
                        <div class="shape shape-1"></div>
                        <div class="shape shape-2"></div>
                        <div class="shape shape-3"></div>
                    </div>

                    <!-- Card Header -->
                    <div class="card-header text-white text-center position-relative overflow-hidden">
                        <div class="header-graphics">
                            <div class="header-overlay"></div>
                        </div>
                        <div class="header-content py-4">
                            <div class="avatar-circle mb-3">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <h3 class="fw-bold mb-1">Welcome Back!</h3>
                            <p class="mb-3 opacity-90">Login to your account and start exploring</p>
                            <div class="header-indicator"></div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-4 p-lg-5">
                        @if (session('error'))
                            <div class="alert alert-custom alert-dismissible fade show mb-4" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-exclamation-circle me-2"></i>
                                    <div>{{ session('error') }}</div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <!-- Email Field -->
                            <div class="form-floating mb-4">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}"
                                       placeholder="Email Address" required autofocus>
                                <label for="email">
                                    <i class="bi bi-envelope me-2"></i>Email Address
                                </label>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="form-floating mb-4 password-field">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password" placeholder="Password" required>
                                <label for="password">
                                    <i class="bi bi-lock me-2"></i>Password
                                </label>
                                <button type="button" class="btn password-toggle">
                                    <i class="bi bi-eye"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">
                                        Remember me
                                    </label>
                                </div>
                                <a href="#" class="forgot-link">Forgot password?</a>
                            </div>

                            <!-- Login Button -->
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary py-3 main-button">
                                    <span>Sign In</span>
                                    <i class="bi bi-arrow-right-circle ms-2"></i>
                                </button>
                            </div>

                            <!-- Admin Login -->
                            <div class="d-grid mb-4">
                                <a href="{{ route('filament.admin.auth.login') }}" class="btn btn-outline py-2 admin-button">
                                    <i class="bi bi-shield-lock me-2"></i>
                                    <span>Login as Admin</span>
                                </a>
                            </div>
                        </form>
                    <!-- Card Footer -->
                    <div class="card-footer text-center py-4">
                        <p class="mb-0">Don't have an account?
                            <a href="{{ route('show.register') }}" class="signup-link">
                                Create an account
                                <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/components/login.js') }}"></script>
@endpush
