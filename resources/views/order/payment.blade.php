@extends('layouts.app')

@section('title', 'Pembayaran Pesanan ' . $order->order_code . ' - DETROIT')

@section('content')
<div class="py-5" style="background-color: var(--detroit-champagne); min-height: 85vh;">
    <div class="container">

        <!-- Wizard Step Indicators -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <div class="d-flex align-items-center justify-content-between position-relative">
                    <div class="position-absolute top-50 start-0 end-0 translate-middle-y" style="height: 3px; background: #E8DCCF; z-index: 1;"></div>
                    <div class="position-absolute top-50 start-0 translate-middle-y" style="width: 100%; height: 3px; background: var(--detroit-gold); z-index: 1;"></div>

                    <!-- Step 1 -->
                    <div class="text-center position-relative" style="z-index: 2;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 fw-bold text-white shadow-sm"
                             style="width: 42px; height: 42px; background: var(--detroit-gold);">
                            <i class="bi bi-check2 fs-5"></i>
                        </div>
                        <div class="small fw-semibold text-dark">1. Pilih Template</div>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center position-relative" style="z-index: 2;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 fw-bold text-white shadow-sm"
                             style="width: 42px; height: 42px; background: var(--detroit-gold);">
                            <i class="bi bi-check2 fs-5"></i>
                        </div>
                        <div class="small fw-semibold text-dark">2. Data Pesanan</div>
                    </div>

                    <!-- Step 3 Active -->
                    <div class="text-center position-relative" style="z-index: 2;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 fw-bold text-white shadow"
                             style="width: 42px; height: 42px; background: var(--detroit-gold); ring: 4px solid #EBD8B8;">
                            3
                        </div>
                        <div class="small fw-bold" style="color: var(--detroit-gold-dark);">3. Pembayaran</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Content Box -->
        <div class="row justify-content-center g-4">
            <!-- Order Summary Card -->
            <div class="col-lg-4">
                <div class="detroit-card p-4 h-100">
                    <h5 class="fw-bold mb-3 pb-2 border-bottom">Ringkasan Tagihan</h5>

                    <div class="mb-3">
                        <div class="small text-muted">Nomor Pesanan</div>
                        <div class="fw-bold font-monospace fs-5 text-dark">{{ $order->order_code }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="small text-muted">Pemesan</div>
                        <div class="fw-semibold text-dark">{{ $order->user->name ?? 'Pelanggan' }}</div>
                        <div class="small text-muted">{{ $order->user->phone ?? '' }} | {{ $order->user->email ?? '' }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="small text-muted">Item / Template</div>
                        <div class="fw-semibold text-dark">{{ $order->items->first()->name ?? 'Template Undangan' }}</div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-bold">Total Pembayaran:</span>
                        <span class="fs-4 fw-bold" style="color: var(--detroit-gold-dark);">
                            Rp {{ number_format($order->final_amount, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="p-3 rounded-3 bg-light text-center small text-muted">
                        <i class="bi bi-shield-lock-fill text-success fs-5 d-block mb-1"></i>
                        Transaksi aman dan terenkripsi. Link undangan langsung aktif setelah pembayaran.
                    </div>
                </div>
            </div>

            <!-- Payment Methods Card (matching Image 2) -->
            <div class="col-lg-7">
                <div class="detroit-card p-4">
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                        <i class="bi bi-wallet2 text-warning fs-4"></i>
                        <h5 class="fw-bold mb-0">Pilih Metode Pembayaran</h5>
                    </div>

                    <form action="{{ route('order.confirm', $order->order_code) }}" method="POST" id="paymentForm">
                        @csrf
                        
                        <!-- Nav Tabs Payment Methods (matching Image 2) -->
                        <ul class="nav nav-pills nav-fill gap-2 mb-4" id="paymentTab" role="tablist">
                            <!-- QRIS Tab -->
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active py-3 border d-flex flex-column align-items-center gap-1" id="qris-tab" data-bs-toggle="pill" data-bs-target="#tab-qris" type="button" role="tab" onclick="setPaymentMethod('qris')">
                                    <i class="bi bi-qr-code fs-4 text-primary"></i>
                                    <span class="fw-bold">QRIS</span>
                                    <span class="text-muted" style="font-size: 0.7rem;">(Scan QR Semua Bank)</span>
                                </button>
                            </li>

                            <!-- Transfer Bank Tab -->
                            <li class="nav-item" role="presentation">
                                <button class="nav-link py-3 border d-flex flex-column align-items-center gap-1" id="bank-tab" data-bs-toggle="pill" data-bs-target="#tab-bank" type="button" role="tab" onclick="setPaymentMethod('bank_transfer')">
                                    <i class="bi bi-bank fs-4 text-warning"></i>
                                    <span class="fw-bold">Transfer Bank</span>
                                    <span class="text-muted" style="font-size: 0.7rem;">(BCA, Mandiri, BRI, BNI)</span>
                                </button>
                            </li>

                            <!-- E-Wallet Tab -->
                            <li class="nav-item" role="presentation">
                                <button class="nav-link py-3 border d-flex flex-column align-items-center gap-1" id="ewallet-tab" data-bs-toggle="pill" data-bs-target="#tab-ewallet" type="button" role="tab" onclick="setPaymentMethod('ewallet')">
                                    <i class="bi bi-phone fs-4 text-success"></i>
                                    <span class="fw-bold">E-Wallet</span>
                                    <span class="text-muted" style="font-size: 0.7rem;">(DANA, OVO, GoPay)</span>
                                </button>
                            </li>
                        </ul>

                        <input type="hidden" name="payment_method" id="selectedPaymentMethod" value="qris">

                        <!-- Tab Content Details -->
                        <div class="tab-content border rounded-3 p-4 mb-4 bg-white" id="paymentTabContent">
                            
                            <!-- TAB 1: QRIS -->
                            <div class="tab-pane fade show active text-center" id="tab-qris" role="tabpanel">
                                <h6 class="fw-bold mb-2">Scan QRIS dengan Aplikasi Apapun</h6>
                                <p class="text-muted small mb-3">BCA, Mandiri Livin, BRImo, GoPay, OVO, DANA, ShopeePay, LinkAja</p>
                                
                                <div class="position-relative d-inline-block p-2 border rounded-3 shadow-sm bg-white mb-3">
                                    <img src="{{ asset('images/qris-code.svg') }}" alt="QRIS Code" class="img-fluid" style="width: 200px; height: 200px;">
                                </div>

                                <div class="alert alert-light border small text-muted mx-auto" style="max-width: 450px;">
                                    Jumlah Transfer Tepat: <strong class="text-dark fs-6">Rp {{ number_format($order->final_amount, 0, ',', '.') }}</strong>
                                </div>
                            </div>

                            <!-- TAB 2: Transfer Bank -->
                            <div class="tab-pane fade" id="tab-bank" role="tabpanel">
                                <h6 class="fw-bold mb-3">Daftar Rekening Bank DETROIT:</h6>
                                
                                <!-- BCA -->
                                <div class="d-flex justify-content-between align-items-center p-3 mb-2 rounded-3 border bg-light">
                                    <div>
                                        <div class="fw-bold text-primary">Bank BCA</div>
                                        <div class="font-monospace fw-bold fs-6" id="bcaAcc">8271928371</div>
                                        <div class="small text-muted">a.n DETROIT Studio</div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary copy-btn" data-target="8271928371">
                                        <i class="bi bi-copy"></i> Salin
                                    </button>
                                </div>

                                <!-- Mandiri -->
                                <div class="d-flex justify-content-between align-items-center p-3 mb-2 rounded-3 border bg-light">
                                    <div>
                                        <div class="fw-bold" style="color: #003876;">Bank Mandiri</div>
                                        <div class="font-monospace fw-bold fs-6" id="mandiriAcc">1370019283712</div>
                                        <div class="small text-muted">a.n DETROIT Studio</div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary copy-btn" data-target="1370019283712">
                                        <i class="bi bi-copy"></i> Salin
                                    </button>
                                </div>
                            </div>

                            <!-- TAB 3: E-Wallet -->
                            <div class="tab-pane fade" id="tab-ewallet" role="tabpanel">
                                <h6 class="fw-bold mb-3">Pilihan Nomor E-Wallet:</h6>
                                
                                <div class="d-flex justify-content-between align-items-center p-3 mb-2 rounded-3 border bg-light">
                                    <div>
                                        <div class="fw-bold text-success">GoPay / DANA / OVO</div>
                                        <div class="font-monospace fw-bold fs-6">0812-3456-7890</div>
                                        <div class="small text-muted">a.n DETROIT Studio</div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary copy-btn" data-target="081234567890">
                                        <i class="bi bi-copy"></i> Salin
                                    </button>
                                </div>
                            </div>

                        </div>

                        <!-- Important notice from Image 2 -->
                        <div class="d-flex align-items-start gap-2 p-3 rounded-3 mb-4" style="background-color: #FAF4EB; border-left: 4px solid var(--detroit-gold);">
                            <i class="bi bi-info-circle-fill text-warning mt-1 fs-5"></i>
                            <div class="small text-muted">
                                <strong>Setelah pembayaran berhasil</strong>, link undangan akan langsung otomatis dikirim ke <strong>WhatsApp</strong> dan <strong>E-mail</strong> Anda.
                            </div>
                        </div>

                        <!-- Submit Confirmation Button -->
                        <button type="submit" class="btn btn-detroit w-100 py-3 fs-6">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Saya Sudah Bayar / Konfirmasi Pembayaran</span>
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function setPaymentMethod(method) {
        document.getElementById('selectedPaymentMethod').value = method;
    }

    document.querySelectorAll('.copy-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const val = this.getAttribute('data-target');
            navigator.clipboard.writeText(val).then(() => {
                const originalHtml = this.innerHTML;
                this.innerHTML = '<i class="bi bi-check-lg text-success"></i> Tersalin!';
                setTimeout(() => {
                    this.innerHTML = originalHtml;
                }, 2000);
            });
        });
    });
</script>
@endpush
