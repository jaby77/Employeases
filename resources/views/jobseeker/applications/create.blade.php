@extends('layouts.jobseeker')

@section('title', 'Apply for ' . $jobVacancy->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Apply for Position</h4>
        <p class="text-muted mb-0">{{ $jobVacancy->title }} &mdash; {{ $jobVacancy->company ?? 'N/A' }}</p>
    </div>
    <a href="{{ route('jobseeker.jobs.show', $jobVacancy) }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Job
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('jobseeker.applications.store', $jobVacancy) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-medium">Your Resume</label>
                        @if($user->profile?->resume_path)
                            <div class="d-flex align-items-center gap-2 mb-2 text-success">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>You have a resume on file</span>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="use_existing_resume" class="form-check-input" value="1" id="useExisting" checked>
                                <label class="form-check-label" for="useExisting">Use my existing resume</label>
                            </div>
                        @endif
                        <input type="file" name="resume" class="form-control mt-2 @error('resume') is-invalid @enderror" accept=".pdf">
                        @error('resume') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="text-muted">PDF only. Max 5MB</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium">Cover Letter</label>
                        <textarea name="cover_letter" class="form-control @error('cover_letter') is-invalid @enderror"
                                  rows="8" placeholder="Write a brief cover letter explaining why you're a good fit for this position...">{{ old('cover_letter') }}</textarea>
                        @error('cover_letter') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="text-muted">Optional but recommended</small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="bi bi-send me-1"></i> Submit Application
                        </button>
                        <a href="{{ route('jobseeker.jobs.show', $jobVacancy) }}" class="btn btn-outline-secondary px-4">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-3"><i class="bi bi-briefcase me-1 text-primary"></i> Job Summary</h6>
                <h5 class="fw-bold">{{ $jobVacancy->title }}</h5>
                <p class="text-muted small">{{ $jobVacancy->company ?? '' }}</p>
                <hr>
                <small class="text-muted d-block mb-2">
                    <i class="bi bi-geo-alt me-1"></i> {{ $jobVacancy->location }}
                </small>
                <small class="text-muted d-block mb-2">
                    <i class="bi bi-clock me-1"></i> {{ $jobVacancy->employment_type_label }}
                </small>
                <small class="text-muted d-block mb-2">
                    <i class="bi bi-cash me-1"></i> {{ $jobVacancy->salary_formatted }}
                </small>
                <small class="text-muted d-block">
                    <i class="bi bi-calendar me-1"></i>
                    @if($jobVacancy->application_deadline)
                        Deadline: {{ $jobVacancy->application_deadline->format('M d, Y') }}
                    @else
                        No deadline
                    @endif
                </small>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-3"><i class="bi bi-info-circle me-1 text-primary"></i> Tips</h6>
                <ul class="small text-muted ps-3 mb-0">
                    <li class="mb-2">Tailor your cover letter to the position</li>
                    <li class="mb-2">Highlight relevant skills and experience</li>
                    <li class="mb-2">Ensure your resume is up to date</li>
                    <li>Proofread before submitting</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
