@extends('layouts.admin')

@section('title', 'Applicant Details')

@section('breadcrumbs')
    <x-breadcrumbs :items="[
        ['label' => 'Applicants', 'url' => route('admin.applicants.index')],
        ['label' => $application->user->name],
    ]" />
@endsection

@push('styles')
<style>
    /* ===== Resume Preview Modal ===== */
    .resume-modal .modal-dialog {
        --bs-modal-width: 900px;
    }

    .resume-modal .modal-content {
        border-radius: 1rem;
        box-shadow: 0 24px 64px rgba(10, 37, 64, .18);
    }

    .resume-modal .modal-header {
        padding: 1rem 1.25rem;
    }

    .resume-modal .modal-title i {
        font-size: 20px;
        vertical-align: -2px;
    }

    /* Custom minimal toolbar (dark navy bar) */
    .resume-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: .5rem .75rem;
        background: linear-gradient(135deg, #0F172A, #1E293B);
        color: #fff;
    }

    .resume-page-indicator {
        font-size: .8rem;
        font-weight: 500;
        letter-spacing: .3px;
        color: rgba(255, 255, 255, .9);
        white-space: nowrap;
    }

    .resume-zoom {
        display: flex;
        align-items: center;
        gap: .35rem;
    }

    .resume-zoom button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 9px;
        border: 1px solid rgba(255, 255, 255, .14);
        background: rgba(255, 255, 255, .08);
        color: #fff;
        font-size: 1rem;
        transition: background-color .2s ease, border-color .2s ease, transform .15s ease;
    }

    .resume-zoom button:hover:not(:disabled) {
        background: rgba(255, 255, 255, .18);
        border-color: rgba(255, 255, 255, .28);
    }

    .resume-zoom button:active:not(:disabled) {
        transform: scale(.94);
    }

    .resume-zoom button:disabled {
        opacity: .4;
        cursor: not-allowed;
    }

    .resume-zoom .resume-zoom-label {
        width: auto;
        min-width: 58px;
        padding: 0 .4rem;
        font-size: .78rem;
        font-weight: 600;
        letter-spacing: .2px;
    }

    /* PDF canvas viewport */
    .resume-viewport {
        position: relative;
        min-height: 320px;
        background: #f3f4f6;
        padding: 1.5rem 1.75rem;
        max-height: calc(100vh - 320px);
        overflow-y: auto;
        overflow-x: auto;
    }

    .resume-pages {
        position: relative;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center; /* fallback for browsers without `safe` alignment */
        align-items: safe center;
        justify-content: flex-start;
        gap: 1.25rem;
    }

    .resume-page {
        background: #fff;
        border-radius: 4px;
        box-shadow: 0 2px 6px rgba(10, 37, 64, .08), 0 14px 32px rgba(10, 37, 64, .16);
        flex-shrink: 0;
    }

    .resume-page canvas {
        display: block;
        border-radius: 4px;
    }

    .resume-status {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        padding: 1.5rem;
        text-align: center;
        color: #64748b;
        font-size: .9rem;
    }

    .resume-modal .modal-footer {
        padding: .9rem 1.25rem;
    }

    .resume-skeleton-sheet {
        width: 300px;
        height: 400px;
        border-radius: 4px;
        box-shadow: 0 2px 6px rgba(10, 37, 64, .08), 0 14px 32px rgba(10, 37, 64, .16);
        flex-shrink: 0;
    }

    [data-bs-theme="dark"] .resume-viewport {
        background: #171a20;
    }

    [data-bs-theme="dark"] .resume-page {
        box-shadow: 0 2px 6px rgba(0, 0, 0, .45), 0 14px 32px rgba(0, 0, 0, .55);
    }

    @media (max-width: 575.98px) {
        .resume-modal .modal-dialog {
            margin: .5rem;
        }

        .resume-viewport {
            padding: 1rem;
            max-height: calc(100vh - 340px);
        }
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Applicant Details</h4>
        <p class="text-muted mb-0">Review applicant information and manage application</p>
    </div>
    <a href="{{ route('admin.applicants.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to List
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <!-- Applicant Info -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:60px;height:60px;font-size:24px;font-weight:600">
                        {{ strtoupper(substr($application->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">{{ $application->user->name }}</h5>
                        <p class="text-muted mb-0">{{ $application->user->email }}</p>
                        <p class="text-muted mb-0"><small>Applied for: <a href="{{ route('admin.job-vacancies.show', $application->jobVacancy) }}" class="text-decoration-none">{{ $application->jobVacancy->title }}</a></small></p>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    @if($application->user->profile)
                        @php $p = $application->user->profile; @endphp
                        <div class="col-sm-6">
                            <small class="text-muted d-block">Phone</small>
                            <span>{{ $p->phone ?? 'N/A' }}</span>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block">Gender</small>
                            <span>{{ $p->gender ? ucfirst($p->gender) : 'N/A' }}</span>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block">Birth Date</small>
                            <span>{{ $p->birth_date ? $p->birth_date->format('M d, Y') : 'N/A' }}</span>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block">Address</small>
                            <span>{{ $p->address ? $p->address . ', ' . ($p->city ?? '') : 'N/A' }}</span>
                        </div>
                    @endif
                </div>

                @if($application->user->profile?->education)
                    <div class="mb-3">
                        <h6 class="fw-semibold"><i class="bi bi-book me-2 text-primary"></i>Education</h6>
                        <p class="text-muted">{{ $application->user->profile->education }}</p>
                    </div>
                @endif

                @if($application->user->profile?->skills)
                    <div class="mb-3">
                        <h6 class="fw-semibold"><i class="bi bi-gear me-2 text-primary"></i>Skills</h6>
                        <div>
                            @foreach($application->user->profile->skills_array as $skill)
                                <span class="badge bg-primary-subtle text-primary-emphasis me-1 mb-1">{{ $skill }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($application->user->profile?->work_experience)
                    <div class="mb-3">
                        <h6 class="fw-semibold"><i class="bi bi-briefcase me-2 text-primary"></i>Work Experience</h6>
                        <p class="text-muted">{{ $application->user->profile->work_experience }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Cover Letter -->
        @if($application->cover_letter)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-3"><i class="bi bi-envelope me-2 text-primary"></i>Cover Letter</h5>
                    <p class="text-muted">{{ $application->cover_letter }}</p>
                </div>
            </div>
        @endif

        <!-- Interview Info -->
        @if($application->interview)
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-3"><i class="bi bi-calendar-event me-2 text-success"></i>Scheduled Interview</h5>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <small class="text-muted d-block">Date & Time</small>
                            <span class="fw-medium">{{ $application->interview->scheduled_at->format('F d, Y h:i A') }}</span>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block">Type</small>
                            <span>{{ $application->interview->type_label }}</span>
                        </div>
                        <div class="col-12">
                            <small class="text-muted d-block">Location</small>
                            <span>{{ $application->interview->location }}</span>
                        </div>
                        @if($application->interview->notes)
                            <div class="col-12">
                                <small class="text-muted d-block">Notes</small>
                                <span>{{ $application->interview->notes }}</span>
                            </div>
                        @endif
                        <div class="col-12">
                            <x-status-badge :status="$application->interview->status" :label="$application->interview->status_label" />
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="col-lg-4">
        <!-- Status Management -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="fw-semibold mb-3"><i class="bi bi-flag me-2 text-primary"></i>Application Status</h5>
                <div class="mb-3">
                    <x-status-badge :status="$application->status" :label="$application->status_label" />
                </div>

                <form id="statusForm" class="mb-3">
                    @csrf
                    <label class="form-label fw-medium">Update Status</label>
                    <select name="status" class="form-select mb-2" id="statusSelect">
                        @foreach(['pending','under_review','shortlisted','interview_scheduled','accepted','rejected'] as $s)
                            <option value="{{ $s }}" {{ $application->status == $s ? 'selected' : '' }}>{{ ucwords(str_replace('_', ' ', $s)) }}</option>
                        @endforeach
                    </select>
                    <textarea name="admin_notes" class="form-control mb-2" rows="2" placeholder="Add notes...">{{ $application->admin_notes }}</textarea>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-lg me-1"></i> Update Status
                    </button>
                </form>

                @if(!$application->interview && $application->status !== 'rejected')
                    <a href="{{ route('admin.interviews.create', $application) }}" class="btn btn-outline-success w-100">
                        <i class="bi bi-calendar-plus me-1"></i> Schedule Interview
                    </a>
                @endif
            </div>
        </div>

        <!-- Resume -->
        @if($application->resume_path || $application->user->profile?->resume_path)
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-file-pdf fs-1 text-danger mb-2 d-block"></i>
                    <h6 class="fw-semibold mb-3">Resume Available</h6>
                    <div class="d-flex flex-column flex-sm-row gap-2">
                        <button type="button" class="btn btn-outline-primary flex-fill" data-bs-toggle="modal" data-bs-target="#resumePreviewModal">
                            <i class="bi bi-eye me-1"></i> View Resume
                        </button>
                        <a href="{{ route('admin.applicants.download-resume', $application) }}" class="btn btn-danger flex-fill">
                            <i class="bi bi-download me-1"></i> Download Resume
                        </a>
                    </div>
                </div>
            </div>

            <!-- Resume Preview Modal -->
            <div class="modal fade resume-modal" id="resumePreviewModal" tabindex="-1" aria-labelledby="resumePreviewModalLabel" aria-hidden="true" data-resume-url="{{ route('admin.applicants.view-resume', $application) }}">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 overflow-hidden">
                        <div class="modal-header">
                            <h5 class="modal-title fw-semibold" id="resumePreviewModalLabel">
                                <i class="bi bi-file-earmark-pdf text-danger me-2" aria-hidden="true"></i> Resume — {{ $application->user->name }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <!-- Custom minimal viewer toolbar -->
                        <div class="resume-toolbar">
                            <span class="resume-page-indicator" id="resumePageIndicator" aria-live="polite">Page 1 of 1</span>
                            <div class="resume-zoom" role="group" aria-label="Zoom controls">
                                <button type="button" id="resumeZoomOut" title="Zoom out" aria-label="Zoom out" disabled>
                                    <i class="bi bi-zoom-out" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="resume-zoom-label" id="resumeZoomReset" title="Reset zoom" aria-label="Reset zoom to 100%" disabled>100%</button>
                                <button type="button" id="resumeZoomIn" title="Zoom in" aria-label="Zoom in" disabled>
                                    <i class="bi bi-zoom-in" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>

                        <!-- PDF canvas area -->
                        <div class="resume-viewport" id="resumeViewport">
                            <div class="resume-pages" id="resumePages"></div>
                            <div class="resume-status flex-column" id="resumeLoading">
                                <div class="skeleton resume-skeleton-sheet" aria-hidden="true"></div>
                                <span class="mt-3">Loading resume…</span>
                            </div>
                            <div class="resume-status text-danger d-none" id="resumeError" role="alert">
                                <i class="bi bi-exclamation-triangle me-2" aria-hidden="true"></i>
                                <span>Unable to load the resume preview. The file may be missing or damaged — you can still download it below.</span>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <a href="{{ route('admin.applicants.download-resume', $application) }}" class="btn btn-danger">
                                <i class="bi bi-download me-1" aria-hidden="true"></i> Download Resume
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
@vite(['resources/js/resume-preview.js'])
<script>
document.getElementById('statusForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const formData = new FormData(form);

    Swal.fire({
        title: 'Update Status?',
        text: 'Are you sure you want to change the application status?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#A16207',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, update it!'
    }).then(result => {
        if (result.isConfirmed) {
            fetch('{{ route("admin.applicants.update-status", $application) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    setTimeout(() => location.reload(), 600);
                } else {
                    showToast(data.message || 'Could not update the application status.', 'error');
                }
            })
            .catch(() => showToast('Connection error. Could not update the application status.', 'error'));
        }
    });
});
</script>
@endpush
