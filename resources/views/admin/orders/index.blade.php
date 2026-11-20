@extends('layouts.admin')

@section('title', 'Kelola Pesanan - DETROIT')
@section('page_title', 'Kelola Pesanan')

@section('content')
<div class="stat-card mb-4">
    <!-- Filter bar -->
    <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3 align-items-center mb-3">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="text" name="q" class="form-control" placeholder="Cari Kode / Nama / WhatsApp..." value="{{ request('q') }}">
            </div>
        </div>

        <div class="col-md-3">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid (Lunas)</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>

        @if(request('q') || request('status'))
            <div class="col-md-2">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        @endif
    </form>

    <!-- Orders Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Invoice / Kode</th>
                    <th>Pemesan</th>
                    <th>Template</th>
                    <th>Total</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $o)
                    <tr>
                        <td>
                            <a href="{{ route('admin.orders.show', $o->id) }}" class="fw-bold font-monospace text-primary text-decoration-none">
                                #{{ $o->order_code }}
                            </a>
                        </td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $o->user->name ?? 'User' }}</div>
                            <div class="small text-muted">{{ $o->user->phone ?? '' }}</div>
                        </td>
                        <td>
                            <span class="small fw-semibold">{{ $o->items->first()->name ?? 'Template' }}</span>
                        </td>
                        <td class="fw-bold text-dark">
                            Rp {{ number_format($o->final_amount, 0, ',', '.') }}
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border font-monospace text-uppercase">
                                {{ $o->payment_method ?? 'qris' }}
                            </span>
                        </td>
                        <td>
                            @if($o->status === 'paid')
                                <span class="badge bg-success rounded-pill px-3 py-1">Paid</span>
                            @elseif($o->status === 'pending')
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-1">Pending</span>
                            @else
                                <span class="badge bg-secondary rounded-pill px-3 py-1">{{ ucfirst($o->status) }}</span>
                            @endif
                        </td>
                        <td class="small text-muted">
                            {{ $o->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.orders.show', $o->id) }}" class="btn btn-outline-primary" title="Detail Pesanan">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($o->user && $o->user->phone)
                                    @php
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $o->user->phone);
                                        if (str_starts_with($cleanPhone, '0')) $cleanPhone = '62' . substr($cleanPhone, 1);
                                    @endphp
                                    <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="btn btn-outline-success" title="Hubungi WhatsApp">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            Tidak ada pesanan ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->withQueryString()->links() }}
    </div>
</div>
@endsection
