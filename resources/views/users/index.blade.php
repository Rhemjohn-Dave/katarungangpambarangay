@extends('layouts.app')

@section('title', 'User Management')
@section('breadcrumb', 'User Management')

@section('content')
<div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-2">
    <div>
        <h4><i class="bi bi-people me-2" style="color:var(--primary)"></i>User Management</h4>
        <p>Manage system users and their roles.</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus me-1"></i> Add User
    </a>
</div>

<!-- Search -->
<div class="card form-card mb-3">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('users.index') }}" class="row g-2 align-items-center">
            <div class="col">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           class="form-control border-start-0 ps-0"
                           placeholder="Search by name or email...">
                </div>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Search</button>
                @if($search)
                <a href="{{ route('users.index') }}" class="btn btn-light ms-1">Clear</a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="card table-card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Cases Filed</th>
                    <th>Registered</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                <tr>
                    <td class="text-muted small">{{ $users->firstItem() + $index }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="user-avatar" style="width:32px;height:32px;font-size:0.8rem;
                                background:{{ $user->isAdmin() ? 'var(--primary)' : '#10b981' }}">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold small">{{ $user->name }}</div>
                                @if($user->id === auth()->id())
                                <small class="text-muted">(You)</small>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td><small>{{ $user->email }}</small></td>
                    <td>
                        <span class="badge px-2 py-1 {{ $user->isAdmin() ? 'badge-admin' : 'badge-staff' }}">
                            {{ $user->isAdmin() ? 'Admin' : 'Barangay Staff' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark">{{ $user->cases_count }}</span>
                    </td>
                    <td><small class="text-muted">{{ $user->created_at->format('M d, Y') }}</small></td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('users.edit', $user) }}"
                               class="btn btn-sm btn-outline-secondary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('users.destroy', $user) }}"
                                  onsubmit="return confirm('Delete user {{ $user->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="bi bi-people fs-2 d-block mb-2"></i>No users found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="card-footer bg-white py-3 px-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <small class="text-muted">
                Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }} users
            </small>
            {{ $users->links() }}
        </div>
    </div>
    @endif
</div>
@endsection
