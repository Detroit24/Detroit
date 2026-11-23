<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }} - DETROIT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Plus+Jakarta+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root { --p: #C5A059; --bg: #F9F7F2; --card: #FFFFFF; --accent: #1B4D3E; }
        body { background: var(--bg); color: #333; font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        .font-amiri { font-family: 'Amiri', serif; }
        
        /* Desert Vibes (Clouds/Sand) */
        .sand { position: fixed; top: 0; pointer-events: none; z-index: -1; opacity: 0.2; animation: drift 30s linear infinite; }
        @keyframes drift { from { transform: translateX(-100px); } to { transform: translateX(100vw); } }

        /* Mecca Style Card */
        .mecca-card { background: var(--card); border: 2px solid var(--p); border-radius: 15px; padding: 40px 25px; text-align: center; position: relative; margin-bottom: 40px; box-shadow: 0 10px 30px rgba(197, 160, 89, 0.1); }
        .mecca-card::before { content: '🕌'; position: absolute; top: -25px; left: 50%; transform: translateX(-50%); font-size: 2.5rem; background: var(--bg); padding: 0 10px; }

        /* Opening */
        #openingCover { position: fixed; inset: 0; background: #F9F7F2; z-index: 10000; display: flex; align-items: center; justify-content: center; transition: 1.2s cubic-bezier(0.7, 0, 0.3, 1); }
        #openingCover.opened { transform: translateY(-100%); }

        .btn-mecca { background: var(--p); color: #fff; font-weight: 700; border-radius: 5px; padding: 12px 40px; border: none; transition: 0.3s; letter-spacing: 2px; }
        .btn-mecca:hover { background: var(--accent); transform: scale(1.05); }
    </style>
</head>
<body>
    <div id="openingCover">
        <div class="container text-center">
            <div class="mecca-card mx-auto" style="max-width: 400px; border: none; background: transparent; box-shadow: none;">
                <div class="font-amiri fs-2 mb-2" style="color: var(--p);">Walimatussafar</div>
                <h1 class="font-amiri display-4 mb-4" style="color: var(--accent);">Haji & Umroh</h1>
                <div class="p-3 bg-white rounded-4 shadow-sm mb-4 border border-warning border-opacity-25">
                    <div class="small text-muted mb-1">Kepada Yth:</div>
                    <div class="fs-5 fw-bold">{{ $guestName }}</div>
                </div>
                <button class="btn btn-mecca" onclick="document.getElementById('openingCover').classList.add('opened')">
                    <i class="bi bi-compass-fill me-2"></i> BUKA UNDANGAN
                </button>
            </div>
        </div>
    </div>

    <div class="container py-5" style="max-width: 650px;">
        <div class="mecca-card">
            <div class="font-amiri fs-3 mb-3" style="color: var(--accent);">Labbaik Allahumma Labbaik</div>
            <p class="mb-4">Mohon doa restu atas keberangkatan kami memenuhi panggilan Allah SWT ke Baitullah.</p>
            <div class="fw-bold fs-4" style="color: var(--p);">{{ $content['groom_name'] }}</div>
        </div>

        <div class="mecca-card">
            <h4 class="font-amiri fw-bold mb-4" style="color: var(--accent); font-size: 1.8rem;">Waktu & Lokasi</h4>
            @foreach($invitation->events as $ev)
                <div class="mb-4">
                    <h5 class="fw-bold">{{ $ev->event_name }}</h5>
                    <div class="text-muted"><i class="bi bi-calendar-event me-2"></i> {{ $ev->event_date?->isoFormat('dddd, D MMMM YYYY') }}</div>
                    <div class="text-muted"><i class="bi bi-clock me-2"></i> {{ $ev->event_time }}</div>
                    <div class="mt-2 fw-semibold" style="color: var(--p);"><i class="bi bi-geo-alt-fill me-1"></i> {{ $ev->location }}</div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
