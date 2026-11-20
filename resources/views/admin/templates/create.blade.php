@extends('layouts.admin')

@section('title', 'Tambah Template Baru - DETROIT')
@section('page_title', 'Tambah Template Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="stat-card">
            <h5 class="fw-bold mb-4 pb-2 border-bottom">Form Tambah Template</h5>

            <form action="{{ route('admin.templates.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Nama Template <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Luxury Golden Rose" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Kategori Acara <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Harga (Rp)</label>
                    <input type="number" name="price_override" class="form-control" placeholder="149000" value="149000">
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Deskripsi Singkat</label>
                    <textarea name="description" rows="3" class="form-control" placeholder="Jelaskan tema visual dan karakteristik template ini..."></textarea>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="is_active" id="isActiveCheck" checked>
                    <label class="form-check-label small" for="isActiveCheck">
                        Aktifkan dan tampilkan langsung di katalog utama
                    </label>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.templates.index') }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary px-4">Simpan Template</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
