@extends('layouts.admin')

@section('title', 'Kelola Kategori - DETROIT')
@section('page_title', 'Kelola Kategori Template')

@section('content')
<div class="row g-4">
    <!-- Categories List -->
    <div class="col-lg-8">
        <div class="stat-card">
            <h5 class="fw-bold mb-3 pb-2 border-bottom">Daftar Kategori</h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Ikon</th>
                            <th>Nama Kategori</th>
                            <th>Slug</th>
                            <th>Total Template</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $cat)
                            <tr>
                                <td>
                                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-light border" style="width: 38px; height: 38px;">
                                        <i class="bi {{ $cat->icon ?? 'bi-star' }} text-warning"></i>
                                    </div>
                                </td>
                                <td class="fw-bold">{{ $cat->name }}</td>
                                <td class="font-monospace small text-muted">{{ $cat->slug }}</td>
                                <td>
                                    <span class="badge bg-primary bg-opacity-10 text-primary fw-bold">
                                        {{ $cat->templates_count }} Template
                                    </span>
                                </td>
                                <td class="text-end">
                                    <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Category Form -->
    <div class="col-lg-4">
        <div class="stat-card">
            <h5 class="fw-bold mb-3 pb-2 border-bottom">Tambah Kategori Baru</h5>

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Wisuda & Kelulusan" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Ikon Bootstrap Icons</label>
                    <input type="text" name="icon" class="form-control" placeholder="bi-mortarboard" value="bi-star">
                    <div class="form-text small" style="font-size: 0.75rem;">Nama kelas Bootstrap Icons (contoh: bi-heart, bi-book, bi-cake2).</div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Deskripsi</label>
                    <textarea name="description" rows="2" class="form-control" placeholder="Deskripsi peruntukan kategori..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-plus-lg me-1"></i> Simpan Kategori
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
