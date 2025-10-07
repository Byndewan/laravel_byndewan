@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="login-card card">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <i class="fas fa-hospital fa-3x text-primary mb-3"></i>
                <h3 class="font-weight-bold" style="color: var(--text-primary);">Manajemen Rumah Sakit</h3>
                <p class="text-muted">Sign in to continue</p>
            </div>

            <form method="POST" action="{{ route('login_post') }}">
                @csrf
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-transparent border-right-0">
                                <i class="fas fa-user text-muted"></i>
                            </span>
                        </div>
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                               name="username" value="{{ old('username') }}" required autocomplete="username" autofocus
                               placeholder="Enter your username">
                    </div>
                    @error('username')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-transparent border-right-0">
                                <i class="fas fa-lock text-muted"></i>
                            </span>
                        </div>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                               name="password" required autocomplete="current-password" placeholder="Enter your password">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent border-left-0">
                                <i class="fas fa-eye-slash toggle-password" style="cursor: pointer;"></i>
                            </span>
                        </div>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Sign In</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.toggle-password').click(function() {
            const passwordInput = $('#password');
            const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
            passwordInput.attr('type', type);

            $(this).toggleClass('fa-eye fa-eye-slash');
        });
    });
</script>
@endsection
