@extends('layouts.app')

@section('content')
<style>
    body.login-bg {
        background: linear-gradient(135deg, #b2ebf2 0%, #e3f2fd 100%);
        min-height: 100vh;
        overflow: hidden;
    }
    .login-container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        padding: 0;
        gap: 32px;
    }
    .login-left {
        background: #fff;
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        padding: 2.5rem;
        width: 370px;
        min-width: 320px;
        z-index: 2;
        animation: fadeInLeft 1s;
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 480px;
        margin: 0;
    }
    .login-title {
        font-size: 2rem;
        font-weight: bold;
        color: #7f53ac;
        margin-bottom: 0.5rem;
    }
    .login-btn {
        background: linear-gradient(90deg, #7f53ac 0%, #647dee 100%);
        border: none;
        border-radius: 1.5rem;
        color: #fff;
        font-weight: bold;
        padding: 0.7rem 2.5rem;
        box-shadow: 0 4px 16px rgba(100,125,222,0.15);
        transition: 0.3s;
        width: 100%;
        margin-top: 1rem;
    }
    .login-btn:hover {
        background: linear-gradient(90deg, #647dee 0%, #7f53ac 100%);
        transform: translateY(-2px) scale(1.04);
    }
    .login-link {
        color: #7f53ac;
        font-weight: bold;
        text-decoration: underline;
    }
    .login-social {
        display: flex;
        gap: 1rem;
        margin-top: 1.2rem;
        justify-content: center;
    }
    .login-social button {
        border: none;
        border-radius: 0.7rem;
        padding: 0.5rem 1.2rem;
        background: #f3f3f3;
        color: #333;
        font-weight: 500;
        box-shadow: 0 2px 8px rgba(100,125,222,0.08);
        cursor: pointer;
        transition: 0.2s;
    }
    .login-social button:hover {
        background: #e0e0e0;
    }
    .login-right {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 370px;
        min-width: 320px;
        animation: fadeInRight 1s;
        height: 480px;
        background: #fff;
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.10);
        margin: 0;
    }
    .login-right img {
        width: 100%;
        height: 100%;
        min-width: 320px;
        min-height: 480px;
        object-fit: cover;
        border-radius: 1.5rem;
        display: block;
    }
    @media (max-width: 900px) {
        .login-container { flex-direction: column; }
        .login-left { margin-right: 0; margin-bottom: 2vw; }
    }
    @keyframes fadeInLeft {
        from { opacity: 0; transform: translateX(-40px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes fadeInRight {
        from { opacity: 0; transform: translateX(40px); }
        to { opacity: 1; transform: translateX(0); }
    }
</style>
<script>
    document.body.classList.add('login-bg');
</script>
<div class="login-container">
    <div class="login-left">
        <div class="login-title">Login</div>
        <div style="color:#888; font-size:0.95rem; margin-bottom:18px;">Don't have an account yet? <a href="{{ route('register') }}" class="login-link">Sign Up</a></div>
        @if(session('success'))
            <div id="register-success" class="alert alert-success text-center" style="font-weight:bold; font-size:1.1rem;">
                {{ session('success') }}<br>
                <span id="countdown">5</span> giây nữa sẽ chuyển về trang đăng nhập...
            </div>
            <script>
                let seconds = 5;
                const countdown = document.getElementById('countdown');
                const interval = setInterval(function() {
                    seconds--;
                    countdown.textContent = seconds;
                    if(seconds <= 0) {
                        clearInterval(interval);
                        window.location.href = "{{ route('login') }}";
                    }
                }, 1000);
            </script>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="you@example.com">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter 6 character or more">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-2 d-flex justify-content-between align-items-center">
                <a href="{{ route('password.request') }}" class="login-link">Forgot Password?</a>
            </div>
            <div class="mb-2">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember" style="font-size:0.95rem; color:#888;">Remember me</label>
            </div>
            <button type="submit" class="login-btn">LOGIN</button>
            <div class="login-social">
                <button type="button"><img src="https://img.icons8.com/color/24/000000/google-logo.png" style="vertical-align:middle; margin-right:6px;"> Google</button>
                <button type="button"><img src="https://img.icons8.com/color/24/000000/facebook-new.png" style="vertical-align:middle; margin-right:6px;"> Facebook</button>
            </div>
        </form>
    </div>
    <div class="login-right">
        <img src="https://img.freepik.com/free-vector/working-concept-illustration_114360-2143.jpg" alt="Work Illustration">
    </div>
</div>
@endsection

                        <div class="row mb-3">

