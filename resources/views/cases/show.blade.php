@extends('layouts.app')

@section('title', 'View Case — ' . $case->case_no)
@section('breadcrumb', 'View Case')

@push('styles')
<style>
    .detail-label {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #94a3b8;
        margin-bottom: 0.25rem;
    }
    .detail-value {
        font-size: 0.95rem;
        color: #1e293b;
    }
    .pdf-container {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }
</style>
@endpush

@section('content')
<div class="page-header d-flex flex-wrap align-items-center justify-content-between gap-2">
    <div>
        <h4><i class="bi bi-file-earmark-text me-2" style="color:var(--primary)"></i>Case Details</h4>
        <p>Viewing full record for case <strong>{{ $case->case_no }}</strong></p>
    </div>
    <div class="d-flex gap-2">
        @if(auth()->user()->isAdmin() || $case->created_by === auth()->id())
        <a href="{{ route('cases.edit', $case) }}" class="btn btn-outline-secondary">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
        @endif
        <a href="{{ route('cases.index') }}" class="btn btn-light">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Case Details -->
    <div class="col-lg-4">
        <div class="card form-card h-100">
            <div class="card-header bg-white py-3 px-4 border-bottom">
                <h6 class="fw-bold mb-0"><i class="bi bi-info-circle me-2" style="color:var(--primary)"></i>Case Information</h6>
            </div>
            <div class="card-body p-4">
                <div class="mb-4">
                    <div class="detail-label">Case Number</div>
                    <div class="detail-value fw-bold fs-5 text-primary">{{ $case->case_no }}</div>
                </div>
                <div class="mb-4">
                    <div class="detail-label">Complainant</div>
                    <div class="detail-value">{{ $case->complainant }}</div>
                </div>
                <div class="mb-4">
                    <div class="detail-label">Respondent</div>
                    <div class="detail-value">{{ $case->respondent }}</div>
                </div>
                <div class="mb-4">
                    <div class="detail-label">Nature of Complaint</div>
                    <div class="detail-value">{{ $case->nature_of_complaint }}</div>
                </div>
                <hr>
                <div class="mb-3">
                    <div class="detail-label">Filed By</div>
                    <div class="detail-value d-flex align-items-center gap-2">
                        <div class="user-avatar" style="width:28px;height:28px;font-size:0.75rem;">
                            {{ strtoupper(substr($case->creator->name ?? 'U', 0, 1)) }}
                        </div>
                        {{ $case->creator->name ?? 'Unknown' }}
                    </div>
                </div>
                <div class="mb-3">
                    <div class="detail-label">Date Filed</div>
                    <div class="detail-value">{{ $case->created_at->format('F d, Y \a\t h:i A') }}</div>
                </div>
                <div>
                    <div class="detail-label">Last Updated</div>
                    <div class="detail-value">{{ $case->updated_at->format('F d, Y \a\t h:i A') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- PDF Viewer -->
    <div class="col-lg-8">
        <div class="card form-card h-100">
            <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-file-earmark-pdf me-2 text-danger"></i>PDF Document
                </h6>
                @if($case->pdf_file)
                <a href="{{ route('cases.pdf', $case) }}" target="_blank"
                   class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-download me-1"></i> Open / Download PDF
                </a>
                @endif
            </div>
            <div class="card-body p-4">
                @if($case->pdf_file)
                <div class="pdf-container">
                    <iframe src="{{ route('cases.pdf', $case) }}"
                            width="100%"
                            height="650"
                            frameborder="0"
                            style="display:block;">
                        <p>Your browser does not support embedded PDF preview.
                            <a href="{{ route('cases.pdf', $case) }}" target="_blank">Click here to open the PDF.</a>
                        </p>
                    </iframe>
                </div>
                @else
                <div class="text-center text-muted py-5">
                    <i class="bi bi-file-earmark-x fs-1 d-block mb-3 text-secondary"></i>
                    <p>No PDF file attached to this case.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
