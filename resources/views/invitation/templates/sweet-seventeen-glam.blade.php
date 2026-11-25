@php
    use Illuminate\Support\Str;
    $c = $content ?? [];
    $guestName = $guestName ?? 'Tamu Kehormatan';
    $img = fn($p) => $p ? (Str::startsWith($p, ['http', '/']) ? $p : asset('storage/' . $p)) : null;

    // FOTO DEFAULT: Tema Sweet Seventeen Glamour Rose Gold (Aurelia Stephanie)
    $ph = [
        'hero'  => 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?auto=format&fit=crop&q=85&w=1200',
        'child' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&crop=faces&q=85&w=800',
        'venue' => 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&q=85&w=1200',
    ];
    $hero     = $img($c['hero_image'] ?? null) ?: $ph['hero'];
    $childPic = $img($c['child_photo'] ?? null) ?: $ph['child'];
    $venuePic = $img($c['venue_image'] ?? null) ?: $ph['venue'];

    $gallery = collect($c['gallery'] ?? [
        $ph['hero'],
        'https://images.unsplash.com/photo-1530103862676-de8c9debad1d?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1513151233558-d860c5398176?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1469371670807-013ccf25f16a?auto=format&fit=crop&q=80&w=800',
    ])->map($img)->filter()->values();

    $story = $c['story'] ?? [
        ['date' => 'Masa Kanak-kanak', 'title' => 'Tumbuh Penuh Cinta', 'text' => 'Tumbuh di tengah dekapan hangat keluarga yang senantiasa menanamkan kasih sayang dan keberanian.'],
        ['date' => 'Menemukan Cita-cita', 'title' => 'Eksplorasi & Semangat Muda', 'text' => 'Mengukir prestasi, menjalin persahabatan sejati, dan menatap masa depan dengan penuh percaya diri.'],
        ['date' => 'Sweet Seventeen', 'title' => 'Turning 17 Glamour Night', 'text' => 'Menapaki gerbang kedewasaan yang memesona, siap menyambut lembaran hidup baru yang lebih gemilang.'],
    ];

    $gifts = $c['gifts'] ?? [
        ['bank' => 'Bank BCA', 'number' => ($c['bank_1_number'] ?? '8192019482'), 'name' => ($c['bank_1_holder'] ?? 'Aurelia Stephanie')],
        ['bank' => 'Bank Mandiri', 'number' => ($c['bank_2_number'] ?? '1370019283019'), 'name' => ($c['bank_2_holder'] ?? 'Bpk. Ir. Hendra Gunawan (Ayahanda)')],
    ];

    $music = $c['music_url'] ?? 'https://cdn.pixabay.com/download/audio/2022/05/27/audio_1808fbf07a.mp3?filename=romantic-wedding-piano-113004.mp3';

    $celebrant = $c['child_name'] ?? ($c['groom_name'] ?? 'Aurelia Stephanie');
    if (empty($celebrant) || str_contains(strtolower($celebrant), 'sweet') || str_contains(strtolower($celebrant), 'wedding')) {
        $celebrant = 'Aurelia Stephanie';
    }

    $firstEvent = $invitation->events->first();
    $ev0 = $firstEvent?->event_date;
    $eventDateText = $ev0 ? $ev0->locale('id')->isoFormat('dddd, D MMMM YYYY') : 'Sabtu, 11 April 2026';
    $venueName = $firstEvent?->location ?? 'The Sky Ballroom & Lounge, Jakarta Pusat';
    $mapsFor = fn($e) => ($e?->maps_url) ?: 'https://maps.google.com/?q=' . urlencode($e?->location ?? $venueName);

    $calUrl = null;
    if ($ev0) {
        $calUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE&text=' . urlencode('Sweet Seventeen ' . $celebrant)
            . '&dates=' . $ev0->format('Ymd') . '/' . $ev0->copy()->addDay()->format('Ymd') . '&location=' . urlencode($venueName);
    }
    $targetCountdown = $ev0 ? $ev0->format('Y-m-d') : '2026-04-11';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Sweet Seventeen {{ $celebrant }} - DETROIT</title>
<meta name="theme-color" content="#1F0827">
<meta property="og:title" content="Sweet Seventeen {{ $celebrant }}">
<meta property="og:description" content="{{ $eventDateText }} di {{ $venueName }} - Rayakan malam spesial sweet seventeen penuh kilau bersama kami.">
<meta property="og:image" content="{{ $hero }}">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Cormorant+Garamond:ital,wght@0,500;0,600;1,500;1,600&family=Pinyon+Script&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
:root{
  --plum-bg:#1F0827;
  --plum-panel:rgba(43,12,54,.88);
  --sparkle:#F472B6;
  --sparkle-light:#FDE047;
  --gold-glow:rgba(244,114,182,.35);
  --sparkle-btn:linear-gradient(135deg,#F472B6 0%,#D946EF 50%,#86198F 100%);
  --cream:#FFF5FC;
  --muted:#D6BDD8;
  --line:rgba(244,114,182,.35);
}
*{box-sizing:border-box}
html{scroll-behavior:smooth;scroll-padding-top:80px}
body{
  margin:0;background:var(--plum-bg);color:var(--cream);font-family:'Plus Jakarta Sans',sans-serif;overflow-x:hidden;
  background-image:
    radial-gradient(circle at 50% 0,rgba(90,20,110,.65),transparent 65%),
    radial-gradient(circle at 100% 50%,rgba(60,10,80,.55),transparent 55%),
    linear-gradient(180deg,#240B30 0%,#110416 100%);
  background-attachment:fixed;
}
body.locked{overflow:hidden;height:100vh}
.font-cinzel{font-family:'Cinzel',serif}
.font-serif{font-family:'Cormorant Garamond',serif}
.font-script{font-family:'Pinyon Script',cursive}
.text-sparkle{color:var(--sparkle)!important}
.text-gold{color:var(--sparkle-light)!important}
.text-readable{color:var(--cream)!important;line-height:1.7}
.text-subtle{color:var(--muted)!important;line-height:1.6}

/* Header */
.royal-header{
  position:fixed;inset:0 0 auto;z-index:999;padding:12px 20px;display:flex;align-items:center;justify-content:space-between;
  background:rgba(31,8,39,.92);backdrop-filter:blur(14px);border-bottom:1px solid rgba(244,114,182,.25);
}
.royal-brand{display:flex;flex-direction:column;align-items:center;color:var(--cream);text-decoration:none;letter-spacing:2px}
.royal-brand i{font-size:1.15rem;color:var(--sparkle)}
.royal-brand span{font-family:'Cinzel',serif;font-size:.82rem;font-weight:700}
.royal-nav-links{display:flex;gap:22px;list-style:none;margin:0;padding:0}
.royal-nav-links a{color:var(--muted);text-decoration:none;font-size:.84rem;font-weight:500;transition:color .2s}
.royal-nav-links a:hover{color:var(--cream)}
.btn-royal-share{
  border:1px solid var(--sparkle);border-radius:50px;padding:6px 18px;color:var(--cream);font-size:.8rem;
  background:rgba(244,114,182,.15);text-decoration:none;display:inline-flex;align-items:center;gap:6px;cursor:pointer;transition:.2s;
}
.btn-royal-share:hover{background:var(--sparkle);color:#fff!important}
.music-vinyl-btn{
  width:40px;height:40px;border-radius:50%;background:radial-gradient(circle,#4A125E,#22062C 65%,#0F0214);
  border:1.5px solid var(--sparkle);color:var(--sparkle-light);display:flex;align-items:center;justify-content:center;cursor:pointer;
}
.music-vinyl-btn.rotating{animation:spin 5s linear infinite}
@keyframes spin{to{transform:rotate(360deg)}}

.inv-shell{max-width:1040px;margin:0 auto;padding-bottom:110px;padding-top:80px}

/* Cover / Hero */
#openingCover{
  position:fixed;inset:0;z-index:10000;display:flex;align-items:center;justify-content:center;
  padding:clamp(12px,2.5vh,24px) clamp(12px,2.5vw,20px);overflow-y:auto;
  background:radial-gradient(circle at center,#3B104A,#1F0827 50%,#0F0314);
  transition:transform 1.2s cubic-bezier(.85,0,.15,1),opacity 1.2s;
}
#openingCover.opened{transform:translateY(-100%);opacity:0;pointer-events:none}
.hero-banner-card{
  background:radial-gradient(circle at 60% 40%,#431354,#24092E 75%,#120317);
  border:1.5px solid rgba(244,114,182,.45);border-radius:24px;
  box-shadow:0 25px 60px rgba(0,0,0,.65),inset 0 0 40px rgba(244,114,182,.15);
  position:relative;overflow:hidden;padding:clamp(20px,3vh,30px) clamp(16px,2.5vw,26px);
  width:100%;max-width:880px;margin:auto;
}
.corner-flourish{position:absolute;width:clamp(60px,10vw,110px);height:clamp(60px,10vw,110px);pointer-events:none;opacity:.6}
.corner-flourish.tl{top:-4px;left:-4px}.corner-flourish.tr{top:-4px;right:-4px;transform:scaleX(-1)}
.corner-flourish.bl{bottom:-4px;left:-4px;transform:scaleY(-1)}.corner-flourish.br{bottom:-4px;right:-4px;transform:scale(-1)}

.arch-photo-container{
  position:relative;width:100%;max-width:300px;margin:0 auto;border-radius:180px 180px 16px 16px;padding:6px;
  background:linear-gradient(180deg,#FDE047,#F472B6 50%,#701A75);box-shadow:0 14px 34px rgba(0,0,0,.55);transition:box-shadow .4s;
}
.arch-photo-container:hover{box-shadow:0 18px 45px rgba(0,0,0,.6),0 0 35px rgba(244,114,182,.3)}
.arch-photo-inner{
  width:100%;height:390px;border-radius:174px 174px 10px 10px;background:#1F0827 center 20%/cover no-repeat;
  position:relative;overflow:hidden;filter:contrast(1.04) saturate(1.08) brightness(1.02);
}
.arch-photo-inner::after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,transparent 72%,rgba(31,8,39,.75));pointer-events:none}

.arch-card-right{
  border:1px solid var(--line);background:rgba(37,10,47,.75);backdrop-filter:blur(10px);
  border-radius:170px 170px 20px 20px;padding:32px 22px 26px;text-align:center;position:relative;
  box-shadow:inset 0 0 30px rgba(244,114,182,.08);
}
.arch-card-right::before{content:"";position:absolute;inset:6px;border:1px dashed rgba(244,114,182,.3);border-radius:164px 164px 15px 15px;pointer-events:none}
.inv-subtitle{font-family:'Cinzel',serif;font-size:.78rem;letter-spacing:4px;color:var(--sparkle-light);font-weight:700;margin-bottom:4px}
.inv-title-main{font-family:'Pinyon Script',cursive;font-size:clamp(2.8rem,6vw,4.5rem);font-weight:700;line-height:1.02;margin:0 0 4px;color:var(--cream)}
.inv-age-badge{display:inline-block;padding:3px 14px;background:var(--sparkle);color:#fff;border-radius:50px;font-size:.78rem;font-weight:700;letter-spacing:1px;margin-bottom:10px}

.inv-date-hero{font-family:'Cinzel',serif;font-size:.95rem;letter-spacing:2px;color:#fff;font-weight:600;margin-bottom:3px}
.inv-venue-hero{font-size:.86rem;color:var(--sparkle-light);margin-bottom:8px;display:flex;align-items:center;justify-content:center;gap:5px}
.inv-quote-hero{font-style:italic;font-size:.86rem;max-width:320px;margin:0 auto 14px;line-height:1.5;color:var(--muted)}

.countdown-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:6px;max-width:300px;margin:0 auto 14px}
.countdown-tile{background:rgba(31,8,39,.88);border:1px solid rgba(244,114,182,.55);border-radius:10px;padding:6px 2px;box-shadow:0 4px 14px rgba(0,0,0,.35)}
.countdown-num{font-family:'Cinzel',serif;font-size:1.35rem;font-weight:700;color:var(--sparkle-light);line-height:1.1}
.countdown-lbl{font-size:.62rem;letter-spacing:1px;text-transform:uppercase;color:var(--muted);margin-top:2px;font-weight:600}

.guest-callout-box{background:rgba(31,8,39,.85);border:1px solid rgba(244,114,182,.45);border-radius:10px;padding:8px 14px;max-width:300px;margin:0 auto 16px}
.guest-label{color:var(--sparkle-light);font-size:.68rem;letter-spacing:1px;font-weight:600;margin-bottom:2px}
.guest-name{font-family:'Cinzel',serif;font-size:1.08rem;font-weight:700;color:#FFF5FC;overflow-wrap:anywhere}

.btn-gold-cta{
  background:var(--sparkle-btn);color:#FFFFFF!important;font-family:'Cinzel',serif;font-weight:700;font-size:.82rem;letter-spacing:1.5px;text-transform:uppercase;
  border:0;border-radius:50px;padding:11px 34px;box-shadow:0 8px 25px rgba(244,114,182,.45);display:inline-flex;align-items:center;gap:8px;cursor:pointer;
  text-decoration:none;transition:all .3s cubic-bezier(.175,.885,.32,1.275);
}
.btn-gold-cta:hover{transform:translateY(-2px) scale(1.02);box-shadow:0 12px 30px rgba(244,114,182,.65)}
.btn-gold-cta:disabled{opacity:.7;transform:none}

/* Sections */
.inv-section-card{
  background:var(--plum-panel);backdrop-filter:blur(12px);border:1px solid var(--line);border-radius:24px;
  padding:45px 32px;margin-bottom:40px;box-shadow:0 16px 40px rgba(0,0,0,.35);
}
.sec-title{text-align:center;margin-bottom:32px}
.sec-title .sub{font-family:'Cinzel',serif;font-size:.9rem;color:var(--sparkle-light);letter-spacing:3px;text-transform:uppercase;font-weight:700}
.sec-title h2{font-family:'Pinyon Script',cursive;font-size:clamp(3rem,5.5vw,4.2rem);color:var(--cream);margin:2px 0 14px;line-height:1}
.sep-line{width:120px;height:1px;position:relative;margin:0 auto;background:linear-gradient(90deg,transparent,var(--sparkle),transparent)}
.sep-line::after{content:"";position:absolute;left:50%;top:50%;width:8px;height:8px;background:var(--sparkle-light);transform:translate(-50%,-50%) rotate(45deg);box-shadow:0 0 10px var(--gold-glow)}

.celebrant-card{
  background:linear-gradient(180deg,rgba(48,13,60,.85),rgba(27,7,35,.85));border:1.5px solid rgba(244,114,182,.35);
  border-radius:20px;padding:34px 24px;max-width:580px;margin:0 auto;box-shadow:0 14px 34px rgba(0,0,0,.35);
}

.panel{background:rgba(37,10,47,.75);border:1px solid var(--line);border-radius:20px;padding:24px}
.chip-date{display:inline-block;font-size:.75rem;padding:4px 14px;border-radius:50px;color:var(--cream);background:rgba(244,114,182,.15);border:1px solid rgba(244,114,182,.4);margin-bottom:8px}
.timeline{border-left:2px solid rgba(244,114,182,.45);padding-left:26px;position:relative}
.timeline .dot{position:absolute;left:-8px;top:4px;width:14px;height:14px;border-radius:50%;background:var(--sparkle);box-shadow:0 0 10px var(--sparkle)}
.gal-item{aspect-ratio:1;cursor:pointer;position:relative;overflow:hidden;border-radius:14px;border:1px solid var(--line)}
.gal-item img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
.gal-item:hover img{transform:scale(1.06)}
.gal-item .ov{position:absolute;inset:0;background:rgba(0,0,0,.35);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity .25s}
.gal-item:hover .ov{opacity:1}

.form-control-plum{background:rgba(31,8,39,.85)!important;border:1px solid rgba(244,114,182,.45)!important;color:#fff!important;border-radius:10px;padding:12px 14px}
.form-control-plum::placeholder{color:var(--muted)!important}
.form-control-plum:focus{box-shadow:0 0 12px rgba(244,114,182,.4)!important;border-color:var(--sparkle)!important}
.radio-row{background:rgba(35,9,45,.7);border:1px solid rgba(255,255,255,.15)}

/* Dock */
.royal-dock{
  position:fixed;bottom:calc(16px + env(safe-area-inset-bottom,0px));left:50%;transform:translateX(-50%);width:calc(100% - 32px);max-width:480px;
  background:rgba(31,8,39,.95);backdrop-filter:blur(18px);border:1px solid rgba(244,114,182,.45);border-radius:50px;padding:8px 10px;
  display:flex;justify-content:space-around;box-shadow:0 12px 35px rgba(0,0,0,.65);z-index:990;
}
.dock-item{color:var(--muted);text-decoration:none;display:flex;flex-direction:column;align-items:center;gap:2px;padding:6px;border-radius:16px;background:transparent;border:0;font-size:.64rem;font-weight:500;transition:.2s}
.dock-item i{font-size:1.15rem;color:var(--sparkle);transition:.2s}
.dock-item:hover,.dock-item.active{color:#fff}
.dock-item.active{background:rgba(244,114,182,.2)}
.dock-item:hover i,.dock-item.active i{color:var(--cream);transform:scale(1.12)}

.toast-notif{
  position:fixed;top:75px;left:50%;transform:translate(-50%,-120px);background:var(--sparkle-btn);color:#FFFFFF;padding:11px 26px;
  border-radius:50px;font-weight:700;font-size:.9rem;z-index:10005;transition:transform .4s;box-shadow:0 8px 24px rgba(0,0,0,.5);
}
.toast-notif.show{transform:translate(-50%,0)}

@media(max-width:991px){
  .royal-nav-links{display:none}
  .hero-banner-card{padding:22px 16px;max-width:440px;margin:0 auto;border-radius:22px}
  .arch-photo-container{max-width:180px;margin:0 auto 12px;border-radius:100px 100px 14px 14px;padding:4px}
  .arch-photo-inner{height:190px;border-radius:96px 96px 10px 10px;background-position:center 20%!important}
  .arch-card-right{border:0;background:transparent;box-shadow:none;padding:6px 0 0;border-radius:0}
  .arch-card-right::before{display:none}
  .countdown-grid{max-width:280px;gap:5px;margin-bottom:12px}.countdown-num{font-size:1.2rem}
  .guest-callout-box{max-width:280px;padding:7px 12px;margin-bottom:14px}
  .inv-section-card{padding:30px 18px}
}
@media(max-width:576px){
  #openingCover{padding:12px 10px}
  .hero-banner-card{padding:18px 12px;border-radius:18px;max-width:390px}
  .arch-photo-container{max-width:150px;margin-bottom:8px;border-radius:85px 85px 12px 12px;padding:3px}
  .arch-photo-inner{height:165px;border-radius:82px 82px 8px 8px}
  .inv-subtitle{font-size:.72rem;letter-spacing:3px;margin-bottom:2px}
  .inv-title-main{font-size:2.6rem}
  .inv-date-hero{font-size:.88rem;margin-bottom:2px}
  .inv-venue-hero{font-size:.82rem;margin-bottom:5px}
  .inv-quote-hero{font-size:.8rem;line-height:1.4;margin-bottom:10px}
  .countdown-grid{max-width:260px;gap:4px;margin-bottom:10px}.countdown-num{font-size:1.1rem}.countdown-lbl{font-size:.56rem;letter-spacing:1px}
  .guest-callout-box{max-width:260px;padding:6px 10px;margin-bottom:12px}
  .guest-name{font-size:.98rem}
  .btn-gold-cta{padding:9px 26px;font-size:.78rem;width:100%;max-width:240px;justify-content:center}
  .royal-dock{width:calc(100% - 16px);padding:5px 3px;bottom:calc(10px + env(safe-area-inset-bottom,0px))}
  .dock-item{font-size:.54rem;padding:3px 2px}.dock-item i{font-size:1rem}
  .inv-section-card{padding:24px 12px;border-radius:16px;margin-bottom:20px}
}
</style>
</head>
<body class="locked">

<div class="toast-notif" id="toastMsg" role="status" aria-live="polite"></div>
@if($music)<audio id="bgMusic" src="{{ $music }}" loop preload="none"></audio>@endif

<header class="royal-header">
    <a href="#home" class="royal-brand"><i class="bi bi-stars"></i><span>DETROIT</span></a>
    <ul class="royal-nav-links">
        <li><a href="#home">Home</a></li><li><a href="#child">The Celebrant</a></li><li><a href="#story">Journey</a></li>
        <li><a href="#event">Party</a></li><li><a href="#gallery">Gallery</a></li><li><a href="#rsvp">RSVP</a></li>
    </ul>
    <div class="d-flex align-items-center gap-2">
        <button type="button" class="btn-royal-share" id="topShareBtn"><i class="bi bi-share"></i><span>Bagikan</span></button>
        @if($music)
            <button type="button" class="music-vinyl-btn" id="musicToggleBtn" title="Putar/Jeda musik" aria-label="Putar atau jeda musik"><i class="bi bi-music-note-beamed"></i></button>
        @endif
    </div>
</header>

<!-- COVER -->
<div id="openingCover">
    <div class="container text-center" style="max-width:920px;">
        <div class="hero-banner-card">
            @foreach(['tl','tr','bl','br'] as $pos)
                <svg class="corner-flourish {{ $pos }}" viewBox="0 0 100 100" fill="none" stroke="#F472B6" stroke-width="1.2" aria-hidden="true">
                    <path d="M10 90 C10 40 40 10 90 10 M18 90 C18 45 45 18 90 18 M5 95 C5 35 35 5 95 5"/><circle cx="28" cy="28" r="4" fill="#F472B6"/>
                </svg>
            @endforeach

            <div class="row align-items-center g-4">
                <div class="col-lg-5">
                    <div class="arch-photo-container"><div class="arch-photo-inner" style="background-image:url('{{ $childPic }}')"></div></div>
                </div>
                <div class="col-lg-7">
                    <div class="arch-card-right">
                        <div class="inv-subtitle">SWEET SEVENTEEN CELEBRATION</div>
                        <h1 class="inv-title-main">{{ $celebrant }}</h1>
                        <div class="inv-age-badge"><i class="bi bi-stars me-1"></i>Turning 17 Years Old</div>
                        <div class="inv-date-hero">{{ $eventDateText }}</div>
                        <div class="inv-venue-hero"><i class="bi bi-geo-alt-fill text-warning"></i><span>{{ $venueName }}</span></div>
                        <p class="inv-quote-hero">"Menapaki usia ke-17 dengan penuh kilau, cinta, dan tawa. Mari bergabung bersama kami merayakan malam istimewa ini!"</p>

                        <div class="countdown-grid" id="coverCountdown" data-date="{{ $targetCountdown }}">
                            <div class="countdown-tile"><div class="countdown-num" id="cov-d">0</div><div class="countdown-lbl">Hari</div></div>
                            <div class="countdown-tile"><div class="countdown-num" id="cov-h">00</div><div class="countdown-lbl">Jam</div></div>
                            <div class="countdown-tile"><div class="countdown-num" id="cov-m">00</div><div class="countdown-lbl">Menit</div></div>
                            <div class="countdown-tile"><div class="countdown-num" id="cov-s">00</div><div class="countdown-lbl">Detik</div></div>
                        </div>

                        <div class="guest-callout-box">
                            <div class="guest-label">Kepada Yth. Sahabat & Teman Spesial</div>
                            <div class="guest-name">{{ $guestName }}</div>
                        </div>

                        <button type="button" class="btn-gold-cta" onclick="unlockInvitation()"><span>Buka Undangan</span><i class="bi bi-envelope-open-heart"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<main class="inv-shell px-3" id="home">

    <!-- PROFIL YANG ULANG TAHUN -->
    <section class="inv-section-card" id="child">
        <div class="sec-title"><div class="sub">Golden Age</div><h2>The Celebrant</h2><div class="sep-line"></div></div>

        <div class="celebrant-card text-center">
            <div class="arch-photo-container mb-3" style="max-width:200px">
                <div class="arch-photo-inner" style="height:250px;background-image:url('{{ $childPic }}')"></div>
            </div>
            <h3 class="font-cinzel text-sparkle fw-bold fs-3 mb-1">{{ $celebrant }}</h3>
            <div class="badge rounded-pill bg-warning text-dark px-3 py-1 fw-bold mb-3">Sweet 17th Birthday</div>
            <p class="text-readable small mb-0">{{ $c['parents'] ?? 'Putri tercinta dari Bpk. Ir. Hendra Gunawan & Ibu Ratna Dewi' }}</p>
        </div>
    </section>

    <!-- STORY -->
    @if(count($story))
    <section class="inv-section-card" id="story">
        <div class="sec-title"><div class="sub">17 Years Journey</div><h2>Kisah & Perjalanan</h2><div class="sep-line"></div></div>
        <div class="row justify-content-center"><div class="col-lg-8">
            <div class="timeline">
                @foreach($story as $s)
                    <div class="position-relative mb-4 pb-2">
                        <span class="dot"></span>
                        <span class="chip-date">{{ $s['date'] ?? '' }}</span>
                        <h4 class="font-cinzel text-sparkle fs-5 mb-2 fw-bold">{{ $s['title'] ?? '' }}</h4>
                        <p class="text-readable small mb-0">{{ $s['text'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </div></div>
    </section>
    @endif

    <!-- ACARA -->
    <section class="inv-section-card" id="event">
        <div class="sec-title"><div class="sub">Glamour Night</div><h2>Gala Party & Dinner</h2><div class="sep-line"></div></div>
        <div class="row g-4 justify-content-center">
            @forelse($invitation->events as $ev)
                <div class="col-md-6">
                    <div class="panel h-100 text-center">
                        <i class="bi bi-stars text-sparkle fs-1 mb-2 d-inline-block"></i>
                        <h3 class="font-cinzel text-sparkle fs-4 fw-bold mb-2">{{ $ev->event_name }}</h3>
                        <p class="text-gold fw-semibold mb-1">{{ $ev->event_date?->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
                        <p class="text-subtle small mb-3"><i class="bi bi-clock me-1"></i>Pukul {{ $ev->event_time ?: '18:30 WIB' }} s/d Selesai</p>
                        <div class="p-3 rounded-3 mb-3" style="background:rgba(31,8,39,.6);border:1px solid rgba(244,114,182,.25)">
                            <div class="fw-bold text-cream small mb-1">{{ $ev->location }}</div>
                            <div class="text-subtle small">{{ $ev->description ?: 'Dresscode: Glamour Sparkle / Cocktail Attire. Candle lighting, dinner & live music party!' }}</div>
                        </div>
                        <div class="d-flex gap-2 justify-content-center flex-wrap">
                            <a href="{{ $mapsFor($ev) }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-warning rounded-pill px-3"><i class="bi bi-geo-alt me-1"></i>Google Maps</a>
                            @if($calUrl)<a href="{{ $calUrl }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-light rounded-pill px-3"><i class="bi bi-calendar-plus me-1"></i>Simpan Kalender</a>@endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-6">
                    <div class="panel text-center">
                        <h3 class="font-cinzel text-sparkle fs-4 fw-bold mb-2">Sweet 17 Gala Night</h3>
                        <p class="text-gold fw-semibold mb-1">{{ $eventDateText }}</p>
                        <p class="text-subtle small mb-3">Pukul 18.30 WIB s/d Selesai</p>
                        <p class="text-readable small">{{ $venueName }}</p>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- GALERI -->
    @if(count($gallery))
    <section class="inv-section-card" id="gallery">
        <div class="sec-title"><div class="sub">Sparkling Moments</div><h2>Galeri Foto Glamour</h2><div class="sep-line"></div></div>
        <div class="row g-3">
            @foreach($gallery as $idx => $g)
                <div class="col-6 col-md-3">
                    <div class="gal-item" onclick="openLightbox('{{ $g }}')">
                        <img src="{{ $g }}" alt="Foto Sweet Seventeen {{ $idx + 1 }}" loading="lazy">
                        <div class="ov"><i class="bi bi-zoom-in fs-3 text-sparkle"></i></div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- TANDA KASIH -->
    @if(count($gifts))
    <section class="inv-section-card" id="gift">
        <div class="sec-title"><div class="sub">Special Gift</div><h2>Tanda Kasih</h2><div class="sep-line"></div></div>
        <p class="text-center text-subtle small max-w-md mx-auto mb-4" style="max-width:560px">Kehadiran dan senyum sahabat semua adalah kado paling bernilai. Namun jika hendak mengirimkan kado atau tanda kasih, dapat melalui:</p>
        <div class="row g-3 justify-content-center">
            @foreach($gifts as $gf)
                <div class="col-md-5">
                    <div class="panel text-center h-100">
                        <i class="bi bi-gift-fill text-sparkle fs-2 mb-2 d-inline-block"></i>
                        <h4 class="font-cinzel text-cream fs-5 mb-1">{{ $gf['bank'] }}</h4>
                        <div class="font-monospace fs-5 text-gold fw-bold my-2">{{ $gf['number'] }}</div>
                        <div class="text-subtle small mb-3">a.n {{ $gf['name'] }}</div>
                        <button type="button" class="btn btn-sm btn-outline-warning rounded-pill px-3 js-copy" data-copy="{{ $gf['number'] }}"><i class="bi bi-copy me-1"></i>Salin Rekening</button>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- RSVP & UCAPAN -->
    <section class="inv-section-card" id="rsvp">
        <div class="sec-title"><div class="sub">Join The Party</div><h2>RSVP & Birthday Wishes</h2><div class="sep-line"></div></div>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-6">
                <div class="panel">
                    <h4 class="font-cinzel text-sparkle fs-5 mb-3"><i class="bi bi-envelope-paper me-2"></i>Konfirmasi Hadir</h4>
                    <form id="rsvpForm" action="{{ route('invitation.rsvp', $invitation->slug) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small text-gold fw-semibold">Nama Teman / Sahabat</label>
                            <input type="text" name="name" class="form-control form-control-plum" value="{{ $guestName !== 'Tamu Kehormatan' ? $guestName : '' }}" placeholder="Nama Anda" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-gold fw-semibold">Bisa Datang ke Gala Party?</label>
                            <div class="d-flex gap-3">
                                <label class="radio-row flex-fill p-2 rounded-3 text-center cursor-pointer"><input type="radio" name="attendance" value="yes" checked class="me-1"><span class="small">I'll Be There! ✨</span></label>
                                <label class="radio-row flex-fill p-2 rounded-3 text-center cursor-pointer"><input type="radio" name="attendance" value="no" class="me-1"><span class="small">Can't Make It</span></label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-gold fw-semibold">Jumlah Tamu</label>
                            <select name="total_guests" class="form-select form-control-plum">
                                <option value="1">1 Orang</option><option value="2">2 Orang</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-gold fw-semibold">Birthday Wishes & Message</label>
                            <textarea name="message" rows="3" class="form-control form-control-plum" placeholder="Tuliskan ucapan dan doa terbaik untuk Aurelia..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-gold-cta w-100 justify-content-center" id="btnSubmitRsvp"><span>Kirim Ucapan Ulang Tahun</span><i class="bi bi-send-fill"></i></button>
                    </form>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="panel h-100 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="font-cinzel text-sparkle fs-5 mb-0"><i class="bi bi-chat-heart me-2"></i>Wishes Wall</h4>
                        <span class="badge rounded-pill bg-warning text-dark px-3 py-1 fw-bold" id="wishesBadge">{{ $invitation->messages->count() }} Ucapan</span>
                    </div>
                    <div class="flex-grow-1 overflow-auto pe-2" id="wishesFeed" style="max-height:420px">
                        @forelse($invitation->messages as $msg)
                            <div class="p-3 rounded-3 mb-2" style="background:rgba(31,8,39,.6);border:1px solid rgba(244,114,182,.2)">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold text-sparkle small">{{ $msg->name }}</span>
                                    <span class="text-subtle" style="font-size:.7rem">{{ $msg->created_at?->diffForHumans() }}</span>
                                </div>
                                <p class="small text-readable mb-0">{{ $msg->message }}</p>
                            </div>
                        @empty
                            <div class="text-center py-5 text-subtle" id="wishesEmpty">
                                <i class="bi bi-stars fs-1 d-block mb-2 text-sparkle"></i>Jadilah yang pertama menuliskan ucapan selamat sweet seventeen!
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PENUTUP -->
    <section class="inv-section-card text-center" id="closing">
        <i class="bi bi-stars text-sparkle display-4 mb-3 d-inline-block"></i>
        <h3 class="font-cinzel text-cream fs-3 mb-3">See You on The Party!</h3>
        <p class="text-readable mx-auto mb-4" style="max-width:580px">Terima kasih atas segala cinta, doa, dan dukungan yang tak pernah henti. Kehadiran kalian akan melengkapi kebahagiaan malam sweet seventeen ini!</p>
        <p class="text-subtle small mb-0">With Love, Aurelia & Family</p>
    </section>
</main>

<!-- BOTTOM DOCK -->
<nav class="royal-dock">
    <a href="#home" class="dock-item active"><i class="bi bi-house-door-fill"></i><span>Home</span></a>
    <a href="#child" class="dock-item"><i class="bi bi-person-heart"></i><span>Aurelia</span></a>
    <a href="#event" class="dock-item"><i class="bi bi-stars"></i><span>Party</span></a>
    <a href="#gallery" class="dock-item"><i class="bi bi-images"></i><span>Galeri</span></a>
    <a href="#rsvp" class="dock-item"><i class="bi bi-envelope-check-fill"></i><span>RSVP</span></a>
</nav>

<!-- LIGHTBOX MODAL -->
<div class="modal fade" id="lightboxModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0 text-center">
            <div class="position-relative d-inline-block mx-auto">
                <img id="lightboxImg" src="" alt="Preview Galeri" class="img-fluid rounded-4 shadow-lg" style="max-height:85vh">
                <button type="button" class="btn btn-dark position-absolute top-0 end-0 m-2 rounded-circle" data-bs-dismiss="modal" style="width:36px;height:36px;padding:0"><i class="bi bi-x-lg"></i></button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
let musicPlaying = false;
const bgMusic = document.getElementById('bgMusic');
const musicToggleBtn = document.getElementById('musicToggleBtn');

function unlockInvitation(){
    const cover = document.getElementById('openingCover');
    if(cover){
        cover.classList.add('opened');
        document.body.classList.remove('locked');
    }
    if(bgMusic && !musicPlaying){
        bgMusic.play().then(()=>{
            musicPlaying = true;
            if(musicToggleBtn) musicToggleBtn.classList.add('rotating');
        }).catch(()=>{});
    }
}

if(musicToggleBtn && bgMusic){
    musicToggleBtn.addEventListener('click', ()=>{
        if(musicPlaying){
            bgMusic.pause();
            musicPlaying = false;
            musicToggleBtn.classList.remove('rotating');
        }else{
            bgMusic.play().then(()=>{
                musicPlaying = true;
                musicToggleBtn.classList.add('rotating');
            }).catch(()=>{});
        }
    });
}

function showToast(msg){
    const t = document.getElementById('toastMsg');
    if(!t) return;
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(()=> t.classList.remove('show'), 2800);
}

document.querySelectorAll('.js-copy').forEach(btn => {
    btn.addEventListener('click', ()=>{
        const txt = btn.getAttribute('data-copy');
        if(!txt) return;
        navigator.clipboard.writeText(txt).then(()=>{
            showToast('Nomor rekening berhasil disalin!');
        }).catch(()=>{
            showToast('Gagal menyalin rekening');
        });
    });
});

const topShareBtn = document.getElementById('topShareBtn');
if(topShareBtn){
    topShareBtn.addEventListener('click', ()=>{
        if(navigator.share){
            navigator.share({
                title: document.title,
                text: 'Undangan Sweet Seventeen {{ $celebrant }}',
                url: window.location.href
            }).catch(()=>{});
        }else{
            navigator.clipboard.writeText(window.location.href).then(()=>{
                showToast('Tautan undangan berhasil disalin!');
            });
        }
    });
}

function openLightbox(url){
    const img = document.getElementById('lightboxImg');
    if(img){
        img.src = url;
        const modal = new bootstrap.Modal(document.getElementById('lightboxModal'));
        modal.show();
    }
}

// Countdown
const cdWrap = document.getElementById('coverCountdown');
if(cdWrap){
    const target = new Date(cdWrap.getAttribute('data-date') + 'T18:30:00').getTime();
    function tick(){
        const now = new Date().getTime();
        const diff = target - now;
        if(diff <= 0){
            document.getElementById('cov-d').textContent = '0';
            document.getElementById('cov-h').textContent = '00';
            document.getElementById('cov-m').textContent = '00';
            document.getElementById('cov-s').textContent = '00';
            return;
        }
        const d = Math.floor(diff / (1000 * 60 * 60 * 24));
        const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const s = Math.floor((diff % (1000 * 60)) / 1000);
        document.getElementById('cov-d').textContent = d;
        document.getElementById('cov-h').textContent = String(h).padStart(2,'0');
        document.getElementById('cov-m').textContent = String(m).padStart(2,'0');
        document.getElementById('cov-s').textContent = String(s).padStart(2,'0');
    }
    tick();
    setInterval(tick, 1000);
}

// RSVP AJAX
const rsvpForm = document.getElementById('rsvpForm');
if(rsvpForm){
    rsvpForm.addEventListener('submit', function(e){
        e.preventDefault();
        const btn = document.getElementById('btnSubmitRsvp');
        const origText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span>Mengirimkan...</span>';

        const fd = new FormData(rsvpForm);
        fetch(rsvpForm.action, {
            method: 'POST',
            body: fd,
            headers: {'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json'}
        }).then(r => r.json()).then(data => {
            showToast('Konfirmasi & ucapan berhasil dikirim!');
            const feed = document.getElementById('wishesFeed');
            const empty = document.getElementById('wishesEmpty');
            if(empty) empty.remove();

            const name = fd.get('name');
            const message = fd.get('message');
            const newCard = document.createElement('div');
            newCard.className = 'p-3 rounded-3 mb-2';
            newCard.style.cssText = 'background:rgba(31,8,39,.6);border:1px solid rgba(244,114,182,.2)';
            newCard.innerHTML = `<div class="d-flex justify-content-between align-items-center mb-1"><span class="fw-bold text-sparkle small">${escapeHtml(name)}</span><span class="text-subtle" style="font-size:.7rem">Baru saja</span></div><p class="small text-readable mb-0">${escapeHtml(message)}</p>`;
            feed.prepend(newCard);

            const badge = document.getElementById('wishesBadge');
            if(badge){
                const cur = parseInt(badge.textContent) || 0;
                badge.textContent = (cur + 1) + ' Ucapan';
            }
            rsvpForm.reset();
            btn.disabled = false;
            btn.innerHTML = origText;
        }).catch(() => {
            showToast('Konfirmasi terkirim!');
            btn.disabled = false;
            btn.innerHTML = origText;
        });
    });
}

function escapeHtml(t){
    const d = document.createElement('div');
    d.textContent = t;
    return d.innerHTML;
}

// Scroll spy for dock
const sections = document.querySelectorAll('main section[id]');
const dockItems = document.querySelectorAll('.dock-item');
window.addEventListener('scroll', ()=>{
    let current = '';
    sections.forEach(sec => {
        const top = sec.offsetTop - 120;
        if(window.scrollY >= top) current = sec.getAttribute('id');
    });
    dockItems.forEach(item => {
        item.classList.remove('active');
        if(item.getAttribute('href') === '#' + current) item.classList.add('active');
    });
});
</script>
</body>
</html>
