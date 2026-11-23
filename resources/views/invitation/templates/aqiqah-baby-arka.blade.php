<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }} - DETROIT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        :root { --p: #7A9A7B; --bg: #F2F7F2; --card: #FFFFFF; --text: #4B634C; }
        body { background: var(--bg); color: var(--text); font-family: 'Quicksand', sans-serif; overflow-x: hidden; }
        .font-serif { font-family: 'Playfair Display', serif; }
        
        /* Floating Clouds */
        .cloud { position: fixed; top: 0; pointer-events: none; z-index: -1; opacity: 0.6; animation: drift linear infinite; }
        @keyframes drift { from { transform: translateX(-150px); } to { transform: translateX(100vw); } }

        /* Soft Card */
        .baby-card { background: var(--card); border: 2px solid #ADC1AD; border-radius: 50px 10px 50px 10px; padding: 40px 25px; text-align: center; position: relative; margin-bottom: 40px; box-shadow: 0 10px 25px rgba(122, 154, 123, 0.1); }
        .baby-card::before { content: '👶'; position: absolute; top: -25px; left: 50%; transform: translateX(-50%); font-size: 2.5rem; }

        /* Opening */
        #openingCover { position: fixed; inset: 0; background: var(--bg); z-index: 10000; display: flex; align-items: center; justify-content: center; transition: 1.2s cubic-bezier(0.7, 0, 0.3, 1); }
        #openingCover.opened { transform: translateY(100%); }

        .btn-baby { background: var(--p); color: #fff; font-weight: 700; border-radius: 50px; padding: 12px 40px; border: none; transition: 0.3s; }
        .btn-baby:hover { transform: scale(1.05); filter: brightness(1.1); }
    </style>
</head>
<body>
    <div id="clouds"></div>

    <div id="openingCover">
        <div class="container text-center">
            <div class="baby-card mx-auto" style="max-width: 400px; border: none; background: transparent; box-shadow: none;">
                <div class="text-uppercase fw-bold mb-2" style="color: var(--p); letter-spacing: 2px;">Aqiqah & Tasyakuran</div>
                <h1 class="font-serif display-4 mb-4" style="color: var(--text);">{{ $content['groom_name'] }}</h1>
                <div class="p-3 bg-white rounded-4 shadow-sm mb-4">
                    <div class="small text-muted mb-1">Kepada Yth:</div>
                    <div class="fs-5 fw-bold">{{ $guestName }}</div>
                </div>
                <button class="btn btn-baby" onclick="document.getElementById('openingCover').classList.add('opened')">
                    <i class="bi bi-heart-fill me-2"></i> BUKA UNDANGAN
                </button>
            </div>
        </div>
    </div>

    <div class="container py-5" style="max-width: 650px;">
        <div class="baby-card">
            <h2 class="font-serif display-5 mb-3">Aqiqah</h2>
            <p class="mb-4">Tiada kata yang paling indah selain rasa syukur atas kehadiran buah hati kami.</p>
            <h3 class="fw-bold" style="color: var(--p);">{{ $content['groom_name'] }}</h3>
            <p class="small text-muted">{{ $content['groom_parents'] }}</p>
        </div>

        <div class="baby-card">
            <h4 class="fw-bold mb-4" style="color: var(--p);">Pelaksanaan Acara</h4>
            @foreach($invitation->events as $ev)
                <div class="mb-4">
                    <h5 class="fw-bold">{{ $ev->event_name }}</h5>
                    <div class="text-muted"><i class="bi bi-calendar-check me-2"></i> {{ $ev->event_date?->isoFormat('dddd, D MMMM YYYY') }}</div>
                    <div class="text-muted"><i class="bi bi-clock me-2"></i> {{ $ev->event_time }}</div>
                    <div class="mt-2 fw-semibold"><i class="bi bi-geo-alt me-1"></i> {{ $ev->location }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        const container = document.getElementById('clouds');
        for (let i = 0; i < 6; i++) {
            const c = document.createElement('div');
            c.className = 'cloud';
            c.innerHTML = '☁️';
            c.style.fontSize = (Math.random() * 50 + 50) + 'px';
            c.style.top = (Math.random() * 100) + 'vh';
            c.style.animationDuration = (Math.random() * 20 + 20) + 's';
            c.style.animationDelay = (Math.random() * 10) + 's';
            container.appendChild(c);
        }
    </script>
</body>
</html>
