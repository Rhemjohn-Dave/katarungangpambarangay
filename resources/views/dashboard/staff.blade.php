@extends('layouts.app')

@section('title', 'Staff Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h4><i class="bi bi-speedometer2 me-2" style="color:var(--primary)"></i>Staff Dashboard</h4>
        <p>Welcome back, <strong>{{ auth()->user()->name }}</strong>! Here are your case uploads.</p>
    </div>
    <span class="badge px-3 py-2 badge-staff">Barangay Staff</span>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="card-icon" style="background:rgba(56,85,165,0.12);color:var(--primary)">
                    <i class="bi bi-folder2-open"></i>
                </div>
                <div>
                    <div class="text-muted small">My Total Cases</div>
                    <div class="fw-bold fs-3 lh-1 mt-1">{{ number_format($totalCases) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="card-icon" style="background:rgba(245,158,11,0.12);color:#f59e0b">
                    <i class="bi bi-file-earmark-pdf"></i>
                </div>
                <div>
                    <div class="text-muted small">This Month</div>
                    <div class="fw-bold fs-3 lh-1 mt-1">
                        {{ \App\Models\CaseRecord::where('created_by', auth()->id())->whereMonth('created_at', now()->month)->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="card-icon" style="background:rgba(16,185,129,0.12);color:#10b981">
                    <i class="bi bi-plus-circle"></i>
                </div>
                <div class="d-grid">
                    <a href="{{ route('cases.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus me-1"></i> Add New Case
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Uploads -->
<div class="card table-card">
    <div class="card-header bg-white d-flex align-items-center justify-content-between py-3 px-4">
        <h6 class="fw-bold mb-0"><i class="bi bi-clock-history me-2" style="color:var(--primary)"></i>My Recent Uploads</h6>
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
                    <th>Date Filed</th>
                    <th>Actions</th>
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
                    <td><small class="text-muted">{{ $case->created_at->format('M d, Y') }}</small></td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('cases.show', $case) }}" class="btn btn-sm btn-outline-primary" title="View">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('cases.edit', $case) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="bi bi-folder2 fs-3 d-block mb-2"></i>You haven't uploaded any cases yet.
                        <div class="mt-2">
                            <a href="{{ route('cases.create') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus me-1"></i> Add Your First Case
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
