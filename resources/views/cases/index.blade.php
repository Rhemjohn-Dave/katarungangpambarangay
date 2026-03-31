@extends('layouts.app')

@section('title', 'Case Records')
@section('breadcrumb', 'Case Records')

@section('content')
<div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-2">
    <div>
        <h4><i class="bi bi-folder2-open me-2" style="color:var(--primary)"></i>Case Records</h4>
        <p>{{ auth()->user()->isAdmin() ? 'All barangay case records.' : 'Cases you have filed.' }}</p>
    </div>
    <a href="{{ route('cases.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Add New Case
    </a>
</div>

<!-- Search Bar -->
<div class="card form-card mb-3">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('cases.index') }}" class="row g-2 align-items-center">
            <div class="col">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           class="form-control border-start-0 ps-0"
                           placeholder="Search by Case No., Complainant, Respondent, or Nature...">
                </div>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Search</button>
                @if($search)
                <a href="{{ route('cases.index') }}" class="btn btn-light ms-1">Clear</a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Cases Table -->
<div class="card table-card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Case No.</th>
                    <th>Complainant</th>
                    <th>Respondent</th>
                    <th>Nature of Complaint</th>
                    <th>Filed By</th>
                    <th>Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cases as $index => $case)
                <tr>
                    <td class="text-muted small">{{ $cases->firstItem() + $index }}</td>
                    <td>
                        <a href="{{ route('cases.show', $case) }}" class="fw-semibold text-primary text-decoration-none">
                            {{ $case->case_no }}
                        </a>
                    </td>
                    <td>{{ $case->complainant }}</td>
                    <td>{{ $case->respondent }}</td>
                    <td>
                        <span class="text-muted small" title="{{ $case->nature_of_complaint }}">
                            {{ Str::limit($case->nature_of_complaint, 50) }}
                        </span>
                    </td>
                    <td>
                        <small>{{ $case->creator->name ?? 'N/A' }}</small>
                    </td>
                    <td>
                        <small class="text-muted">{{ $case->created_at->format('M d, Y') }}</small>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('cases.show', $case) }}"
                               class="btn btn-sm btn-outline-primary" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if(auth()->user()->isAdmin() || $case->created_by === auth()->id())
                            <a href="{{ route('cases.edit', $case) }}"
                               class="btn btn-sm btn-outline-secondary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @endif
                            @if(auth()->user()->isAdmin())
                            <form method="POST" action="{{ route('cases.destroy', $case) }}"
                                  onsubmit="return confirm('Delete case {{ $case->case_no }}? This cannot be undone.')">
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
                    <td colspan="8" class="text-center text-muted py-5">
                        <i class="bi bi-folder2 fs-2 d-block mb-2"></i>
                        No cases found.
                        @if($search)
                            <span>Try a different search term.</span>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($cases->hasPages())
    <div class="card-footer bg-white py-3 px-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <small class="text-muted">
                Showing {{ $cases->firstItem() }}–{{ $cases->lastItem() }} of {{ $cases->total() }} records
            </small>
            {{ $cases->links() }}
        </div>
    </div>
    @endif
</div>
@endsection
