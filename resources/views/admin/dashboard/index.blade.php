@extends('layouts.admin')

@section('title', 'Dashboard')

@section('breadcrumbs')
    <x-breadcrumbs :items="[['label' => 'Dashboard']]" />
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Dashboard</h4>
        <p class="text-muted mb-0">Welcome back, {{ auth()->user()->name }}!</p>
    </div>
    <div>
        <span class="badge bg-light text-dark p-2">
            <i class="bi bi-calendar3 me-1"></i> {{ now()->format('F d, Y') }}
        </span>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1 small">Total Vacancies</p>
                        <h3 class="fw-bold mb-0">{{ $totalVacancies }}</h3>
                    </div>
                    <div class="stat-icon bg-primary-subtle text-primary rounded-3 p-2">
                        <i class="bi bi-briefcase fs-4"></i>
                    </div>
                </div>
                <small class="text-muted">All posted job vacancies</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1 small">Total Applicants</p>
                        <h3 class="fw-bold mb-0">{{ $totalApplicants }}</h3>
                    </div>
                    <div class="stat-icon bg-primary-subtle text-primary rounded-3 p-2">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                </div>
                <small class="text-muted">All submitted applications</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1 small">Active Jobs</p>
                        <h3 class="fw-bold mb-0 text-success">{{ $activeJobs }}</h3>
                    </div>
                    <div class="stat-icon bg-success-subtle text-success rounded-3 p-2">
                        <i class="bi bi-check-circle fs-4"></i>
                    </div>
                </div>
                <small class="text-muted">Currently accepting applicants</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1 small">Closed Jobs</p>
                        <h3 class="fw-bold mb-0 text-danger">{{ $closedJobs }}</h3>
                    </div>
                    <div class="stat-icon bg-danger-subtle text-danger rounded-3 p-2">
                        <i class="bi bi-x-circle fs-4"></i>
                    </div>
                </div>
                <small class="text-muted">No longer accepting applicants</small>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Stats -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm bg-brand-navy-deep">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-people-fill fs-1 opacity-75"></i>
                    <div>
                        <h3 class="fw-bold mb-0">{{ $totalJobSeekers }}</h3>
                        <small>Registered Job Seekers</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm bg-brand-gold">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-clock-fill fs-1 opacity-75"></i>
                    <div>
                        <h3 class="fw-bold mb-0">{{ $pendingApplications }}</h3>
                        <small>Pending Applications</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm bg-brand-teal">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-calendar-check-fill fs-1 opacity-75"></i>
                    <div>
                        <h3 class="fw-bold mb-0">{{ $interviewsScheduled }}</h3>
                        <small>Upcoming Interviews</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm bg-brand-navy">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-bar-chart-fill fs-1 opacity-75"></i>
                    <div>
                        <h3 class="fw-bold mb-0">{{ $totalApplicants > 0 ? round(($totalApplicants / max($totalVacancies, 1)) * 100) : 0 }}%</h3>
                        <small>Application Rate</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row g-3 mb-4">
    <div class="col-xl-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="card-title mb-0 fw-semibold">
                    <i class="bi bi-bar-chart-line me-2 text-primary"></i>Applications per Month ({{ date('Y') }})
                </h5>
            </div>
            <div class="card-body">
                <div class="skeleton-chart" aria-hidden="true"></div>
                <canvas id="applicationsChart" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="card-title mb-0 fw-semibold">
                    <i class="bi bi-pie-chart me-2 text-primary"></i>Jobs by Category
                </h5>
            </div>
            <div class="card-body">
                <div class="skeleton-chart" aria-hidden="true"></div>
                <canvas id="categoryChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Applications -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-semibold">
                    <i class="bi bi-clock-history me-2 text-primary"></i>Recent Applications
                </h5>
                <a href="{{ route('admin.applicants.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body p-0">
                @if($recentApplications->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Applicant</th>
                                    <th>Position</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentApplications as $app)
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
                                        <td>{{ $app->jobVacancy->title }}</td>
                                        <td>{{ $app->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <x-status-badge :status="$app->status" :label="$app->status_label" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <x-empty-state
                        icon="bi-inbox"
                        title="No applications yet"
                        text="Applications submitted by job seekers will appear here." />
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@vite('resources/js/charts.js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Applications per Month Chart
    const appCtx = document.getElementById('applicationsChart');
    if (appCtx) {
        const months = @json($applicationsPerMonth->pluck('month'));
        const totals = @json($applicationsPerMonth->pluck('total'));

        new Chart(appCtx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Applications',
                    data: totals,
                    backgroundColor: 'rgba(10, 37, 64, 0.7)',
                    borderColor: 'rgba(10, 37, 64, 1)',
                    borderWidth: 2,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    }

    // Jobs by Category Chart
    const catCtx = document.getElementById('categoryChart');
    if (catCtx) {
        const categories = @json($jobsByCategory->pluck('label'));
        const counts = @json($jobsByCategory->pluck('count'));

        new Chart(catCtx, {
            type: 'doughnut',
            data: {
                labels: categories,
                datasets: [{
                    data: counts,
                    backgroundColor: [
                        '#0A2540', '#E3A008', '#334155', '#C99700',
                        '#475569', '#F0D494', '#0F766E', '#A16207'
                    ],
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 12, usePointStyle: true }
                    }
                }
            }
        });
    }

    // Hide chart skeletons once both charts have rendered.
    chartReady();
});
</script>
@endpush
