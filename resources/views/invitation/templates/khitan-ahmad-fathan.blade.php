<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }} - DETROIT Premium</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Cinzel:wght@400;700&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        :root { --p: #E8C36A; --bg: #0B1726; --card: #142B47; --text: #FFFFFF; }
        body { background: var(--bg); color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        
        /* Islamic Star Background */
        #starCanvas { position: fixed; inset: 0; z-index: -1; }
        .font-amiri { font-family: 'Amiri', serif; }
        .font-cinzel { font-family: 'Cinzel', serif; }

        /* Cover Section */
        #openingCover { 
            position: fixed; inset: 0; z-index: 10000; 
            background: radial-gradient(circle at center, #142B47, #0B1726);
            display: flex; align-items: center; justify-content: center; text-align: center;
            transition: 1.5s transform cubic-bezier(0.85, 0, 0.15, 1);
        }
        #openingCover.opened { transform: translateY(-100%); }

        /* Floating Nav */
        .inv-nav { 
            position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); 
            background: rgba(20, 43, 71, 0.8); backdrop-filter: blur(10px);
            padding: 10px 20px; border-radius: 50px; display: flex; gap: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.3); z-index: 999; border: 1px solid rgba(232,195,106,0.3);
        }
        .inv-nav a { color: var(--text); font-size: 1.2rem; transition: 0.3s; }
        .inv-nav a:hover { color: var(--p); transform: scale(1.2); }

        /* Islamic Arch Card */
        .arch-card { 
            background: var(--card); border: 1px solid #255082; border-radius: 30px; 
            padding: 40px 25px; margin-bottom: 50px; position: relative;
        }
        .arch-card::before { 
            content: ''; position: absolute; top: -15px; left: 50%; transform: translateX(-50%);
            width: 60px; height: 30px; background: var(--p); clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
        }

        .btn-gold { background: var(--p); color: var(--bg); border: none; padding: 12px 30px; border-radius: 50px; font-weight: 700; }
        .countdown-item { background: #1C3D63; border: 1px solid #255082; color: #fff; width: 70px; height: 70px; display: flex; flex-direction: column; align-items: center; justify-content: center; border-radius: 12px; }
    </style>
</head>
<body>
    <canvas id="starCanvas"></canvas>

    <div id="openingCover">
        <div class="container" data-aos="zoom-in">
            <h4 class="font-amiri display-4 mb-3" style="color: var(--p);">Tasyakuran Khitan</h4>
            <h1 class="font-cinzel display-3 mb-4">{{ $content['groom_name'] }}</h1>
            <div class="p-3 rounded-4 mb-4 border border-info border-opacity-25" style="background: rgba(255,255,255,0.05);">
                <p class="small mb-1 opacity-75">Kepada Yth. Bapak/Ibu/Saudara/i:</p>
                <h3 class="font-serif">{{ $guestName }}</h3>
            </div>
            <button class="btn btn-gold px-5 py-3" onclick="startInv()">
                <i class="bi bi-envelope-open me-2"></i> BUKA UNDANGAN
            </button>
        </div>
    </div>

    <audio id="bgMusic" loop>
        <source src="https://cdn.pixabay.com/download/audio/2023/03/01/audio_1808fbf07a.mp3" type="audio/mpeg">
    </audio>

    <div class="inv-nav">
        <a href="#home"><i class="bi bi-house-heart"></i></a>
        <a href="#couple"><i class="bi bi-people"></i></a>
        <a href="#event"><i class="bi bi-calendar-event"></i></a>
        <a href="#guestbook"><i class="bi bi-chat-dots"></i></a>
    </div>

    <div class="container py-5" style="max-width: 600px;">
        <section id="home" class="text-center mb-5" data-aos="fade-up">
            <i class="bi bi-moon-stars display-1" style="color: var(--p);"></i>
            <h2 class="font-amiri display-3 mt-3">Assalamu'alaikum</h2>
            <p class="opacity-75 px-4">Maka nikmat Tuhanmu yang manakah yang kamu dustakan?</p>
        </section>

        <section class="arch-card text-center" data-aos="fade-up">
            <h5 class="font-cinzel mb-4" style="color: var(--p);">COUNTDOWN</h5>
            <div class="d-flex justify-content-center gap-3">
                <div class="countdown-item"><span id="cdD">00</span><small>Hari</small></div>
                <div class="countdown-item"><span id="cdH">00</span><small>Jam</small></div>
                <div class="countdown-item"><span id="cdM">00</span><small>Menit</small></div>
                <div class="countdown-item"><span id="cdS">00</span><small>Detik</small></div>
            </div>
        </section>

        <section id="couple" class="mb-5">
            <div class="arch-card text-center" data-aos="fade-right">
                <div class="mx-auto rounded-circle overflow-hidden mb-4 border border-4 border-warning shadow" style="width: 150px; height: 150px; background: url('https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?auto=format&fit=crop&q=80&w=300') center/cover;"></div>
                <h3 class="font-cursive display-5" style="color: var(--p);">{{ $content['groom_name'] }}</h3>
                <p class="opacity-75 small">{{ $content['groom_parents'] }}</p>
            </div>
        </section>

        <section id="event" class="arch-card" data-aos="fade-up">
            <h4 class="font-cinzel text-center mb-5" style="color: var(--p);">ACARA</h4>
            @foreach($invitation->events as $ev)
            <div class="mb-5 text-center">
                <div class="h5 fw-bold mb-1">{{ $ev->event_name }}</div>
                <div class="opacity-75 small mb-3"><i class="bi bi-calendar-check me-2"></i>{{ $ev->event_date?->isoFormat('dddd, D MMMM YYYY') }}</div>
                <div class="p-3 rounded-4 mb-3" style="background: rgba(255,255,255,0.05);">
                    <div class="small fw-bold"><i class="bi bi-clock me-2"></i>WAKTU</div>
                    <div>{{ $ev->event_time }} - Selesai</div>
                </div>
                <div class="mb-3">
                    <div class="small fw-bold"><i class="bi bi-geo-alt me-1"></i>LOKASI</div>
                    <div class="fw-semibold">{{ $ev->location }}</div>
                    <p class="small opacity-75 px-3">{{ $ev->description }}</p>
                </div>
                <a href="https://maps.google.com/?q={{ urlencode($ev->location) }}" target="_blank" class="btn btn-gold btn-sm rounded-pill">
                    <i class="bi bi-map me-2"></i>LIHAT GOOGLE MAPS
                </a>
            </div>
            @if(!$loop->last) <hr class="border-info opacity-25 my-5"> @endif
            @endforeach
        </section>

        <section id="guestbook" class="arch-card" data-aos="fade-up">
            <h4 class="font-cinzel text-center mb-4" style="color: var(--p);">GUESTBOOK</h4>
            <div class="mb-4">
                <textarea class="form-control border-0 rounded-4 p-3 mb-3" style="background: rgba(255,255,255,0.05); color: #fff;" rows="3" placeholder="Tulis ucapan & doa restu..."></textarea>
                <button class="btn btn-gold w-100 rounded-pill py-2">KIRIM UCAPAN</button>
            </div>
            <div style="max-height: 400px; overflow-y: auto;">
                <div class="msg-item border-bottom border-secondary border-opacity-25 py-3">
                    <div class="fw-bold small">Ahmad Fathan <span class="badge bg-gold ms-2">Hadir</span></div>
                    <p class="small opacity-75 mb-0">Barakallah! Semoga menjadi anak sholeh.</p>
                </div>
            </div>
        </section>

        <div class="text-center py-5 opacity-50">
            <p class="small mb-0">Created with love by</p>
            <h5 class="font-cinzel">DETROIT INVITATION</h5>
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

        // Star Field
        const canvas = document.getElementById('starCanvas');
        const ctx = canvas.getContext('2d');
        let stars = [];
        function resize() { canvas.width = window.innerWidth; canvas.height = window.innerHeight; }
        window.addEventListener('resize', resize); resize();
        for(let i=0; i<150; i++) stars.push({ x: Math.random()*canvas.width, y: Math.random()*canvas.height, r: Math.random()*1.5, s: Math.random()*0.5 + 0.1 });
        function draw() {
            ctx.clearRect(0,0,canvas.width,canvas.height);
            stars.forEach(s => {
                ctx.fillStyle = 'rgba(255,255,255,' + (0.5 + Math.sin(Date.now()*0.001*s.s)*0.5) + ')';
                ctx.beginPath(); ctx.arc(s.x, s.y, s.r, 0, Math.PI*2); ctx.fill();
            });
            requestAnimationFrame(draw);
        }
        draw();

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
