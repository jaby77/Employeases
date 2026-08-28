@extends('layouts.jobseeker')

@section('title', 'My Applications')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">My Applications</h4>
        <p class="text-muted mb-0">Track your job applications</p>
    </div>
</div>

<!-- Status Filter -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    @foreach(['pending','under_review','shortlisted','interview_scheduled','accepted','rejected'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucwords(str_replace('_', ' ', $s)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel me-1"></i> Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Applications -->
@if($applications->count() > 0)
    <div class="row g-3">
        @foreach($applications as $app)
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="app-card-mobile">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-6">
                                    <h5 class="fw-semibold mb-1">
                                        <a href="{{ route('jobseeker.applications.show', $app) }}" class="text-decoration-none">{{ $app->jobVacancy->title }}</a>
                                    </h5>
                                    <p class="text-muted small mb-0">
                                        <i class="bi bi-building me-1"></i>{{ $app->jobVacancy->company ?? 'N/A' }}
                                        &middot; <i class="bi bi-geo-alt me-1"></i>{{ $app->jobVacancy->location }}
                                    </p>
                                </div>
                                <div class="col-6 col-md-3">
                                    <small class="text-muted d-block">Applied</small>
                                    <span class="small">{{ $app->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="col-6 col-md-2 text-end text-md-start">
                                    <span class="badge bg-{{ $app->status_color }} fs-6 p-2">{{ $app->status_label }}</span>
                                </div>
                                <div class="col-12 col-md-1 text-end mt-2 mt-md-0">
                                    <a href="{{ route('jobseeker.applications.show', $app) }}" class="btn btn-sm btn-outline-primary w-100 w-md-auto">
                                        <i class="bi bi-eye me-1"></i><span class="d-md-none">View</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @if($app->interview)
                            <div class="mt-2 pt-2 border-top">
                                <small class="text-muted">
                                    <i class="bi bi-calendar-event me-1"></i>
                                    Interview: {{ $app->interview->scheduled_at->format('M d, Y h:i A') }}
                                </small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $applications->links() }}</div>
@else
    <div class="text-center py-5 text-muted">
        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
        <h5>No Applications Yet</h5>
        <p>Start by browsing available job opportunities</p>
        <a href="{{ route('jobseeker.jobs.index') }}" class="btn btn-primary">Browse Jobs</a>
    </div>
@endif
@endsection
