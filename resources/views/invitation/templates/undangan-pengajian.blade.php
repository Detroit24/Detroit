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
        :root { --p: #1B4D3E; --bg: #F0F4F2; --card: #FFFFFF; --gold: #C5A059; }
        body { background: var(--bg); color: #333; font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        .font-amiri { font-family: 'Amiri', serif; }
        
        /* Lanterns */
        .lantern { position: fixed; top: -50px; pointer-events: none; z-index: -1; animation: swing 3s ease-in-out infinite; }
        @keyframes swing { 0%, 100% { transform: rotate(-5deg); } 50% { transform: rotate(5deg); } }

        /* Islamic Card */
        .islamic-card { background: var(--card); border: 1px solid #D1D9D4; border-radius: 20px; padding: 40px 25px; text-align: center; position: relative; margin-bottom: 40px; box-shadow: 0 10px 30px rgba(27, 77, 62, 0.05); }
        .islamic-card::after { content: '🕌'; position: absolute; bottom: -20px; left: 50%; transform: translateX(-50%); font-size: 2rem; background: var(--bg); padding: 0 15px; }

        /* Opening */
        #openingCover { position: fixed; inset: 0; background: var(--bg); z-index: 10000; display: flex; align-items: center; justify-content: center; transition: 1s cubic-bezier(0.7, 0, 0.3, 1); }
        #openingCover.opened { transform: translateY(-100%); }

        .btn-islamic { background: var(--p); color: #fff; font-weight: 700; border-radius: 10px; padding: 12px 40px; border: none; transition: 0.3s; }
        .btn-islamic:hover { background: var(--gold); transform: translateY(-2px); }
    </style>
</head>
<body>
    <div id="lanterns"></div>

    <div id="openingCover">
        <div class="container text-center">
            <div class="islamic-card mx-auto" style="max-width: 400px; border: none; background: transparent; box-shadow: none;">
                <div class="font-amiri fs-2 mb-2" style="color: var(--p);">Undangan Pengajian</div>
                <h1 class="font-amiri display-4 mb-4" style="color: var(--gold);">Doa Bersama</h1>
                <div class="p-3 bg-white rounded-4 shadow-sm mb-4 border border-success border-opacity-25">
                    <div class="small text-muted mb-1">Kepada Yth:</div>
                    <div class="fs-5 fw-bold">{{ $guestName }}</div>
                </div>
                <button class="btn btn-islamic" onclick="document.getElementById('openingCover').classList.add('opened')">
                    <i class="bi bi-book-half me-2"></i> BUKA UNDANGAN
                </button>
            </div>
        </div>
    </div>

    <div class="container py-5" style="max-width: 650px;">
        <div class="islamic-card">
            <div class="font-amiri fs-3 mb-3" style="color: var(--p);">Assalamu'alaikum Wr. Wb.</div>
            <p class="mb-4">Kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam acara pengajian dan doa bersama.</p>
            <div class="fw-bold fs-4" style="color: var(--gold);">{{ $content['groom_name'] }}</div>
        </div>

        <div class="islamic-card">
            <h4 class="font-amiri fw-bold mb-4" style="color: var(--p); font-size: 1.8rem;">Waktu & Tempat</h4>
            @foreach($invitation->events as $ev)
                <div class="mb-4">
                    <h5 class="fw-bold">{{ $ev->event_name }}</h5>
                    <div class="text-muted"><i class="bi bi-calendar3 me-2"></i> {{ $ev->event_date?->isoFormat('dddd, D MMMM YYYY') }}</div>
                    <div class="text-muted"><i class="bi bi-clock me-2"></i> {{ $ev->event_time }}</div>
                    <div class="mt-2 fw-semibold" style="color: var(--gold);"><i class="bi bi-geo-alt-fill me-1"></i> {{ $ev->location }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        const container = document.getElementById('lanterns');
        for (let i = 0; i < 4; i++) {
            const l = document.createElement('div');
            l.className = 'lantern';
            l.innerHTML = '🏮';
            l.style.left = (i * 30 + 5) + '%';
            l.style.fontSize = '40px';
            l.style.animationDelay = (Math.random() * 2) + 's';
            container.appendChild(l);
        }
    </script>
</body>
</html>
