@extends('layouts.app')

@section('title', 'Edit Case')
@section('breadcrumb', 'Edit Case')

@section('content')
<div class="page-header">
    <h4><i class="bi bi-pencil-square me-2" style="color:var(--primary)"></i>Edit Case Record</h4>
    <p>Update the information for case <strong>{{ $case->case_no }}</strong>.</p>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card form-card">
            <div class="card-header bg-white py-3 px-4 border-bottom">
                <h6 class="fw-bold mb-0">Case Information</h6>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('cases.update', $case) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="case_no" class="form-label">Case Number <span class="text-danger">*</span></label>
                        <input type="text" id="case_no" name="case_no"
                               class="form-control @error('case_no') is-invalid @enderror"
                               value="{{ old('case_no', $case->case_no) }}">
                        @error('case_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="complainant" class="form-label">Complainant <span class="text-danger">*</span></label>
                            <input type="text" id="complainant" name="complainant"
                                   class="form-control @error('complainant') is-invalid @enderror"
                                   value="{{ old('complainant', $case->complainant) }}">
                            @error('complainant')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="respondent" class="form-label">Respondent <span class="text-danger">*</span></label>
                            <input type="text" id="respondent" name="respondent"
                                   class="form-control @error('respondent') is-invalid @enderror"
                                   value="{{ old('respondent', $case->respondent) }}">
                            @error('respondent')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nature_of_complaint" class="form-label">Nature of Complaint <span class="text-danger">*</span></label>
                        <textarea id="nature_of_complaint" name="nature_of_complaint" rows="4"
                                  class="form-control @error('nature_of_complaint') is-invalid @enderror">{{ old('nature_of_complaint', $case->nature_of_complaint) }}</textarea>
                        @error('nature_of_complaint')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="pdf_file" class="form-label">Replace PDF File</label>
                        @if($case->pdf_file)
                        <div class="mb-2 p-2 border rounded d-flex align-items-center gap-2 bg-light">
                            <i class="bi bi-file-earmark-pdf text-danger fs-5"></i>
                            <div class="flex-grow-1">
                                <small class="text-muted">Current file: {{ basename($case->pdf_file) }}</small>
                            </div>
                            <a href="{{ route('cases.pdf', $case) }}" target="_blank"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye me-1"></i> View
                            </a>
                        </div>
                        @endif
                        <input type="file" id="pdf_file" name="pdf_file" accept=".pdf"
                               class="form-control @error('pdf_file') is-invalid @enderror">
                        <div class="form-text">Leave empty to keep the current PDF. PDF only, max 10MB.</div>
                        @error('pdf_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Update Case
                        </button>
                        <a href="{{ route('cases.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
