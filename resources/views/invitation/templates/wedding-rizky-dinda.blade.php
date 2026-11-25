@php
    use Illuminate\Support\Str;
    $c = $content ?? [];
    $guestName = $guestName ?? 'Tamu Undangan';
    $img = fn($p) => $p ? (Str::startsWith($p, ['http', '/']) ? $p : asset('storage/' . $p)) : null;

    // FOTO DEFAULT: Tema Champagne / Floral Elegance (Rizky & Dinda)
    $ph = [
        'hero'  => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=85&w=1400',
        'groom' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=85&w=900',
        'bride' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=85&w=900',
        'venue' => 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&q=85&w=1400',
    ];
    $hero     = $img($c['hero_image'] ?? null) ?: $ph['hero'];
    $groomPic = $img($c['groom_photo'] ?? null) ?: $ph['groom'];
    $bridePic = $img($c['bride_photo'] ?? null) ?: $ph['bride'];
    $venuePic = $img($c['venue_image'] ?? null) ?: $ph['venue'];

    $gallery = collect($c['gallery'] ?? [
        $ph['hero'],
        'https://images.unsplash.com/photo-1583939003579-730e3918a45a?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1606800052052-a08af7148866?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1520854221256-17451cc331bf?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1469371670807-013ccf25f16a?auto=format&fit=crop&q=80&w=800',
    ])->map($img)->filter()->values();

    $story = $c['story'] ?? [
        ['date' => '14 Februari 2022', 'title' => 'Pertemuan Pertama', 'text' => 'Sebuah takdir manis mempertemukan kami di sebuah acara silaturahmi sahabat, di mana senyuman pertama menjadi titik awal dari perjalanan indah ini.'],
        ['date' => '20 Agustus 2023', 'title' => 'Mengikat Janji (Lamaran)', 'text' => 'Dengan doa dan restu dari kedua keluarga tercinta, kami memantapkan niat suci melangkah menuju ikatan pernikahan.'],
        ['date' => '14 Desember 2024', 'title' => 'Menuju Hari Bahagia', 'text' => 'Hari di mana dua insan dipersatukan dalam ikrar suci pernikahan yang kekal, penuh keberkahan dan kebahagiaan.'],
    ];

    $gifts = $c['gifts'] ?? [
        ['bank' => 'Bank BCA', 'number' => ($c['bank_1_number'] ?? '7410293847'), 'name' => ($c['bank_1_holder'] ?? 'Rizky Pratama')],
        ['bank' => 'Bank Mandiri', 'number' => ($c['bank_2_number'] ?? '1370019283712'), 'name' => ($c['bank_2_holder'] ?? 'Dinda Kirana')],
    ];

    $music = $c['music_url'] ?? 'https://cdn.pixabay.com/download/audio/2022/05/27/audio_1808fbf07a.mp3?filename=romantic-wedding-piano-113004.mp3';

    $ytId = fn($u) => preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|shorts/))([\w-]{11})~', $u, $m) ? $m[1] : null;
    $videos = collect($c['videos'] ?? [])->map(function ($v) use ($ytId, $img) {
        $v = is_string($v) ? ['url' => $v] : $v;
        $id = $ytId($v['url'] ?? '');
        return ['title' => $v['title'] ?? '', 'yt' => $id, 'src' => $id ? null : $img($v['url'] ?? null),
                'poster' => $id ? "https://img.youtube.com/vi/$id/hqdefault.jpg" : $img($v['poster'] ?? null)];
    })->filter(fn($v) => $v['yt'] || $v['src'])->values();

    $wa = preg_replace('/\D/', '', $c['wa_number'] ?? '6281234567890');
    $firstEvent = $invitation->events->first();

    $groomName = $c['groom_name'] ?? 'Rizky';
    $brideName = $c['bride_name'] ?? 'Dinda';
    if (empty($groomName) || empty($brideName) || $groomName === $brideName
        || str_contains(strtolower($groomName), 'wedding') || (strtolower($groomName) === strtolower($brideName))) {
        $groomName = 'Rizky'; $brideName = 'Dinda';
    }
    $coupleTitle = $groomName . ' & ' . $brideName;

    $ev0 = $firstEvent?->event_date;
    $deadline = $c['rsvp_deadline'] ?? ($ev0 ? $ev0->copy()->subDays(14)->locale('id')->isoFormat('D MMMM YYYY') : '1 Desember 2024');
    $eventDateText = $ev0 ? $ev0->locale('id')->isoFormat('dddd, D MMMM YYYY') : 'Sabtu, 14 Desember 2024';
    $venueName = $firstEvent?->location ?? 'Grand Ballroom Hotel Mulia, Jakarta';
    $mapsFor = fn($e) => ($e?->maps_url) ?: 'https://maps.google.com/?q=' . urlencode($e?->location ?? $venueName);

    $calUrl = null;
    if ($ev0) {
        $calUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE&text=' . urlencode('Pernikahan ' . $coupleTitle)
            . '&dates=' . $ev0->format('Ymd') . '/' . $ev0->copy()->addDay()->format('Ymd') . '&location=' . urlencode($venueName);
    }
    $targetCountdown = $ev0 ? $ev0->format('Y-m-d') : '2024-12-14';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>The Wedding of {{ $coupleTitle }} - DETROIT Floral Elegance</title>
<meta name="theme-color" content="#FAF5EE">
<meta property="og:title" content="Undangan Pernikahan {{ $coupleTitle }}">
<meta property="og:description" content="{{ $eventDateText }} di {{ $venueName }} - Kami mengundang Anda untuk hadir.">
<meta property="og:image" content="{{ $hero }}">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600&family=Pinyon+Script&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
:root{
  --cream-bg:#FAF5EE;
  --cream-paper:#FCFAF6;
  --card-bg:#FFFFFF;
  --brown-dark:#332115;
  --brown-base:#5A3827;
  --brown-soft:#7A533E;
  --tan:#9C7351;
  --gold:#C89D56;
  --gold-light:#EED7AA;
  --gold-glow:rgba(200,157,86,.35);
  --gold-grad:linear-gradient(135deg,#DFBE82 0%,#C89D56 50%,#9E7432 100%);
  --gold-btn:linear-gradient(135deg,#B5885C 0%,#94683E 50%,#6E4624 100%);
  --text-gold:#C89D56;
  --cream:#332115;
  --muted:#7A5D4C;
  --line:rgba(156,115,81,.3);
  --panel:rgba(255,255,255,.94);
}
*{box-sizing:border-box}
html{scroll-behavior:smooth;scroll-padding-top:80px}
body{
  margin:0;
  background:var(--cream-bg);
  color:var(--cream);
  font-family:'Plus Jakarta Sans',sans-serif;
  overflow-x:hidden;
  background-image:
    radial-gradient(circle at 10% 20%,rgba(229,214,190,.45) 0%,transparent 40%),
    radial-gradient(circle at 90% 80%,rgba(200,157,86,.25) 0%,transparent 45%),
    linear-gradient(180deg,#FCFAF6 0%,#F5ECE0 50%,#ECE1D1 100%);
  background-attachment:fixed;
}
body.locked{overflow:hidden;height:100vh}
.font-cinzel{font-family:'Cinzel',serif}
.font-serif{font-family:'Cormorant Garamond',Georgia,serif}
.text-gold{color:var(--text-gold)!important}
.text-cream{color:var(--brown-dark)!important}
.text-readable{color:var(--brown-dark)!important;line-height:1.7}
.text-subtle{color:var(--muted)!important;line-height:1.6}
.text-gold-gradient{background:var(--gold-grad);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;display:inline-block}
a:focus-visible,button:focus-visible,input:focus-visible,select:focus-visible,textarea:focus-visible{outline:2px solid var(--tan);outline-offset:3px}

/* Header */
.royal-header{
  position:fixed;inset:0 0 auto;z-index:999;padding:12px 22px;display:flex;align-items:center;justify-content:space-between;
  background:rgba(252,250,246,.94);backdrop-filter:blur(14px);border-bottom:1px solid rgba(156,115,81,.22);
  box-shadow:0 4px 20px rgba(58,36,24,.05);
}
.royal-brand{display:flex;flex-direction:column;align-items:center;color:var(--brown-dark);text-decoration:none;letter-spacing:2.5px}
.royal-brand i{font-size:1.15rem;color:var(--gold)}
.royal-brand span{font-family:'Cinzel',serif;font-size:.85rem;font-weight:700;color:var(--brown-dark)}
.royal-nav-links{display:flex;gap:22px;list-style:none;margin:0;padding:0}
.royal-nav-links a{color:var(--brown-soft);text-decoration:none;font-size:.86rem;font-weight:600;transition:color .2s}
.royal-nav-links a:hover{color:var(--gold)}
.btn-royal-share{
  border:1px solid var(--tan);border-radius:50px;padding:6px 18px;color:var(--brown-base);font-size:.8rem;
  background:rgba(200,157,86,.12);text-decoration:none;display:inline-flex;align-items:center;gap:6px;
  font-weight:600;cursor:pointer;transition:.2s;
}
.btn-royal-share:hover{background:var(--brown-base);color:#FFFFFF!important}
.music-vinyl-btn{
  width:40px;height:40px;border-radius:50%;background:radial-gradient(circle,#2A1A10,#0E0E0E 65%,#2A1A10);
  border:1.5px solid var(--tan);color:var(--gold-light);display:flex;align-items:center;justify-content:center;cursor:pointer;
  box-shadow:0 4px 15px rgba(58,34,22,.25);
}
.music-vinyl-btn.rotating{animation:spin 5s linear infinite}
@keyframes spin{to{transform:rotate(360deg)}}

.inv-shell{max-width:1040px;margin:0 auto;padding-bottom:110px;padding-top:80px}

/* Cover / Hero */
#openingCover{
  position:fixed;inset:0;z-index:10000;display:flex;align-items:center;justify-content:center;
  padding:clamp(12px,2.5vh,24px) clamp(12px,2.5vw,20px);overflow-y:auto;
  background:radial-gradient(ellipse 90% 60% at 50% 0%,rgba(229,214,190,.75),transparent 70%),var(--cream-bg);
  transition:transform 1.2s cubic-bezier(.85,0,.15,1),opacity 1.2s;
}
#openingCover.opened{transform:translateY(-100%);opacity:0;pointer-events:none}
.hero-banner-card{
  background:radial-gradient(circle at 60% 30%,#FFFFFF 0%,#FCF8F2 65%,#F5ECE0 100%);
  border:1.5px solid rgba(200,157,86,.45);border-radius:24px;
  box-shadow:0 25px 60px rgba(58,34,22,.14),inset 0 0 40px rgba(229,214,190,.35);
  position:relative;overflow:hidden;padding:clamp(20px,3vh,30px) clamp(16px,2.5vw,26px);
  width:100%;max-width:880px;margin:auto;
}
.corner-flourish{position:absolute;width:clamp(60px,10vw,110px);height:clamp(60px,10vw,110px);pointer-events:none;opacity:.6}
.corner-flourish.tl{top:-4px;left:-4px}.corner-flourish.tr{top:-4px;right:-4px;transform:scaleX(-1)}
.corner-flourish.bl{bottom:-4px;left:-4px;transform:scaleY(-1)}.corner-flourish.br{bottom:-4px;right:-4px;transform:scale(-1)}

.arch-photo-container{
  position:relative;width:100%;max-width:300px;margin:0 auto;border-radius:180px 180px 16px 16px;padding:6px;
  background:linear-gradient(180deg,#F3E1B6,#C89D56 50%,#9C7351);box-shadow:0 14px 34px rgba(58,34,22,.18);
  transition:box-shadow .4s;
}
.arch-photo-container:hover{box-shadow:0 18px 45px rgba(58,34,22,.25),0 0 35px rgba(200,157,86,.3)}
.arch-photo-inner{
  width:100%;height:390px;border-radius:174px 174px 10px 10px;background:#F6EDE2 center 20%/cover no-repeat;
  position:relative;overflow:hidden;filter:contrast(1.04) saturate(1.06) brightness(1.02);
}
.arch-photo-inner::before{
  content:"";position:absolute;inset:0;z-index:1;pointer-events:none;opacity:.12;mix-blend-mode:overlay;
  background-image:url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='160' height='160'><filter id='n'><feTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='2' stitchTiles='stitch'/></filter><rect width='100%' height='100%' filter='url(%23n)'/></svg>");
}
.arch-photo-inner::after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,transparent 72%,rgba(58,34,22,.35));pointer-events:none}

.arch-card-right{
  border:1px solid rgba(156,115,81,.35);background:rgba(255,255,255,.9);backdrop-filter:blur(10px);
  border-radius:170px 170px 20px 20px;padding:32px 22px 26px;text-align:center;position:relative;
  box-shadow:0 10px 30px rgba(58,34,22,.08),inset 0 0 30px rgba(229,214,190,.2);
}
.arch-card-right::before{content:"";position:absolute;inset:6px;border:1px dashed rgba(156,115,81,.35);border-radius:164px 164px 15px 15px;pointer-events:none}
.wedding-subtitle{font-family:'Cinzel',serif;font-size:.78rem;letter-spacing:4px;color:var(--tan);font-weight:700;margin-bottom:4px}

.couple-name-hero{display:flex;flex-direction:column;align-items:center;gap:2px;margin:0 0 10px}
.cn-name{
  font-family:'Pinyon Script',cursive;font-size:clamp(2.5rem,5.5vw,4.2rem);line-height:1.02;
  background:linear-gradient(100deg,#A87948 0%,#C89D56 40%,#5A3827 80%,#A87948 100%);background-size:220% 100%;
  -webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;
  filter:drop-shadow(0 3px 10px rgba(156,115,81,.25));animation:goldSweep 2.6s ease-out .6s 1 both;
}
@keyframes goldSweep{from{background-position:100% 0}to{background-position:0 0}}
.cn-amp{display:flex;align-items:center;gap:10px;font-family:'Cormorant Garamond',serif;font-style:italic;font-weight:600;font-size:1.4rem;color:var(--gold);line-height:1;margin:2px 0}
.cn-amp::before,.cn-amp::after{content:"";width:34px;height:1px;background:linear-gradient(90deg,transparent,var(--tan))}
.cn-amp::after{transform:scaleX(-1)}

.wedding-date-hero{font-family:'Cinzel',serif;font-size:.95rem;letter-spacing:2px;color:var(--brown-base);font-weight:700;margin-bottom:3px}
.wedding-venue-hero{font-size:.86rem;color:var(--brown-soft);margin-bottom:8px;display:flex;align-items:center;justify-content:center;gap:5px;font-weight:500}
.wedding-quote-hero{font-style:italic;font-size:.86rem;color:var(--brown-soft);max-width:320px;margin:0 auto 14px;line-height:1.5}

.countdown-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:6px;max-width:300px;margin:0 auto 14px}
.countdown-tile{background:#FFFFFF;border:1px solid rgba(156,115,81,.45);border-radius:10px;padding:6px 2px;box-shadow:0 4px 14px rgba(58,34,22,.08)}
.countdown-num{font-family:'Cormorant Garamond',serif;font-size:1.5rem;font-weight:700;color:var(--brown-dark);line-height:1}
.countdown-lbl{font-size:.62rem;letter-spacing:1px;text-transform:uppercase;color:var(--tan);margin-top:2px;font-weight:700}

.guest-callout-box{background:#FFFFFF;border:1px solid rgba(156,115,81,.4);border-radius:10px;padding:8px 14px;max-width:300px;margin:0 auto 16px;box-shadow:0 4px 15px rgba(58,34,22,.06)}
.guest-label{color:var(--tan);font-size:.68rem;letter-spacing:1px;text-transform:uppercase;font-weight:700;margin-bottom:2px}
.guest-name{font-family:'Cormorant Garamond',serif;font-size:1.15rem;font-weight:700;color:var(--brown-dark);overflow-wrap:anywhere}

.btn-gold-cta{
  background:var(--gold-btn);color:#FFFFFF!important;font-family:'Cinzel',serif;font-weight:700;font-size:.82rem;letter-spacing:1.5px;text-transform:uppercase;
  border:0;border-radius:50px;padding:11px 34px;box-shadow:0 8px 25px rgba(90,56,39,.35);display:inline-flex;align-items:center;gap:8px;cursor:pointer;
  text-decoration:none;transition:all .3s cubic-bezier(.175,.885,.32,1.275);
}
.btn-gold-cta:hover{transform:translateY(-2px) scale(1.02);box-shadow:0 12px 30px rgba(90,56,39,.5)}
.btn-gold-cta:disabled{opacity:.7;transform:none}

/* Sections */
.inv-section-card{
  background:rgba(255,255,255,.9);backdrop-filter:blur(12px);border:1px solid rgba(156,115,81,.28);
  border-radius:24px;padding:45px 32px;margin-bottom:40px;box-shadow:0 15px 40px rgba(58,34,22,.08);
}
.sec-title{text-align:center;margin-bottom:32px}
.sec-title .sub{font-family:'Cormorant Garamond',serif;font-style:italic;font-size:1.15rem;color:var(--tan);font-weight:600}
.sec-title h2{font-family:'Pinyon Script',cursive;font-size:clamp(3rem,5.5vw,4rem);color:var(--brown-dark);margin:2px 0 14px;line-height:1}
.sep-line{width:120px;height:1px;position:relative;margin:0 auto;background:linear-gradient(90deg,transparent,var(--tan),transparent)}
.sep-line::after{content:"";position:absolute;left:50%;top:50%;width:8px;height:8px;background:var(--tan);transform:translate(-50%,-50%) rotate(45deg);box-shadow:0 0 10px var(--gold-glow)}

.quran-box{
  background:#FFFFFF;border:1.5px solid rgba(156,115,81,.35);border-radius:20px;padding:30px 24px;
  max-width:680px;margin:0 auto 36px;text-align:center;box-shadow:0 10px 30px rgba(58,34,22,.06),inset 0 0 25px rgba(229,214,190,.2);
}
.quran-bismillah{font-size:clamp(1.4rem,3.4vw,1.8rem);color:var(--gold);margin-bottom:14px;direction:rtl;font-weight:700}
.quran-text{font-size:clamp(.95rem,2vw,1.05rem);line-height:1.85;font-style:italic;margin-bottom:12px;color:var(--brown-dark)}
.quran-surah{color:var(--tan);font-size:.9rem;letter-spacing:2px;font-weight:700;text-transform:uppercase}

.couple-card{
  background:#FFFFFF;border:1.5px solid rgba(156,115,81,.25);border-radius:20px;padding:30px 20px;height:100%;
  box-shadow:0 14px 34px rgba(58,34,22,.06);transition:transform .3s,border-color .3s;
}
.couple-card:hover{transform:translateY(-4px);border-color:rgba(156,115,81,.6)}
.couple-role{font-family:'Cormorant Garamond',serif;font-style:italic;font-size:1.15rem;color:var(--tan);margin-bottom:2px;font-weight:600}
.couple-name{font-family:'Cormorant Garamond',serif;font-weight:700;font-size:2rem;letter-spacing:.5px;margin-bottom:8px;color:var(--brown-dark)}
.amp-mark{font-family:'Cormorant Garamond',serif;font-style:italic;font-weight:600;font-size:clamp(3rem,6vw,4.5rem);color:var(--tan);line-height:1}

.panel{background:var(--panel);border:1px solid rgba(156,115,81,.25);border-radius:20px;padding:24px;box-shadow:0 8px 24px rgba(58,34,22,.04)}
.chip-date{display:inline-block;font-size:.75rem;padding:4px 14px;border-radius:50px;color:var(--brown-dark);background:rgba(200,157,86,.15);border:1px solid rgba(156,115,81,.35);margin-bottom:8px;font-weight:700}
.timeline{border-left:2px solid rgba(156,115,81,.45);padding-left:26px;position:relative}
.timeline .dot{position:absolute;left:-8px;top:4px;width:14px;height:14px;border-radius:50%;background:var(--tan);box-shadow:0 0 10px var(--gold-glow)}
.gal-item{aspect-ratio:1;cursor:pointer;position:relative;overflow:hidden;border-radius:14px;border:1px solid rgba(156,115,81,.25);box-shadow:0 4px 14px rgba(58,34,22,.06)}
.gal-item img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
.gal-item:hover img{transform:scale(1.06)}
.gal-item .ov{position:absolute;inset:0;background:rgba(58,34,22,.35);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity .25s}
.gal-item:hover .ov{opacity:1}

.form-control-floral{background:#FFFFFF!important;border:1px solid rgba(156,115,81,.4)!important;color:var(--brown-dark)!important;border-radius:10px;padding:12px 14px}
.form-control-floral::placeholder{color:#A98C77!important}
.form-control-floral:focus{box-shadow:0 0 12px rgba(156,115,81,.25)!important;border-color:var(--brown-base)!important}
.radio-row{background:var(--cream-bg);border:1px solid rgba(156,115,81,.25)}

/* Dock */
.royal-dock{
  position:fixed;bottom:calc(16px + env(safe-area-inset-bottom,0px));left:50%;transform:translateX(-50%);width:calc(100% - 32px);max-width:480px;
  background:linear-gradient(180deg,#5E3B28,#3A2216);backdrop-filter:blur(18px);border:1px solid rgba(229,214,190,.35);
  border-radius:50px;padding:8px 10px;display:flex;justify-content:space-around;
  box-shadow:0 12px 35px rgba(58,34,22,.45);z-index:990;
}
.dock-item{color:#F5E9D6;text-decoration:none;display:flex;flex-direction:column;align-items:center;gap:2px;padding:6px;border-radius:16px;background:transparent;border:0;font-size:.64rem;font-weight:600;transition:.2s}
.dock-item i{font-size:1.15rem;color:var(--gold-light);transition:.2s}
.dock-item:hover,.dock-item.active{color:#fff;background:rgba(255,255,255,.15)}
.dock-item:hover i,.dock-item.active i{color:#fff;transform:scale(1.12)}

.toast-notif{
  position:fixed;top:75px;left:50%;transform:translate(-50%,-120px);background:var(--brown-dark);color:#FFF6E8;
  padding:11px 26px;border-radius:50px;font-weight:700;font-size:.9rem;z-index:10005;transition:transform .4s;
  box-shadow:0 8px 24px rgba(58,34,22,.4);
}
.toast-notif.show{transform:translate(-50%,0)}

@media(max-width:991px){
  .royal-nav-links{display:none}
  .hero-banner-card{padding:22px 16px;max-width:440px;margin:0 auto;border-radius:22px}
  .arch-photo-container{max-width:180px;margin:0 auto 12px;border-radius:100px 100px 14px 14px;padding:4px}
  .arch-photo-inner{height:190px;border-radius:96px 96px 10px 10px;background-position:center 20%!important}
  .arch-card-right{border:0;background:transparent;box-shadow:none;padding:6px 0 0;border-radius:0}
  .arch-card-right::before{display:none}
  .countdown-grid{max-width:280px;gap:5px;margin-bottom:12px}.countdown-num{font-size:1.35rem}
  .guest-callout-box{max-width:280px;padding:7px 12px;margin-bottom:14px}
  .inv-section-card{padding:30px 18px}
}
@media(max-width:576px){
  #openingCover{padding:12px 10px}
  .hero-banner-card{padding:18px 12px;border-radius:18px;max-width:390px}
  .arch-photo-container{max-width:150px;margin-bottom:8px;border-radius:85px 85px 12px 12px;padding:3px}
  .arch-photo-inner{height:165px;border-radius:82px 82px 8px 8px}
  .wedding-subtitle{font-size:.72rem;letter-spacing:3px;margin-bottom:2px}
  .cn-name{font-size:2.35rem}
  .wedding-date-hero{font-size:.88rem;margin-bottom:2px}
  .wedding-venue-hero{font-size:.82rem;margin-bottom:5px}
  .wedding-quote-hero{font-size:.8rem;line-height:1.4;margin-bottom:10px}
  .countdown-grid{max-width:260px;gap:4px;margin-bottom:10px}.countdown-num{font-size:1.25rem}.countdown-lbl{font-size:.56rem;letter-spacing:1px}
  .guest-callout-box{max-width:260px;padding:6px 10px;margin-bottom:12px}
  .guest-name{font-size:1.05rem}
  .btn-gold-cta{padding:9px 26px;font-size:.78rem;width:100%;max-width:240px;justify-content:center}
  .royal-dock{width:calc(100% - 16px);padding:5px 3px;bottom:calc(10px + env(safe-area-inset-bottom,0px))}
  .dock-item{font-size:.54rem;padding:3px 2px}.dock-item i{font-size:1rem}
  .inv-section-card{padding:24px 12px;border-radius:16px;margin-bottom:20px}
  .sec-title h2{font-size:2.6rem}
}
@media(prefers-reduced-motion:reduce){
  .cn-name,.music-vinyl-btn.rotating{animation:none}
  html{scroll-behavior:auto}
  #openingCover{transition:opacity .3s}
}
</style>
</head>
<body class="locked">

<div class="toast-notif" id="toastMsg" role="status" aria-live="polite"></div>
@if($music)<audio id="bgMusic" src="{{ $music }}" loop preload="none"></audio>@endif

<header class="royal-header">
    <a href="#home" class="royal-brand"><i class="bi bi-crown-fill"></i><span>DETROIT</span></a>
    <ul class="royal-nav-links">
        <li><a href="#home">Home</a></li><li><a href="#couple">Mempelai</a></li><li><a href="#story">Story</a></li>
        <li><a href="#event">Event</a></li><li><a href="#gallery">Gallery</a></li><li><a href="#rsvp">RSVP</a></li>
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
    <div class="container text-center" style="max-width:960px;">
        <div class="hero-banner-card">
            @foreach(['tl','tr','bl','br'] as $pos)
                <svg class="corner-flourish {{ $pos }}" viewBox="0 0 100 100" fill="none" stroke="#C89D56" stroke-width="1.2" aria-hidden="true">
                    <path d="M10 90 C10 40 40 10 90 10 M18 90 C18 45 45 18 90 18 M5 95 C5 35 35 5 95 5"/><circle cx="28" cy="28" r="4" fill="#C89D56"/>
                </svg>
            @endforeach

            <div class="row align-items-center g-4">
                <div class="col-lg-5">
                    <div class="arch-photo-container"><div class="arch-photo-inner" style="background-image:url('{{ $hero }}')"></div></div>
                </div>
                <div class="col-lg-7">
                    <div class="arch-card-right">
                        <div class="wedding-subtitle">THE WEDDING OF</div>
                        <h1 class="couple-name-hero" aria-label="{{ $coupleTitle }}">
                            <span class="cn-name">{{ $groomName }}</span>
                            <span class="cn-amp" aria-hidden="true">&amp;</span>
                            <span class="cn-name">{{ $brideName }}</span>
                        </h1>
                        <div class="wedding-date-hero">{{ $eventDateText }}</div>
                        <div class="wedding-venue-hero"><i class="bi bi-geo-alt-fill text-warning"></i><span>{{ $venueName }}</span></div>
                        <p class="wedding-quote-hero">"{{ $c['quote_intro'] ?? 'Cinta adalah awal dari segala kebahagiaan.' }}"</p>

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

                        <button type="button" class="btn-gold-cta" onclick="unlockInvitation()"><span>Buka Undangan</span><i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<main class="inv-shell px-3" id="home">

    <!-- MEMPELAI -->
    <section class="inv-section-card" id="couple">
        <div class="sec-title"><div class="sub">Mempelai Bahagia</div><h2>Kedua Mempelai</h2><div class="sep-line"></div></div>

        <div class="quran-box">
            <div class="quran-bismillah" lang="ar">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</div>
            <p class="quran-text">"{{ $c['quote'] ?? 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.' }}"</p>
            <div class="quran-surah">{{ $c['quote_source'] ?? 'QS. Ar-Rum: 21' }}</div>
        </div>

        <div class="row g-4 justify-content-center text-center">
            <div class="col-md-5">
                <div class="couple-card">
                    <div class="arch-photo-container mb-3" style="max-width:220px">
                        <div class="arch-photo-inner" style="height:290px;background-image:url('{{ $groomPic }}')"></div>
                    </div>
                    <div class="couple-role">Mempelai Pria</div>
                    <h3 class="couple-name">{{ $groomName }}</h3>
                    <p class="text-readable small mb-3">{{ $c['groom_parents'] ?? 'Putra tercinta dari Bpk. Ir. H. Bambang Wijaya & Ibu Hj. Siti Aminah' }}</p>
                    @if(!empty($c['groom_instagram']))
                        <a href="https://instagram.com/{{ $c['groom_instagram'] }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary rounded-pill px-3"><i class="bi bi-instagram me-1"></i>&#64;{{ $c['groom_instagram'] }}</a>
                    @endif
                </div>
            </div>

            <div class="col-md-2 d-flex align-items-center justify-content-center"><div class="amp-mark" aria-hidden="true">&amp;</div></div>

            <div class="col-md-5">
                <div class="couple-card">
                    <div class="arch-photo-container mb-3" style="max-width:220px">
                        <div class="arch-photo-inner" style="height:290px;background-image:url('{{ $bridePic }}')"></div>
                    </div>
                    <div class="couple-role">Mempelai Wanita</div>
                    <h3 class="couple-name">{{ $brideName }}</h3>
                    <p class="text-readable small mb-3">{{ $c['bride_parents'] ?? 'Putri tercinta dari Bpk. Dr. H. Hendra Gunawan & Ibu Hj. Ratna Dewi' }}</p>
                    @if(!empty($c['bride_instagram']))
                        <a href="https://instagram.com/{{ $c['bride_instagram'] }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary rounded-pill px-3"><i class="bi bi-instagram me-1"></i>&#64;{{ $c['bride_instagram'] }}</a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- STORY -->
    @if(count($story))
    <section class="inv-section-card" id="story">
        <div class="sec-title"><div class="sub">Jejak langkah cinta</div><h2>Kisah Kami</h2><div class="sep-line"></div></div>
        <div class="row justify-content-center"><div class="col-lg-8">
            <div class="timeline">
                @foreach($story as $s)
                    <div class="position-relative mb-4 pb-2">
                        <span class="dot"></span>
                        <span class="chip-date">{{ $s['date'] ?? '' }}</span>
                        <h4 class="font-serif text-dark fs-4 mb-2 fw-bold">{{ $s['title'] ?? '' }}</h4>
                        <p class="text-readable small mb-0">{{ $s['text'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </div></div>
    </section>
    @endif

    <!-- EVENT -->
    <section class="inv-section-card" id="event">
        <div class="sec-title"><div class="sub">Waktu &amp; tempat</div><h2>Rangkaian Acara</h2><div class="sep-line"></div></div>
        <div class="row g-4 justify-content-center">
            @forelse($invitation->events as $ev)
                <div class="col-md-6">
                    <div class="panel h-100 text-center">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3 border border-warning" style="width:60px;height:60px;background:rgba(200,157,86,.15)">
                            <i class="bi bi-calendar2-heart fs-3" style="color:var(--brown-base)"></i>
                        </div>
                        <h3 class="font-serif text-dark fs-3 mb-2 fw-bold">{{ $ev->event_name }}</h3>
                        <div class="small fw-bold text-dark mb-1"><i class="bi bi-calendar-check me-1" style="color:var(--tan)"></i>{{ $ev->event_date ? $ev->event_date->locale('id')->isoFormat('dddd, D MMMM YYYY') : $eventDateText }}</div>
                        <div class="small mb-3" style="color:var(--tan);font-weight:600"><i class="bi bi-clock me-1"></i>{{ $ev->event_time ?? '09:00 WIB - Selesai' }}</div>
                        <hr class="border-secondary opacity-25">
                        <div class="fw-bold text-dark mb-1">{{ $ev->location ?? $venueName }}</div>
                        <p class="text-subtle small mb-4">{{ $ev->description ?? 'Kehadiran dan doa restu Anda merupakan suatu kehormatan bagi kami.' }}</p>
                        <div class="d-flex flex-wrap justify-content-center gap-2">
                            <a href="{{ $mapsFor($ev) }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary rounded-pill px-3"><i class="bi bi-geo-alt me-1"></i>Buka Google Maps</a>
                            @if($calUrl)<a href="{{ $calUrl }}" target="_blank" rel="noopener" class="btn-royal-share"><i class="bi bi-calendar-plus"></i>Simpan ke Kalender</a>@endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-6"><div class="panel text-center">
                    <h3 class="font-serif text-dark fs-3 mb-2 fw-bold">Akad &amp; Resepsi</h3>
                    <div class="small fw-bold text-dark mb-1">{{ $eventDateText }}</div>
                    <div class="fw-bold text-dark mb-3">{{ $venueName }}</div>
                    <a href="{{ $mapsFor(null) }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary rounded-pill px-3"><i class="bi bi-geo-alt me-1"></i>Buka Google Maps</a>
                </div></div>
            @endforelse
        </div>
    </section>

    <!-- GALLERY -->
    @if($gallery->count() || $videos->count())
    <section class="inv-section-card" id="gallery">
        <div class="sec-title"><div class="sub">Momen bahagia</div><h2>Galeri Kenangan</h2><div class="sep-line"></div></div>
        @if($gallery->count())
            <div class="row g-3 row-cols-2 row-cols-md-3 mb-4">
                @foreach($gallery as $idx => $g)
                    <div class="col">
                        <div class="gal-item" role="button" tabindex="0" data-src="{{ $g }}" aria-label="Perbesar foto {{ $idx + 1 }}">
                            <img src="{{ $g }}" alt="Foto galeri {{ $idx + 1 }}" loading="lazy">
                            <div class="ov"><i class="bi bi-zoom-in text-white fs-3"></i></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        @if($videos->count())
            <div class="row g-4 justify-content-center">
                @foreach($videos as $v)
                    <div class="col-md-8 text-center">
                        <div class="rounded-4 overflow-hidden border border-secondary border-opacity-25 ratio ratio-16x9">
                            @if($v['yt'])
                                <iframe src="https://www.youtube-nocookie.com/embed/{{ $v['yt'] }}" title="{{ $v['title'] ?: 'Video' }}" loading="lazy" allowfullscreen></iframe>
                            @else
                                <video controls playsinline poster="{{ $v['poster'] }}"><source src="{{ $v['src'] }}" type="video/mp4"></video>
                            @endif
                        </div>
                        @if($v['title'])<div class="small text-readable mt-2">{{ $v['title'] }}</div>@endif
                    </div>
                @endforeach
            </div>
        @endif
    </section>
    @endif

    <!-- GIFT -->
    @if(count($gifts) || !empty($c['gift_address']))
    <section class="inv-section-card" id="gift">
        <div class="sec-title"><div class="sub">Tanda kasih</div><h2>Amplop Digital</h2><div class="sep-line"></div></div>
        <p class="text-center text-readable small mx-auto mb-4" style="max-width:520px">Doa restu Anda adalah karunia yang terindah bagi kami. Namun jika Anda berkenan memberikan tanda kasih, dapat disalurkan melalui:</p>
        <div class="row g-3 justify-content-center">
            @foreach($gifts as $g)
                <div class="col-md-5">
                    <div class="panel text-center">
                        <div class="font-serif text-dark fw-bold fs-4 mb-1">{{ $g['bank'] ?? 'Bank' }}</div>
                        <div class="font-monospace fs-4 fw-bold text-dark my-2">{{ $g['number'] ?? '' }}</div>
                        <div class="small text-subtle mb-3">a.n. {{ $g['name'] ?? '' }}</div>
                        <button type="button" class="btn-gold-cta py-2 px-3 js-copy" style="font-size:.75rem;letter-spacing:1px" data-copy="{{ $g['number'] ?? '' }}" data-label="Nomor rekening"><i class="bi bi-clipboard"></i>Salin Nomor</button>
                    </div>
                </div>
            @endforeach
        </div>
        @if(!empty($c['gift_address']))
            <div class="panel text-center mt-4 mx-auto" style="max-width:600px">
                <div class="fw-bold text-dark mb-1"><i class="bi bi-box-seam me-1" style="color:var(--tan)"></i>Kirim Kado Fisik</div>
                <p class="text-readable small mb-3">{{ $c['gift_address'] }}</p>
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 js-copy" data-copy="{{ $c['gift_address'] }}" data-label="Alamat kado"><i class="bi bi-clipboard me-1"></i>Salin Alamat</button>
            </div>
        @endif
    </section>
    @endif

    <!-- RSVP -->
    <section class="inv-section-card" id="rsvp">
        <div class="sec-title"><div class="sub">Konfirmasi &amp; doa</div><h2>RSVP &amp; Buku Tamu</h2><div class="sep-line"></div></div>
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="panel">
                    <h4 class="font-serif text-dark fs-4 mb-3 text-center fw-bold">Konfirmasi Kehadiran</h4>
                    <form id="rsvpOnlineForm" method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small text-dark fw-bold" for="fName">Nama Anda <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="fName" class="form-control form-control-floral" value="{{ $guestName !== 'Tamu Undangan' ? $guestName : '' }}" placeholder="Nama lengkap" required>
                        </div>
                        <div class="mb-3">
                            <div class="form-label small text-dark fw-bold">Apakah Anda akan hadir?</div>
                            <div class="vstack gap-2">
                                <div class="form-check p-2 rounded-2 radio-row"><input class="form-check-input ms-1" type="radio" name="attendance" id="radHadir" value="yes" checked><label class="form-check-label text-dark small ms-2 fw-semibold" for="radHadir"><i class="bi bi-check-circle-fill text-success me-1"></i>Insya Allah, saya hadir</label></div>
                                <div class="form-check p-2 rounded-2 radio-row"><input class="form-check-input ms-1" type="radio" name="attendance" id="radTidak" value="no"><label class="form-check-label text-dark small ms-2 fw-semibold" for="radTidak"><i class="bi bi-x-circle-fill text-danger me-1"></i>Mohon maaf, saya berhalangan</label></div>
                                <div class="form-check p-2 rounded-2 radio-row"><input class="form-check-input ms-1" type="radio" name="attendance" id="radRagu" value="maybe"><label class="form-check-label text-dark small ms-2 fw-semibold" for="radRagu"><i class="bi bi-question-circle-fill text-warning me-1"></i>Belum pasti</label></div>
                            </div>
                        </div>
                        <div class="row g-2 mb-3" id="guestCountRow">
                            <div class="col-6">
                                <label class="form-label small text-dark fw-bold" for="fAdult">Tamu dewasa</label>
                                <select name="total_guests" class="form-select form-control-floral" id="fAdult">
                                    <option value="1">1 orang</option><option value="2" selected>2 orang</option><option value="3">3 orang</option><option value="4">4 orang</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label small text-dark fw-bold" for="fKid">Tamu anak</label>
                                <select class="form-select form-control-floral" id="fKid"><option value="0" selected>0 anak</option><option value="1">1 anak</option><option value="2">2 anak</option></select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small text-dark fw-bold" for="fMsg">Ucapan &amp; doa restu</label>
                            <textarea name="message" id="fMsg" rows="3" class="form-control form-control-floral" placeholder="Tuliskan ucapan dan doa untuk kedua mempelai"></textarea>
                        </div>
                        <button type="submit" class="btn-gold-cta w-100 justify-content-center py-3" style="max-width:none"><i class="bi bi-send-fill"></i><span>Kirim Konfirmasi</span></button>
                        <div class="text-subtle text-center mt-2" style="font-size:.75rem">Mohon konfirmasi sebelum {{ $deadline }}</div>
                    </form>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="panel h-100 d-flex flex-column">
                    <h4 class="font-serif text-dark fs-4 mb-3 text-center fw-bold">Ucapan &amp; Doa</h4>
                    <div class="d-flex justify-content-around text-center p-2 rounded-3 mb-3" style="background:var(--cream-bg);border:1px solid rgba(156,115,81,.25)">
                        <div><div class="fs-4 fw-bold text-dark" id="statWishes">{{ $invitation->messages->count() }}</div><div class="text-subtle" style="font-size:.72rem">Ucapan</div></div>
                        <div class="vr opacity-25"></div>
                        <div><div class="fs-4 fw-bold text-success">{{ $invitation->rsvps->where('attendance', 'yes')->count() }}</div><div class="text-subtle" style="font-size:.72rem">Hadir</div></div>
                        <div class="vr opacity-25"></div>
                        <div><div class="fs-4 fw-bold text-primary" id="statTamu">{{ $invitation->rsvps->where('attendance', 'yes')->sum('total_guests') ?: $invitation->rsvps->where('attendance', 'yes')->count() }}</div><div class="text-subtle" style="font-size:.72rem">Total tamu</div></div>
                    </div>
                    <div class="vstack gap-3 flex-grow-1 overflow-auto pe-1" id="wishesFeed" style="max-height:420px">
                        @forelse($invitation->messages as $msg)
                            <div class="p-3 rounded-3 radio-row">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div class="fw-bold text-dark small"><i class="bi bi-person-circle me-1" style="color:var(--tan)"></i>{{ $msg->name }}</div>
                                    <div class="text-subtle" style="font-size:.7rem">{{ $msg->created_at ? $msg->created_at->locale('id')->diffForHumans() : 'Baru saja' }}</div>
                                </div>
                                <p class="small text-secondary mb-0" style="line-height:1.6">{{ $msg->message }}</p>
                            </div>
                        @empty
                            <div class="text-center py-4 text-subtle small" id="emptyWishes">Belum ada ucapan. Jadilah yang pertama mengirim doa untuk kedua mempelai.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PENUTUP -->
    <section class="inv-section-card text-center py-5">
        <i class="bi bi-flower1 display-4 text-warning mb-3 d-inline-block" style="color:var(--gold)!important"></i>
        <p class="mx-auto text-readable mb-4" style="max-width:520px;line-height:1.8">Merupakan suatu kehormatan dan kebahagiaan bagi kami sekeluarga apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu kepada kedua mempelai.</p>
        <div class="font-cinzel text-dark fs-5 mb-2 fw-bold">Wassalamu'alaikum Warahmatullahi Wabarakatuh</div>
        <div class="my-2"><span class="cn-name" style="animation:none">{{ $groomName }}</span> <span class="cn-amp" style="font-size:2rem">&amp;</span> <span class="cn-name" style="animation:none">{{ $brideName }}</span></div>
        <div class="small text-subtle mt-3">Beserta keluarga besar</div>
        <div class="mt-4"><button type="button" class="btn-royal-share px-4 py-2" id="bottomShareBtn"><i class="bi bi-share"></i>Bagikan Undangan</button></div>
    </section>
</main>

<nav class="royal-dock" aria-label="Navigasi cepat">
    <a href="#story" class="dock-item"><i class="bi bi-heart-pulse"></i><span>Story</span></a>
    <a href="#event" class="dock-item"><i class="bi bi-calendar-event"></i><span>Event</span></a>
    <a href="#gallery" class="dock-item"><i class="bi bi-camera"></i><span>Gallery</span></a>
    <a href="#gift" class="dock-item"><i class="bi bi-gift"></i><span>Gift</span></a>
    <a href="#rsvp" class="dock-item"><i class="bi bi-chat-heart"></i><span>RSVP</span></a>
    <a href="{{ $mapsFor($firstEvent) }}" target="_blank" rel="noopener" class="dock-item"><i class="bi bi-geo-alt"></i><span>Maps</span></a>
    @if($music)<button type="button" class="dock-item" id="dockMusicBtn"><i class="bi bi-disc" id="dockMusicIcon"></i><span>Musik</span></button>@endif
</nav>

<div class="modal fade" id="lightboxModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0 text-center">
            <div class="position-relative d-inline-block mx-auto">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 z-3" data-bs-dismiss="modal" aria-label="Tutup"></button>
                <img id="lightboxImg" src="" alt="Foto diperbesar" class="img-fluid rounded-4 shadow-lg" style="max-height:85vh">
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const $ = id => document.getElementById(id);
const esc = s => String(s).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));

/* Toast */
function showToast(msg){const t=$('toastMsg');t.textContent=msg;t.classList.add('show');setTimeout(()=>t.classList.remove('show'),2500)}

/* Musik */
const bgMusic=$('bgMusic'); let playing=false;
function setMusicUI(on){
    playing=on;
    $('musicToggleBtn')?.classList.toggle('rotating',on);
    const i=$('dockMusicIcon'); if(i) i.className=on?'bi bi-disc-fill text-warning':'bi bi-disc';
}
function toggleMusic(){
    if(!bgMusic) return;
    if(playing){bgMusic.pause();setMusicUI(false)}
    else bgMusic.play().then(()=>setMusicUI(true)).catch(()=>showToast('Ketuk lagi untuk memutar musik'));
}
$('musicToggleBtn')?.addEventListener('click',toggleMusic);
$('dockMusicBtn')?.addEventListener('click',toggleMusic);

/* Buka undangan */
function unlockInvitation(){
    $('openingCover').classList.add('opened');
    document.body.classList.remove('locked');
    window.scrollTo(0,0);
    if(bgMusic && !playing) bgMusic.play().then(()=>setMusicUI(true)).catch(()=>{});
}

/* Countdown */
(function(){
    const box=$('coverCountdown'); if(!box) return;
    const target=new Date((box.dataset.date||'2024-12-14')+'T09:00:00').getTime();
    const set=(id,v)=>{$(id).textContent=v};
    const pad=n=>String(n).padStart(2,'0');
    function tick(){
        const d=Math.max(0,target-Date.now());
        set('cov-d',Math.floor(d/864e5));
        set('cov-h',pad(Math.floor(d%864e5/36e5)));
        set('cov-m',pad(Math.floor(d%36e5/6e4)));
        set('cov-s',pad(Math.floor(d%6e4/1e3)));
    }
    tick(); setInterval(tick,1000);
})();

/* Salin */
function copyData(val,label){
    (navigator.clipboard?.writeText(val)||Promise.reject()).then(()=>showToast(label+' berhasil disalin')).catch(()=>showToast('Salin manual: '+val));
}
document.querySelectorAll('.js-copy').forEach(b=>b.addEventListener('click',()=>copyData(b.dataset.copy,b.dataset.label)));

/* Bagikan */
function shareInvitation(){
    const data={title:@json('The Wedding of '.$coupleTitle),text:@json('Undangan Pernikahan '.$coupleTitle.' - '.$eventDateText.' di '.$venueName),url:location.href};
    if(navigator.share) navigator.share(data).catch(()=>{});
    else navigator.clipboard?.writeText(location.href).then(()=>showToast('Link undangan berhasil disalin'));
}
$('topShareBtn')?.addEventListener('click',shareInvitation);
$('bottomShareBtn')?.addEventListener('click',shareInvitation);

/* Lightbox */
let lb=null;
function openLightbox(src){
    $('lightboxImg').src=src;
    lb=lb||new bootstrap.Modal($('lightboxModal'));
    lb.show();
}
document.querySelectorAll('.gal-item').forEach(el=>{
    el.addEventListener('click',()=>openLightbox(el.dataset.src));
    el.addEventListener('keydown',e=>{if(e.key==='Enter'||e.key===' '){e.preventDefault();openLightbox(el.dataset.src)}});
});

/* Dock aktif mengikuti scroll */
(function(){
    const links=[...document.querySelectorAll('.dock-item[href^="#"]')], map=new Map();
    links.forEach(l=>{const s=document.querySelector(l.getAttribute('href'));if(s)map.set(s,l)});
    const io=new IntersectionObserver(es=>es.forEach(e=>{
        if(e.isIntersecting){links.forEach(l=>l.classList.remove('active'));map.get(e.target)?.classList.add('active')}
    }),{rootMargin:'-40% 0px -50% 0px'});
    map.forEach((_,s)=>io.observe(s));
})();

/* RSVP */
document.querySelectorAll('input[name="attendance"]').forEach(r=>r.addEventListener('change',function(){
    $('guestCountRow').style.display=this.value==='yes'?'':'none';
}));

const form=$('rsvpOnlineForm');
form?.addEventListener('submit',function(e){
    e.preventDefault();
    const fd=new FormData(this), btn=this.querySelector('button[type="submit"]'), html=btn.innerHTML;
    const nameVal=$('fName').value.trim(), msgVal=$('fMsg').value.trim();
    btn.disabled=true; btn.innerHTML='<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';

    fetch(this.action,{method:'POST',headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json','X-CSRF-TOKEN':this.querySelector('input[name="_token"]').value},body:fd})
    .then(r=>{if(!r.ok) throw new Error(r.status);return r.json()})
    .then(res=>{
        showToast(res.message||'Konfirmasi kehadiran terkirim');
        btn.disabled=false; btn.innerHTML=html;

        if(msgVal&&nameVal){
            $('emptyWishes')?.remove();
            const card=document.createElement('div');
            card.className='p-3 rounded-3 radio-row';
            card.innerHTML=`<div class="d-flex justify-content-between align-items-center mb-1">
                <div class="fw-bold text-dark small"><i class="bi bi-person-circle me-1" style="color:var(--tan)"></i>${esc(nameVal)}</div>
                <div class="text-subtle" style="font-size:.7rem">Baru saja</div></div>
                <p class="small text-secondary mb-0" style="line-height:1.6">${esc(msgVal)}</p>`;
            $('wishesFeed').prepend(card);
            $('statWishes').textContent=(parseInt($('statWishes').textContent)||0)+1;
        }

        const waNum=@json($wa);
        if(waNum){
            const att={yes:'Insya Allah hadir',no:'Mohon maaf berhalangan',maybe:'Belum pasti'}[fd.get('attendance')];
            const text=encodeURIComponent(`Halo, saya ${nameVal}. Konfirmasi kehadiran di pernikahan {{ $coupleTitle }}: ${att}.`+(msgVal?` Ucapan: ${msgVal}`:''));
            setTimeout(()=>{if(confirm('Kirim konfirmasi ini ke WhatsApp mempelai juga?')) window.open(`https://wa.me/${waNum}?text=${text}`,'_blank')},500);
        }
        $('fMsg').value='';
    })
    .catch(()=>{btn.disabled=false;btn.innerHTML=html;form.submit()});
});
</script>
</body>
</html>
