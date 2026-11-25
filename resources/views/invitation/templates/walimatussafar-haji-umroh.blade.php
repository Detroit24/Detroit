@php
    use Illuminate\Support\Str;
    $c = $content ?? [];
    $guestName = $guestName ?? 'Bapak/Ibu/Saudara/i';
    $img = fn($p) => $p ? (Str::startsWith($p, ['http', '/']) ? $p : asset('storage/' . $p)) : null;

    // FOTO DEFAULT: Tema Walimatussafar Kaaba Emerald & Radiant Gold
    $ph = [
        'hero'  => 'https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?auto=format&fit=crop&q=85&w=1200',
        'host'  => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&crop=faces&q=85&w=800',
        'venue' => 'https://images.unsplash.com/photo-1519817650390-64a93db51149?auto=format&fit=crop&q=85&w=1200',
    ];
    $hero     = $img($c['hero_image'] ?? null) ?: $ph['hero'];
    $hostPic  = $img($c['host_photo'] ?? null) ?: $ph['host'];
    $venuePic = $img($c['venue_image'] ?? null) ?: $ph['venue'];

    $gallery = collect($c['gallery'] ?? [
        $ph['hero'],
        'https://images.unsplash.com/photo-1564769625905-50e93615e769?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1585036156171-384164a8c675?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1542816417-0983c9c9ad53?auto=format&fit=crop&q=80&w=800',
    ])->map($img)->filter()->values();

    $story = $c['story'] ?? [
        ['date' => 'Niat Suci', 'title' => 'Panggilan Baitullah', 'text' => 'Menjawab panggilan suci Allah SWT untuk menunaikan rukun Islam kelima ke tanah suci Makkah dan Madinah.'],
        ['date' => 'Tasyakuran & Pamitan', 'title' => 'Walimatussafar & Silaturahmi', 'text' => 'Memohon maaf lahir dan batin serta untaian doa restu dari sanak famili, kerabat, dan para sahabat.'],
        ['date' => 'Ibadah di Tanah Suci', 'title' => 'Meraih Haji & Umroh Mabrur', 'text' => 'Bermunajat di Multazam, Raudhah, dan Padang Arafah demi meraih ridho dan ampunan Allah SWT.'],
    ];

    $gifts = $c['gifts'] ?? [
        ['bank' => 'Bank Syariah Indonesia (BSI)', 'number' => ($c['bank_1_number'] ?? '7192019283'), 'name' => ($c['bank_1_holder'] ?? 'H. Sudirman (Calon Jama\'ah)')],
        ['bank' => 'Bank BCA', 'number' => ($c['bank_2_number'] ?? '8192837192'), 'name' => ($c['bank_2_holder'] ?? 'Hj. Marwah (Calon Jama\'ah)')],
    ];

    $music = $c['music_url'] ?? 'https://cdn.pixabay.com/download/audio/2022/05/27/audio_1808fbf07a.mp3?filename=romantic-wedding-piano-113004.mp3';

    $pilgrimName = $c['host_name'] ?? ($c['groom_name'] ?? 'Bpk. H. Sudirman & Ibu Hj. Marwah');
    if (empty($pilgrimName) || str_contains(strtolower($pilgrimName), 'walimatussafar') || str_contains(strtolower($pilgrimName), 'wedding')) {
        $pilgrimName = 'Bpk. H. Sudirman & Ibu Hj. Marwah';
    }

    $firstEvent = $invitation->events->first();
    $ev0 = $firstEvent?->event_date;
    $eventDateText = $ev0 ? $ev0->locale('id')->isoFormat('dddd, D MMMM YYYY') : 'Ahad, 26 April 2026';
    $venueName = $firstEvent?->location ?? 'Kediaman Keluarga / Gedung Serbaguna An-Nur, Jakarta Selatan';
    $mapsFor = fn($e) => ($e?->maps_url) ?: 'https://maps.google.com/?q=' . urlencode($e?->location ?? $venueName);

    $calUrl = null;
    if ($ev0) {
        $calUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE&text=' . urlencode('Walimatussafar Haji & Umroh ' . $pilgrimName)
            . '&dates=' . $ev0->format('Ymd') . '/' . $ev0->copy()->addDay()->format('Ymd') . '&location=' . urlencode($venueName);
    }
    $targetCountdown = $ev0 ? $ev0->format('Y-m-d') : '2026-04-26';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Walimatussafar Haji & Umroh {{ $pilgrimName }} - DETROIT</title>
<meta name="theme-color" content="#131B15">
<meta property="og:title" content="Walimatussafar Haji & Umroh {{ $pilgrimName }}">
<meta property="og:description" content="{{ $eventDateText }} di {{ $venueName }} - Mohon doa restu keberangkatan ibadah menuju Baitullah.">
<meta property="og:image" content="{{ $hero }}">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Cinzel:wght@600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
:root{
  --haji-bg:#131B15;
  --haji-card:#1A251D;
  --haji-panel:rgba(26,37,29,.88);
  --gold:#D4AF37;
  --gold-light:#FDE68A;
  --gold-glow:rgba(212,175,55,.35);
  --gold-btn:linear-gradient(135deg,#FBBF24 0%,#D4AF37 50%,#8E6C18 100%);
  --green:#22C55E;
  --cream:#F8FAFC;
  --muted:#A7B7AC;
  --line:rgba(212,175,55,.35);
}
*{box-sizing:border-box}
html{scroll-behavior:smooth;scroll-padding-top:80px}
body{
  margin:0;background:var(--haji-bg);color:var(--cream);font-family:'Plus Jakarta Sans',sans-serif;overflow-x:hidden;
  background-image:
    radial-gradient(circle at 50% 0,rgba(34,84,52,.65),transparent 65%),
    radial-gradient(circle at 100% 50%,rgba(20,55,34,.55),transparent 55%),
    linear-gradient(180deg,#17231A 0%,#0C120D 100%);
  background-attachment:fixed;
}
body.locked{overflow:hidden;height:100vh}
.font-cinzel{font-family:'Cinzel',serif}
.font-amiri{font-family:'Amiri',serif}
.text-gold{color:var(--gold)!important}
.text-gold-light{color:var(--gold-light)!important}
.text-readable{color:var(--cream)!important;line-height:1.7}
.text-subtle{color:var(--muted)!important;line-height:1.6}

/* Header */
.royal-header{
  position:fixed;inset:0 0 auto;z-index:999;padding:12px 20px;display:flex;align-items:center;justify-content:space-between;
  background:rgba(19,27,21,.92);backdrop-filter:blur(14px);border-bottom:1px solid rgba(212,175,55,.25);
}
.royal-brand{display:flex;flex-direction:column;align-items:center;color:var(--gold-light);text-decoration:none;letter-spacing:2px}
.royal-brand i{font-size:1.15rem;color:var(--gold)}
.royal-brand span{font-family:'Cinzel',serif;font-size:.82rem;font-weight:700}
.royal-nav-links{display:flex;gap:22px;list-style:none;margin:0;padding:0}
.royal-nav-links a{color:var(--muted);text-decoration:none;font-size:.84rem;font-weight:500;transition:color .2s}
.royal-nav-links a:hover{color:var(--gold-light)}
.btn-royal-share{
  border:1px solid var(--gold);border-radius:50px;padding:6px 18px;color:var(--gold-light);font-size:.8rem;
  background:rgba(212,175,55,.12);text-decoration:none;display:inline-flex;align-items:center;gap:6px;cursor:pointer;transition:.2s;
}
.btn-royal-share:hover{background:var(--gold);color:var(--haji-bg)!important}
.music-vinyl-btn{
  width:40px;height:40px;border-radius:50%;background:radial-gradient(circle,#283C2D,#141F17 65%,#0A100B);
  border:1.5px solid var(--gold);color:var(--gold-light);display:flex;align-items:center;justify-content:center;cursor:pointer;
}
.music-vinyl-btn.rotating{animation:spin 5s linear infinite}
@keyframes spin{to{transform:rotate(360deg)}}

.inv-shell{max-width:1040px;margin:0 auto;padding-bottom:110px;padding-top:80px}

/* Cover / Hero */
#openingCover{
  position:fixed;inset:0;z-index:10000;display:flex;align-items:center;justify-content:center;
  padding:clamp(12px,2.5vh,24px) clamp(12px,2.5vw,20px);overflow-y:auto;
  background:radial-gradient(circle at center,#1E2E21,#131B15 50%,#090E0B);
  transition:transform 1.2s cubic-bezier(.85,0,.15,1),opacity 1.2s;
}
#openingCover.opened{transform:translateY(-100%);opacity:0;pointer-events:none}
.hero-banner-card{
  background:radial-gradient(circle at 60% 40%,#243728,#17231A 75%,#0E1610);
  border:1.5px solid rgba(212,175,55,.45);border-radius:24px;
  box-shadow:0 25px 60px rgba(0,0,0,.65),inset 0 0 40px rgba(212,175,55,.12);
  position:relative;overflow:hidden;padding:clamp(20px,3vh,30px) clamp(16px,2.5vw,26px);
  width:100%;max-width:880px;margin:auto;
}
.corner-flourish{position:absolute;width:clamp(60px,10vw,110px);height:clamp(60px,10vw,110px);pointer-events:none;opacity:.6}
.corner-flourish.tl{top:-4px;left:-4px}.corner-flourish.tr{top:-4px;right:-4px;transform:scaleX(-1)}
.corner-flourish.bl{bottom:-4px;left:-4px;transform:scaleY(-1)}.corner-flourish.br{bottom:-4px;right:-4px;transform:scale(-1)}

.arch-photo-container{
  position:relative;width:100%;max-width:300px;margin:0 auto;border-radius:180px 180px 16px 16px;padding:6px;
  background:linear-gradient(180deg,#FDE68A,#D4AF37 50%,#544015);box-shadow:0 14px 34px rgba(0,0,0,.55);transition:box-shadow .4s;
}
.arch-photo-container:hover{box-shadow:0 18px 45px rgba(0,0,0,.6),0 0 35px rgba(212,175,55,.3)}
.arch-photo-inner{
  width:100%;height:390px;border-radius:174px 174px 10px 10px;background:#131B15 center 20%/cover no-repeat;
  position:relative;overflow:hidden;filter:contrast(1.04) saturate(1.08) brightness(1.02);
}
.arch-photo-inner::after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,transparent 72%,rgba(19,27,21,.75));pointer-events:none}

.arch-card-right{
  border:1px solid var(--line);background:rgba(26,37,29,.75);backdrop-filter:blur(10px);
  border-radius:170px 170px 20px 20px;padding:32px 22px 26px;text-align:center;position:relative;
  box-shadow:inset 0 0 30px rgba(212,175,55,.08);
}
.arch-card-right::before{content:"";position:absolute;inset:6px;border:1px dashed rgba(212,175,55,.3);border-radius:164px 164px 15px 15px;pointer-events:none}
.inv-subtitle{font-family:'Cinzel',serif;font-size:.78rem;letter-spacing:4px;color:var(--gold-light);font-weight:700;margin-bottom:4px}
.inv-title-main{font-family:'Amiri',serif;font-size:clamp(2.4rem,5.5vw,3.8rem);font-weight:700;line-height:1.1;margin:0 0 10px;color:var(--gold-light)}

.inv-date-hero{font-family:'Cinzel',serif;font-size:.95rem;letter-spacing:2px;color:#fff;font-weight:600;margin-bottom:3px}
.inv-venue-hero{font-size:.86rem;color:var(--gold);margin-bottom:8px;display:flex;align-items:center;justify-content:center;gap:5px}
.inv-quote-hero{font-style:italic;font-size:.86rem;max-width:320px;margin:0 auto 14px;line-height:1.5;color:var(--muted)}

.countdown-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:6px;max-width:300px;margin:0 auto 14px}
.countdown-tile{background:rgba(19,27,21,.88);border:1px solid rgba(212,175,55,.55);border-radius:10px;padding:6px 2px;box-shadow:0 4px 14px rgba(0,0,0,.35)}
.countdown-num{font-family:'Cinzel',serif;font-size:1.35rem;font-weight:700;color:var(--gold-light);line-height:1.1}
.countdown-lbl{font-size:.62rem;letter-spacing:1px;text-transform:uppercase;color:var(--muted);margin-top:2px;font-weight:600}

.guest-callout-box{background:rgba(19,27,21,.85);border:1px solid rgba(212,175,55,.45);border-radius:10px;padding:8px 14px;max-width:300px;margin:0 auto 16px}
.guest-label{color:var(--gold);font-size:.68rem;letter-spacing:1px;font-weight:600;margin-bottom:2px}
.guest-name{font-family:'Cinzel',serif;font-size:1.08rem;font-weight:700;color:#FFF8EB;overflow-wrap:anywhere}

.btn-gold-cta{
  background:var(--gold-btn);color:#131B15!important;font-family:'Cinzel',serif;font-weight:700;font-size:.82rem;letter-spacing:1.5px;text-transform:uppercase;
  border:0;border-radius:50px;padding:11px 34px;box-shadow:0 8px 25px rgba(212,175,55,.45);display:inline-flex;align-items:center;gap:8px;cursor:pointer;
  text-decoration:none;transition:all .3s cubic-bezier(.175,.885,.32,1.275);
}
.btn-gold-cta:hover{transform:translateY(-2px) scale(1.02);box-shadow:0 12px 30px rgba(212,175,55,.65)}
.btn-gold-cta:disabled{opacity:.7;transform:none}

/* Sections */
.inv-section-card{
  background:var(--haji-panel);backdrop-filter:blur(12px);border:1px solid var(--line);border-radius:24px;
  padding:45px 32px;margin-bottom:40px;box-shadow:0 16px 40px rgba(0,0,0,.35);
}
.sec-title{text-align:center;margin-bottom:32px}
.sec-title .sub{font-family:'Amiri',serif;font-size:1.25rem;color:var(--gold);font-weight:700}
.sec-title h2{font-family:'Cinzel',serif;font-size:clamp(2.2rem,4.5vw,3.2rem);color:var(--gold-light);margin:2px 0 14px;font-weight:700}
.sep-line{width:120px;height:1px;position:relative;margin:0 auto;background:linear-gradient(90deg,transparent,var(--gold),transparent)}
.sep-line::after{content:"";position:absolute;left:50%;top:50%;width:8px;height:8px;background:var(--gold);transform:translate(-50%,-50%) rotate(45deg);box-shadow:0 0 10px var(--gold-glow)}

.doa-box{
  background:linear-gradient(135deg,rgba(26,37,29,.92),rgba(17,25,19,.95));border:1.5px solid rgba(212,175,55,.45);
  border-radius:20px;padding:30px 24px;max-width:680px;margin:0 auto 36px;text-align:center;box-shadow:0 10px 30px rgba(0,0,0,.4);
}
.doa-bismillah{font-size:clamp(1.4rem,3.4vw,1.8rem);color:var(--gold-light);margin-bottom:14px;direction:rtl;font-family:'Amiri',serif}
.doa-text{font-size:clamp(.95rem,2vw,1.05rem);line-height:1.85;font-style:italic;margin-bottom:12px}
.doa-source{color:var(--gold);font-size:.9rem;letter-spacing:2px;font-weight:700}

.child-card{
  background:linear-gradient(180deg,rgba(32,48,36,.85),rgba(20,30,22,.85));border:1.5px solid rgba(212,175,55,.35);
  border-radius:20px;padding:34px 24px;max-width:580px;margin:0 auto;box-shadow:0 14px 34px rgba(0,0,0,.35);
}

.panel{background:rgba(26,37,29,.75);border:1px solid var(--line);border-radius:20px;padding:24px}
.chip-date{display:inline-block;font-size:.75rem;padding:4px 14px;border-radius:50px;color:var(--gold-light);background:rgba(212,175,55,.15);border:1px solid rgba(212,175,55,.4);margin-bottom:8px}
.timeline{border-left:2px solid rgba(212,175,55,.45);padding-left:26px;position:relative}
.timeline .dot{position:absolute;left:-8px;top:4px;width:14px;height:14px;border-radius:50%;background:var(--gold);box-shadow:0 0 10px var(--gold)}
.gal-item{aspect-ratio:1;cursor:pointer;position:relative;overflow:hidden;border-radius:14px;border:1px solid var(--line)}
.gal-item img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
.gal-item:hover img{transform:scale(1.06)}
.gal-item .ov{position:absolute;inset:0;background:rgba(0,0,0,.35);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity .25s}
.gal-item:hover .ov{opacity:1}

.form-control-haji{background:rgba(19,27,21,.85)!important;border:1px solid rgba(212,175,55,.45)!important;color:#fff!important;border-radius:10px;padding:12px 14px}
.form-control-haji::placeholder{color:var(--muted)!important}
.form-control-haji:focus{box-shadow:0 0 12px rgba(212,175,55,.4)!important;border-color:var(--gold)!important}
.radio-row{background:rgba(22,33,25,.7);border:1px solid rgba(255,255,255,.15)}

/* Dock */
.royal-dock{
  position:fixed;bottom:calc(16px + env(safe-area-inset-bottom,0px));left:50%;transform:translateX(-50%);width:calc(100% - 32px);max-width:480px;
  background:rgba(19,27,21,.95);backdrop-filter:blur(18px);border:1px solid rgba(212,175,55,.45);border-radius:50px;padding:8px 10px;
  display:flex;justify-content:space-around;box-shadow:0 12px 35px rgba(0,0,0,.65);z-index:990;
}
.dock-item{color:var(--muted);text-decoration:none;display:flex;flex-direction:column;align-items:center;gap:2px;padding:6px;border-radius:16px;background:transparent;border:0;font-size:.64rem;font-weight:500;transition:.2s}
.dock-item i{font-size:1.15rem;color:var(--gold);transition:.2s}
.dock-item:hover,.dock-item.active{color:#fff}
.dock-item.active{background:rgba(212,175,55,.15)}
.dock-item:hover i,.dock-item.active i{color:var(--gold-light);transform:scale(1.12)}

.toast-notif{
  position:fixed;top:75px;left:50%;transform:translate(-50%,-120px);background:var(--gold-btn);color:#131B15;padding:11px 26px;
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
  .inv-title-main{font-size:2.35rem}
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
    <a href="#home" class="royal-brand"><i class="bi bi-compass-fill"></i><span>DETROIT</span></a>
    <ul class="royal-nav-links">
        <li><a href="#home">Home</a></li><li><a href="#pilgrim">Jama'ah</a></li><li><a href="#story">Perjalanan</a></li>
        <li><a href="#event">Acara</a></li><li><a href="#gallery">Galeri</a></li><li><a href="#rsvp">Titip Doa</a></li>
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
                <svg class="corner-flourish {{ $pos }}" viewBox="0 0 100 100" fill="none" stroke="#D4AF37" stroke-width="1.2" aria-hidden="true">
                    <path d="M10 90 C10 40 40 10 90 10 M18 90 C18 45 45 18 90 18 M5 95 C5 35 35 5 95 5"/><circle cx="28" cy="28" r="4" fill="#D4AF37"/>
                </svg>
            @endforeach

            <div class="row align-items-center g-4">
                <div class="col-lg-5">
                    <div class="arch-photo-container"><div class="arch-photo-inner" style="background-image:url('{{ $hero }}')"></div></div>
                </div>
                <div class="col-lg-7">
                    <div class="arch-card-right">
                        <div class="inv-subtitle">WALIMATUSSAFAR HAJI &amp; UMROH</div>
                        <h1 class="inv-title-main">{{ $pilgrimName }}</h1>
                        <div class="inv-date-hero">{{ $eventDateText }}</div>
                        <div class="inv-venue-hero"><i class="bi bi-geo-alt-fill text-warning"></i><span>{{ $venueName }}</span></div>
                        <p class="inv-quote-hero">"Labbaikallahumma Labbaik, Labbaika Laa Syariika Laka Labbaik. Mohon doa restu keberangkatan kami ke Baitullah."</p>

                        <div class="countdown-grid" id="coverCountdown" data-date="{{ $targetCountdown }}">
                            <div class="countdown-tile"><div class="countdown-num" id="cov-d">0</div><div class="countdown-lbl">Hari</div></div>
                            <div class="countdown-tile"><div class="countdown-num" id="cov-h">00</div><div class="countdown-lbl">Jam</div></div>
                            <div class="countdown-tile"><div class="countdown-num" id="cov-m">00</div><div class="countdown-lbl">Menit</div></div>
                            <div class="countdown-tile"><div class="countdown-num" id="cov-s">00</div><div class="countdown-lbl">Detik</div></div>
                        </div>

                        <div class="guest-callout-box">
                            <div class="guest-label">Kepada Yth. Bapak/Ibu/Saudara/i</div>
                            <div class="guest-name">{{ $guestName }}</div>
                        </div>

                        <button type="button" class="btn-gold-cta" onclick="unlockInvitation()"><span>Buka Undangan</span><i class="bi bi-envelope-open-fill"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<main class="inv-shell px-3" id="home">

    <!-- JAMAAH -->
    <section class="inv-section-card" id="pilgrim">
        <div class="sec-title"><div class="sub">Calon Tamu Allah</div><h2>Jama'ah Haji & Umroh</h2><div class="sep-line"></div></div>

        <div class="doa-box">
            <div class="doa-bismillah" lang="ar">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</div>
            <p class="doa-text">"Mengharap kehadiran dan keikhlasan doa restu Bapak/Ibu/Saudara/i sekalian dalam rangka pelepasan keberangkatan kami menunaikan ibadah haji & umroh ke tanah suci."</p>
            <div class="doa-source">Assalamu'alaikum Warahmatullahi Wabarakatuh</div>
        </div>

        <div class="child-card text-center">
            <div class="arch-photo-container mb-3" style="max-width:200px">
                <div class="arch-photo-inner" style="height:250px;background-image:url('{{ $hostPic }}')"></div>
            </div>
            <h3 class="font-cinzel text-gold-light fw-bold fs-4 mb-2">{{ $pilgrimName }}</h3>
            <p class="text-readable small mb-0">Mohon dimaafkan atas segala khilaf dan salah kata maupun perbuatan.</p>
        </div>
    </section>

    <!-- SUSUNAN ACARA -->
    @if(count($story))
    <section class="inv-section-card" id="story">
        <div class="sec-title"><div class="sub">Rencana Perjalanan</div><h2>Tahapan Ibadah</h2><div class="sep-line"></div></div>
        <div class="row justify-content-center"><div class="col-lg-8">
            <div class="timeline">
                @foreach($story as $s)
                    <div class="position-relative mb-4 pb-2">
                        <span class="dot"></span>
                        <span class="chip-date">{{ $s['date'] ?? '' }}</span>
                        <h4 class="font-cinzel text-gold-light fs-5 mb-2 fw-bold">{{ $s['title'] ?? '' }}</h4>
                        <p class="text-readable small mb-0">{{ $s['text'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </div></div>
    </section>
    @endif

    <!-- ACARA -->
    <section class="inv-section-card" id="event">
        <div class="sec-title"><div class="sub">Waktu & Tempat</div><h2>Acara Walimatussafar</h2><div class="sep-line"></div></div>
        <div class="row g-4 justify-content-center">
            @forelse($invitation->events as $ev)
                <div class="col-md-6">
                    <div class="panel h-100 text-center">
                        <i class="bi bi-moon-stars text-gold fs-1 mb-2 d-inline-block"></i>
                        <h3 class="font-cinzel text-gold-light fs-4 fw-bold mb-2">{{ $ev->event_name }}</h3>
                        <p class="text-gold fw-semibold mb-1">{{ $ev->event_date?->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
                        <p class="text-subtle small mb-3"><i class="bi bi-clock me-1"></i>Pukul {{ $ev->event_time ?: '09:00 WIB' }} s/d Selesai</p>
                        <div class="p-3 rounded-3 mb-3" style="background:rgba(19,27,21,.6);border:1px solid rgba(212,175,55,.25)">
                            <div class="fw-bold text-gold-light small mb-1">{{ $ev->location }}</div>
                            <div class="text-subtle small">{{ $ev->description ?: 'Tasyakuran, tausiyah safar, doa pelepasan, dan santap berkah bersama.' }}</div>
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
                        <h3 class="font-cinzel text-gold-light fs-4 fw-bold mb-2">Tasyakuran Walimatussafar</h3>
                        <p class="text-gold fw-semibold mb-1">{{ $eventDateText }}</p>
                        <p class="text-subtle small mb-3">Pukul 09.00 WIB s/d Selesai</p>
                        <p class="text-readable small">{{ $venueName }}</p>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- GALERI -->
    @if(count($gallery))
    <section class="inv-section-card" id="gallery">
        <div class="sec-title"><div class="sub">Kenangan Manis</div><h2>Galeri Foto</h2><div class="sep-line"></div></div>
        <div class="row g-3">
            @foreach($gallery as $idx => $g)
                <div class="col-6 col-md-3">
                    <div class="gal-item" onclick="openLightbox('{{ $g }}')">
                        <img src="{{ $g }}" alt="Foto Walimatussafar {{ $idx + 1 }}" loading="lazy">
                        <div class="ov"><i class="bi bi-zoom-in fs-3 text-gold-light"></i></div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- TANDA KASIH -->
    @if(count($gifts))
    <section class="inv-section-card" id="gift">
        <div class="sec-title"><div class="sub">Infaq & Tanda Kasih</div><h2>Amplop Digital</h2><div class="sep-line"></div></div>
        <p class="text-center text-subtle small max-w-md mx-auto mb-4" style="max-width:560px">Untaian doa Anda merupakan bekal terindah bagi kami. Namun jika hendak menitipkan tanda kasih atau infaq shadaqah, dapat melalui:</p>
        <div class="row g-3 justify-content-center">
            @foreach($gifts as $gf)
                <div class="col-md-5">
                    <div class="panel text-center h-100">
                        <i class="bi bi-wallet2 text-gold fs-2 mb-2 d-inline-block"></i>
                        <h4 class="font-cinzel text-gold-light fs-5 mb-1">{{ $gf['bank'] }}</h4>
                        <div class="font-monospace fs-5 text-cream fw-bold my-2">{{ $gf['number'] }}</div>
                        <div class="text-subtle small mb-3">a.n {{ $gf['name'] }}</div>
                        <button type="button" class="btn btn-sm btn-outline-warning rounded-pill px-3 js-copy" data-copy="{{ $gf['number'] }}"><i class="bi bi-copy me-1"></i>Salin Rekening</button>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- RSVP & TITIP DOA -->
    <section class="inv-section-card" id="rsvp">
        <div class="sec-title"><div class="sub">Konfirmasi Hadir</div><h2>Kehadiran & Titip Doa</h2><div class="sep-line"></div></div>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-6">
                <div class="panel">
                    <h4 class="font-cinzel text-gold-light fs-5 mb-3"><i class="bi bi-envelope-paper me-2"></i>Konfirmasi & Titip Doa</h4>
                    <form id="rsvpForm" action="{{ route('invitation.rsvp', $invitation->slug) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small text-gold fw-semibold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control form-control-haji" value="{{ $guestName !== 'Bapak/Ibu/Saudara/i' ? $guestName : '' }}" placeholder="Nama Anda" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-gold fw-semibold">Rencana Kehadiran</label>
                            <div class="d-flex gap-3">
                                <label class="radio-row flex-fill p-2 rounded-3 text-center cursor-pointer"><input type="radio" name="attendance" value="yes" checked class="me-1"><span class="small">Insya Allah Hadir</span></label>
                                <label class="radio-row flex-fill p-2 rounded-3 text-center cursor-pointer"><input type="radio" name="attendance" value="no" class="me-1"><span class="small">Berhalangan</span></label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-gold fw-semibold">Jumlah Tamu</label>
                            <select name="total_guests" class="form-select form-control-haji">
                                <option value="1">1 Orang</option><option value="2">2 Orang</option><option value="3">3 Orang</option><option value="4">4 Orang</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-gold fw-semibold">Titipan Doa di Tanah Suci</label>
                            <textarea name="message" rows="3" class="form-control form-control-haji" placeholder="Tuliskan titipan doa Anda untuk dimunajatkan di Baitullah..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-gold-cta w-100 justify-content-center" id="btnSubmitRsvp"><span>Kirim Doa & Konfirmasi</span><i class="bi bi-send-fill"></i></button>
                    </form>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="panel h-100 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="font-cinzel text-gold-light fs-5 mb-0"><i class="bi bi-chat-quote me-2"></i>Daftar Titipan Doa</h4>
                        <span class="badge rounded-pill bg-warning text-dark px-3 py-1 fw-bold" id="wishesBadge">{{ $invitation->messages->count() }} Doa</span>
                    </div>
                    <div class="flex-grow-1 overflow-auto pe-2" id="wishesFeed" style="max-height:420px">
                        @forelse($invitation->messages as $msg)
                            <div class="p-3 rounded-3 mb-2" style="background:rgba(19,27,21,.6);border:1px solid rgba(212,175,55,.2)">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold text-gold-light small">{{ $msg->name }}</span>
                                    <span class="text-subtle" style="font-size:.7rem">{{ $msg->created_at?->diffForHumans() }}</span>
                                </div>
                                <p class="small text-readable mb-0">{{ $msg->message }}</p>
                            </div>
                        @empty
                            <div class="text-center py-5 text-subtle" id="wishesEmpty">
                                <i class="bi bi-chat-heart fs-1 d-block mb-2 text-gold"></i>Jadilah yang pertama menitipkan doa di tanah suci!
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PENUTUP -->
    <section class="inv-section-card text-center" id="closing">
        <i class="bi bi-compass-fill text-gold display-4 mb-3 d-inline-block"></i>
        <h3 class="font-cinzel text-gold-light fs-3 mb-3">Jazakumullahu Khairan Katsiran</h3>
        <p class="text-readable mx-auto mb-4" style="max-width:580px">Terima kasih atas segala keikhlasan, doa, dan persaudaraan yang terjalin. Semoga Allah memudahkan langkah kita semua untuk berziarah ke Baitullah.</p>
        <p class="font-amiri fs-4 text-gold mb-4">وَالسَّلاَمُ عَلَيْكُمْ وَرَحْمَةُ اللهِ وَبَرَكَاتُهُ</p>
        <p class="text-subtle small mb-0">{{ $pilgrimName }} sekeluarga</p>
    </section>
</main>

<!-- BOTTOM DOCK -->
<nav class="royal-dock">
    <a href="#home" class="dock-item active"><i class="bi bi-house-door-fill"></i><span>Home</span></a>
    <a href="#pilgrim" class="dock-item"><i class="bi bi-person-fill"></i><span>Jama'ah</span></a>
    <a href="#event" class="dock-item"><i class="bi bi-calendar-event-fill"></i><span>Acara</span></a>
    <a href="#gallery" class="dock-item"><i class="bi bi-images"></i><span>Galeri</span></a>
    <a href="#rsvp" class="dock-item"><i class="bi bi-envelope-check-fill"></i><span>Titip Doa</span></a>
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
                text: 'Undangan Walimatussafar {{ $pilgrimName }}',
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
    const target = new Date(cdWrap.getAttribute('data-date') + 'T09:00:00').getTime();
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
            showToast('Konfirmasi & doa berhasil dikirim!');
            const feed = document.getElementById('wishesFeed');
            const empty = document.getElementById('wishesEmpty');
            if(empty) empty.remove();

            const name = fd.get('name');
            const message = fd.get('message');
            const newCard = document.createElement('div');
            newCard.className = 'p-3 rounded-3 mb-2';
            newCard.style.cssText = 'background:rgba(19,27,21,.6);border:1px solid rgba(212,175,55,.2)';
            newCard.innerHTML = `<div class="d-flex justify-content-between align-items-center mb-1"><span class="fw-bold text-gold-light small">${escapeHtml(name)}</span><span class="text-subtle" style="font-size:.7rem">Baru saja</span></div><p class="small text-readable mb-0">${escapeHtml(message)}</p>`;
            feed.prepend(newCard);

            const badge = document.getElementById('wishesBadge');
            if(badge){
                const cur = parseInt(badge.textContent) || 0;
                badge.textContent = (cur + 1) + ' Doa';
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
