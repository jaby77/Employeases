@extends('layouts.admin')

@section('title', 'Schedule Interview')

@section('breadcrumbs')
    <x-breadcrumbs :items="[
        ['label' => 'Applicants', 'url' => route('admin.applicants.index')],
        ['label' => $application->user->name, 'url' => route('admin.applicants.show', $application)],
        ['label' => 'Schedule Interview'],
    ]" />
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Schedule Interview</h4>
        <p class="text-muted mb-0">{{ $application->user->name }} &mdash; {{ $application->jobVacancy->title }}</p>
    </div>
    <a href="{{ route('admin.interviews.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.interviews.store') }}" class="confirm-form"
                      data-confirm-title="Schedule this interview?"
                      data-confirm-text="The applicant's status will be updated to 'Interview Scheduled' and they will be notified by email."
                      data-confirm-ok="Yes, schedule it"
                      data-confirm-color="#0A2540">
                    @csrf
                    <input type="hidden" name="application_id" value="{{ $application->id }}">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Interview Date & Time <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="scheduled_at" class="form-control @error('scheduled_at') is-invalid @enderror"
                                   value="{{ old('scheduled_at', now()->addHours(1)->format('Y-m-d\TH:i')) }}"
                                   min="{{ now()->format('Y-m-d\TH:i') }}">
                            @error('scheduled_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-medium">Interview Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select @error('type') is-invalid @enderror">
                                <option value="in_person" {{ old('type') == 'in_person' ? 'selected' : '' }}>In Person</option>
                                <option value="online" {{ old('type') == 'online' ? 'selected' : '' }}>Online</option>
                                <option value="phone" {{ old('type') == 'phone' ? 'selected' : '' }}>Phone Call</option>
                            </select>
                            @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-medium">Location / Meeting Link <span class="text-danger">*</span></label>
                            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                                   value="{{ old('location', 'PESO Office, Municipal Hall, Tagudin, Ilocos Sur') }}" placeholder="e.g., PESO Office or Google Meet link">
                            @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-medium">Notes / Instructions</label>
                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror"
                                      rows="4" placeholder="Any additional instructions for the applicant...">{{ old('notes') }}</textarea>
                            @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-calendar-check me-1"></i> Schedule Interview
                            </button>
                            <a href="{{ route('admin.applicants.show', $application) }}" class="btn btn-outline-secondary px-4 ms-2">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-3">Applicant Summary</h6>
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px">
                        {{ strtoupper(substr($application->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="mb-0 fw-medium">{{ $application->user->name }}</p>
                        <small class="text-muted">{{ $application->user->email }}</small>
                    </div>
                </div>
                <hr>
                <small class="text-muted d-block mb-1">Position</small>
                <p class="fw-medium">{{ $application->jobVacancy->title }}</p>
                <small class="text-muted d-block mb-1">Applied</small>
                <p>{{ $application->created_at->format('M d, Y') }}</p>
                <small class="text-muted d-block mb-1">Current Status</small>
                <span class="badge bg-{{ $application->status_color }}">{{ $application->status_label }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
