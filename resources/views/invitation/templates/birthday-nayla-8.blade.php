<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }} - DETROIT Premium</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        :root { --p: #D85A7F; --bg: #FFE8EC; --card: #FFFFFF; --text: #2E282A; }
        body { background: var(--bg); color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        
        /* Festive Pattern Background */
        body::before {
            content: ""; position: fixed; inset: 0; 
            background-image: url('https://www.transparenttextures.com/patterns/confetti.png');
            opacity: 0.3; z-index: -2;
        }

        .font-fredoka { font-family: 'Fredoka', sans-serif; }

        /* Cover Section */
        #openingCover { 
            position: fixed; inset: 0; z-index: 10000; 
            background: linear-gradient(135deg, #FFB4C2 0%, #D85A7F 100%);
            display: flex; align-items: center; justify-content: center; text-align: center; color: #fff;
            transition: 1s cubic-bezier(0.85, 0, 0.15, 1);
        }
        #openingCover.opened { transform: scale(1.5); opacity: 0; pointer-events: none; }

        /* Floating Nav */
        .inv-nav { 
            position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); 
            background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);
            padding: 10px 20px; border-radius: 50px; display: flex; gap: 20px; 
            box-shadow: 0 10px 30px rgba(216, 90, 127, 0.2); z-index: 999; border: 2px solid var(--p);
        }
        .inv-nav a { color: var(--p); font-size: 1.2rem; transition: 0.3s; }
        .inv-nav a:hover { transform: scale(1.3); }

        .fun-card { 
            background: var(--card); border: 4px solid var(--p); border-radius: 40px; 
            padding: 40px 25px; margin-bottom: 50px; box-shadow: 0 15px 35px rgba(216, 90, 127, 0.1);
        }
        .fun-card::before { content: '🎈'; position: absolute; top: -30px; left: 50%; transform: translateX(-50%); font-size: 3rem; }

        .btn-fun { background: var(--p); color: #fff; border: none; padding: 12px 30px; border-radius: 50px; font-weight: 700; font-family: 'Fredoka'; }
        .countdown-item { background: #fff; border: 2px solid var(--p); color: var(--p); width: 70px; height: 70px; display: flex; flex-direction: column; align-items: center; justify-content: center; border-radius: 20px; }
        
        .balloon { position: fixed; bottom: -100px; z-index: -1; animation: floatUp linear infinite; }
        @keyframes floatUp { to { transform: translateY(-110vh) rotate(360deg); } }
    </style>
</head>
<body>
    <div id="balloonField"></div>

    <div id="openingCover">
        <div class="container" data-aos="zoom-in">
            <h4 class="font-fredoka mb-3" style="letter-spacing: 3px;">BIRTHDAY PARTY</h4>
            <h1 class="font-fredoka display-1 mb-4">Happy Birthday {{ $content['groom_name'] }}!</h1>
            <div class="p-3 rounded-4 mb-4" style="background: rgba(255,255,255,0.2);">
                <p class="small mb-1">Kepada Yth. Sahabat:</p>
                <h3 class="font-fredoka text-white">{{ $guestName }}</h3>
            </div>
            <button class="btn btn-fun px-5 py-3 shadow-lg" onclick="startInv()">
                <i class="bi bi-gift-fill me-2"></i> BUKA KADO
            </button>
        </div>
    </div>

    <audio id="bgMusic" loop>
        <source src="https://cdn.pixabay.com/download/audio/2022/10/24/audio_323f4625b1.mp3" type="audio/mpeg">
    </audio>

    <div class="inv-nav">
        <a href="#home"><i class="bi bi-house-heart"></i></a>
        <a href="#couple"><i class="bi bi-gift"></i></a>
        <a href="#event"><i class="bi bi-calendar-event"></i></a>
        <a href="#guestbook"><i class="bi bi-chat-dots"></i></a>
    </div>

    <div class="container py-5" style="max-width: 600px;">
        <section id="home" class="text-center mb-5" data-aos="fade-up">
            <img src="https://cdn-icons-png.flaticon.com/512/2488/2488614.png" width="100" class="mb-4">
            <h2 class="font-fredoka display-4 mb-3" style="color: var(--p);">Hooray!</h2>
            <p class="px-4">Let's celebrate another year of fun and laughter!</p>
        </section>

        <section class="fun-card text-center" data-aos="fade-up">
            <h5 class="font-fredoka mb-4" style="color: var(--p);">COUNTDOWN</h5>
            <div class="d-flex justify-content-center gap-3">
                <div class="countdown-item"><span id="cdD">00</span><small>Hari</small></div>
                <div class="countdown-item"><span id="cdH">00</span><small>Jam</small></div>
                <div class="countdown-item"><span id="cdM">00</span><small>Menit</small></div>
                <div class="countdown-item"><span id="cdS">00</span><small>Detik</small></div>
            </div>
        </section>

        <section id="event" class="fun-card" data-aos="fade-up">
            <h4 class="font-fredoka text-center mb-5" style="color: var(--p);">PARTY INFO</h4>
            @foreach($invitation->events as $ev)
            <div class="mb-5 text-center">
                <div class="h4 font-fredoka mb-1">{{ $ev->event_name }}</div>
                <div class="text-muted small mb-3"><i class="bi bi-calendar-check me-2"></i>{{ $ev->event_date?->isoFormat('dddd, D MMMM YYYY') }}</div>
                <div class="p-3 bg-light rounded-4 mb-3">
                    <div class="small fw-bold"><i class="bi bi-clock me-2"></i>WAKTU</div>
                    <div>{{ $ev->event_time }} - Selesai</div>
                </div>
                <div class="mb-3">
                    <div class="small fw-bold"><i class="bi bi-geo-alt me-1"></i>LOKASI</div>
                    <div class="fw-semibold">{{ $ev->location }}</div>
                    <p class="small text-muted px-3">{{ $ev->description }}</p>
                </div>
                <a href="https://maps.google.com/?q={{ urlencode($ev->location) }}" target="_blank" class="btn btn-fun btn-sm rounded-pill">
                    <i class="bi bi-map me-2"></i>LIHAT GOOGLE MAPS
                </a>
            </div>
            @if(!$loop->last) <hr class="opacity-10 my-5"> @endif
            @endforeach
        </section>

        <section id="guestbook" class="fun-card" data-aos="fade-up">
            <h4 class="font-fredoka text-center mb-4" style="color: var(--p);">BIRTHDAY WISHES</h4>
            <div class="mb-4">
                <textarea class="form-control border-0 bg-light rounded-4 p-3 mb-3" rows="3" placeholder="Tulis ucapan ultahmu..."></textarea>
                <button class="btn btn-fun w-100 rounded-pill py-2 shadow">KIRIM UCAPAN</button>
            </div>
            <div style="max-height: 400px; overflow-y: auto;">
                <div class="p-3 border-bottom border-light">
                    <div class="fw-bold small">Nayla <span class="badge bg-fun ms-2" style="background: var(--p);">Hadir</span></div>
                    <p class="small text-muted mb-0">HBD! Wish you all the best!</p>
                </div>
            </div>
        </section>

        <div class="text-center py-5 opacity-50">
            <p class="small mb-0">Created with love by</p>
            <h5 class="font-fredoka">DETROIT INVITATION</h5>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 1000, once: true });

        function startInv() {
            document.getElementById('openingCover').classList.add('opened');
            document.getElementById('bgMusic').play().catch(() => {});
        }

        // Balloons
        const field = document.getElementById('balloonField');
        const colors = ['#FFB4C2', '#FAD074', '#B3D9FF', '#E5C7F5'];
        for(let i=0; i<15; i++) {
            const b = document.createElement('div');
            b.className = 'balloon';
            b.style.left = Math.random()*100+'%';
            b.style.width = b.style.height = (Math.random()*30+30)+'px';
            b.style.background = colors[Math.floor(Math.random()*colors.length)];
            b.style.borderRadius = '50%';
            b.style.animationDuration = (Math.random()*10+10)+'s';
            b.style.animationDelay = (Math.random()*5)+'s';
            field.appendChild(b);
        }

        // Countdown
        const targetDate = new Date("{{ $primaryEvent?->event_date?->format('Y-m-d') ?? '2024-12-14' }}T08:00:00").getTime();
        setInterval(function() {
            const now = new Date().getTime();
            const d = targetDate - now;
            if(d > 0) {
                document.getElementById('cdD').innerText = Math.floor(d / (1000 * 60 * 60 * 24));
                document.getElementById('cdH').innerText = Math.floor((d % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                document.getElementById('cdM').innerText = Math.floor((d % (1000 * 60 * 60)) / (1000 * 60));
                document.getElementById('cdS').innerText = Math.floor((d % (1000 * 60)) / 1000);
            }
        }, 1000);
    </script>
</body>
</html>
