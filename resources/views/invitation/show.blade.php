<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $invitation->title }} - DETROIT Digital Invitation</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Great+Vibes&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --inv-gold: #B8860B;
            --inv-gold-dark: #8C6200;
            --inv-cream: #FAF6F0;
            --inv-ivory: #F4ECE1;
            --inv-dark: #2B231D;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--inv-cream);
            color: var(--inv-dark);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        body.locked {
            overflow: hidden;
            height: 100vh;
        }

        .font-serif {
            font-family: 'Playfair Display', Georgia, serif;
        }

        .font-cursive {
            font-family: 'Great Vibes', cursive;
        }

        /* Opening Envelope Overlay */
        #openingCover {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: radial-gradient(circle at center, #FFFFFF 0%, #F5ECE0 100%);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            transition: all 0.8s cubic-bezier(0.77, 0, 0.175, 1);
        }

        #openingCover.opened {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-100%);
        }

        /* Floating Music Button */
        #musicToggle {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #B8860B 0%, #8C6200 100%);
            color: #FFFFFF;
            border: 2px solid #FFF;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        #musicToggle.rotating {
            animation: spin 4s linear infinite;
        }

        @keyframes spin {
            100% { transform: rotate(360deg); }
        }

        .inv-card {
            background: #FFFFFF;
            border: 1px solid #E8DCCF;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.04);
            margin-bottom: 30px;
        }

        .countdown-box {
            background: #FAF5EE;
            border: 1px solid #E8DCCF;
            border-radius: 12px;
            padding: 12px;
            text-align: center;
            min-width: 70px;
        }
    </style>
</head>
<body class="locked">

    <!-- Background Audio Element -->
    <audio id="bgmAudio" loop preload="auto">
        <source src="https://cdn.pixabay.com/download/audio/2022/05/27/audio_1808fbf07a.mp3?filename=romantic-wedding-piano-113004.mp3" type="audio/mp3">
    </audio>

    <!-- Floating Music Disc Button -->
    <div id="musicToggle" title="Play/Pause Musik">
        <i class="bi bi-disc-fill fs-4" id="musicIcon"></i>
    </div>

    <!-- Opening Envelope Cover (Screen 1) -->
    <div id="openingCover">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="p-4 p-md-5 rounded-4 shadow-lg border position-relative" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); border-color: #E8DCCF !important;">
                        
                        <!-- Arch floral top -->
                        <div class="mb-4">
                            <span class="badge py-2 px-3 rounded-pill" style="background-color: #F8EFE2; color: #8C6200; border: 1px solid #E5D2BA;">
                                <i class="bi bi-gem me-1"></i> THE WEDDING INVITATION
                            </span>
                        </div>

                        <div class="font-cursive display-5 text-muted mb-2">The Wedding Of</div>
                        
                        <h1 class="font-serif fw-bold display-5 mb-1 text-dark">
                            {{ $content['groom_name'] ?? 'Andika' }}
                        </h1>
                        <div class="font-cursive fs-2" style="color: var(--inv-gold);">&amp;</div>
                        <h1 class="font-serif fw-bold display-5 mb-4 text-dark">
                            {{ $content['bride_name'] ?? 'Salsabila' }}
                        </h1>

                        <!-- Guest Name Box -->
                        <div class="p-3 rounded-3 mb-4 border" style="background-color: #FAF6F0; border-color: #E8DCCF !important;">
                            <div class="small text-muted mb-1">Kepada Yth. Bapak/Ibu/Saudara/i:</div>
                            <div class="fs-5 fw-bold text-dark">{{ $guestName }}</div>
                            <div class="small text-muted" style="font-size: 0.75rem;">di Tempat</div>
                        </div>

                        <!-- Open Button -->
                        <button type="button" class="btn btn-warning w-100 py-3 fw-bold rounded-pill text-white shadow" 
                                style="background: linear-gradient(135deg, #C59B27 0%, #A47712 100%); border: none;"
                                onclick="openInvitation()">
                            <i class="bi bi-envelope-open-heart me-2"></i>
                            <span>Buka Undangan</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Invitation Content (Unlocked) -->
    <div class="container py-5" style="max-width: 680px;">

        <!-- Header / Hero Section -->
        <div class="text-center mb-5 inv-card">
            <div class="font-cursive display-6 mb-2 text-muted">Walimatul \'Ursy</div>
            <h2 class="font-serif display-5 fw-bold mb-3" style="color: var(--inv-gold-dark);">
                {{ $content['groom_name'] ?? 'Andika Pratama' }} &amp; {{ $content['bride_name'] ?? 'Salsabila Putri' }}
            </h2>
            <div class="text-muted fw-semibold small letter-spacing-1 mb-4">
                SABTU, 14 DESEMBER 2024
            </div>

            <!-- Quote Quran -->
            <div class="p-4 rounded-3 mb-2" style="background-color: #FAF6F0; border-left: 3px solid var(--inv-gold);">
                <p class="fst-italic text-secondary small mb-2" style="line-height: 1.8;">
                    "{{ $content['quote'] ?? 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri...' }}"
                </p>
                <div class="fw-bold small" style="color: var(--inv-gold-dark);">
                    {{ $content['quote_source'] ?? 'QS. Ar-Rum: 21' }}
                </div>
            </div>
        </div>

        <!-- The Couple Section -->
        <div class="inv-card text-center">
            <h3 class="font-serif fw-bold mb-4">Mempelai Bahagia</h3>

            <!-- Groom -->
            <div class="mb-4">
                <div class="mx-auto rounded-circle overflow-hidden mb-3 border shadow-sm" style="width: 120px; height: 120px; background-color: #EFE8DE;">
                    <img src="{{ asset('images/hero-card.svg') }}" alt="Groom" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <h4 class="font-serif fw-bold mb-1">{{ $content['groom_name'] ?? 'Andika Pratama, S.Kom' }}</h4>
                <p class="text-muted small mb-1">{{ $content['groom_parents'] ?? 'Putra pertama dari Bpk. Bambang Wijaya & Ibu Siti Aminah' }}</p>
                @if(!empty($content['groom_instagram']))
                    <a href="https://instagram.com/{{ $content['groom_instagram'] }}" target="_blank" class="badge rounded-pill text-decoration-none border text-muted">
                        <i class="bi bi-instagram text-danger"></i> &#64;{{ $content['groom_instagram'] }}
                    </a>
                @endif
            </div>

            <div class="font-cursive display-4 my-2" style="color: var(--inv-gold);">&amp;</div>

            <!-- Bride -->
            <div class="mt-4">
                <div class="mx-auto rounded-circle overflow-hidden mb-3 border shadow-sm" style="width: 120px; height: 120px; background-color: #EFE8DE;">
                    <img src="{{ asset('images/hero-card.svg') }}" alt="Bride" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <h4 class="font-serif fw-bold mb-1">{{ $content['bride_name'] ?? 'Salsabila Putri, S.Ds' }}</h4>
                <p class="text-muted small mb-1">{{ $content['bride_parents'] ?? 'Putri kedua dari Bpk. Hendra Gunawan & Ibu Ratna Dewi' }}</p>
                @if(!empty($content['bride_instagram']))
                    <a href="https://instagram.com/{{ $content['bride_instagram'] }}" target="_blank" class="badge rounded-pill text-decoration-none border text-muted">
                        <i class="bi bi-instagram text-danger"></i> &#64;{{ $content['bride_instagram'] }}
                    </a>
                @endif
            </div>
        </div>

        <!-- Countdown Timer -->
        <div class="inv-card text-center">
            <h4 class="font-serif fw-bold mb-3">Menghitung Hari Bahagia</h4>
            
            <div class="d-flex justify-content-center gap-2 gap-sm-3 mb-4">
                <div class="countdown-box">
                    <div class="display-6 fw-bold text-dark" id="cdDays">00</div>
                    <div class="small text-muted" style="font-size: 0.75rem;">HARI</div>
                </div>
                <div class="countdown-box">
                    <div class="display-6 fw-bold text-dark" id="cdHours">00</div>
                    <div class="small text-muted" style="font-size: 0.75rem;">JAM</div>
                </div>
                <div class="countdown-box">
                    <div class="display-6 fw-bold text-dark" id="cdMinutes">00</div>
                    <div class="small text-muted" style="font-size: 0.75rem;">MENIT</div>
                </div>
                <div class="countdown-box">
                    <div class="display-6 fw-bold text-dark" id="cdSeconds">00</div>
                    <div class="small text-muted" style="font-size: 0.75rem;">DETIK</div>
                </div>
            </div>

            <div class="small text-muted">
                <i class="bi bi-calendar-event text-warning me-1"></i> Sabtu, 14 Desember 2024
            </div>
        </div>

        <!-- Event Schedules -->
        <div class="inv-card">
            <h3 class="font-serif fw-bold text-center mb-4">Rangkaian Acara</h3>

            @foreach($invitation->events as $ev)
                <div class="p-4 rounded-3 border mb-3 bg-light text-center">
                    <h5 class="fw-bold mb-2 text-dark">{{ $ev->event_name }}</h5>
                    <div class="d-flex justify-content-center align-items-center gap-3 text-muted small mb-3">
                        <div><i class="bi bi-calendar3 text-warning"></i> {{ $ev->event_date ? $ev->event_date->format('d M Y') : '14 Des 2024' }}</div>
                        <div><i class="bi bi-clock text-warning"></i> {{ $ev->event_time ?? '09:00 WIB' }}</div>
                    </div>
                    <p class="small text-secondary mb-3">
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $ev->location }}
                    </p>
                    @if($ev->maps_url)
                        <a href="{{ $ev->maps_url }}" target="_blank" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                            <i class="bi bi-map me-1"></i> Buka Google Maps
                        </a>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- RSVP Form Section -->
        <div class="inv-card" id="rsvpSection">
            <h3 class="font-serif fw-bold text-center mb-2">Konfirmasi Kehadiran</h3>
            <p class="text-muted small text-center mb-4">Mohon kesediaan Anda untuk mengonfirmasi kehadiran.</p>

            @if(session('success_rsvp'))
                <div class="alert alert-success border-0 small mb-3">
                    <i class="bi bi-check-circle-fill me-1"></i> {{ session('success_rsvp') }}
                </div>
            @endif

            <form action="{{ route('invitation.rsvp', $invitation->slug) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ $guestName !== 'Tamu Undangan' ? $guestName : '' }}" placeholder="Nama Anda" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Apakah Anda Berkenan Hadir?</label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="attendance" id="attYes" value="yes" checked>
                            <label class="form-check-label small" for="attYes">Ya, Saya Hadir</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="attendance" id="attNo" value="no">
                            <label class="form-check-label small" for="attNo">Maaf, Tidak Bisa</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="attendance" id="attMaybe" value="maybe">
                            <label class="form-check-label small" for="attMaybe">Masih Ragu</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Jumlah Tamu</label>
                    <select name="total_guests" class="form-select">
                        <option value="1">1 Orang</option>
                        <option value="2" selected>2 Orang</option>
                        <option value="3">3 Orang</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Pesan &amp; Ucapan (Opsional)</label>
                    <textarea name="message" rows="3" class="form-control" placeholder="Tuliskan ucapan selamat atau doa restu..."></textarea>
                </div>

                <button type="submit" class="btn btn-warning w-100 py-2 fw-semibold text-white shadow-sm" style="background: var(--inv-gold); border: none;">
                    Kirim Konfirmasi Kehadiran
                </button>
            </form>
        </div>

        <!-- Guestbook / Ucapan & Doa -->
        <div class="inv-card">
            <h3 class="font-serif fw-bold text-center mb-2">Buku Tamu &amp; Doa Restu</h3>
            <p class="text-muted small text-center mb-4">Sampaikan untaian doa dan ucapan hangat Anda untuk kedua mempelai.</p>

            <form action="{{ route('invitation.message', $invitation->slug) }}" method="POST" class="mb-4">
                @csrf
                <div class="mb-2">
                    <input type="text" name="name" class="form-control" placeholder="Nama Anda" value="{{ $guestName !== 'Tamu Undangan' ? $guestName : '' }}" required>
                </div>
                <div class="mb-2">
                    <textarea name="message" rows="2" class="form-control" placeholder="Tulis ucapan dan doa..." required></textarea>
                </div>
                <button type="submit" class="btn btn-dark btn-sm rounded-pill px-4">
                    <i class="bi bi-send-fill me-1"></i> Kirim Ucapan
                </button>
            </form>

            <hr>

            <!-- Messages List -->
            <div class="vstack gap-3" style="max-height: 400px; overflow-y: auto;">
                @forelse($invitation->messages as $msg)
                    <div class="p-3 rounded-3 bg-light border">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-bold small text-dark"><i class="bi bi-person-circle text-muted me-1"></i> {{ $msg->name }}</span>
                            <span class="text-muted" style="font-size: 0.7rem;">{{ $msg->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="mb-0 small text-secondary">{{ $msg->message }}</p>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted small">
                        Belum ada ucapan. Jadilah yang pertama memberikan doa restu!
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Digital Gift / Amplop Digital -->
        <div class="inv-card text-center">
            <h3 class="font-serif fw-bold mb-2">Amplop Digital</h3>
            <p class="text-muted small mb-4">
                Doa restu Anda merupakan karunia terindah bagi kami. Namun jika Anda ingin memberikan tanda kasih, dapat disalurkan melalui:
            </p>

            <!-- Bank 1 -->
            <div class="p-3 rounded-3 border bg-light mb-3 mx-auto" style="max-width: 380px;">
                <div class="fw-bold text-primary">{{ $content['bank_1_name'] ?? 'BCA' }}</div>
                <div class="font-monospace fw-bold fs-5 my-1" id="invAcc1">{{ $content['bank_1_number'] ?? '5420918273' }}</div>
                <div class="small text-muted mb-2">a.n {{ $content['bank_1_holder'] ?? 'Andika Pratama' }}</div>
                <button type="button" class="btn btn-sm btn-outline-dark rounded-pill px-3" onclick="copyText('{{ $content['bank_1_number'] ?? '5420918273' }}')">
                    <i class="bi bi-copy"></i> Salin Nomor Rekening
                </button>
            </div>

            <!-- Bank 2 -->
            <div class="p-3 rounded-3 border bg-light mb-3 mx-auto" style="max-width: 380px;">
                <div class="fw-bold" style="color: #003876;">{{ $content['bank_2_name'] ?? 'Bank Mandiri' }}</div>
                <div class="font-monospace fw-bold fs-5 my-1" id="invAcc2">{{ $content['bank_2_number'] ?? '1270009827162' }}</div>
                <div class="small text-muted mb-2">a.n {{ $content['bank_2_holder'] ?? 'Salsabila Putri' }}</div>
                <button type="button" class="btn btn-sm btn-outline-dark rounded-pill px-3" onclick="copyText('{{ $content['bank_2_number'] ?? '1270009827162' }}')">
                    <i class="bi bi-copy"></i> Salin Nomor Rekening
                </button>
            </div>
        </div>

        <!-- Footer watermark -->
        <div class="text-center py-4 small text-muted">
            <div class="fw-bold font-serif">DETROIT Digital Invitation Studio</div>
            <div style="font-size: 0.75rem;">Platform Undangan Digital Modern &amp; Elegan</div>
            <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary rounded-pill mt-2">
                Buat Undangan Anda Seperti Ini
            </a>
        </div>

    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const audio = document.getElementById('bgmAudio');
        const musicToggle = document.getElementById('musicToggle');
        const musicIcon = document.getElementById('musicIcon');
        let isPlaying = false;

        function openInvitation() {
            document.getElementById('openingCover').classList.add('opened');
            document.body.classList.remove('locked');

            // Play background music automatically upon opening
            audio.play().then(() => {
                isPlaying = true;
                musicToggle.classList.add('rotating');
                musicIcon.className = 'bi bi-pause-fill fs-4';
            }).catch(e => {
                console.log('Audio autoplay blocked, click music icon to play.');
            });
        }

        musicToggle.addEventListener('click', function () {
            if (isPlaying) {
                audio.pause();
                isPlaying = false;
                musicToggle.classList.remove('rotating');
                musicIcon.className = 'bi bi-disc-fill fs-4';
            } else {
                audio.play();
                isPlaying = true;
                musicToggle.classList.add('rotating');
                musicIcon.className = 'bi bi-pause-fill fs-4';
            }
        });

        // Copy Helper
        function copyText(val) {
            navigator.clipboard.writeText(val).then(() => {
                alert('Nomor rekening ' + val + ' berhasil disalin!');
            });
        }

        // Live Countdown calculation
        const targetDate = new Date("2024-12-14T08:00:00").getTime();
        setInterval(function() {
            const now = new Date().getTime();
            let distance = targetDate - now;
            if (distance < 0) {
                // If past, show countdown to a future date
                distance = Math.abs(distance);
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("cdDays").innerText = days < 10 ? '0' + days : days;
            document.getElementById("cdHours").innerText = hours < 10 ? '0' + hours : hours;
            document.getElementById("cdMinutes").innerText = minutes < 10 ? '0' + minutes : minutes;
            document.getElementById("cdSeconds").innerText = seconds < 10 ? '0' + seconds : seconds;
        }, 1000);
    </script>
</body>
</html>
