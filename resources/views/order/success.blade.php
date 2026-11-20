@extends('layouts.app')

@section('title', 'Pesanan Berhasil - DETROIT Digital Invitation Studio')

@section('content')
<div class="py-5" style="background-color: var(--detroit-champagne); min-height: 85vh;">
    <div class="container py-4">

        <div class="row justify-content-center">
            <div class="col-lg-8 text-center mb-4">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center p-3 mb-3 shadow"
                     style="width: 72px; height: 72px; background: linear-gradient(135deg, #25D366 0%, #128C7E 100%); color: #FFF;">
                    <i class="bi bi-check-lg display-5"></i>
                </div>
                <h2 class="display-6 fw-bold mb-2">Pembayaran Berhasil!</h2>
                <p class="text-muted lead mx-auto" style="max-width: 550px;">
                    Terima kasih telah memesan undangan di <strong>DETROIT</strong>. Link undangan digital Anda telah siap dan aktif!
                </p>
            </div>
        </div>

        <div class="row justify-content-center g-4">
            <!-- Left: WhatsApp Mockup (matching Image 2) -->
            <div class="col-lg-6">
                <div class="position-relative">
                    <!-- Annotation Callout Arrow (matching Image 2) -->
                    <div class="d-none d-md-block position-absolute" style="top: -25px; right: -40px; z-index: 10;">
                        <span class="badge p-2 shadow-sm rounded-3" style="background: #FCEFD5; color: #8C6200; border: 1px dashed #D4A338; font-size: 0.8rem;">
                            <i class="bi bi-whatsapp text-success me-1"></i> Setelah bayar, link undangan langsung dikirim ke WhatsApp! ✨
                        </span>
                    </div>

                    <!-- WhatsApp UI Mockup Container -->
                    <div class="card border-0 shadow-lg overflow-hidden rounded-4" style="background-color: #ECE5DD;">
                        <!-- WhatsApp Top Bar -->
                        <div class="p-3 d-flex align-items-center justify-content-between text-white" style="background-color: #075E54;">
                            <div class="d-flex align-items-center gap-3">
                                <i class="bi bi-arrow-left fs-5"></i>
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold bg-white text-dark shadow-sm"
                                     style="width: 40px; height: 40px; font-family: 'Cinzel', serif; color: var(--detroit-gold) !important;">
                                    D
                                </div>
                                <div>
                                    <div class="fw-bold mb-0" style="font-size: 0.95rem; line-height: 1.1;">
                                        DETROIT Official <i class="bi bi-patch-check-fill text-info" style="font-size: 0.8rem;"></i>
                                    </div>
                                    <div style="font-size: 0.7rem; color: #A8D5C8;">Online</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <i class="bi bi-camera-video-fill"></i>
                                <i class="bi bi-telephone-fill"></i>
                                <i class="bi bi-three-dots-vertical"></i>
                            </div>
                        </div>

                        <!-- WhatsApp Chat Body with Bubble (matching Image 2) -->
                        <div class="p-3" style="background-image: radial-gradient(#D6CBC1 1px, transparent 1px); background-size: 16px 16px; min-height: 340px;">
                            <div class="card border-0 shadow-sm p-3 rounded-3" style="background-color: #FFFFFF; max-width: 90%; border-top-left-radius: 0 !important;">
                                
                                <p class="mb-2 fw-semibold" style="font-size: 0.9rem;">
                                    Halo Kak <strong>{{ $order->user->name ?? 'Pelanggan' }}</strong> 👋
                                </p>
                                <p class="mb-3 text-secondary small" style="line-height: 1.4;">
                                    Terima kasih telah memesan undangan di <strong>DETROIT Digital Invitation Studio</strong>!
                                </p>

                                <div class="p-2 rounded-2 mb-3 bg-light border small" style="line-height: 1.6;">
                                    <div class="fw-bold mb-1 text-dark">Berikut detail pesanan Anda:</div>
                                    <div>📦 <strong>Template</strong>: {{ $templateName }}</div>
                                    <div>💰 <strong>Total</strong>: Rp {{ number_format($order->final_amount, 0, ',', '.') }}</div>
                                    <div>💳 <strong>Metode</strong>: {{ strtoupper($order->payment_method ?? 'QRIS') }}</div>
                                </div>

                                <div class="mb-3">
                                    <div class="small fw-bold text-muted mb-1">🔗 Link Undangan Anda:</div>
                                    <a href="{{ $invitationUrl }}" target="_blank" class="fw-bold text-decoration-none text-primary small d-inline-block p-2 bg-light border rounded-2 text-break">
                                        {{ $invitationUrl }}
                                    </a>
                                </div>

                                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                    <span class="small text-muted" style="font-size: 0.75rem;">
                                        Terima kasih telah mempercayakan momen spesial Anda. ❤️
                                    </span>
                                    <span class="small text-muted d-flex align-items-center gap-1" style="font-size: 0.7rem;">
                                        {{ now()->format('H:i') }} <i class="bi bi-check2-all text-primary"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- WhatsApp Action CTA Bottom -->
                        <div class="p-3 bg-white border-top text-center">
                            <a href="{{ $whatsappUrl }}" target="_blank" class="btn btn-success w-100 py-2 fw-bold d-flex align-items-center justify-content-center gap-2 shadow-sm">
                                <i class="bi bi-whatsapp fs-5"></i>
                                <span>Buka / Kirim ke WhatsApp ({{ $phone }})</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Next Steps & Quick Actions -->
            <div class="col-lg-5">
                <div class="detroit-card p-4 h-100 d-flex flex-column">
                    <h5 class="fw-bold mb-3 pb-2 border-bottom">Undangan Digital Anda Aktif</h5>

                    <p class="text-muted small mb-4">
                        Pesanan dengan nomor invoice <strong>#{{ $order->order_code }}</strong> telah berstatus <span class="badge bg-success">PAID / LUNAS</span>.
                    </p>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">Salin Link Undangan Anda:</label>
                        <div class="input-group">
                            <input type="text" class="form-control font-monospace small bg-light" id="invUrlInput" value="{{ $invitationUrl }}" readonly>
                            <button class="btn btn-detroit-outline" type="button" onclick="copyInvitationLink()">
                                <i class="bi bi-copy"></i> Salin
                            </button>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mb-4">
                        <a href="{{ $invitationUrl }}" target="_blank" class="btn btn-detroit py-3 fs-6">
                            <i class="bi bi-envelope-open-heart"></i>
                            <span>Buka Undangan Saya Sekarang</span>
                            <i class="bi bi-arrow-up-right"></i>
                        </a>

                        <a href="{{ $whatsappUrl }}" target="_blank" class="btn btn-outline-success py-2">
                            <i class="bi bi-whatsapp me-1"></i> Simpan di WhatsApp
                        </a>
                    </div>

                    <div class="mt-auto p-3 rounded-3 bg-light border small">
                        <div class="fw-bold mb-1"><i class="bi bi-lightbulb-fill text-warning me-1"></i> Tips Membagikan Undangan:</div>
                        <p class="text-muted mb-0" style="font-size: 0.8rem;">
                            Tambahkan parameter nama tamu di belakang link, contoh:<br>
                            <code class="text-dark">{{ $invitationUrl }}?to=Nama+Tamu</code>
                        </p>
                    </div>

                    <div class="text-center mt-3">
                        <a href="{{ route('home') }}" class="text-decoration-none small text-muted">
                            <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function copyInvitationLink() {
        const input = document.getElementById('invUrlInput');
        input.select();
        navigator.clipboard.writeText(input.value).then(() => {
            alert('Link undangan berhasil disalin!');
        });
    }
</script>
@endpush
