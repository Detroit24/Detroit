@extends('layouts.admin')

@section('title', 'Kelola Pengguna - DETROIT')
@section('page_title', 'Kelola Pengguna')

@section('content')
<div class="stat-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-0">Daftar Pengguna Sistem</h5>
            <span class="text-muted small">Manajemen akun administrator dan data pelanggan</span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>WhatsApp</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Total Pesanan</th>
                    <th>Bergabung</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark">{{ $u->name }}</div>
                        </td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->phone ?? '-' }}</td>
                        <td>
                            @foreach($u->roles as $r)
                                <span class="badge {{ $r->slug === 'super-admin' ? 'bg-danger' : ($r->slug === 'admin' ? 'bg-primary' : 'bg-secondary') }}">
                                    {{ $r->name }}
                                </span>
                            @endforeach
                        </td>
                        <td>
                            <span class="badge {{ $u->status === 'active' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ ucfirst($u->status) }}
                            </span>
                        </td>
                        <td class="fw-semibold text-center">{{ $u->orders_count }}</td>
                        <td class="small text-muted">{{ $u->created_at ? $u->created_at->format('d M Y') : '-' }}</td>
                        <td class="text-end">
                            <form action="{{ route('admin.users.toggle', $u->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-secondary" title="Toggle Status">
                                    <i class="bi bi-arrow-repeat"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
