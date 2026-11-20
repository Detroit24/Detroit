@extends('layouts.app')

@section('title', 'DETROIT Digital Invitation Studio - Undangan Digital Premium')

@section('content')

    <!-- HERO SECTION -->
    <section class="py-5 position-relative overflow-hidden" style="background: radial-gradient(circle at 75% 30%, rgba(243, 230, 212, 0.6) 0%, rgba(253, 249, 243, 1) 70%);">
        <div class="container py-4">
            <div class="row align-items-center g-5">
                <!-- Hero Left: Text & CTAs -->
                <div class="col-lg-6">
                    <div class="detroit-badge mb-3">
                        <i class="bi bi-stars"></i> Undangan Digital Premium
                    </div>

                    <h1 class="display-4 fw-bold mb-3" style="letter-spacing: -0.5px; line-height: 1.15; color: #1E1916;">
                        <span class="font-cinzel d-block">DETROIT</span>
                        <span class="font-serif fw-normal">Digital</span>
                        <span class="font-serif fw-semibold" style="color: var(--detroit-gold);">Invitation</span>
                        <span class="font-serif fw-normal">Studio</span>
                    </h1>

                    <p class="lead mb-4 text-muted" style="font-size: 1.15rem; max-width: 480px; line-height: 1.6;">
                        Buat undangan digital yang elegan, modern, dan berkesan dalam hitungan menit.
                    </p>

                    <!-- Features Row -->
                    <div class="d-flex flex-wrap align-items-center gap-3 py-3 mb-4 border-top border-bottom" style="border-color: rgba(210, 190, 165, 0.4) !important;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-lightning-charge-fill" style="color: var(--detroit-gold); font-size: 1.2rem;"></i>
                            <div>
                                <div class="fw-bold small" style="line-height: 1;">Proses</div>
                                <div class="text-muted" style="font-size: 0.75rem;">Super Cepat</div>
                            </div>
                        </div>
                        <div class="vr mx-2 text-muted opacity-25"></div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-phone" style="color: var(--detroit-gold); font-size: 1.2rem;"></i>
                            <div>
                                <div class="fw-bold small" style="line-height: 1;">Desain</div>
                                <div class="text-muted" style="font-size: 0.75rem;">Responsif</div>
                            </div>
                        </div>
                        <div class="vr mx-2 text-muted opacity-25"></div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-gem" style="color: var(--detroit-gold); font-size: 1.2rem;"></i>
                            <div>
                                <div class="fw-bold small" style="line-height: 1;">Kualitas</div>
                                <div class="text-muted" style="font-size: 0.75rem;">Premium</div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <a href="{{ route('order.checkout') }}" class="btn btn-detroit px-4 py-2">
                            <i class="bi bi-chat-dots"></i>
                            <span>Pesan Sekarang</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="{{ route('invitation.show', 'andika-salsabila') }}" target="_blank" class="btn btn-detroit-outline px-4 py-2">
                            <i class="bi bi-play-circle text-warning"></i>
                            <span>Lihat Demo</span>
                        </a>
                    </div>
                </div>

                <!-- Hero Right: Smartphone & Card Mockup -->
                <div class="col-lg-6 position-relative text-center">
                    <div class="hero-mockup-wrapper position-relative d-inline-block">
                        <!-- Phone Mockup -->
                        <div class="position-relative d-inline-block" style="z-index: 2;">
                            <img src="{{ asset('images/hero-phone.svg') }}" alt="Detroit Phone Preview" class="img-fluid" style="max-height: 520px; filter: drop-shadow(0 20px 30px rgba(0,0,0,0.15));">
                        </div>

                        <!-- Thank You Floating Card -->
                        <div class="position-absolute d-none d-sm-block" style="top: 15%; right: -30px; z-index: 3; transform: rotate(6deg);">
                            <img src="{{ asset('images/hero-card.svg') }}" alt="Thank You Card" class="img-fluid" style="max-height: 290px; filter: drop-shadow(0 15px 25px rgba(0,0,0,0.12));">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: 10+ TEMPLATE EKSKLUSIF (PILIKAN TEMPLATE TERBAIK) -->
    <section id="templates" class="py-5" style="background-color: #FFFFFF;">
        <div class="container py-4">
            <div class="text-center mb-5">
                <div class="small fw-bold text-uppercase tracking-wider mb-1" style="color: var(--detroit-gold); letter-spacing: 2px;">
                    10+ Template Eksklusif
                </div>
                <h2 class="display-6 fw-bold mb-2">Pilihan Template Terbaik</h2>
                <p class="text-muted mx-auto" style="max-width: 550px;">
                    Desain modern dan elegan untuk setiap momen spesial Anda.
                </p>

                <!-- Filter Tabs -->
                <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
                    <a href="{{ route('home') }}#templates" class="btn btn-sm {{ empty($activeCategoryId) ? 'btn-dark' : 'btn-outline-secondary' }} rounded-pill px-3 py-1">
                        Semua
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('home', ['category' => $cat->id]) }}#templates" 
                           class="btn btn-sm {{ $activeCategoryId == $cat->id ? 'btn-dark' : 'btn-outline-secondary' }} rounded-pill px-3 py-1">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Templates Grid -->
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-3 g-md-4">
                @forelse($templates as $tmpl)
                    <div class="col">
                        <div class="detroit-card h-100 overflow-hidden d-flex flex-column text-center p-2">
                            <!-- Template Preview -->
                            <div class="position-relative rounded-3 overflow-hidden mb-2" style="background-color: #F8F5F0;">
                                @php
                                    $imgUrl = asset('images/' . $tmpl->preview_image);
                                    if (!str_contains($tmpl->preview_image, '.svg')) {
                                        $imgUrl = str_replace('.jpg', '.svg', $imgUrl);
                                    }
                                @endphp
                                <img src="{{ $imgUrl }}" alt="{{ $tmpl->name }}" class="img-fluid rounded-3" style="width: 100%; height: 230px; object-fit: cover;" onerror="this.src='{{ asset('images/templates/wedding-andika.svg') }}'">
                                
                                <div class="position-absolute top-0 start-0 m-2">
                                    <span class="badge bg-white text-dark shadow-sm small" style="font-size: 0.65rem; border: 1px solid #E8DCCF;">
                                        {{ $tmpl->category->name ?? 'Premium' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Title & Actions -->
                            <div class="p-1 mt-auto">
                                <h6 class="fw-bold mb-2 text-truncate" title="{{ $tmpl->name }}" style="font-size: 0.85rem;">
                                    {{ $tmpl->name }}
                                </h6>
                                <div class="d-grid gap-1">
                                    <a href="{{ route('order.checkout', ['template' => $tmpl->slug]) }}" class="btn btn-sm btn-detroit py-1" style="font-size: 0.75rem;">
                                        <i class="bi bi-check2"></i> Pilih Template
                                    </a>
                                    <a href="{{ route('invitation.show', 'andika-salsabila') }}" target="_blank" class="btn btn-sm btn-outline-secondary py-1" style="font-size: 0.75rem;">
                                        <i class="bi bi-eye"></i> Demo
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Belum ada template pada kategori ini.</p>
                        <a href="{{ route('home') }}#templates" class="btn btn-detroit-outline btn-sm">Lihat Semua</a>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- SECTION: KATEGORI KAMI (UNTUK SEGALA MOMEN SPESIAL) -->
    <section id="categories" class="py-5" style="background-color: var(--detroit-champagne);">
        <div class="container py-4">
            <div class="row align-items-center mb-4">
                <div class="col-md-8">
                    <div class="small fw-bold text-uppercase mb-1" style="color: var(--detroit-gold); letter-spacing: 1.5px;">
                        Kategori Kami
                    </div>
                    <h2 class="display-6 fw-bold mb-2">Untuk Segala Momen Spesial</h2>
                    <p class="text-muted mb-0">
                        Apapun acaranya, DETROIT siap membantu membuat undangan digital terbaik untuk Anda.
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('home') }}#templates" class="btn btn-detroit-outline">
                        <span>Lihat Semua Template</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Categories Cards Row matching Image 1 -->
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3">
                @php
                    $categoryVisuals = [
                        ['name' => 'Pernikahan & Lamaran', 'icon' => 'bi-heart', 'desc' => 'Sakral & Romantis'],
                        ['name' => 'Khitanan & Aqiqah', 'icon' => 'bi-moon-stars', 'desc' => 'Tasyakuran Berkah'],
                        ['name' => 'Ulang Tahun & Anniversary', 'icon' => 'bi-cake2', 'desc' => 'Pesta Meriah'],
                        ['name' => 'Pengajian & Acara Islami', 'icon' => 'bi-book', 'desc' => 'Majelis Doa'],
                        ['name' => 'Acara Lainnya', 'icon' => 'bi-star', 'desc' => 'Reuni & Gathering'],
                    ];
                @endphp

                @foreach($categories as $idx => $cat)
                    <div class="col">
                        <a href="{{ route('home', ['category' => $cat->id]) }}#templates" class="text-decoration-none">
                            <div class="detroit-card text-center p-4 h-100 d-flex flex-column justify-content-center align-items-center">
                                <div class="mb-3 rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 60px; height: 60px; background-color: #FAF4EB; border: 1.5px solid var(--detroit-gold-light);">
                                    <i class="bi {{ $cat->icon ?? 'bi-star' }}" style="font-size: 1.6rem; color: var(--detroit-gold-dark);"></i>
                                </div>
                                <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.95rem;">
                                    {{ $cat->name }}
                                </h6>
                                <span class="badge bg-light text-muted small border">
                                    {{ $cat->templates_count ?? 2 }} Template
                                </span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- SECTION: MENGAPA MEMILIH DETROIT? -->
    <section id="about" class="py-5" style="background-color: #FFFFFF;">
        <div class="container py-4">
            <div class="text-center mb-5">
                <div class="d-inline-flex align-items-center gap-2 mb-2">
                    <span style="width: 30px; height: 1.5px; background: var(--detroit-gold);"></span>
                    <h2 class="display-6 fw-bold mb-0">Mengapa Memilih DETROIT?</h2>
                    <span style="width: 30px; height: 1.5px; background: var(--detroit-gold);"></span>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4 text-center">
                <div class="col">
                    <div class="p-3">
                        <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 58px; height: 58px; background-color: #F8F1E5;">
                            <i class="bi bi-gem text-warning" style="font-size: 1.6rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Desain Premium</h5>
                        <p class="text-muted small mb-0">Tampilan elegan, eksklusif, dan profesional untuk setiap momen berharga Anda.</p>
                    </div>
                </div>

                <div class="col">
                    <div class="p-3">
                        <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 58px; height: 58px; background-color: #F8F1E5;">
                            <i class="bi bi-lightning-charge-fill text-warning" style="font-size: 1.6rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Mudah Digunakan</h5>
                        <p class="text-muted small mb-0">Atur undangan dengan sangat mudah, cepat, dan praktis tanpa ribet.</p>
                    </div>
                </div>

                <div class="col">
                    <div class="p-3">
                        <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 58px; height: 58px; background-color: #F8F1E5;">
                            <i class="bi bi-wallet2 text-warning" style="font-size: 1.6rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Harga Terjangkau</h5>
                        <p class="text-muted small mb-0">Kualitas terbaik dengan penawaran harga bersahabat dan transparan.</p>
                    </div>
                </div>

                <div class="col">
                    <div class="p-3">
                        <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 58px; height: 58px; background-color: #F8F1E5;">
                            <i class="bi bi-headset text-warning" style="font-size: 1.6rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Customer Support</h5>
                        <p class="text-muted small mb-0">Tim ramah kami siap membantu dan mendampingi Anda kapan saja.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: PAKET HARGA (matching Image 1) -->
    <section id="pricing" class="py-5" style="background-color: var(--detroit-champagne);">
        <div class="container py-4">
            <div class="text-center mb-5">
                <div class="d-inline-flex align-items-center gap-2 mb-2">
                    <span style="width: 30px; height: 1.5px; background: var(--detroit-gold);"></span>
                    <h2 class="display-6 fw-bold mb-0">Paket Harga</h2>
                    <span style="width: 30px; height: 1.5px; background: var(--detroit-gold);"></span>
                </div>
                <p class="text-muted">Pilih paket terbaik sesuai kebutuhan Anda</p>
            </div>

            <div class="row justify-content-center align-items-stretch g-4">
                <!-- Basic Plan -->
                <div class="col-md-4">
                    <div class="detroit-card p-4 h-100 d-flex flex-column text-center position-relative">
                        <h4 class="fw-bold mb-1">Basic</h4>
                        <p class="text-muted small mb-3">Tampilan pilihan dengan fitur dasar</p>

                        <div class="mb-4">
                            <span class="fs-6 text-muted">Rp</span>
                            <span class="display-6 fw-bold text-dark">99.000</span>
                        </div>

                        <ul class="list-unstyled text-start small mb-4 flex-grow-1" style="line-height: 2;">
                            <li><i class="bi bi-check2 text-warning fw-bold me-2"></i> 1 Template Premium</li>
                            <li><i class="bi bi-check2 text-warning fw-bold me-2"></i> Akses Selamanya</li>
                            <li><i class="bi bi-check2 text-warning fw-bold me-2"></i> Support via WhatsApp</li>
                        </ul>

                        <a href="{{ route('order.checkout', ['package' => 'basic']) }}" class="btn btn-detroit-outline w-100 py-2">
                            Pesan Sekarang
                        </a>
                    </div>
                </div>

                <!-- Premium Plan (Highlighted as "Paling Populer") -->
                <div class="col-md-4">
                    <div class="detroit-card p-4 h-100 d-flex flex-column text-center position-relative shadow-lg" 
                         style="border: 2px solid var(--detroit-gold); background: #FFFDF9;">
                        <!-- Badge Paling Populer -->
                        <div class="position-absolute top-0 start-50 translate-middle">
                            <span class="badge py-2 px-3 fw-semibold shadow-sm" style="background-color: #D4A338; color: #FFF; font-size: 0.75rem; border-radius: 20px;">
                                Paling Populer
                            </span>
                        </div>

                        <h4 class="fw-bold mb-1 mt-2">Premium</h4>
                        <p class="text-muted small mb-3">Lebih lengkap untuk acara spesial</p>

                        <div class="mb-4">
                            <span class="fs-6 text-muted">Rp</span>
                            <span class="display-6 fw-bold text-dark">149.000</span>
                        </div>

                        <ul class="list-unstyled text-start small mb-4 flex-grow-1" style="line-height: 2;">
                            <li><i class="bi bi-check2 text-warning fw-bold me-2"></i> 10+ Template Premium</li>
                            <li><i class="bi bi-check2 text-warning fw-bold me-2"></i> Custom Nama & Tanggal</li>
                            <li><i class="bi bi-check2 text-warning fw-bold me-2"></i> Galeri Foto & Musik BGM</li>
                            <li><i class="bi bi-check2 text-warning fw-bold me-2"></i> Amplop Digital & RSVP Live</li>
                            <li><i class="bi bi-check2 text-warning fw-bold me-2"></i> Support Prioritas</li>
                        </ul>

                        <a href="{{ route('order.checkout', ['package' => 'premium']) }}" class="btn btn-detroit w-100 py-2">
                            Pesan Sekarang
                        </a>
                    </div>
                </div>

                <!-- Enterprise Plan -->
                <div class="col-md-4">
                    <div class="detroit-card p-4 h-100 d-flex flex-column text-center position-relative">
                        <h4 class="fw-bold mb-1">Enterprise</h4>
                        <p class="text-muted small mb-3">Solusi lengkap untuk kebutuhan bisnis</p>

                        <div class="mb-4">
                            <span class="fs-6 text-muted">Rp</span>
                            <span class="display-6 fw-bold text-dark">299.000</span>
                        </div>

                        <ul class="list-unstyled text-start small mb-4 flex-grow-1" style="line-height: 2;">
                            <li><i class="bi bi-check2 text-warning fw-bold me-2"></i> Semua Template Premium</li>
                            <li><i class="bi bi-check2 text-warning fw-bold me-2"></i> Fitur Custom Desain</li>
                            <li><i class="bi bi-check2 text-warning fw-bold me-2"></i> Custom Domain Sendiri</li>
                            <li><i class="bi bi-check2 text-warning fw-bold me-2"></i> Unlimited Tamu Undangan</li>
                            <li><i class="bi bi-check2 text-warning fw-bold me-2"></i> Prioritas Support 24/7</li>
                        </ul>

                        <a href="https://wa.me/6281234567890?text=Halo%20DETROIT%2C%20saya%20tertarik%20dengan%20Paket%20Enterprise" target="_blank" class="btn btn-detroit-outline w-100 py-2">
                            Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: CALL TO ACTION BANNER (Dark & Gold matching Image 1) -->
    <section id="contact" class="py-5" style="background: linear-gradient(135deg, #1F1B18 0%, #2A2420 100%); color: #FFFFFF;">
        <div class="container py-3">
            <div class="row align-items-center g-4">
                <div class="col-lg-8 d-flex align-items-center gap-3">
                    <div class="rounded-circle p-3 d-flex align-items-center justify-content-center" 
                         style="background: rgba(184, 134, 11, 0.2); border: 1.5px solid var(--detroit-gold); width: 64px; height: 64px; flex-shrink: 0;">
                        <i class="bi bi-envelope-open" style="font-size: 1.8rem; color: #E8C36A;"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1 text-white">Siap Membuat Undangan Digital Anda?</h4>
                        <p class="mb-0 text-white-50 small">
                            Pesan sekarang dan wujudkan momen istimewa Anda bersama DETROIT.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('order.checkout') }}" class="btn btn-detroit px-4 py-2">
                        <i class="bi bi-chat-dots"></i>
                        <span>Pesan Sekarang</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
