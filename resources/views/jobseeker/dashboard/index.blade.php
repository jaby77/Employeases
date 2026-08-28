@extends('layouts.jobseeker')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Welcome, {{ auth()->user()->name }}!</h4>
        <p class="text-muted mb-0">Your employment journey starts here</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row stats-row-mobile g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-brand-navy-deep">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-briefcase-fill fs-1 opacity-75"></i>
                <div>
                    <h3 class="fw-bold mb-0">{{ $savedJobsCount }}</h3>
                    <small>Saved Jobs</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-brand-gold">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-file-text-fill fs-1 opacity-75"></i>
                <div>
                    <h3 class="fw-bold mb-0">{{ $applicationsCount }}</h3>
                    <small>Applications</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-brand-navy">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-bell-fill fs-1 opacity-75"></i>
                <div>
                    <h3 class="fw-bold mb-0">{{ $unreadNotifications }}</h3>
                    <small>Notifications</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Application Statistics -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-semibold mb-0"><i class="bi bi-pie-chart me-2 text-primary"></i>Application Status</h5>
            </div>
            <div class="card-body">
                @if($applicationStats->count() > 0)
                    <div class="mb-3">
                        <canvas id="appStatusChart" height="200"></canvas>
                    </div>
                    <div class="mt-3">
                        @foreach($applicationStats as $stat)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-{{ (new \App\Models\Application)->fill(['status'=>$stat->status])->status_color }}">
                                    {{ ucwords(str_replace('_', ' ', $stat->status)) }}
                                </span>
                                <span class="fw-bold">{{ $stat->total }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        <p class="mb-0">No applications yet</p>
                        <a href="{{ route('jobseeker.jobs.index') }}" class="btn btn-primary btn-sm mt-2">Browse Jobs</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Applications -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-semibold mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Recent Applications</h5>
                <a href="{{ route('jobseeker.applications.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body p-0">
                @if($recentApplications->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentApplications as $app)
                            <a href="{{ route('jobseeker.applications.show', $app) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-0 fw-medium">{{ $app->jobVacancy->title }}</p>
                                    <small class="text-muted">{{ $app->created_at->diffForHumans() }}</small>
                                </div>
                                <span class="badge bg-{{ $app->status_color }}">{{ $app->status_label }}</span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <p class="mb-0">No recent applications</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Recent Jobs -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <h5 class="fw-semibold mb-0"><i class="bi bi-stars me-2 text-primary"></i>Latest Job Opportunities</h5>
        <a href="{{ route('jobseeker.jobs.index') }}" class="btn btn-sm btn-primary">Browse All</a>
    </div>
    <div class="card-body">
        @if($recentJobs->count() > 0)
            <div class="row g-3">
                @foreach($recentJobs as $job)
                    <div class="col-md-6 col-lg-4">
                        <div class="card border h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge bg-primary-subtle text-primary-emphasis">{{ $job->category->name }}</span>
                                    <small class="text-muted">{{ $job->employment_type_label }}</small>
                                </div>
                                <h6 class="card-title fw-semibold mb-1">
                                    <a href="{{ route('jobseeker.jobs.show', $job) }}" class="text-decoration-none stretched-link">{{ $job->title }}</a>
                                </h6>
                                <p class="card-text text-muted small">
                                    <i class="bi bi-geo-alt me-1"></i>{{ $job->location }}
                                    @if($job->salary_min)
                                        <br><i class="bi bi-cash me-1"></i>{{ $job->salary_formatted }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-4 text-muted">
                <p class="mb-0">No job vacancies available at the moment</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
@vite('resources/js/charts.js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('appStatusChart');
    if (ctx) {
        const labels = @json($applicationStats->pluck('status')->map(fn($s) => ucwords(str_replace('_', ' ', $s))));
        const data = @json($applicationStats->pluck('total'));
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: ['#ffc107','#E3A008','#0A2540','#6f42c1','#198754','#dc3545'],
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { padding: 10, font: { size: 11 } } } }
            }
        });
    }
});
</script>
@endpush
