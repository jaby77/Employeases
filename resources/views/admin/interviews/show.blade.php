@extends('layouts.admin')

@section('title', 'Interview Details')

@section('breadcrumbs')
    <x-breadcrumbs :items="[
        ['label' => 'Interviews', 'url' => route('admin.interviews.index')],
        ['label' => $interview->application->user->name],
    ]" />
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Interview Details</h4>
        <p class="text-muted mb-0">
            {{ $interview->application->user->name }} &mdash; {{ $interview->application->jobVacancy->title }}
        </p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.interviews.edit', $interview) }}" class="btn btn-warning">
            <i class="bi bi-calendar2 me-1"></i> Reschedule
        </a>
        <a href="{{ route('admin.interviews.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-sm-6">
                        <small class="text-muted d-block">Scheduled Date & Time</small>
                        <h5 class="fw-semibold">{{ $interview->scheduled_at->format('F d, Y') }}</h5>
                        <p class="text-primary fw-medium">{{ $interview->scheduled_at->format('h:i A') }}</p>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block">Status</small>
                        <h5 class="pt-1"><x-status-badge :status="$interview->status" :label="$interview->status_label" /></h5>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block">Type</small>
                        <p class="fw-medium">{{ $interview->type_label }}</p>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block">Location / Link</small>
                        <p class="fw-medium">{{ $interview->location }}</p>
                    </div>
                    @if($interview->notes)
                        <div class="col-12">
                            <small class="text-muted d-block">Notes</small>
                            <p>{{ $interview->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-3">Update Status</h6>
                <form id="interviewStatusForm">
                    @csrf
                    <select name="status" class="form-select mb-2">
                        <option value="scheduled" {{ $interview->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="completed" {{ $interview->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $interview->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="rescheduled" {{ $interview->status == 'rescheduled' ? 'selected' : '' }}>Rescheduled</option>
                    </select>
                    <textarea name="notes" class="form-control mb-2" rows="2" placeholder="Update notes...">{{ $interview->notes }}</textarea>
                    <button type="submit" class="btn btn-primary w-100">Update</button>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-3">Applicant Info</h6>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:35px;height:35px;font-size:13px">
                        {{ strtoupper(substr($interview->application->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="mb-0 fw-medium">{{ $interview->application->user->name }}</p>
                        <small class="text-muted">{{ $interview->application->user->email }}</small>
                    </div>
                </div>
                <a href="{{ route('admin.applicants.show', $interview->application) }}" class="btn btn-sm btn-outline-primary w-100 mt-2">
                    <i class="bi bi-eye me-1"></i> View Full Application
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('interviewStatusForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    Swal.fire({
        title: 'Update Interview Status?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#A16207',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, update!'
    }).then(result => {
        if (result.isConfirmed) {
            fetch('{{ route("admin.interviews.update-status", $interview) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            }).then(r => r.json()).then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    setTimeout(() => location.reload(), 600);
                } else {
                    showToast(data.message || 'Could not update the interview status.', 'error');
                }
            })
            .catch(() => showToast('Connection error. Could not update the interview status.', 'error'));
        }
    });
});
</script>
@endpush
