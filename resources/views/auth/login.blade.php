@extends('layouts.app')

@section('title', 'Login Administrator - DETROIT Digital Invitation Studio')

@section('content')
<div class="py-5" style="background-color: var(--detroit-champagne); min-height: 85vh;">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="detroit-card p-4 p-md-5 shadow-lg">
                    <!-- Brand Top -->
                    <div class="text-center mb-4">
                        <div class="brand-logo-badge mx-auto mb-2" style="width: 50px; height: 50px; font-size: 24px;">D</div>
                        <h4 class="font-cinzel fw-bold mb-0">DETROIT</h4>
                        <div class="small text-muted" style="letter-spacing: 1px;">ADMIN PANEL LOGIN</div>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger border-0 small py-2">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Alamat E-mail</label>
                            <input type="email" name="email" class="form-control" placeholder="admin@detroit.id" value="{{ old('email', 'admin@detroit.id') }}" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Kata Sandi (Password)</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" value="password" required>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" checked>
                            <label class="form-check-label small" for="rememberMe">
                                Ingat saya di perangkat ini
                            </label>
                        </div>

                        <button type="submit" class="btn btn-detroit w-100 py-2 fs-6 mb-3">
                            <i class="bi bi-box-arrow-in-right"></i>
                            <span>Masuk ke Admin Panel</span>
                        </button>

                        <div class="p-2 rounded bg-light border text-center small text-muted">
                            <div><strong>Akun Demo:</strong></div>
                            <div>Email: <code>admin@detroit.id</code></div>
                            <div>Password: <code>password</code></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
