@extends('layouts.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/components/login_register.css') }}">
@endpush

@section('content')
<div class="login-container">
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
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
                                <i class="bi bi-person-plus"></i>
                            </div>
                            <h3 class="fw-bold mb-1">Join Us and Fly High!</h3>
                            <p class="mb-3 opacity-90">Book your dream destination with ease</p>
                            <div class="header-indicator"></div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-4 p-lg-5">
                        @if (session('success'))
                            <div class="alert alert-success-custom alert-dismissible fade show mb-4" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle me-2"></i>
                                    <div>{{ session('success') }}</div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <!-- Full Name Field -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}"
                                       placeholder="Full Name" required>
                                <label for="name">
                                    <i class="bi bi-person me-2"></i>Full Name
                                </label>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}"
                                       placeholder="Email Address" required>
                                <label for="email">
                                    <i class="bi bi-envelope me-2"></i>Email Address
                                </label>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Phone Number Field -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone') }}"
                                       placeholder="Phone Number" required>
                                <label for="phone">
                                    <i class="bi bi-telephone me-2"></i>Phone Number
                                </label>
                                @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Address Field -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                       id="address" name="address" value="{{ old('address') }}"
                                       placeholder="Address (Optional)">
                                <label for="address">
                                    <i class="bi bi-geo-alt me-2"></i>Address (Optional)
                                </label>
                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="form-floating mb-3 password-field">
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

                            <!-- Confirm Password Field -->
                            <div class="form-floating mb-4 password-field">
                                <input type="password" class="form-control"
                                       id="password_confirmation" name="password_confirmation"
                                       placeholder="Confirm Password" required>
                                <label for="password_confirmation">
                                    <i class="bi bi-lock-fill me-2"></i>Confirm Password
                                </label>
                                <button type="button" class="btn password-toggle" data-target="password_confirmation">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>

                            <!-- Terms Checkbox -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" class="terms-link">Terms of Service</a> and <a href="#" class="terms-link">Privacy Policy</a>
                                </label>
                            </div>

                            <!-- Register Button -->
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary py-3 main-button">
                                    <span>Create Account</span>
                                    <i class="bi bi-person-plus ms-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Card Footer -->
                    <div class="card-footer text-center py-4">
                        <p class="mb-0">Already have an account?
                            <a href="{{ route('show.login') }}" class="signup-link">
                                Sign in
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
    <script src="{{ asset('js/components/register.js') }}"></script>
@endpush
