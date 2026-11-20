@extends('layouts.admin')

@section('title', 'Kelola Template - DETROIT')
@section('page_title', 'Kelola Template')

@section('content')
<div class="stat-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-0">Daftar Template Undangan</h5>
            <span class="text-muted small">Kelola koleksi template yang tampil pada halaman depan</span>
        </div>
        <a href="{{ route('admin.templates.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Tambah Template
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 80px;">Preview</th>
                    <th>Nama Template</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($templates as $tmpl)
                    <tr>
                        <td>
                            @php
                                $img = asset('images/' . str_replace('.jpg', '.svg', $tmpl->preview_image ?? 'templates/wedding-andika.svg'));
                            @endphp
                            <img src="{{ $img }}" alt="{{ $tmpl->name }}" class="rounded border" style="width: 60px; height: 75px; object-fit: cover;">
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $tmpl->name }}</div>
                            <div class="small text-muted font-monospace">{{ $tmpl->slug }}</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $tmpl->category->name ?? '-' }}</span>
                        </td>
                        <td class="fw-semibold">
                            Rp {{ number_format($tmpl->effective_price, 0, ',', '.') }}
                        </td>
                        <td>
                            <form action="{{ route('admin.templates.toggle', $tmpl->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $tmpl->is_active ? 'btn-success' : 'btn-secondary' }} rounded-pill px-3 py-0" style="font-size: 0.75rem;">
                                    {{ $tmpl->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </form>
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.templates.edit', $tmpl->id) }}" class="btn btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.templates.destroy', $tmpl->id) }}" method="POST" onsubmit="return confirm('Hapus template ini?')" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $templates->links() }}
    </div>
</div>
@endsection
