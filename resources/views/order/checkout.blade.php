@extends('layouts.app')

@section('title', 'Form Pemesanan Undangan - DETROIT Digital Invitation Studio')

@section('content')
<div class="py-5" style="background-color: var(--detroit-champagne); min-height: 85vh;">
    <div class="container">
        
        <!-- Wizard Step Indicators (Image 2) -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <div class="d-flex align-items-center justify-content-between position-relative">
                    <!-- Progress bar line -->
                    <div class="position-absolute top-50 start-0 end-0 translate-middle-y" style="height: 3px; background: #E8DCCF; z-index: 1;"></div>
                    <div class="position-absolute top-50 start-0 translate-middle-y" style="width: 50%; height: 3px; background: var(--detroit-gold); z-index: 1;"></div>

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
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 fw-bold text-white shadow"
                             style="width: 42px; height: 42px; background: var(--detroit-gold); ring: 4px solid #EBD8B8;">
                            2
                        </div>
                        <div class="small fw-bold" style="color: var(--detroit-gold-dark);">2. Data Pesanan</div>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center position-relative" style="z-index: 2;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 fw-semibold text-muted bg-white border shadow-sm"
                             style="width: 42px; height: 42px;">
                            3
                        </div>
                        <div class="small text-muted">3. Pembayaran</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checkout Form Container -->
        <form action="{{ route('order.store') }}" method="POST">
            @csrf
            <div class="row g-4 justify-content-center">
                
                <!-- Left Column: Detail Pesanan Card (Image 2) -->
                <div class="col-lg-5">
                    <div class="detroit-card p-4 h-100">
                        <h5 class="fw-bold mb-3 pb-2 border-bottom">Detail Pesanan</h5>
                        
                        <!-- Selected Template Visual & Selector -->
                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block rounded-3 overflow-hidden shadow-sm border mb-3" style="max-width: 200px;">
                                <img id="templatePreviewImg" src="{{ asset('images/templates/wedding-andika.svg') }}" alt="Preview Template" class="img-fluid" style="height: 240px; width: 100%; object-fit: cover;">
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Pilih Template yang Diinginkan:</label>
                                <select name="template_id" id="templateSelect" class="form-select text-center fw-semibold">
                                    @foreach($templates as $tmpl)
                                        <option value="{{ $tmpl->id }}" 
                                                data-price="{{ $tmpl->effective_price }}"
                                                data-name="{{ $tmpl->name }}"
                                                data-slug="{{ $tmpl->slug }}"
                                                data-img="{{ asset('images/' . str_replace('.jpg', '.svg', $tmpl->preview_image ?? 'templates/wedding-andika.svg')) }}"
                                                {{ ($selectedTemplate && $selectedTemplate->id == $tmpl->id) ? 'selected' : '' }}>
                                            {{ $tmpl->name }} (Rp {{ number_format($tmpl->effective_price, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="bg-light rounded-3 p-3 mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Template</span>
                                <span class="fw-semibold text-dark" id="summaryTemplateName">{{ $selectedTemplate->name ?? 'Elegance Wedding' }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Harga</span>
                                <span class="fw-semibold text-dark" id="summaryPrice">Rp {{ number_format($selectedTemplate->effective_price ?? 149000, 0, ',', '.') }}</span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold fs-6">Total Pembayaran</span>
                                <span class="fw-bold fs-5 text-dark" id="summaryTotal" style="color: var(--detroit-gold-dark) !important;">
                                    Rp {{ number_format($selectedTemplate->effective_price ?? 149000, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <div class="small text-muted d-flex align-items-center gap-2">
                            <i class="bi bi-shield-check text-success fs-5"></i>
                            <span>Akses undangan aktif selamanya dengan garansi support teknis Detroit.</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Data Pemesan (Image 2) -->
                <div class="col-lg-6">
                    <div class="detroit-card p-4">
                        <h5 class="fw-bold mb-3 pb-2 border-bottom">Data Pemesan</h5>

                        <!-- Customer Name -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Nama Lengkap Pemesan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" name="customer_name" class="form-control border-start-0" placeholder="Contoh: Alfaro Fadhil" value="{{ old('customer_name', 'Alfaro Fadhil') }}" required>
                            </div>
                        </div>

                        <!-- Customer WhatsApp -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Nomor WhatsApp Aktif <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-whatsapp text-success"></i></span>
                                <input type="text" name="customer_phone" class="form-control border-start-0" placeholder="Contoh: 081234567890" value="{{ old('customer_phone', '081234567890') }}" required>
                            </div>
                            <div class="form-text small" style="font-size: 0.75rem;">Link undangan dan konfirmasi pesanan akan dikirimkan langsung ke nomor ini.</div>
                        </div>

                        <!-- Customer Email -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Alamat E-mail <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                                <input type="email" name="customer_email" class="form-control border-start-0" placeholder="Contoh: alfaro@email.com" value="{{ old('customer_email', 'alfaro@email.com') }}" required>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h6 class="fw-bold mb-3">Detail Acara (Opsional &amp; Dapat Diedit Kapan Saja)</h6>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Judul Undangan</label>
                            <input type="text" name="event_title" class="form-control" placeholder="Contoh: The Wedding Of Andika & Salsabila" value="{{ old('event_title', 'The Wedding Of Andika & Salsabila') }}">
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-sm-6">
                                <label class="form-label small fw-semibold">Mempelai / Pihak Pria</label>
                                <input type="text" name="groom_name" class="form-control" placeholder="Nama Pria" value="{{ old('groom_name', 'Andika') }}">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label small fw-semibold">Mempelai / Pihak Wanita</label>
                                <input type="text" name="bride_name" class="form-control" placeholder="Nama Wanita" value="{{ old('bride_name', 'Salsabila') }}">
                            </div>
                        </div>

                        <div class="row g-2 mb-4">
                            <div class="col-sm-6">
                                <label class="form-label small fw-semibold">Tanggal Acara</label>
                                <input type="date" name="event_date" class="form-control" value="{{ old('event_date', '2024-12-14') }}">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label small fw-semibold">Lokasi / Venue</label>
                                <input type="text" name="event_location" class="form-control" placeholder="Nama Gedung / Kota" value="{{ old('event_location', 'Hotel Indonesia Kempinski Jakarta') }}">
                            </div>
                        </div>

                        <!-- Submit Button (Image 2: Lanjut ke Pembayaran) -->
                        <button type="submit" class="btn btn-detroit w-100 py-3 fs-6">
                            <span>Lanjut ke Pembayaran</span>
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('templateSelect');
        const previewImg = document.getElementById('templatePreviewImg');
        const summaryName = document.getElementById('summaryTemplateName');
        const summaryPrice = document.getElementById('summaryPrice');
        const summaryTotal = document.getElementById('summaryTotal');

        function updateSummary() {
            const opt = select.options[select.selectedIndex];
            const name = opt.getAttribute('data-name');
            const price = parseInt(opt.getAttribute('data-price')) || 149000;
            const img = opt.getAttribute('data-img');

            if (previewImg && img) previewImg.src = img;
            if (summaryName) summaryName.textContent = name;
            
            const formatted = 'Rp ' + price.toLocaleString('id-ID');
            if (summaryPrice) summaryPrice.textContent = formatted;
            if (summaryTotal) summaryTotal.textContent = formatted;
        }

        if (select) {
            select.addEventListener('change', updateSummary);
            updateSummary();
        }
    });
</script>
@endpush
