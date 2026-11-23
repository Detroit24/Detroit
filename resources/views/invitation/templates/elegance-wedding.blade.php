@php
    use Illuminate\Support\Str;
    $c = $content ?? [];
    $img = fn($p) => $p ? (Str::startsWith($p, ['http', '/']) ? $p : asset('storage/' . $p)) : null;

    // Distinct, curated default photos for each section (Emerald & Royal Wedding Theme)
    $hero      = $img($c['hero_image'] ?? null) ?: asset('images/royal-couple.jpg');
    $groomPic  = $img($c['groom_photo'] ?? null) ?: asset('images/royal-groom.jpg');
    $bridePic  = $img($c['bride_photo'] ?? null) ?: asset('images/royal-bride.jpg');
    $venuePic  = $img($c['venue_image'] ?? null) ?: 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&q=80&w=1000';

    $gallery   = collect($c['gallery'] ?? [
        asset('images/royal-couple.jpg'),
        asset('images/royal-bride.jpg'),
        asset('images/royal-groom.jpg'),
        'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1583939003579-730e3918a45a?auto=format&fit=crop&q=80&w=800',
        'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&q=80&w=800'
    ])->map($img)->filter()->values();

    $story     = $c['story'] ?? [
        ['date' => '15 Oktober 2023', 'title' => 'Pertemuan Pertama', 'text' => 'Awal kisah kami bersemi dari sebuah pertemuan tak terduga, di mana senyuman pertama menjadi titik awal dari takdir indah yang Allah gariskan.'],
        ['date' => '24 Mei 2024', 'title' => 'Lamaran & Mengikat Janji', 'text' => 'Dengan penuh rasa syukur dan didampingi keluarga tercinta, kami memantapkan langkah menuju ikatan pernikahan yang suci.'],
        ['date' => '24 Januari 2026', 'title' => 'Menuju Hari Bahagia', 'text' => 'Hari di mana dua hati, dua keluarga, dan dua takdir dipersatukan dalam ikrar suci pernikahan yang kekal hingga ke jannah-Nya.']
    ];

    $gifts     = $c['gifts'] ?? [
        ['bank' => 'Bank BCA', 'number' => ($c['bank_1_number'] ?? '8271928371'), 'name' => ($c['bank_1_holder'] ?? 'Rama Prasetya')],
        ['bank' => 'Bank Mandiri', 'number' => ($c['bank_2_number'] ?? '1370019283712'), 'name' => ($c['bank_2_holder'] ?? 'Aulia Rahma')]
    ];

    $stays     = $c['stays'] ?? [
        ['name' => 'Hotel Grand Royal', 'text' => 'Tersedia akomodasi khusus untuk keluarga dan tamu undangan di lokasi acara.', 'url' => 'https://maps.google.com/?q=Hotel+Grand+Royal']
    ];

    $registry  = $c['registry_url'] ?? null;
    $music     = $c['music_url'] ?? 'https://cdn.pixabay.com/download/audio/2022/05/27/audio_1808fbf07a.mp3?filename=romantic-wedding-piano-113004.mp3';

    $ytId = fn($u) => preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|shorts/))([\w-]{11})~', $u, $m) ? $m[1] : null;
    $videos = collect($c['videos'] ?? [])->map(function ($v) use ($ytId, $img) {
        $v = is_string($v) ? ['url' => $v] : $v;
        $id = $ytId($v['url'] ?? '');
        return ['title' => $v['title'] ?? '', 'yt' => $id, 'src' => $id ? null : $img($v['url'] ?? null), 'poster' => $id ? "https://img.youtube.com/vi/$id/hqdefault.jpg" : $img($v['poster'] ?? null)];
    })->filter(fn($v) => $v['yt'] || $v['src'])->values();

    $wa        = preg_replace('/\D/', '', $c['wa_number'] ?? '6281234567890');
    $firstEvent = $invitation->events->first();

    // Couple Names (Ensure clean couple names and avoid dummy duplication)
    $groomName = $c['groom_name'] ?? 'Aulia';
    $brideName = $c['bride_name'] ?? 'Rama';
    if (empty($groomName) || empty($brideName) || $groomName === $brideName || str_contains(strtolower($groomName), 'wedding') || str_contains(strtolower($groomName), 'elegance')) {
        $groomName = 'Aulia';
        $brideName = 'Rama';
    }
    $coupleTitle = $groomName . ' & ' . $brideName;

    $ev0 = $firstEvent?->event_date;
    $initials = Str::upper(Str::substr($groomName, 0, 1)) . ' & ' . Str::upper(Str::substr($brideName, 0, 1));
    $deadline = $c['rsvp_deadline'] ?? ($ev0 ? $ev0->copy()->subDays(14)->locale('id')->isoFormat('D MMMM YYYY') : '10 Januari 2026');
    $eventDateText = $ev0 ? $ev0->locale('id')->isoFormat('dddd, D MMMM YYYY') : 'Sabtu, 24 Januari 2026';
    $venueName = $firstEvent->location ?? 'Hotel Grand Royal';

    $calUrl = null;
    if ($ev0) {
        $d = $ev0->format('Ymd');
        $calUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE&text=' . urlencode('Pernikahan ' . $coupleTitle)
            . '&dates=' . $d . '/' . $ev0->copy()->addDay()->format('Ymd') . '&location=' . urlencode($venueName);
    }
    $targetCountdown = $ev0 ? $ev0->format('Y-m-d') : '2026-01-24';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>The Wedding of {{ $coupleTitle }} - DETROIT Royal Emerald</title>
    <meta name="theme-color" content="#061C14">
    <meta property="og:title" content="Undangan Pernikahan {{ $coupleTitle }}">
    <meta property="og:description" content="{{ $eventDateText }} di {{ $venueName }} - Kami mengundang Anda untuk hadir.">
    @if($hero)<meta property="og:image" content="{{ $hero }}">@endif

    <!-- Fonts & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800;900&family=Great+Vibes&family=Pinyon+Script&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --em-darkest: #04140E;
            --em-dark: #072017;
            --em-base: #0B2C20;
            --em-card: #0E3628;
            --em-card-2: #124030;
            --em-border: #1B5842;
            --gold: #D4AF37;
            --gold-light: #F3E1B6;
            --gold-glow: rgba(212, 175, 55, 0.45);
            --gold-grad: linear-gradient(135deg, #F5E5C0 0%, #D4AF37 50%, #A97A24 100%);
            --gold-btn: linear-gradient(135deg, #F3D28E 0%, #D4AF37 40%, #B8860B 80%, #8A5E12 100%);
            --text-gold: #ECC880;
            --text-cream: #FAF8F2;
            --text-readable: #F2ECE1;
            --text-muted: #D3E0D8; /* High-contrast readable sage text */
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            background-color: var(--em-darkest);
            color: var(--text-cream);
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background-image: 
                radial-gradient(circle at 50% 0%, rgba(20, 77, 56, 0.65) 0%, transparent 60%),
                radial-gradient(circle at 100% 50%, rgba(13, 53, 38, 0.45) 0%, transparent 50%),
                linear-gradient(180deg, #072017 0%, #03120C 100%);
            background-attachment: fixed;
        }

        body.locked { overflow: hidden; height: 100vh; }

        .font-cinzel { font-family: 'Cinzel', serif; }
        .font-script { font-family: 'Pinyon Script', cursive; line-height: 1.05; }
        .font-greatvibes { font-family: 'Great Vibes', cursive; }

        /* Gold Gradient Text */
        .text-gold-gradient {
            background: var(--gold-grad);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }

        /* Top Header Navigation (Image Match: DETROIT + Crown + Share) */
        .royal-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 999;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(4, 20, 14, 0.88);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(212, 175, 55, 0.25);
        }

        .royal-brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: var(--gold-light);
            text-decoration: none;
            letter-spacing: 2px;
        }
        .royal-brand i { font-size: 1.15rem; color: var(--gold); }
        .royal-brand span { font-family: 'Cinzel', serif; font-size: 0.85rem; font-weight: 700; }

        .royal-nav-links {
            display: flex;
            align-items: center;
            gap: 22px;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .royal-nav-links a {
            color: #DFECE4;
            text-decoration: none;
            font-size: 0.84rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .royal-nav-links a:hover { color: var(--gold-light); }

        .btn-royal-share {
            border: 1px solid var(--gold);
            border-radius: 50px;
            padding: 6px 18px;
            color: var(--gold-light);
            font-size: 0.8rem;
            background: rgba(212, 175, 55, 0.12);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            cursor: pointer;
        }
        .btn-royal-share:hover {
            background: var(--gold);
            color: var(--em-darkest) !important;
        }

        /* Container Main wrapper */
        .inv-shell {
            max-width: 1040px;
            margin: 0 auto;
            position: relative;
            padding-bottom: 100px;
        }

        /* HERO CARD (MATCHING THE UPLOADED SCREENSHOT) */
        .hero-banner-card {
            background: radial-gradient(circle at 60% 40%, #0E3628 0%, #082117 75%, #051610 100%);
            border: 1.5px solid rgba(212, 175, 55, 0.45);
            border-radius: 28px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.6), inset 0 0 40px rgba(212, 175, 55, 0.1);
            position: relative;
            overflow: hidden;
            padding: 40px 30px;
            margin-top: 85px;
            margin-bottom: 50px;
        }

        /* Gold Baroque Corner Flourishes */
        .corner-flourish {
            position: absolute;
            width: 130px;
            height: 130px;
            pointer-events: none;
            opacity: 0.65;
            z-index: 2;
        }
        .corner-flourish.tl { top: -10px; left: -10px; }
        .corner-flourish.tr { top: -10px; right: -10px; transform: scaleX(-1); }
        .corner-flourish.bl { bottom: -10px; left: -10px; transform: scaleY(-1); }
        .corner-flourish.br { bottom: -10px; right: -10px; transform: scale(-1, -1); }

        /* Left side Couple Arch Frame */
        .arch-photo-container {
            position: relative;
            width: 100%;
            max-width: 370px;
            margin: 0 auto;
            border-radius: 190px 190px 18px 18px;
            padding: 8px;
            background: linear-gradient(180deg, #F3E1B6 0%, #D4AF37 50%, #4D3812 100%);
            box-shadow: 0 16px 40px rgba(0,0,0,0.55);
        }

        .arch-photo-inner {
            width: 100%;
            height: 480px;
            border-radius: 182px 182px 12px 12px;
            background-size: cover;
            background-position: center top;
            background-repeat: no-repeat;
            background-color: var(--em-dark);
            position: relative;
            overflow: hidden;
        }

        .arch-photo-inner::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 75%, rgba(4, 20, 14, 0.65) 100%);
            pointer-events: none;
        }

        /* Right side Details Arch Card */
        .arch-card-right {
            border: 1px solid rgba(212, 175, 55, 0.35);
            background: rgba(7, 32, 23, 0.72);
            backdrop-filter: blur(10px);
            border-radius: 200px 200px 24px 24px;
            padding: 50px 30px 40px;
            text-align: center;
            box-shadow: inset 0 0 30px rgba(212, 175, 55, 0.08);
            position: relative;
        }

        .arch-card-right::before {
            content: "";
            position: absolute;
            inset: 7px;
            border: 1px dashed rgba(212, 175, 55, 0.3);
            border-radius: 194px 194px 18px 18px;
            pointer-events: none;
        }

        /* Wedding Header Typography */
        .wedding-subtitle {
            font-family: 'Cinzel', serif;
            font-size: 0.88rem;
            letter-spacing: 5px;
            color: var(--gold-light);
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .couple-name-hero {
            font-family: 'Pinyon Script', 'Great Vibes', cursive;
            font-size: clamp(3.2rem, 6vw, 4.8rem);
            color: var(--gold-light);
            line-height: 1.1;
            margin-bottom: 12px;
            text-shadow: 0 4px 16px rgba(212, 175, 55, 0.35);
        }

        .wedding-date-hero {
            font-family: 'Cinzel', serif;
            font-size: 1.05rem;
            letter-spacing: 2px;
            color: #FFFFFF;
            margin-bottom: 6px;
            font-weight: 600;
        }

        .wedding-venue-hero {
            font-size: 0.95rem;
            color: var(--text-gold);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .wedding-quote-hero {
            font-style: italic;
            font-size: 0.95rem;
            color: #FAF5EB;
            max-width: 360px;
            margin: 0 auto 22px;
            line-height: 1.6;
            text-shadow: 0 1px 3px rgba(0,0,0,0.6);
        }

        /* Countdown Boxes Matching Image */
        .countdown-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            max-width: 360px;
            margin: 0 auto 26px;
        }

        .countdown-tile {
            background: rgba(4, 20, 14, 0.88);
            border: 1px solid rgba(212, 175, 55, 0.55);
            border-radius: 12px;
            padding: 10px 4px;
            text-align: center;
            box-shadow: 0 4px 14px rgba(0,0,0,0.35);
        }

        .countdown-num {
            font-family: 'Cinzel', serif;
            font-size: 1.65rem;
            font-weight: 700;
            color: var(--gold-light);
            line-height: 1.1;
        }

        .countdown-lbl {
            font-size: 0.68rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #D6E3DC;
            margin-top: 3px;
            font-weight: 600;
        }

        /* Guest Callout Box (Kepada Yth...) */
        .guest-callout-box {
            background: rgba(4, 20, 14, 0.85);
            border: 1px solid rgba(212, 175, 55, 0.45);
            border-radius: 12px;
            padding: 10px 18px;
            max-width: 360px;
            margin: 0 auto 24px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.35);
        }
        .guest-label {
            color: #ECC880;
            font-size: 0.78rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 3px;
        }
        .guest-name {
            color: #FFF8EB;
            font-family: 'Cinzel', serif;
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        /* Gold Pill Button (Image Match: Buka Undangan ->) */
        .btn-gold-cta {
            background: var(--gold-btn);
            color: #1A1102 !important;
            font-family: 'Cinzel', serif;
            font-weight: 700;
            font-size: 0.9rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            border: none;
            border-radius: 50px;
            padding: 14px 42px;
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.45);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .btn-gold-cta:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 12px 30px rgba(212, 175, 55, 0.65);
            color: #0B2C20 !important;
        }

        /* Card Section Styling */
        .inv-section-card {
            background: rgba(14, 54, 40, 0.65);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(212, 175, 55, 0.35);
            border-radius: 24px;
            padding: 45px 32px;
            margin-bottom: 40px;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.35);
            position: relative;
        }

        .sec-title-ornate {
            text-align: center;
            margin-bottom: 32px;
        }
        .sec-title-ornate .badge-sub {
            font-family: 'Cinzel', serif;
            letter-spacing: 4px;
            font-size: 0.78rem;
            color: var(--gold);
            text-transform: uppercase;
            font-weight: 600;
        }
        .sec-title-ornate h2 {
            font-family: 'Pinyon Script', cursive;
            font-size: clamp(3rem, 5.5vw, 4rem);
            color: var(--gold-light);
            margin: 4px 0 10px;
            line-height: 1;
        }
        .sec-title-ornate .sep-line {
            width: 80px;
            height: 2px;
            background: var(--gold-grad);
            margin: 0 auto;
        }

        /* Quran Verse Box (High Contrast & Legible) */
        .quran-box {
            background: linear-gradient(135deg, rgba(8, 33, 24, 0.92) 0%, rgba(4, 20, 14, 0.95) 100%);
            border: 1.5px solid rgba(212, 175, 55, 0.45);
            border-radius: 20px;
            padding: 30px 24px;
            max-width: 680px;
            margin: 0 auto 36px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4), inset 0 0 25px rgba(212, 175, 55, 0.08);
            text-align: center;
        }
        .quran-bismillah {
            font-family: 'Cinzel', serif;
            font-size: clamp(1.2rem, 3vw, 1.45rem);
            color: var(--gold-light);
            margin-bottom: 14px;
            letter-spacing: 1px;
            text-shadow: 0 2px 8px rgba(212, 175, 55, 0.4);
        }
        .quran-text {
            color: #FAF8F2 !important;
            font-size: clamp(0.95rem, 2vw, 1.05rem);
            line-height: 1.85;
            font-style: italic;
            margin-bottom: 12px;
            text-shadow: 0 1px 3px rgba(0,0,0,0.85);
        }
        .quran-surah {
            color: #ECC880;
            font-size: 0.95rem;
            letter-spacing: 2px;
            font-weight: 700;
            text-transform: uppercase;
        }

        /* Couple Detail Cards */
        .couple-card {
            background: rgba(6, 26, 19, 0.65);
            border: 1.5px solid rgba(212, 175, 55, 0.3);
            border-radius: 20px;
            padding: 30px 20px;
            height: 100%;
            transition: transform 0.3s ease, border-color 0.3s ease;
        }
        .couple-card:hover {
            transform: translateY(-4px);
            border-color: rgba(212, 175, 55, 0.6);
        }

        /* Description text with strong readability */
        .text-readable {
            color: #FAF5EB !important;
            line-height: 1.7;
        }
        .text-subtle {
            color: #D6E4DB !important;
            line-height: 1.6;
        }

        /* Bottom Floating Dock (Image Match: Our Story, Event, Gallery, Gift, RSVP, Maps) */
        .royal-dock {
            position: fixed;
            bottom: calc(16px + env(safe-area-inset-bottom, 0px));
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 32px);
            max-width: 460px;
            background: rgba(4, 20, 14, 0.95);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(212, 175, 55, 0.45);
            border-radius: 50px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            justify-content: space-around;
            box-shadow: 0 12px 35px rgba(0,0,0,0.65), inset 0 1px 1px rgba(255,255,255,0.15);
            z-index: 990;
        }

        .dock-item {
            color: #D6E4DB;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            padding: 6px 6px;
            border-radius: 16px;
            transition: all 0.2s;
            background: transparent;
            border: 0;
            font-size: 0.66rem;
            letter-spacing: 0.5px;
            font-weight: 500;
        }

        .dock-item i {
            font-size: 1.2rem;
            color: var(--text-gold);
            transition: 0.2s;
        }

        .dock-item:hover, .dock-item.active {
            color: #FFFFFF;
        }
        .dock-item:hover i, .dock-item.active i {
            color: var(--gold-light);
            transform: scale(1.15);
        }

        /* Floating Vinyl Disc */
        .music-vinyl-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: radial-gradient(circle, #251B08 0%, #000 65%, #251B08 100%);
            border: 1.5px solid var(--gold);
            color: var(--gold-light);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0,0,0,0.5);
            transition: all 0.2s;
        }
        .music-vinyl-btn.rotating {
            animation: spin 5s linear infinite;
        }
        @keyframes spin { 100% { transform: rotate(360deg); } }

        /* Full Screen Opening Overlay Cover */
        #openingCover {
            position: fixed;
            inset: 0;
            z-index: 10000;
            background: radial-gradient(circle at center, #0B2D21 0%, #061F16 50%, #03120C 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 1.2s cubic-bezier(0.85, 0, 0.15, 1), opacity 1.2s;
            padding: 20px 14px;
            overflow-y: auto;
        }

        #openingCover.opened {
            transform: translateY(-100%);
            opacity: 0;
            pointer-events: none;
        }

        /* Form Controls Dark Emerald */
        .form-control-emerald {
            background: rgba(4, 20, 14, 0.85) !important;
            border: 1px solid rgba(212, 175, 55, 0.45) !important;
            color: #FFFFFF !important;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 0.95rem;
        }
        .form-control-emerald::placeholder {
            color: #9CB2A5 !important;
        }
        .form-control-emerald:focus {
            box-shadow: 0 0 12px rgba(212, 175, 55, 0.4) !important;
            border-color: var(--gold) !important;
        }

        /* Toast Message */
        .toast-notif {
            position: fixed;
            top: 75px;
            left: 50%;
            transform: translateX(-50%) translateY(-100px);
            background: var(--gold-btn);
            color: #1A1102;
            padding: 11px 26px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.9rem;
            z-index: 10005;
            transition: transform 0.4s ease;
            box-shadow: 0 8px 24px rgba(0,0,0,0.5);
        }
        .toast-notif.show { transform: translateX(-50%) translateY(0); }

        /* RESPONSIVE BREAKPOINTS */
        @media (max-width: 991px) {
            .royal-nav-links { display: none; }
            .hero-banner-card { padding: 32px 18px; margin-top: 70px; margin-bottom: 35px; }
            .arch-photo-container { max-width: 300px; margin-bottom: 24px; }
            .arch-photo-inner { height: 380px; }
            .arch-card-right { padding: 42px 18px 30px; border-radius: 160px 160px 20px 20px; }
            .arch-card-right::before { border-radius: 154px 154px 16px 16px; }
            .countdown-grid { max-width: 320px; gap: 6px; }
            .countdown-num { font-size: 1.4rem; }
            .inv-section-card { padding: 35px 20px; }
        }

        @media (max-width: 576px) {
            .hero-banner-card { padding: 24px 14px; margin-top: 65px; border-radius: 20px; }
            .arch-photo-container { max-width: 260px; height: auto; }
            .arch-photo-inner { height: 320px; border-radius: 150px 150px 10px 10px; }
            .arch-card-right { padding: 34px 14px 24px; border-radius: 130px 130px 16px 16px; }
            .arch-card-right::before { border-radius: 124px 124px 12px 12px; inset: 5px; }
            .countdown-grid { max-width: 290px; gap: 5px; }
            .countdown-tile { padding: 8px 2px; }
            .countdown-num { font-size: 1.25rem; }
            .countdown-lbl { font-size: 0.6rem; letter-spacing: 1px; }
            .btn-gold-cta { padding: 12px 28px; font-size: 0.82rem; width: 100%; max-width: 270px; justify-content: center; }
            .royal-dock { width: calc(100% - 20px); padding: 6px 8px; }
            .dock-item { font-size: 0.62rem; padding: 4px; }
            .dock-item i { font-size: 1.1rem; }
            .inv-section-card { padding: 28px 14px; border-radius: 18px; margin-bottom: 25px; }
            .sec-title-ornate h2 { font-size: 2.8rem; }
        }
    </style>
</head>
<body class="locked">

    <!-- Toast Notification -->
    <div class="toast-notif" id="toastMsg" role="status"></div>

    <!-- Audio BGM -->
    @if($music)
        <audio id="bgMusic" src="{{ $music }}" loop preload="none"></audio>
    @endif

    <!-- TOP HEADER (Image Match: DETROIT + Crown + Navigation) -->
    <header class="royal-header">
        <a href="#home" class="royal-brand">
            <i class="bi bi-crown-fill"></i>
            <span>DETROIT</span>
        </a>

        <ul class="royal-nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#couple">Mempelai</a></li>
            <li><a href="#story">Story</a></li>
            <li><a href="#event">Event</a></li>
            <li><a href="#gallery">Gallery</a></li>
            <li><a href="#rsvp">RSVP</a></li>
        </ul>

        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn-royal-share" id="topShareBtn">
                <i class="bi bi-share"></i>
                <span>Share</span>
            </button>

            @if($music)
                <button type="button" class="music-vinyl-btn" id="musicToggleBtn" title="Putar/Jeda Musik">
                    <i class="bi bi-music-note-beamed" id="musicIcon"></i>
                </button>
            @endif
        </div>
    </header>

    <!-- 1. FULLSCREEN OPENING COVER (MATCHES THE IMAGE BANNER) -->
    <div id="openingCover">
        <div class="container text-center" style="max-width: 960px;">
            <div class="hero-banner-card my-0">
                <!-- SVG Baroque Corner Flourishes -->
                <svg class="corner-flourish tl" viewBox="0 0 100 100" fill="none" stroke="#D4AF37" stroke-width="1.2">
                    <path d="M10 90 C10 40 40 10 90 10 M18 90 C18 45 45 18 90 18 M5 95 C5 35 35 5 95 5"/>
                    <circle cx="28" cy="28" r="4" fill="#D4AF37"/>
                </svg>
                <svg class="corner-flourish tr" viewBox="0 0 100 100" fill="none" stroke="#D4AF37" stroke-width="1.2">
                    <path d="M10 90 C10 40 40 10 90 10 M18 90 C18 45 45 18 90 18 M5 95 C5 35 35 5 95 5"/>
                    <circle cx="28" cy="28" r="4" fill="#D4AF37"/>
                </svg>

                <div class="row align-items-center g-4">
                    <!-- Left: Grand Baroque Arch with Clean Couple Portrait (No Cut-off UI) -->
                    <div class="col-lg-5 text-center">
                        <div class="arch-photo-container">
                            <div class="arch-photo-inner" style="background-image: url('{{ $hero }}');"></div>
                        </div>
                    </div>

                    <!-- Right: The Wedding Typography & Countdown -->
                    <div class="col-lg-7">
                        <div class="arch-card-right">
                            <div class="wedding-subtitle">THE WEDDING OF</div>
                            
                            <h1 class="couple-name-hero">{{ $coupleTitle }}</h1>

                            <div class="wedding-date-hero">{{ $eventDateText }}</div>
                            <div class="wedding-venue-hero">
                                <i class="bi bi-geo-alt-fill text-warning"></i>
                                <span>{{ $venueName }}</span>
                            </div>

                            <p class="wedding-quote-hero">
                                "{{ $c['quote_intro'] ?? 'Cinta adalah awal dari segala kebahagiaan.' }}"
                            </p>

                            <!-- Live Countdown Tiles (Image Match) -->
                            <div class="countdown-grid" id="coverCountdown" data-date="{{ $targetCountdown }}">
                                <div class="countdown-tile">
                                    <div class="countdown-num" id="cov-d">119</div>
                                    <div class="countdown-lbl">Hari</div>
                                </div>
                                <div class="countdown-tile">
                                    <div class="countdown-num" id="cov-h">16</div>
                                    <div class="countdown-lbl">Jam</div>
                                </div>
                                <div class="countdown-tile">
                                    <div class="countdown-num" id="cov-m">20</div>
                                    <div class="countdown-lbl">Menit</div>
                                </div>
                                <div class="countdown-tile">
                                    <div class="countdown-num" id="cov-s">33</div>
                                    <div class="countdown-lbl">Detik</div>
                                </div>
                            </div>

                            <!-- Guest Name Callout (Clear, High-Contrast Text) -->
                            <div class="guest-callout-box">
                                <div class="guest-label">Kepada Yth. Bapak/Ibu/Saudara/i:</div>
                                <div class="guest-name">{{ $guestName }}</div>
                            </div>

                            <!-- Golden Glow Button (Image Match: Buka Undangan ->) -->
                            <button type="button" class="btn-gold-cta" onclick="unlockInvitation()">
                                <span>Buka Undangan</span>
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN BODY CONTENT -->
    <main class="inv-shell px-3" id="home">

        <!-- 2. MEMPELAI (THE COUPLE SECTION) -->
        <section class="inv-section-card" id="couple">
            <div class="sec-title-ornate">
                <span class="badge-sub">Mempelai Bahagia</span>
                <h2>Kedua Mempelai</h2>
                <div class="sep-line"></div>
            </div>

            <!-- Quran Quote Box (Image 1 Fix: Crystal Clear High-Contrast Arabic & Translation) -->
            <div class="quran-box">
                <div class="quran-bismillah">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</div>
                <p class="quran-text">
                    "{{ $c['quote'] ?? 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.' }}"
                </p>
                <div class="quran-surah">{{ $c['quote_source'] ?? 'QS. Ar-Rum: 21' }}</div>
            </div>

            <div class="row g-4 justify-content-center text-center">
                <!-- Groom Card with Distinct Photo -->
                <div class="col-md-5">
                    <div class="couple-card">
                        <div class="arch-photo-container mb-3" style="max-width: 220px;">
                            <div class="arch-photo-inner" style="height: 290px; background-image: url('{{ $groomPic }}');"></div>
                        </div>
                        <h3 class="font-cinzel text-gold-gradient fs-4 mb-2">{{ $groomName }}</h3>
                        <p class="text-readable small mb-3">{{ $c['groom_parents'] ?? 'Putra tercinta dari Bpk. Bambang Wijaya & Ibu Siti Aminah' }}</p>
                        @if(!empty($c['groom_instagram']))
                            <a href="https://instagram.com/{{ $c['groom_instagram'] }}" target="_blank" class="btn btn-sm btn-outline-warning rounded-pill px-3">
                                <i class="bi bi-instagram me-1"></i> &#64;{{ $c['groom_instagram'] }}
                            </a>
                        @endif
                    </div>
                </div>

                <div class="col-md-2 d-flex align-items-center justify-content-center my-2 my-md-0">
                    <div class="font-script display-3 text-gold-gradient">&amp;</div>
                </div>

                <!-- Bride Card with Distinct Photo -->
                <div class="col-md-5">
                    <div class="couple-card">
                        <div class="arch-photo-container mb-3" style="max-width: 220px;">
                            <div class="arch-photo-inner" style="height: 290px; background-image: url('{{ $bridePic }}');"></div>
                        </div>
                        <h3 class="font-cinzel text-gold-gradient fs-4 mb-2">{{ $brideName }}</h3>
                        <p class="text-readable small mb-3">{{ $c['bride_parents'] ?? 'Putri tercinta dari Bpk. Hendra Gunawan & Ibu Ratna Dewi' }}</p>
                        @if(!empty($c['bride_instagram']))
                            <a href="https://instagram.com/{{ $c['bride_instagram'] }}" target="_blank" class="btn btn-sm btn-outline-warning rounded-pill px-3">
                                <i class="bi bi-instagram me-1"></i> &#64;{{ $c['bride_instagram'] }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. OUR STORY TIMELINE -->
        @if(count($story))
        <section class="inv-section-card" id="story">
            <div class="sec-title-ornate">
                <span class="badge-sub">Jejak Langkah Cinta</span>
                <h2>Kisah Kami</h2>
                <div class="sep-line"></div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="position-relative ps-4" style="border-left: 2px solid rgba(212, 175, 55, 0.45);">
                        @foreach($story as $s)
                            <div class="position-relative mb-4 pb-2">
                                <div class="position-absolute rounded-circle" style="left: -29px; top: 2px; width: 14px; height: 14px; background: var(--gold); box-shadow: 0 0 10px var(--gold);"></div>
                                <span class="badge bg-warning bg-opacity-20 text-warning border border-warning border-opacity-40 mb-2 px-3 py-1" style="font-size: 0.75rem;">{{ $s['date'] ?? '' }}</span>
                                <h4 class="font-cinzel text-gold-gradient fs-5 mb-2">{{ $s['title'] ?? '' }}</h4>
                                <p class="text-readable small mb-0">{{ $s['text'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        @endif

        <!-- 4. RANGKAIAN ACARA (EVENT & VENUE) -->
        <section class="inv-section-card" id="event">
            <div class="sec-title-ornate">
                <span class="badge-sub">Waktu &amp; Tempat</span>
                <h2>Rangkaian Acara</h2>
                <div class="sep-line"></div>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach($invitation->events as $ev)
                    <div class="col-md-6">
                        <div class="p-4 rounded-4 border border-warning border-opacity-35 h-100 text-center" style="background: rgba(6, 26, 19, 0.75);">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center p-3 mb-3 border border-warning" style="width: 60px; height: 60px; background: rgba(212, 175, 55, 0.15);">
                                <i class="bi bi-calendar2-heart text-warning fs-3"></i>
                            </div>

                            <h3 class="font-cinzel text-gold-gradient fs-4 mb-2">{{ $ev->event_name }}</h3>
                            <div class="small fw-bold text-cream mb-1">
                                <i class="bi bi-calendar-check me-1 text-warning"></i>
                                {{ $ev->event_date ? $ev->event_date->locale('id')->isoFormat('dddd, D MMMM YYYY') : $eventDateText }}
                            </div>
                            <div class="small text-gold mb-3">
                                <i class="bi bi-clock me-1 text-warning"></i>
                                {{ $ev->event_time ?? '09:00 WIB - Selesai' }}
                            </div>

                            <hr class="border-secondary opacity-25">

                            <div class="fw-bold text-cream fs-6 mb-1">{{ $ev->location ?? $venueName }}</div>
                            <p class="text-subtle small mb-4">{{ $ev->description ?? 'Kehadiran dan doa restu Anda merupakan suatu kehormatan bagi kami.' }}</p>

                            <div class="d-flex flex-wrap justify-content-center gap-2">
                                @if($ev->maps_url)
                                    <a href="{{ $ev->maps_url }}" target="_blank" class="btn btn-sm btn-outline-warning rounded-pill px-3">
                                        <i class="bi bi-geo-alt me-1"></i> Buka Google Maps
                                    </a>
                                @else
                                    <a href="https://maps.google.com/?q={{ urlencode($ev->location ?? $venueName) }}" target="_blank" class="btn btn-sm btn-outline-warning rounded-pill px-3">
                                        <i class="bi bi-geo-alt me-1"></i> Buka Google Maps
                                    </a>
                                @endif

                                @if($calUrl)
                                    <a href="{{ $calUrl }}" target="_blank" class="btn btn-sm btn-royal-share">
                                        <i class="bi bi-calendar-plus me-1"></i> Simpan Kalender
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- 5. GALERI FOTO & VIDEO (6 Distinct Curated Images) -->
        @if($gallery->count() || $videos->count())
        <section class="inv-section-card" id="gallery">
            <div class="sec-title-ornate">
                <span class="badge-sub">Momen Bahagia</span>
                <h2>Galeri Kenangan</h2>
                <div class="sep-line"></div>
            </div>

            @if($gallery->count())
                <div class="row g-3 row-cols-2 row-cols-md-3 mb-4">
                    @foreach($gallery as $idx => $g)
                        <div class="col">
                            <div class="rounded-3 overflow-hidden border border-warning border-opacity-35 position-relative shadow-sm" style="aspect-ratio: 1; cursor: pointer;" onclick="openLightbox('{{ $g }}')">
                                <img src="{{ $g }}" alt="Gallery Foto {{ $idx + 1 }}" class="img-fluid w-100 h-100 object-fit-cover" loading="lazy">
                                <div class="position-absolute inset-0 bg-dark bg-opacity-25 d-flex align-items-center justify-content-center opacity-0 hover-opacity-100 transition">
                                    <i class="bi bi-zoom-in text-white fs-3"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if($videos->count())
                <div class="row g-4 justify-content-center">
                    @foreach($videos as $v)
                        <div class="col-md-8 text-center">
                            <div class="rounded-4 overflow-hidden border border-warning border-opacity-35 ratio ratio-16x9 shadow">
                                @if($v['yt'])
                                    <iframe src="https://www.youtube-nocookie.com/embed/{{ $v['yt'] }}" title="{{ $v['title'] }}" allowfullscreen></iframe>
                                @else
                                    <video controls playsinline poster="{{ $v['poster'] }}"><source src="{{ $v['src'] }}" type="video/mp4"></video>
                                @endif
                            </div>
                            @if($v['title'])
                                <div class="small text-readable mt-2">{{ $v['title'] }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
        @endif

        <!-- 6. HADIAH PERNIKAHAN & TANDA KASIH (GIFT) -->
        @if(count($gifts) || !empty($c['gift_address']))
        <section class="inv-section-card" id="gift">
            <div class="sec-title-ornate">
                <span class="badge-sub">Tanda Kasih</span>
                <h2>Amplop Digital</h2>
                <div class="sep-line"></div>
            </div>

            <p class="text-center text-readable small mx-auto mb-4" style="max-width: 520px;">
                Doa restu Anda adalah karunia yang terindah bagi kami. Namun jika Anda berkehendak memberikan tanda kasih, dapat disalurkan melalui:
            </p>

            <div class="row g-3 justify-content-center">
                @foreach($gifts as $g)
                    <div class="col-md-5">
                        <div class="p-4 rounded-4 border border-warning border-opacity-40 text-center" style="background: rgba(6, 26, 19, 0.8);">
                            <div class="font-cinzel text-warning fw-bold fs-5 mb-1">{{ $g['bank'] ?? 'Bank' }}</div>
                            <div class="font-monospace fs-4 fw-bold text-cream my-2" id="acc-{{ $loop->index }}">{{ $g['number'] ?? '' }}</div>
                            <div class="small text-subtle mb-3">a.n {{ $g['name'] ?? '' }}</div>
                            <button type="button" class="btn btn-sm btn-gold-cta py-2 px-3" onclick="copyData('{{ $g['number'] ?? '' }}', 'Nomor rekening')">
                                <i class="bi bi-clipboard me-1"></i> Salin Nomor Rekening
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            @if(!empty($c['gift_address']))
                <div class="text-center mt-4 p-4 rounded-4 border border-warning border-opacity-35 mx-auto" style="max-width: 600px; background: rgba(6, 26, 19, 0.65);">
                    <div class="fw-bold text-gold mb-1"><i class="bi bi-box-seam me-1"></i> Kirim Kado Fisik</div>
                    <p class="text-readable small mb-3">{{ $c['gift_address'] }}</p>
                    <button type="button" class="btn btn-sm btn-outline-warning rounded-pill px-3" onclick="copyData('{{ $c['gift_address'] }}', 'Alamat kado')">
                        <i class="bi bi-clipboard me-1"></i> Salin Alamat Kado
                    </button>
                </div>
            @endif
        </section>
        @endif

        <!-- 7. RSVP ONLINE & BUKU TAMU -->
        <section class="inv-section-card" id="rsvp">
            <div class="sec-title-ornate">
                <span class="badge-sub">Konfirmasi &amp; Doa</span>
                <h2>RSVP &amp; Buku Tamu</h2>
                <div class="sep-line"></div>
            </div>

            <div class="row g-4">
                <!-- Left: RSVP Form -->
                <div class="col-lg-6">
                    <div class="p-4 rounded-4 border border-warning border-opacity-35" style="background: rgba(6, 26, 19, 0.8);">
                        <h4 class="font-cinzel text-gold-gradient fs-5 mb-3 text-center">Konfirmasi Kehadiran</h4>

                        <form id="rsvpOnlineForm" method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small text-gold fw-semibold">Nama Anda <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="fName" class="form-control form-control-emerald" value="{{ $guestName !== 'Tamu Undangan' ? $guestName : '' }}" placeholder="Nama Lengkap" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small text-gold fw-semibold">Konfirmasi Kehadiran</label>
                                <div class="vstack gap-2">
                                    <div class="form-check p-2 rounded-2 border border-secondary border-opacity-35" style="background: rgba(5,23,16,0.7);">
                                        <input class="form-check-input ms-1" type="radio" name="attendance" id="radHadir" value="yes" checked>
                                        <label class="form-check-label text-cream small ms-2" for="radHadir">
                                            <i class="bi bi-check-circle-fill text-success me-1"></i> Dengan senang hati hadir
                                        </label>
                                    </div>
                                    <div class="form-check p-2 rounded-2 border border-secondary border-opacity-35" style="background: rgba(5,23,16,0.7);">
                                        <input class="form-check-input ms-1" type="radio" name="attendance" id="radTidak" value="no">
                                        <label class="form-check-label text-cream small ms-2" for="radTidak">
                                            <i class="bi bi-x-circle-fill text-danger me-1"></i> Mohon maaf, berhalangan hadir
                                        </label>
                                    </div>
                                    <div class="form-check p-2 rounded-2 border border-secondary border-opacity-35" style="background: rgba(5,23,16,0.7);">
                                        <input class="form-check-input ms-1" type="radio" name="attendance" id="radRagu" value="maybe">
                                        <label class="form-check-label text-cream small ms-2" for="radRagu">
                                            <i class="bi bi-question-circle-fill text-warning me-1"></i> Masih belum pasti
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-2 mb-3" id="guestCountRow">
                                <div class="col-6">
                                    <label class="form-label small text-gold fw-semibold">Tamu Dewasa</label>
                                    <select name="total_guests" class="form-select form-control-emerald" id="fAdult">
                                        <option value="1">1 Orang</option>
                                        <option value="2" selected>2 Orang</option>
                                        <option value="3">3 Orang</option>
                                        <option value="4">4 Orang</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-label small text-gold fw-semibold">Tamu Anak</label>
                                    <select class="form-select form-control-emerald" id="fKid">
                                        <option value="0" selected>0 Anak</option>
                                        <option value="1">1 Anak</option>
                                        <option value="2">2 Anak</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small text-gold fw-semibold">Ucapan &amp; Doa Restu</label>
                                <textarea name="message" id="fMsg" rows="3" class="form-control form-control-emerald" placeholder="Tuliskan ucapan dan untaian doa hangat Anda..."></textarea>
                            </div>

                            <button type="submit" class="btn-gold-cta w-100 justify-content-center py-3">
                                <i class="bi bi-send-fill"></i>
                                <span>Kirim Konfirmasi Kehadiran</span>
                            </button>
                            <div class="small text-subtle text-center mt-2" style="font-size: 0.75rem;">RSVP sebelum {{ $deadline }}</div>
                        </form>
                    </div>
                </div>

                <!-- Right: Guestbook Feed -->
                <div class="col-lg-6">
                    <div class="p-4 rounded-4 border border-warning border-opacity-35 h-100 d-flex flex-column" style="background: rgba(6, 26, 19, 0.8);">
                        <h4 class="font-cinzel text-gold-gradient fs-5 mb-3 text-center">Untaian Doa &amp; Ucapan</h4>

                        <!-- Live Stats -->
                        <div class="d-flex justify-content-around text-center p-2 rounded-3 border border-warning border-opacity-25 mb-3" style="background: rgba(5,23,16,0.6);">
                            <div>
                                <div class="fs-4 fw-bold text-gold" id="statWishes">{{ $invitation->messages->count() }}</div>
                                <div class="small text-subtle" style="font-size: 0.72rem;">Ucapan</div>
                            </div>
                            <div class="vr opacity-25"></div>
                            <div>
                                <div class="fs-4 fw-bold text-success" id="statHadir">{{ $invitation->rsvps->where('attendance', 'yes')->count() }}</div>
                                <div class="small text-subtle" style="font-size: 0.72rem;">Hadir</div>
                            </div>
                            <div class="vr opacity-25"></div>
                            <div>
                                <div class="fs-4 fw-bold text-warning" id="statTamu">{{ $invitation->rsvps->where('attendance', 'yes')->sum('total_guests') ?: $invitation->rsvps->where('attendance', 'yes')->count() }}</div>
                                <div class="small text-subtle" style="font-size: 0.72rem;">Total Tamu</div>
                            </div>
                        </div>

                        <!-- Messages Feed -->
                        <div class="vstack gap-3 flex-grow-1 overflow-auto pe-1" id="wishesFeed" style="max-height: 420px;">
                            @forelse($invitation->messages as $msg)
                                <div class="p-3 rounded-3 border border-secondary border-opacity-35" style="background: rgba(5, 23, 16, 0.7);">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <div class="fw-bold text-gold small"><i class="bi bi-person-circle me-1"></i> {{ $msg->name }}</div>
                                        <div class="small text-subtle" style="font-size: 0.7rem;">{{ $msg->created_at ? $msg->created_at->diffForHumans() : 'Baru saja' }}</div>
                                    </div>
                                    <p class="small text-cream mb-0" style="line-height: 1.6;">{{ $msg->message }}</p>
                                </div>
                            @empty
                                <div class="text-center py-4 text-subtle small" id="emptyWishes">
                                    Belum ada ucapan. Jadilah yang pertama memberikan doa restu!
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 8. PENUTUP -->
        <section class="inv-section-card text-center py-5">
            <i class="bi bi-flower1 display-4 text-warning mb-3 d-inline-block"></i>
            <p class="mx-auto text-readable mb-4" style="max-width: 520px; line-height: 1.8;">
                Merupakan suatu kehormatan dan kebahagiaan yang tak terhingga bagi kami sekeluarga apabila Bapak/Ibu/Saudara/i berkenan hadir serta melimpahkan berkah doa restu bagi kedua mempelai.
            </p>
            <div class="font-cinzel text-gold-gradient fs-4 mb-2">Wassalamu'alaikum Warahmatullahi Wabarakatuh</div>
            <div class="font-script display-3 text-gold-light my-2">{{ $coupleTitle }}</div>
            <div class="small text-subtle mt-3">Beserta Keluarga Besar</div>

            <div class="mt-4">
                <button type="button" class="btn-royal-share px-4 py-2" id="bottomShareBtn">
                    <i class="bi bi-share me-1"></i> Bagikan Undangan Ini
                </button>
            </div>
        </section>

    </main>

    <!-- FLOATING BOTTOM NAVIGATION DOCK (IMAGE MATCH: Our Story, Event, Gallery, Gift, RSVP, Maps) -->
    <nav class="royal-dock" id="bottomDock">
        <a href="#story" class="dock-item" title="Kisah Kami">
            <i class="bi bi-heart-pulse"></i>
            <span>Our Story</span>
        </a>
        <a href="#event" class="dock-item" title="Rangkaian Acara">
            <i class="bi bi-calendar-event"></i>
            <span>Event</span>
        </a>
        <a href="#gallery" class="dock-item" title="Galeri Foto">
            <i class="bi bi-camera"></i>
            <span>Gallery</span>
        </a>
        <a href="#gift" class="dock-item" title="Amplop Digital">
            <i class="bi bi-gift"></i>
            <span>Gift</span>
        </a>
        <a href="#rsvp" class="dock-item" title="RSVP & Doa">
            <i class="bi bi-chat-heart"></i>
            <span>RSVP</span>
        </a>
        @if($firstEvent?->maps_url)
            <a href="{{ $firstEvent->maps_url }}" target="_blank" class="dock-item" title="Peta Lokasi">
                <i class="bi bi-geo-alt"></i>
                <span>Maps</span>
            </a>
        @else
            <a href="https://maps.google.com/?q={{ urlencode($venueName) }}" target="_blank" class="dock-item" title="Peta Lokasi">
                <i class="bi bi-geo-alt"></i>
                <span>Maps</span>
            </a>
        @endif
        @if($music)
            <button type="button" class="dock-item" id="dockMusicBtn" title="Musik">
                <i class="bi bi-disc" id="dockMusicIcon"></i>
                <span>Musik</span>
            </button>
        @endif
    </nav>

    <!-- LIGHTBOX DIALOG -->
    <div class="modal fade" id="lightboxModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0 text-center">
                <div class="position-relative d-inline-block mx-auto">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 z-3" data-bs-dismiss="modal"></button>
                    <img id="lightboxImg" src="" alt="Perbesar Gambar" class="img-fluid rounded-4 shadow-lg" style="max-height: 85vh;">
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Audio & Music State
        const bgMusic = document.getElementById('bgMusic');
        const musicToggleBtn = document.getElementById('musicToggleBtn');
        const dockMusicBtn = document.getElementById('dockMusicBtn');
        const musicIcon = document.getElementById('musicIcon');
        const dockMusicIcon = document.getElementById('dockMusicIcon');
        let isMusicPlaying = false;

        function toggleMusic() {
            if (!bgMusic) return;
            if (isMusicPlaying) {
                bgMusic.pause();
                isMusicPlaying = false;
                if (musicToggleBtn) musicToggleBtn.classList.remove('rotating');
                if (dockMusicIcon) dockMusicIcon.className = 'bi bi-disc';
            } else {
                bgMusic.play().then(() => {
                    isMusicPlaying = true;
                    if (musicToggleBtn) musicToggleBtn.classList.add('rotating');
                    if (dockMusicIcon) dockMusicIcon.className = 'bi bi-disc-fill text-warning';
                }).catch(() => {
                    console.log('Autoplay audio blocked by browser policy');
                });
            }
        }
        if (musicToggleBtn) musicToggleBtn.addEventListener('click', toggleMusic);
        if (dockMusicBtn) dockMusicBtn.addEventListener('click', toggleMusic);

        // Unlock Cover Screen
        function unlockInvitation() {
            const cover = document.getElementById('openingCover');
            if (cover) {
                cover.classList.add('opened');
                document.body.classList.remove('locked');
            }
            if (bgMusic && !isMusicPlaying) {
                bgMusic.play().then(() => {
                    isMusicPlaying = true;
                    if (musicToggleBtn) musicToggleBtn.classList.add('rotating');
                    if (dockMusicIcon) dockMusicIcon.className = 'bi bi-disc-fill text-warning';
                }).catch(() => {});
            }
        }

        // Countdown Timer Logic
        const cdContainer = document.getElementById('coverCountdown');
        if (cdContainer) {
            const targetDateStr = cdContainer.getAttribute('data-date') || '2026-01-24';
            const target = new Date(targetDateStr + 'T09:00:00').getTime();

            function updateCountdown() {
                const now = new Date().getTime();
                const dist = target - now;

                if (dist < 0) {
                    document.getElementById('cov-d').textContent = '0';
                    document.getElementById('cov-h').textContent = '0';
                    document.getElementById('cov-m').textContent = '0';
                    document.getElementById('cov-s').textContent = '0';
                    return;
                }

                const d = Math.floor(dist / (1000 * 60 * 60 * 24));
                const h = Math.floor((dist % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const m = Math.floor((dist % (1000 * 60 * 60)) / (1000 * 60));
                const s = Math.floor((dist % (1000 * 60)) / 1000);

                const elD = document.getElementById('cov-d');
                const elH = document.getElementById('cov-h');
                const elM = document.getElementById('cov-m');
                const elS = document.getElementById('cov-s');

                if (elD) elD.textContent = d;
                if (elH) elH.textContent = String(h).padStart(2, '0');
                if (elM) elM.textContent = String(m).padStart(2, '0');
                if (elS) elS.textContent = String(s).padStart(2, '0');
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        }

        // Toast Helper
        function showToast(msg) {
            const t = document.getElementById('toastMsg');
            if (!t) return;
            t.textContent = msg;
            t.classList.add('show');
            setTimeout(() => t.classList.remove('show'), 2500);
        }

        function copyData(val, label) {
            navigator.clipboard.writeText(val).then(() => {
                showToast(label + ' berhasil disalin!');
            }).catch(() => {
                showToast('Salin: ' + val);
            });
        }

        // Share API
        function shareInvitation() {
            const shareData = {
                title: 'The Wedding of {{ $coupleTitle }}',
                text: 'Undangan Pernikahan {{ $coupleTitle }} - {{ $eventDateText }} di {{ $venueName }}',
                url: window.location.href
            };
            if (navigator.share) {
                navigator.share(shareData).catch(() => {});
            } else {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    showToast('Link undangan berhasil disalin!');
                });
            }
        }
        const topShareBtn = document.getElementById('topShareBtn');
        const bottomShareBtn = document.getElementById('bottomShareBtn');
        if (topShareBtn) topShareBtn.addEventListener('click', shareInvitation);
        if (bottomShareBtn) bottomShareBtn.addEventListener('click', shareInvitation);

        // Lightbox
        let lbModal = null;
        function openLightbox(src) {
            const img = document.getElementById('lightboxImg');
            if (img) img.src = src;
            if (!lbModal) {
                lbModal = new bootstrap.Modal(document.getElementById('lightboxModal'));
            }
            lbModal.show();
        }

        // Attendance Radio Toggle Hide/Show Guest Count
        document.querySelectorAll('input[name="attendance"]').forEach(r => {
            r.addEventListener('change', function () {
                const row = document.getElementById('guestCountRow');
                if (row) {
                    row.style.display = (this.value === 'yes') ? '' : 'none';
                }
            });
        });

        // AJAX RSVP Submission
        const rsvpForm = document.getElementById('rsvpOnlineForm');
        if (rsvpForm) {
            rsvpForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalHtml = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Mengirim..';

                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                })
                .then(r => r.json())
                .then(res => {
                    showToast(res.message || 'Konfirmasi kehadiran berhasil dikirim!');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHtml;

                    const msgVal = document.getElementById('fMsg').value.trim();
                    const nameVal = document.getElementById('fName').value.trim();
                    
                    if (msgVal && nameVal) {
                        const empty = document.getElementById('emptyWishes');
                        if (empty) empty.remove();

                        const feed = document.getElementById('wishesFeed');
                        const card = document.createElement('div');
                        card.className = 'p-3 rounded-3 border border-secondary border-opacity-35 mb-2';
                        card.style.background = 'rgba(5, 23, 16, 0.7)';
                        card.innerHTML = `
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="fw-bold text-gold small"><i class="bi bi-person-circle me-1"></i> ${nameVal}</div>
                                <div class="small text-subtle" style="font-size: 0.7rem;">Baru saja</div>
                            </div>
                            <p class="small text-cream mb-0" style="line-height: 1.6;">${msgVal}</p>
                        `;
                        feed.prepend(card);

                        // Increment wish counter
                        const statWishes = document.getElementById('statWishes');
                        if (statWishes) statWishes.textContent = parseInt(statWishes.textContent || 0) + 1;
                    }

                    // Optional WhatsApp Share
                    const waNum = '{{ $wa }}';
                    const attVal = formData.get('attendance');
                    if (waNum) {
                        const attText = (attVal === 'yes') ? 'Insya Allah Hadir' : ((attVal === 'no') ? 'Mohon Maaf Berhalangan' : 'Masih Belum Pasti');
                        const waText = encodeURIComponent(`Halo, saya ${nameVal}. Konfirmasi kehadiran di pernikahan {{ $coupleTitle }}: ${attText}. ${msgVal ? 'Ucapan: ' + msgVal : ''}`);
                        setTimeout(() => {
                            if (confirm('Ingin mengirimkan konfirmasi ini ke WhatsApp pengantin juga?')) {
                                window.open(`https://wa.me/${waNum}?text=${waText}`, '_blank');
                            }
                        }, 500);
                    }

                    document.getElementById('fMsg').value = '';
                })
                .catch(err => {
                    rsvpForm.submit();
                });
            });
        }
    </script>
</body>
</html>
