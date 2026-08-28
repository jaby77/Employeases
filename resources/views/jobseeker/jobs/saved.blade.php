@extends('layouts.jobseeker')

@section('title', 'Saved Jobs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Saved Jobs</h4>
        <p class="text-muted mb-0">Jobs you have bookmarked</p>
    </div>
    <a href="{{ route('jobseeker.jobs.index') }}" class="btn btn-outline-primary btn-saved-jobs">
        <i class="bi bi-search me-1"></i> Browse Jobs
    </a>
</div>

@if($jobs->count() > 0)
    <div class="row g-3">
        @foreach($jobs as $job)
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm h-100 job-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge cat-badge cat-{{ $job->category->slug }}">{{ $job->category->name }}</span>
                            <button class="btn btn-sm btn-link text-muted save-job-btn p-0" data-job-id="{{ $job->id }}">
                                <i class="bi bi-bookmark-fill fs-5 save-icon"></i>
                            </button>
                        </div>
                        <h5 class="fw-semibold mb-1">
                            <a href="{{ route('jobseeker.jobs.show', $job) }}" class="text-decoration-none stretched-link">{{ $job->title }}</a>
                        </h5>
                        <p class="text-muted small mb-2">
                            <i class="bi bi-building me-1"></i>{{ $job->company ?? 'N/A' }}
                        </p>
                        <div class="d-flex flex-wrap gap-2 small">
                            <span class="text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $job->location }}</span>
                            <span class="text-muted"><i class="bi bi-clock me-1"></i>{{ $job->employment_type_label }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $jobs->links() }}</div>
@else
    <div class="text-center py-5 text-muted">
        <i class="bi bi-bookmark-heart fs-1 d-block mb-2"></i>
        <h5>No Saved Jobs</h5>
        <p>Browse jobs and save the ones you're interested in</p>
        <a href="{{ route('jobseeker.jobs.index') }}" class="btn btn-primary">Browse Jobs</a>
    </div>
@endif
@endsection

@push('scripts')
<script>
document.querySelectorAll('.save-job-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const jobId = this.dataset.jobId;
        fetch('/jobseeker/jobs/' + jobId + '/toggle-save', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
        }).then(r => r.json()).then(data => {
            if (data.success && !data.saved) {
                Swal.fire({ icon: 'info', title: 'Removed', text: 'Job removed from saved', timer: 1500, showConfirmButton: false })
                    .then(() => location.reload());
            }
        });
    });
});
</script>
@endpush
