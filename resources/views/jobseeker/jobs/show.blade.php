@extends('layouts.jobseeker')

@section('title', $jobVacancy->title)

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
    <div>
        <h4 class="mb-1 fw-bold">{{ $jobVacancy->title }}</h4>
        <p class="text-muted mb-0">
            <i class="bi bi-building me-1"></i>{{ $jobVacancy->company ?? 'N/A' }}
            &middot; <i class="bi bi-geo-alt me-1"></i>{{ $jobVacancy->location }}
        </p>
    </div>
    <div class="flex-shrink-0 w-100 w-md-auto">
        <a href="{{ route('jobseeker.jobs.index') }}" class="btn btn-outline-secondary w-100 w-md-auto">
            <i class="bi bi-arrow-left me-1"></i> Back to Jobs
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex gap-3 mb-4">
                    <span class="badge bg-primary-subtle text-primary-emphasis p-2">{{ $jobVacancy->category->name }}</span>
                    <span class="badge bg-primary-subtle text-primary-emphasis p-2">{{ $jobVacancy->employment_type_label }}</span>
                    @if($jobVacancy->is_open)
                        <span class="badge bg-success-subtle text-success-emphasis p-2">Accepting Applications</span>
                    @endif
                </div>

                <h5 class="fw-semibold mb-3"><i class="bi bi-file-text me-2 text-primary"></i>Job Description</h5>
                <p class="text-muted">{{ $jobVacancy->description }}</p>

                @if($jobVacancy->requirements)
                    <h5 class="fw-semibold mt-4 mb-3"><i class="bi bi-list-check me-2 text-primary"></i>Requirements</h5>
                    <p class="text-muted">{{ $jobVacancy->requirements }}</p>
                @endif

                @if($jobVacancy->benefits)
                    <h5 class="fw-semibold mt-4 mb-3"><i class="bi bi-gift me-2 text-primary"></i>Benefits</h5>
                    <p class="text-muted">{{ $jobVacancy->benefits }}</p>
                @endif
            </div>
        </div>

        <!-- Related Jobs -->
        @if($relatedJobs->count() > 0)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-semibold mb-0"><i class="bi bi-stars me-2 text-primary"></i>Related Jobs</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($relatedJobs as $related)
                            <div class="col-md-6">
                                <div class="card border h-100">
                                    <div class="card-body">
                                        <h6 class="fw-semibold mb-1">
                                            <a href="{{ route('jobseeker.jobs.show', $related) }}" class="text-decoration-none">{{ $related->title }}</a>
                                        </h6>
                                        <small class="text-muted">{{ $related->location }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="fw-semibold mb-3"><i class="bi bi-info-circle me-2 text-primary"></i>Job Details</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">Salary</span>
                        <span class="fw-medium text-primary-emphasis">{{ $jobVacancy->salary_formatted }}</span>
                    </li>
                    <li class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">Type</span>
                        <span>{{ $jobVacancy->employment_type_label }}</span>
                    </li>
                    <li class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">Category</span>
                        <span>{{ $jobVacancy->category->name }}</span>
                    </li>
                    <li class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">Location</span>
                        <span>{{ $jobVacancy->location }}</span>
                    </li>
                    <li class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">Slots</span>
                        <span>{{ $jobVacancy->slots_available }}</span>
                    </li>
                    @if($jobVacancy->application_deadline)
                        <li class="mb-3 d-flex justify-content-between">
                            <span class="text-muted">Deadline</span>
                            <span class="fw-medium {{ $jobVacancy->isDeadlinePassed() ? 'text-danger' : '' }}">
                                {{ $jobVacancy->application_deadline->format('M d, Y') }}
                            </span>
                        </li>
                    @endif
                    <li class="d-flex justify-content-between">
                        <span class="text-muted">Posted</span>
                        <span>{{ $jobVacancy->created_at->format('M d, Y') }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Actions -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-grid gap-2">
                    @if($hasApplied)
                        <button class="btn btn-secondary btn-lg" disabled>
                            <i class="bi bi-check-circle me-1"></i> Applied
                        </button>
                        <a href="{{ route('jobseeker.applications.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-eye me-1"></i> View My Applications
                        </a>
                    @elseif($jobVacancy->is_open && !$jobVacancy->isDeadlinePassed())
                        <a href="{{ route('jobseeker.applications.create', $jobVacancy) }}" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-send me-1"></i> Apply Now
                        </a>
                    @else
                        <button class="btn btn-secondary btn-lg w-100" disabled>
                            <i class="bi bi-x-circle me-1"></i>
                            {{ $jobVacancy->isDeadlinePassed() ? 'Deadline Passed' : 'Closed' }}
                        </button>
                    @endif

                    <button class="btn btn-outline-primary save-job-btn w-100" data-job-id="{{ $jobVacancy->id }}">
                        <i class="bi bi-bookmark{{ $isSaved ? '-fill' : '' }} me-1"></i>
                        {{ $isSaved ? 'Saved' : 'Save Job' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelector('.save-job-btn')?.addEventListener('click', function() {
    const jobId = this.dataset.jobId;
    fetch('/jobseeker/jobs/' + jobId + '/toggle-save', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        }
    }).then(r => r.json()).then(data => {
        if (data.success) {
            const icon = this.querySelector('i');
            if (data.saved) {
                icon.className = 'bi bi-bookmark-fill me-1';
                this.innerHTML = '<i class="bi bi-bookmark-fill me-1"></i> Saved';
                Swal.fire({ icon: 'success', title: 'Saved!', timer: 1500, showConfirmButton: false });
            } else {
                icon.className = 'bi bi-bookmark me-1';
                this.innerHTML = '<i class="bi bi-bookmark me-1"></i> Save Job';
                Swal.fire({ icon: 'info', title: 'Removed', timer: 1500, showConfirmButton: false });
            }
        }
    });
});
</script>
@endpush
