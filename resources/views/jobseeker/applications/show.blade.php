@extends('layouts.jobseeker')

@section('title', 'Application Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Application Details</h4>
        <p class="text-muted mb-0">{{ $application->jobVacancy->title }}</p>
    </div>
    <a href="{{ route('jobseeker.applications.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Applications
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h5 class="fw-semibold mb-1">{{ $application->jobVacancy->title }}</h5>
                        <p class="text-muted mb-0">
                            {{ $application->jobVacancy->company ?? 'N/A' }} &middot;
                            {{ $application->jobVacancy->location }}
                        </p>
                    </div>
                    <span class="badge bg-{{ $application->status_color }} fs-6 p-2">{{ $application->status_label }}</span>
                </div>

                <div class="mb-4">
                    <h6 class="fw-semibold mb-2"><i class="bi bi-clock me-2 text-primary"></i>Timeline</h6>
                    <div class="timeline">
                        <div class="d-flex gap-3 mb-3">
                            <div class="text-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:30px;height:30px">
                                    <i class="bi bi-send small"></i>
                                </div>
                            </div>
                            <div>
                                <p class="mb-0 fw-medium">Application Submitted</p>
                                <small class="text-muted">{{ $application->created_at->format('F d, Y h:i A') }}</small>
                            </div>
                        </div>
                        @if($application->reviewed_at)
                            <div class="d-flex gap-3 mb-3">
                                <div class="text-center">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:30px;height:30px">
                                        <i class="bi bi-eye small"></i>
                                    </div>
                                </div>
                                <div>
                                    <p class="mb-0 fw-medium">Reviewed by PESO</p>
                                    <small class="text-muted">{{ $application->reviewed_at->format('F d, Y h:i A') }}</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @if($application->cover_letter)
                    <div class="mb-4">
                        <h6 class="fw-semibold mb-2"><i class="bi bi-envelope me-2 text-primary"></i>Cover Letter</h6>
                        <p class="text-muted">{{ $application->cover_letter }}</p>
                    </div>
                @endif

                @if($application->admin_notes)
                    <div class="p-3 bg-light rounded-3">
                        <h6 class="fw-semibold mb-2"><i class="bi bi-chat-dots me-2 text-primary"></i>Admin Notes</h6>
                        <p class="mb-0">{{ $application->admin_notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="fw-semibold mb-3"><i class="bi bi-info-circle me-2 text-primary"></i>Application Info</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">Status</span>
                        <span class="badge bg-{{ $application->status_color }}">{{ $application->status_label }}</span>
                    </li>
                    <li class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">Position</span>
                        <span>{{ $application->jobVacancy->title }}</span>
                    </li>
                    <li class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">Submitted</span>
                        <span>{{ $application->created_at->format('M d, Y') }}</span>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span class="text-muted">Last Updated</span>
                        <span>{{ $application->updated_at->format('M d, Y') }}</span>
                    </li>
                </ul>
            </div>
        </div>

        @if($application->interview)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-3">
                        <i class="bi bi-calendar-event me-2 text-success"></i>Interview Schedule
                    </h5>
                    <div class="p-3 border border-success rounded-3 bg-success-subtle">
                        <p class="mb-1 fw-medium">{{ $application->interview->scheduled_at->format('F d, Y') }}</p>
                        <p class="mb-1 text-success fw-medium">{{ $application->interview->scheduled_at->format('h:i A') }}</p>
                        <p class="mb-1">
                            <i class="bi bi-geo-alt me-1"></i>{{ $application->interview->location }}
                        </p>
                        <p class="mb-0">
                            <span class="badge bg-{{ $application->interview->status_color }}">{{ $application->interview->status_label }}</span>
                        </p>
                    </div>
                    @if($application->interview->notes)
                        <div class="mt-3">
                            <small class="text-muted d-block">Notes:</small>
                            <p class="mb-0 small">{{ $application->interview->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-3">
                    <i class="bi bi-file-text me-1 text-primary"></i> Job Details
                </h6>
                <a href="{{ route('jobseeker.jobs.show', $application->jobVacancy) }}" class="btn btn-outline-primary w-100">
                    <i class="bi bi-eye me-1"></i> View Job Posting
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
