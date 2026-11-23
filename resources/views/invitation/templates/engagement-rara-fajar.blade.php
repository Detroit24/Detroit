<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }} - DETROIT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;700&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root { --p: #C06C84; --bg: #FDF6F8; --card: #FFFFFF; --text: #2C241E; }
        body { background: var(--bg); color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        .font-cursive { font-family: 'Great Vibes', cursive; }
        .font-serif { font-family: 'Playfair Display', serif; }
        
        /* Falling Hearts */
        .heart { position: fixed; top: -10%; pointer-events: none; z-index: -1; animation: fall linear infinite; }
        @keyframes fall { to { transform: translateY(110vh) rotate(360deg); } }

        /* Elegant Card */
        .engagement-card { background: var(--card); border: 1px solid #F2D4DC; border-radius: 30px; padding: 50px 30px; text-align: center; position: relative; margin-bottom: 40px; box-shadow: 0 15px 40px rgba(192, 108, 132, 0.1); }
        .engagement-card::before { content: '💍'; position: absolute; top: -25px; left: 50%; transform: translateX(-50%); font-size: 2.5rem; }

        /* Opening */
        #openingCover { position: fixed; inset: 0; background: #FDF6F8; z-index: 10000; display: flex; align-items: center; justify-content: center; transition: 1.2s cubic-bezier(0.85, 0, 0.15, 1); }
        #openingCover.opened { transform: scale(1.1); opacity: 0; pointer-events: none; }

        .btn-eng { background: var(--p); color: #fff; font-weight: 700; border-radius: 50px; padding: 12px 40px; border: none; transition: 0.3s; }
        .btn-eng:hover { transform: scale(1.05); box-shadow: 0 10px 20px rgba(192, 108, 132, 0.3); }
    </style>
</head>
<body>
    <div id="hearts"></div>

    <div id="openingCover">
        <div class="container text-center">
            <div class="engagement-card mx-auto" style="max-width: 400px; background: transparent; border: none; box-shadow: none;">
                <div class="font-cursive display-5 mb-2" style="color: var(--p);">The Engagement of</div>
                <h1 class="font-serif display-4 mb-4" style="color: var(--text);">{{ $content['groom_name'] }} & {{ $content['bride_name'] }}</h1>
                <div class="p-3 bg-white rounded-4 shadow-sm mb-4">
                    <div class="small text-muted mb-1">Kepada Yth:</div>
                    <div class="fs-5 fw-bold">{{ $guestName }}</div>
                </div>
                <button class="btn btn-eng" onclick="document.getElementById('openingCover').classList.add('opened')">
                    <i class="bi bi-gem me-2"></i> BUKA UNDANGAN
                </button>
            </div>
        </div>
    </div>

    <div class="container py-5" style="max-width: 650px;">
        <div class="engagement-card">
            <div class="font-cursive display-6 mb-2" style="color: var(--p);">Lamaran</div>
            <h2 class="font-serif display-5 fw-bold mb-3">{{ $content['groom_name'] }} & {{ $content['bride_name'] }}</h2>
            <div class="fw-semibold small letter-spacing-2 mb-4" style="color: var(--p);">{{ mb_strtoupper($eventDateLabel) }}</div>
            
            <div class="p-4 rounded-4 mb-2" style="background-color: #FDF6F8; border-left: 4px solid var(--p);">
                <p class="fst-italic text-secondary small mb-2">"{{ $content['quote'] }}"</p>
                <div class="fw-bold small" style="color: var(--p);">{{ $content['quote_source'] }}</div>
            </div>
        </div>

        <div class="engagement-card">
            <h4 class="font-serif fw-bold mb-4" style="color: var(--p);">Waktu & Lokasi</h4>
            @foreach($invitation->events as $ev)
                <div class="mb-4">
                    <h5 class="fw-bold">{{ $ev->event_name }}</h5>
                    <div class="text-muted small"><i class="bi bi-calendar3 me-2"></i> {{ $ev->event_date?->isoFormat('dddd, D MMMM YYYY') }}</div>
                    <div class="text-muted small"><i class="bi bi-clock me-2"></i> {{ $ev->event_time }}</div>
                    <div class="mt-2 fw-semibold"><i class="bi bi-geo-alt-fill me-1"></i> {{ $ev->location }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        const container = document.getElementById('hearts');
        for (let i = 0; i < 15; i++) {
            const h = document.createElement('div');
            h.className = 'heart';
            h.innerHTML = '❤️';
            h.style.left = Math.random() * 100 + '%';
            h.style.animationDuration = (Math.random() * 5 + 5) + 's';
            h.style.fontSize = (Math.random() * 10 + 10) + 'px';
            container.appendChild(h);
        }
    </script>
</body>
</html>
