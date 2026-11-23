<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }} - DETROIT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Playfair+Display:wght@400;700&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root { --p: #D4AF37; --bg: #111111; --card: #1B1B1B; --text: #FFFFFF; }
        body { background: var(--bg); color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        .font-cinzel { font-family: 'Cinzel', serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        
        /* Gold Dust Particles */
        .particle { position: fixed; pointer-events: none; z-index: -1; background: var(--p); border-radius: 50%; animation: sparkle linear infinite; }
        @keyframes sparkle { 0% { transform: translateY(0) scale(0); opacity: 0; } 50% { opacity: 1; } 100% { transform: translateY(-100vh) scale(1); opacity: 0; } }

        /* Royal Card */
        .royal-card { background: var(--card); border: 2px solid var(--p); padding: 50px 30px; text-align: center; position: relative; margin-bottom: 40px; box-shadow: 0 0 30px rgba(212, 175, 55, 0.1); }
        .royal-card::before { content: ''; position: absolute; inset: 10px; border: 1px solid var(--p); opacity: 0.3; }

        /* Opening */
        #openingCover { position: fixed; inset: 0; background: var(--bg); z-index: 10000; display: flex; align-items: center; justify-content: center; transition: 1.5s cubic-bezier(0.19, 1, 0.22, 1); }
        #openingCover.opened { transform: scale(1.1); opacity: 0; pointer-events: none; }

        .btn-royal { background: transparent; color: var(--p); font-weight: 700; border: 2px solid var(--p); border-radius: 0; padding: 15px 50px; transition: 0.4s; letter-spacing: 3px; }
        .btn-royal:hover { background: var(--p); color: #000; }
    </style>
</head>
<body>
    <div id="particles"></div>

    <div id="openingCover">
        <div class="container text-center">
            <div class="royal-card mx-auto" style="max-width: 450px; border: none; background: transparent;">
                <div class="font-cinzel small mb-3" style="color: var(--p); letter-spacing: 8px;">ROYAL WEDDING</div>
                <h1 class="font-serif display-4 mb-4" style="color: var(--p);">{{ $content['groom_name'] }} & {{ $content['bride_name'] }}</h1>
                <div class="mb-5">
                    <div class="small opacity-50 mb-1">UNTUK SAUDARA/I:</div>
                    <div class="fs-4 font-cinzel" style="color: var(--p);">{{ $guestName }}</div>
                </div>
                <button class="btn btn-royal" onclick="document.getElementById('openingCover').classList.add('opened')">OPEN INVITATION</button>
            </div>
        </div>
    </div>

    <div class="container py-5" style="max-width: 600px;">
        <div class="royal-card">
            <div class="font-cinzel small mb-2" style="color: var(--p); letter-spacing: 4px;">WALIMATUL 'URSY</div>
            <h2 class="font-serif display-5 mb-3" style="color: var(--p);">{{ $content['groom_name'] }} & {{ $content['bride_name'] }}</h2>
            <div class="small mb-4" style="letter-spacing: 2px; color: #888;">{{ mb_strtoupper($eventDateLabel) }}</div>
            <hr style="width: 50px; margin: 30px auto; border-color: var(--p);">
            <p class="fst-italic small" style="color: #AAA;">"{{ $content['quote'] }}"</p>
        </div>

        <div class="royal-card">
            <h4 class="font-cinzel small mb-4" style="color: var(--p); letter-spacing: 4px;">SAVE THE DATE</h4>
            @foreach($invitation->events as $ev)
                <div class="mb-4">
                    <h5 class="font-serif" style="color: var(--p);">{{ $ev->event_name }}</h5>
                    <div class="small text-muted">{{ $ev->event_date?->isoFormat('dddd, D MMMM YYYY') }}</div>
                    <div class="small text-muted">{{ $ev->event_time }}</div>
                    <div class="mt-2 fw-bold small" style="letter-spacing: 1px; color: #888;">{{ $ev->location }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        const container = document.getElementById('particles');
        for (let i = 0; i < 50; i++) {
            const p = document.createElement('div');
            p.className = 'particle';
            p.style.left = Math.random() * 100 + '%';
            p.style.top = (Math.random() * 100 + 100) + '%';
            p.style.width = p.style.height = (Math.random() * 3 + 1) + 'px';
            p.style.animationDuration = (Math.random() * 5 + 5) + 's';
            p.style.animationDelay = (Math.random() * 5) + 's';
            container.appendChild(p);
        }
    </script>
</body>
</html>
