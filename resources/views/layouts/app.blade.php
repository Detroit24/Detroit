<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DETROIT Digital Invitation Studio - Undangan Digital Premium')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Great+Vibes&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/template-preview.css') }}">

    <style>
        :root {
            --detroit-gold: #B8860B;
            --detroit-gold-dark: #8C6200;
            --detroit-gold-light: #EBD8B8;
            --detroit-champagne: #FDF9F3;
            --detroit-ivory: #F8F4EE;
            --detroit-dark: #221D1A;
            --detroit-text-muted: #7A6F66;
            --detroit-card-bg: #FFFFFF;
            --detroit-border: #E8DCCF;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--detroit-champagne);
            color: var(--detroit-dark);
            overflow-x: hidden;
        }

        h1, h2, h3, .font-serif {
            font-family: 'Playfair Display', Georgia, serif;
        }

        .font-cinzel {
            font-family: 'Cinzel', serif;
        }

        .font-cursive {
            font-family: 'Great Vibes', cursive;
        }

        /* Navbar */
        .detroit-navbar {
            background-color: rgba(253, 249, 243, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(232, 220, 207, 0.7);
            padding: 14px 0;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--detroit-dark);
            text-decoration: none;
        }

        .navbar-brand .brand-logo-badge {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            border: 2px solid var(--detroit-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Cinzel', serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--detroit-gold);
            background: #FFF;
            box-shadow: 0 4px 12px rgba(184, 134, 11, 0.12);
        }

        .nav-link {
            font-weight: 500;
            font-size: 0.95rem;
            color: #554D47 !important;
            padding: 8px 16px !important;
            border-radius: 20px;
            transition: all 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--detroit-gold-dark) !important;
            background-color: rgba(184, 134, 11, 0.08);
        }

        /* Detroit Buttons */
        .btn-detroit {
            background: linear-gradient(135deg, #C59B27 0%, #A47712 100%);
            color: #FFFFFF !important;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 30px;
            border: none;
            box-shadow: 0 4px 14px rgba(164, 119, 18, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }

        .btn-detroit:hover {
            background: linear-gradient(135deg, #D4AA36 0%, #B8860B 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(164, 119, 18, 0.4);
            color: #FFF !important;
        }

        .btn-detroit-outline {
            background: transparent;
            color: var(--detroit-dark) !important;
            font-weight: 600;
            padding: 9px 22px;
            border-radius: 30px;
            border: 1.5px solid var(--detroit-gold);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-detroit-outline:hover {
            background: rgba(184, 134, 11, 0.1);
            color: var(--detroit-gold-dark) !important;
            transform: translateY(-2px);
        }

        /* Badge Tag */
        .detroit-badge {
            background-color: #F6EDE0;
            color: var(--detroit-gold-dark);
            font-weight: 600;
            font-size: 0.85rem;
            padding: 6px 16px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid var(--detroit-gold-light);
        }

        /* Detroit Card */
        .detroit-card {
            background: #FFFFFF;
            border: 1px solid var(--detroit-border);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
        }

        .detroit-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(164, 119, 18, 0.12);
            border-color: var(--detroit-gold);
        }

        /* Footer */
        .detroit-footer {
            background-color: #F8F3EC;
            border-top: 1px solid var(--detroit-border);
            padding: 40px 0 30px;
        }

        .social-icon-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #FFFFFF;
            color: var(--detroit-dark);
            border: 1px solid var(--detroit-border);
            transition: all 0.2s;
            text-decoration: none;
        }

        .social-icon-btn:hover {
            background: var(--detroit-gold);
            color: #FFFFFF;
            transform: translateY(-2px);
            border-color: var(--detroit-gold);
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg sticky-top detroit-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <div class="brand-logo-badge">D</div>
                <div>
                    <div class="font-cinzel" style="font-size: 1.15rem; line-height: 1.1; letter-spacing: 2px;">DETROIT</div>
                    <div style="font-size: 0.65rem; letter-spacing: 1.5px; color: var(--detroit-text-muted); font-weight: 600;">DIGITAL INVITATION STUDIO</div>
                </div>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') && !request()->has('category') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#templates">Template</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#categories">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#pricing">Paket Harga</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#about">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#contact">Kontak</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('order.checkout') }}" class="btn btn-detroit">
                        <i class="bi bi-cart3"></i>
                        <span>Pesan Sekarang</span>
                    </a>

                    @auth
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-detroit-outline py-2 px-3" title="Admin Panel">
                                <i class="bi bi-speedometer2"></i> Admin
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-secondary text-decoration-none small" title="Login Admin">
                            <i class="bi bi-lock"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer matching Image 1 -->
    <footer class="detroit-footer">
        <div class="container">
            <div class="row align-items-center py-3">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="d-flex align-items-center gap-2">
                        <div class="brand-logo-badge" style="width: 36px; height: 36px; font-size: 18px; border-radius: 8px;">D</div>
                        <div>
                            <div class="font-cinzel fw-bold" style="letter-spacing: 1.5px; font-size: 1rem;">DETROIT</div>
                            <div style="font-size: 0.6rem; letter-spacing: 1px; color: var(--detroit-text-muted);">Digital Invitation Studio</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 mb-3 mb-md-0 text-md-center">
                    <ul class="list-inline mb-0 small">
                        <li class="list-inline-item mx-2"><a href="{{ route('home') }}" class="text-secondary text-decoration-none">Beranda</a></li>
                        <li class="list-inline-item mx-2"><a href="{{ route('home') }}#templates" class="text-secondary text-decoration-none">Template</a></li>
                        <li class="list-inline-item mx-2"><a href="{{ route('home') }}#categories" class="text-secondary text-decoration-none">Kategori</a></li>
                        <li class="list-inline-item mx-2"><a href="{{ route('home') }}#about" class="text-secondary text-decoration-none">Tentang</a></li>
                        <li class="list-inline-item mx-2"><a href="{{ route('home') }}#contact" class="text-secondary text-decoration-none">Kontak</a></li>
                    </ul>
                </div>

                <div class="col-md-3 text-md-end">
                    <div class="d-flex justify-content-md-end gap-2 mb-2">
                        <a href="https://instagram.com" target="_blank" class="social-icon-btn" title="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="https://tiktok.com" target="_blank" class="social-icon-btn" title="TikTok"><i class="bi bi-tiktok"></i></a>
                        <a href="https://youtube.com" target="_blank" class="social-icon-btn" title="YouTube"><i class="bi bi-youtube"></i></a>
                        <a href="https://wa.me/{{ \App\Models\StoreSetting::get('whatsapp_number') }}" target="_blank" class="social-icon-btn" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    </div>
                    <div class="small text-muted" style="font-size: 0.75rem;">
                        &copy; 2025 DETROIT. All rights reserved.
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
