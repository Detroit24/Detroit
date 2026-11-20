@extends('layouts.admin')

@section('title', 'Dashboard Overview - DETROIT Studio')
@section('page_title', 'Dashboard')

@section('content')

    <!-- 3 Metric Cards (matching Image 2) -->
    <div class="row g-4 mb-4">
        <!-- Total Pesanan -->
        <div class="col-md-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small fw-semibold">Total Pesanan</span>
                    <span class="badge bg-success bg-opacity-10 text-success fw-bold small">
                        <i class="bi bi-arrow-up"></i> {{ $orderGrowth }}
                    </span>
                </div>
                <div class="display-6 fw-bold text-dark">{{ number_format($totalOrders, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Pendapatan -->
        <div class="col-md-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small fw-semibold">Pendapatan</span>
                    <span class="badge bg-success bg-opacity-10 text-success fw-bold small">
                        <i class="bi bi-arrow-up"></i> {{ $revenueGrowth }}
                    </span>
                </div>
                <div class="display-6 fw-bold text-dark">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Template Aktif -->
        <div class="col-md-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small fw-semibold">Template Aktif</span>
                    <span class="badge bg-success bg-opacity-10 text-success fw-bold small">
                        <i class="bi bi-arrow-up"></i> {{ $templateGrowth }}
                    </span>
                </div>
                <div class="display-6 fw-bold text-dark">{{ $activeTemplates }}</div>
            </div>
        </div>
    </div>

    <!-- Main Row: Chart on Left & Recent Orders on Right (matching Image 2) -->
    <div class="row g-4">
        <!-- Grafik Penjualan (Left Column) -->
        <div class="col-lg-8">
            <div class="stat-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">Grafik Penjualan</h6>
                        <span class="text-muted small">Tren pendapatan per bulan tahun berjalan</span>
                    </div>
                    <span class="badge bg-light text-dark border">12 Bulan</span>
                </div>
                
                <div style="position: relative; height: 320px;">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Pesanan Terbaru (Right Column) -->
        <div class="col-lg-4">
            <div class="stat-card h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <h6 class="fw-bold mb-0 text-dark">Pesanan Terbaru</h6>
                    <a href="{{ route('admin.orders.index') }}" class="small text-decoration-none text-primary">Lihat Semua</a>
                </div>

                <div class="vstack gap-3 flex-grow-1 overflow-auto" style="max-height: 380px;">
                    @forelse($recentOrders as $order)
                        <div class="p-3 rounded-3 border bg-light d-flex align-items-center justify-content-between">
                            <div>
                                <div class="fw-bold font-monospace small text-primary">#{{ $order->order_code }}</div>
                                <div class="fw-semibold small text-dark">{{ $order->user->name ?? 'Pelanggan' }}</div>
                                <div class="text-muted" style="font-size: 0.75rem;">
                                    Rp {{ number_format($order->final_amount, 0, ',', '.') }}
                                </div>
                            </div>

                            <div class="text-end">
                                @if($order->status === 'paid')
                                    <span class="badge bg-success rounded-pill px-2 py-1 small">Paid</span>
                                @elseif($order->status === 'pending')
                                    <span class="badge bg-warning text-dark rounded-pill px-2 py-1 small">Pending</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill px-2 py-1 small">{{ ucfirst($order->status) }}</span>
                                @endif

                                <div class="mt-1">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-white border py-0 px-2" style="font-size: 0.7rem;">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted small">
                            Belum ada pesanan terbaru.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('salesChart').getContext('2d');
        
        // Gradient fill matching Image 2 line chart
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(37, 99, 235, 0.25)');
        gradient.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($months) !!},
                datasets: [{
                    label: 'Penjualan (Juta Rp)',
                    data: {!! json_encode($salesData) !!},
                    borderColor: '#2563EB',
                    borderWidth: 2.5,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 3,
                    pointBackgroundColor: '#2563EB',
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#F1F5F9' },
                        ticks: {
                            callback: function(value) { return 'Rp ' + value + 'jt'; }
                        }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endpush
