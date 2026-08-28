@extends('layouts.admin')

@section('title', 'Applicants')

@section('breadcrumbs')
    <x-breadcrumbs :items="[['label' => 'Applicants']]" />
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Applicants</h4>
        <p class="text-muted mb-0">Manage job applicants and applications</p>
    </div>
</div>

<!-- Filters -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.applicants.index') }}" class="row g-2">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    @foreach(['pending','under_review','shortlisted','interview_scheduled','accepted','rejected'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucwords(str_replace('_', ' ', $s)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="job_vacancy_id" class="form-select">
                    <option value="">All Jobs</option>
                    @foreach($vacancies as $v)
                        <option value="{{ $v->id }}" {{ request('job_vacancy_id') == $v->id ? 'selected' : '' }}>{{ $v->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel"></i> Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Applications List -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @if($applications->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Applicant</th>
                            <th>Position</th>
                            <th>Applied Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $app)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:35px;height:35px;font-size:13px">
                                            {{ strtoupper(substr($app->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="mb-0 fw-medium">{{ $app->user->name }}</p>
                                            <small class="text-muted">{{ $app->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.job-vacancies.show', $app->jobVacancy) }}" class="text-decoration-none">{{ $app->jobVacancy->title }}</a>
                                </td>
                                <td>{{ $app->created_at->format('M d, Y h:i A') }}</td>
                                <td>
                                    <x-status-badge :status="$app->status" :label="$app->status_label" />
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.applicants.show', $app) }}" class="btn btn-sm btn-outline-primary" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if($app->resume_path || $app->user->profile?->resume_path)
                                            <a href="{{ route('admin.applicants.download-resume', $app) }}" class="btn btn-sm btn-outline-info" title="Download Resume">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($applications->hasPages())
                <div class="p-3 border-top">
                    {{ $applications->links() }}
                </div>
            @endif
        @else
            <x-empty-state
                icon="bi-inbox"
                title="No applicants found"
                text="Try adjusting your search or filters, or check back once job seekers start applying." />
        @endif
    </div>
</div>
@endsection
