@extends('layouts.admin')

@section('title', 'Pengaturan Toko - DETROIT')
@section('page_title', 'Pengaturan Toko & Informasi Kontak')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="stat-card">
            <h5 class="fw-bold mb-4 pb-2 border-bottom">Pengaturan Platform DETROIT</h5>

            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Nama Brand / Toko</label>
                    <input type="text" name="store_name" class="form-control" value="{{ $settings['store_name'] ?? 'DETROIT Digital Invitation Studio' }}">
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Tagline / Slogan</label>
                    <input type="text" name="store_tagline" class="form-control" value="{{ $settings['store_tagline'] ?? 'Buat undangan digital yang elegan, modern, dan berkesan dalam hitungan menit.' }}">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <label class="form-label small fw-semibold">Nomor WhatsApp Admin (Notifikasi)</label>
                        <input type="text" name="whatsapp_number" class="form-control" value="{{ $settings['whatsapp_number'] ?? '6281234567890' }}">
                        <div class="form-text small" style="font-size: 0.75rem;">Gunakan format internasional tanpa tanda plus, contoh: 6281234567890</div>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label small fw-semibold">Alamat E-mail Toko</label>
                        <input type="email" name="store_email" class="form-control" value="{{ $settings['store_email'] ?? 'hello@detroit.id' }}">
                    </div>
                </div>

                <hr class="my-4">
                <h6 class="fw-bold mb-3">Pengaturan Rekening Pembayaran</h6>

                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <label class="form-label small fw-semibold">Nomor Rekening BCA</label>
                        <input type="text" name="bank_bca_number" class="form-control" value="{{ $settings['bank_bca_number'] ?? '8271928371' }}">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label small fw-semibold">Nama Pemilik Rekening BCA</label>
                        <input type="text" name="bank_bca_holder" class="form-control" value="{{ $settings['bank_bca_holder'] ?? 'DETROIT Studio' }}">
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <label class="form-label small fw-semibold">Nomor Rekening Bank Mandiri</label>
                        <input type="text" name="bank_mandiri_number" class="form-control" value="{{ $settings['bank_mandiri_number'] ?? '1370019283712' }}">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label small fw-semibold">Nama Pemilik Rekening Mandiri</label>
                        <input type="text" name="bank_mandiri_holder" class="form-control" value="{{ $settings['bank_mandiri_holder'] ?? 'DETROIT Studio' }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check2 me-1"></i> Simpan Semua Perubahan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
