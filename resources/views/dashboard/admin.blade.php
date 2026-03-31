@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h4><i class="bi bi-speedometer2 me-2" style="color:var(--primary)"></i>Admin Dashboard</h4>
        <p>Welcome back, <strong>{{ auth()->user()->name }}</strong>! Here's an overview of the system.</p>
    </div>
    <span class="badge px-3 py-2 badge-admin">Administrator</span>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="card-icon" style="background:rgba(56,85,165,0.12);color:var(--primary)">
                    <i class="bi bi-folder2-open"></i>
                </div>
                <div>
                    <div class="text-muted small fw-500">Total Cases</div>
                    <div class="fw-bold fs-3 lh-1 mt-1">{{ number_format($totalCases) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="card-icon" style="background:rgba(16,185,129,0.12);color:#10b981">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <div class="text-muted small fw-500">Total Users</div>
                    <div class="fw-bold fs-3 lh-1 mt-1">{{ number_format($totalUsers) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="card-icon" style="background:rgba(245,158,11,0.12);color:#f59e0b">
                    <i class="bi bi-file-earmark-pdf"></i>
                </div>
                <div>
                    <div class="text-muted small fw-500">Recent (This Month)</div>
                    <div class="fw-bold fs-3 lh-1 mt-1">
                        {{ \App\Models\CaseRecord::whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="card-icon" style="background:rgba(139,92,246,0.12);color:#8b5cf6">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div>
                    <div class="text-muted small fw-500">Today</div>
                    <div class="fw-bold fs-3 lh-1 mt-1">
                        {{ \App\Models\CaseRecord::whereDate('created_at', today())->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Cases -->
<div class="card table-card">
    <div class="card-header bg-white d-flex align-items-center justify-content-between py-3 px-4">
        <h6 class="fw-bold mb-0"><i class="bi bi-clock-history me-2" style="color:var(--primary)"></i>Recent Cases</h6>
        <a href="{{ route('cases.index') }}" class="btn btn-sm btn-outline-primary">
            View All <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Case No.</th>
                    <th>Complainant</th>
                    <th>Respondent</th>
                    <th>Nature</th>
                    <th>Filed By</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentCases as $case)
                <tr>
                    <td><span class="fw-semibold text-primary">{{ $case->case_no }}</span></td>
                    <td>{{ $case->complainant }}</td>
                    <td>{{ $case->respondent }}</td>
                    <td>
                        <span title="{{ $case->nature_of_complaint }}">
                            {{ Str::limit($case->nature_of_complaint, 40) }}
                        </span>
                    </td>
                    <td>{{ $case->creator->name ?? 'N/A' }}</td>
                    <td><small class="text-muted">{{ $case->created_at->format('M d, Y') }}</small></td>
                    <td>
                        <a href="{{ route('cases.show', $case) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="bi bi-folder2 fs-3 d-block mb-2"></i>No cases found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
