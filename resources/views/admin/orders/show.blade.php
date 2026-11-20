@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->order_code . ' - DETROIT')
@section('page_title', 'Detail Pesanan #' . $order->order_code)

@section('content')
<div class="row g-4">
    <!-- Left Column: Order Data & Status -->
    <div class="col-lg-8">
        <div class="stat-card mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                <h5 class="fw-bold mb-0">Informasi Pesanan</h5>
                <div>
                    @if($order->status === 'paid')
                        <span class="badge bg-success fs-6 px-3 py-2 rounded-pill">PAID / LUNAS</span>
                    @elseif($order->status === 'pending')
                        <span class="badge bg-warning text-dark fs-6 px-3 py-2 rounded-pill">PENDING</span>
                    @else
                        <span class="badge bg-secondary fs-6 px-3 py-2 rounded-pill">{{ strtoupper($order->status) }}</span>
                    @endif
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-sm-6">
                    <div class="small text-muted">Kode Pesanan</div>
                    <div class="fw-bold font-monospace fs-5">#{{ $order->order_code }}</div>
                </div>
                <div class="col-sm-6">
                    <div class="small text-muted">Waktu Pemesanan</div>
                    <div class="fw-semibold">{{ $order->created_at->format('d F Y, H:i') }} WIB</div>
                </div>
                <div class="col-sm-6">
                    <div class="small text-muted">Nama Pemesan</div>
                    <div class="fw-bold text-dark">{{ $order->user->name ?? '-' }}</div>
                </div>
                <div class="col-sm-6">
                    <div class="small text-muted">Nomor WhatsApp</div>
                    <div class="fw-semibold">{{ $order->user->phone ?? '-' }}</div>
                </div>
                <div class="col-sm-6">
                    <div class="small text-muted">Email</div>
                    <div class="fw-semibold">{{ $order->user->email ?? '-' }}</div>
                </div>
                <div class="col-sm-6">
                    <div class="small text-muted">Metode Pembayaran</div>
                    <div class="fw-bold text-uppercase">{{ $order->payment_method ?? 'QRIS' }}</div>
                </div>
            </div>

            <h6 class="fw-bold mb-3 border-bottom pb-2">Item Pesanan</h6>
            <div class="table-responsive mb-4">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Item / Template</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="text-end fw-bold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total Pembayaran:</td>
                            <td class="text-end fw-bold text-primary fs-5">Rp {{ number_format($order->final_amount, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Update Status Form -->
            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="p-3 bg-light rounded-3 border">
                @csrf
                <div class="row g-2 align-items-center">
                    <div class="col-sm-4">
                        <label class="form-label small fw-bold mb-0">Ubah Status Pesanan:</label>
                    </div>
                    <div class="col-sm-5">
                        <select name="status" class="form-select">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Paid (Tandai Lunas)</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="failed" {{ $order->status === 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-primary w-100">Simpan Status</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Right Column: WhatsApp Generator & Live Invitation Link -->
    <div class="col-lg-4">
        <!-- WhatsApp Notification Card (matching Image 2) -->
        <div class="stat-card mb-4 border-success">
            <h6 class="fw-bold mb-2 text-success"><i class="bi bi-whatsapp"></i> Notifikasi WhatsApp</h6>
            <p class="text-muted small mb-3">Kirim link undangan dan pesan invoice langsung ke WhatsApp pelanggan:</p>

            <div class="p-3 rounded-3 bg-light border small font-monospace mb-3" style="font-size: 0.75rem; white-space: pre-wrap;">{{ $whatsappText }}</div>

            <a href="{{ $whatsappUrl }}" target="_blank" class="btn btn-success w-100 py-2 fw-semibold mb-2">
                <i class="bi bi-whatsapp me-1"></i> Buka &amp; Kirim WhatsApp
            </a>
        </div>

        <!-- Invitation Link Card -->
        @if($order->invitation)
            <div class="stat-card">
                <h6 class="fw-bold mb-2"><i class="bi bi-link-45deg"></i> Undangan Digital</h6>
                <div class="small text-muted mb-2">Slug: <code>{{ $order->invitation->slug }}</code></div>
                
                <a href="{{ $invitationUrl }}" target="_blank" class="btn btn-outline-dark w-100 py-2 mb-2">
                    <i class="bi bi-box-arrow-up-right me-1"></i> Buka Halaman Undangan
                </a>

                <div class="small text-muted">
                    Status: <span class="badge {{ $order->invitation->status === 'published' ? 'bg-success' : 'bg-warning text-dark' }}">{{ ucfirst($order->invitation->status) }}</span>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
