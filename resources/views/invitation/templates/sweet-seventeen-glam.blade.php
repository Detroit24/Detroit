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
        :root { --p: #D85A7F; --bg: #FFF0F5; --card: #FFFFFF; --gold: #E8C36A; }
        body { background: var(--bg); color: #333; font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        .font-cursive { font-family: 'Great Vibes', cursive; }
        .font-serif { font-family: 'Playfair Display', serif; }
        
        /* Sparkles */
        .sparkle { position: fixed; pointer-events: none; z-index: -1; background: var(--gold); border-radius: 50%; animation: sparkle linear infinite; }
        @keyframes sparkle { 0% { transform: translateY(0) scale(0); opacity: 0; } 50% { opacity: 1; } 100% { transform: translateY(-100vh) scale(1); opacity: 0; } }

        /* Glam Card */
        .glam-card { background: var(--card); border: 2px solid var(--gold); border-radius: 30px; padding: 50px 30px; text-align: center; position: relative; margin-bottom: 40px; box-shadow: 0 15px 40px rgba(232, 195, 106, 0.15); }
        .glam-card::before { content: '✨'; position: absolute; top: -25px; left: 50%; transform: translateX(-50%); font-size: 2.5rem; }

        /* Opening */
        #openingCover { position: fixed; inset: 0; background: linear-gradient(135deg, #FFF0F5 0%, #FFE4E1 100%); z-index: 10000; display: flex; align-items: center; justify-content: center; transition: 1.2s cubic-bezier(0.85, 0, 0.15, 1); }
        #openingCover.opened { transform: scale(1.1); opacity: 0; pointer-events: none; }

        .btn-glam { background: linear-gradient(135deg, var(--gold), #D4AF37); color: #fff; font-weight: 700; border-radius: 50px; padding: 12px 40px; border: none; transition: 0.3s; }
        .btn-glam:hover { transform: scale(1.05); box-shadow: 0 10px 20px rgba(232, 195, 106, 0.3); }
    </style>
</head>
<body>
    <div id="sparkles"></div>

    <div id="openingCover">
        <div class="container text-center">
            <div class="glam-card mx-auto" style="max-width: 400px; background: transparent; border: none; box-shadow: none;">
                <div class="font-cursive display-5 mb-2" style="color: var(--gold);">Sweet Seventeen</div>
                <h1 class="font-serif display-4 mb-4" style="color: var(--p);">{{ $content['groom_name'] }}</h1>
                <div class="p-3 bg-white rounded-4 shadow-sm mb-4 border border-warning border-opacity-25">
                    <div class="small text-muted mb-1">Kepada Yth:</div>
                    <div class="fs-5 fw-bold">{{ $guestName }}</div>
                </div>
                <button class="btn btn-glam" onclick="document.getElementById('openingCover').classList.add('opened')">
                    <i class="bi bi-stars me-2"></i> BUKA UNDANGAN
                </button>
            </div>
        </div>
    </div>

    <div class="container py-5" style="max-width: 650px;">
        <div class="glam-card">
            <div class="font-cursive display-6 mb-2" style="color: var(--gold);">Sweet Seventeen Party</div>
            <h2 class="font-serif display-5 fw-bold mb-3" style="color: var(--p);">{{ $content['groom_name'] }}</h2>
            <div class="fw-semibold small letter-spacing-2 mb-4" style="color: var(--gold);">{{ mb_strtoupper($eventDateLabel) }}</div>
            
            <div class="p-4 rounded-4 mb-2" style="background: linear-gradient(135deg, #FFF0F5 0%, #FFF 100%); border: 1px solid #F2D4DC;">
                <p class="fst-italic text-secondary small mb-2">"{{ $content['quote'] }}"</p>
                <div class="fw-bold small" style="color: var(--gold);">{{ $content['quote_source'] }}</div>
            </div>
        </div>

        <div class="glam-card">
            <h4 class="font-serif fw-bold mb-4" style="color: var(--gold);">Pesta Ulang Tahun</h4>
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
        const container = document.getElementById('sparkles');
        for (let i = 0; i < 40; i++) {
            const s = document.createElement('div');
            s.className = 'sparkle';
            s.style.left = Math.random() * 100 + '%';
            s.style.top = (Math.random() * 100 + 100) + '%';
            s.style.width = s.style.height = (Math.random() * 4 + 2) + 'px';
            s.style.animationDuration = (Math.random() * 4 + 4) + 's';
            s.style.animationDelay = (Math.random() * 4) + 's';
            container.appendChild(s);
        }
    </script>
</body>
</html>
