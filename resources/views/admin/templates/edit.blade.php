@extends('layouts.admin')

@section('title', 'Edit Template - DETROIT')
@section('page_title', 'Edit Template ' . $template->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="stat-card">
            <h5 class="fw-bold mb-4 pb-2 border-bottom">Edit Template: {{ $template->name }}</h5>

            <form action="{{ route('admin.templates.update', $template->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Nama Template <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $template->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Kategori Acara <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $template->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Harga (Rp)</label>
                    <input type="number" name="price_override" class="form-control" value="{{ old('price_override', $template->price_override ?? 149000) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Deskripsi</label>
                    <textarea name="description" rows="3" class="form-control">{{ old('description', $template->description) }}</textarea>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="is_active" id="isActiveCheck" {{ $template->is_active ? 'checked' : '' }}>
                    <label class="form-check-label small" for="isActiveCheck">
                        Status Aktif
                    </label>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.templates.index') }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary px-4">Perbarui Template</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
