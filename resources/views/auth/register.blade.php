@extends('layouts.app')

@section('content')
<style>
    body.register-bg {
        background: linear-gradient(135deg, #b2ebf2 0%, #e3f2fd 100%);
        min-height: 100vh;
        overflow: hidden;
    }
    .register-container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        padding: 32px 0;
        gap: 24px;
        flex-wrap: wrap;
    }
    .register-left {
        background: #fff;
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        padding: 2rem 1.5rem 1.5rem 1.5rem;
        width: 340px;
        min-width: 260px;
        z-index: 2;
        animation: fadeInLeft 1s;
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: auto;
        margin: 0;
    }
    .register-title {
        font-size: 2rem;
        font-weight: bold;
        color: #7f53ac;
        margin-bottom: 0.5rem;
    }
    .register-btn {
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
        box-sizing: border-box;
    }
    .register-btn:hover {
        background: linear-gradient(90deg, #647dee 0%, #7f53ac 100%);
        transform: translateY(-2px) scale(1.04);
    }
    .register-link {
        color: #7f53ac;
        font-weight: bold;
        text-decoration: underline;
    }
    .register-social {
        display: flex;
        gap: 1rem;
        margin-top: 1.2rem;
        justify-content: center;
        flex-wrap: wrap;
        width: 100%;
        box-sizing: border-box;
    }
    .register-social button {
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
    .register-social button:hover {
        background: #e0e0e0;
    }
    .register-right {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 340px;
        min-width: 260px;
        animation: fadeInRight 1s;
        height: auto;
        background: #fff;
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.10);
        margin: 0;
        box-sizing: border-box;
    }
    .register-right img {
        width: 90%;
        max-width: 320px;
        height: auto;
        aspect-ratio: 1/1;
        object-fit: contain;
        border-radius: 1.5rem;
        display: block;
        margin: 0 auto;
        box-sizing: border-box;
    }
    @media (max-width: 900px) {
        .register-container { flex-direction: column; }
        .register-left, .register-right { width: 90vw; min-width: 220px; max-width: 400px; margin: 0 auto 2vw auto; }
        .register-social { flex-direction: column; align-items: center; }
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
    document.body.classList.add('register-bg');
</script>
<div class="register-container">
    <div class="register-left" style="margin: 0 auto;">
        <div class="register-title">Sign up</div>
        <div style="color:#888; font-size:0.95rem; margin-bottom:18px;">Already have an account? <a href="{{ route('login') }}" class="register-link">LOGIN</a></div>
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
        @else
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">User name</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="User name">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="you@gmail.com">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password-confirm" class="form-label">Confirm password</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm password">
            </div>
            <button type="submit" class="register-btn">Sign up</button>
            <div class="register-social">
                <button type="button"><img src="https://img.icons8.com/color/24/000000/google-logo.png" style="vertical-align:middle; margin-right:6px;"> Google</button>
                <button type="button"><img src="https://img.icons8.com/color/24/000000/facebook-new.png" style="vertical-align:middle; margin-right:6px;"> Facebook</button>
            </div>
        </form>
        @endif
    </div>
</div>
@endsection


