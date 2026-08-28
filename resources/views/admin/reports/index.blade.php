@extends('layouts.admin')

@section('title', 'Reports')

@section('breadcrumbs')
    <x-breadcrumbs :items="[['label' => 'Reports']]" />
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Reports & Analytics</h4>
        <p class="text-muted mb-0">View employment statistics and generate reports</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.reports.export-pdf') }}" class="btn btn-danger">
            <i class="bi bi-file-pdf me-1"></i> Export PDF
        </a>
        <a href="{{ route('admin.reports.export-excel') }}" class="btn btn-success">
            <i class="bi bi-file-excel me-1"></i> Export Excel
        </a>
    </div>
</div>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-people-fill fs-1 opacity-75"></i>
                    <div>
                        <h3 class="fw-bold mb-0">{{ $totalApplicants }}</h3>
                        <small>Total Applicants</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-briefcase-fill fs-1 opacity-75"></i>
                    <div>
                        <h3 class="fw-bold mb-0">{{ $totalVacancies }}</h3>
                        <small>Total Vacancies</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-person-badge-fill fs-1 opacity-75"></i>
                    <div>
                        <h3 class="fw-bold mb-0">{{ $totalJobSeekers }}</h3>
                        <small>Registered Job Seekers</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Applications by Status -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-semibold mb-0"><i class="bi bi-pie-chart me-2 text-primary"></i>Applications by Status</h5>
            </div>
            <div class="card-body">
                <div class="skeleton-chart" aria-hidden="true"></div>
                <canvas id="statusChart" height="250"></canvas>
            </div>
        </div>
    </div>

    <!-- Monthly Applications -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-semibold mb-0"><i class="bi bi-bar-chart me-2 text-primary"></i>Monthly Applications ({{ date('Y') }})</h5>
            </div>
            <div class="card-body">
                <div class="skeleton-chart" aria-hidden="true"></div>
                <canvas id="monthlyChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Vacancies by Category -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-semibold mb-0"><i class="bi bi-bar-chart-steps me-2 text-primary"></i>Vacancies by Category</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th class="text-end">Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vacanciesByCategory as $cat)
                                <tr>
                                    <td>{{ $cat->name }}</td>
                                    <td class="text-end">{{ $cat->job_vacancies_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Breakdown -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-semibold mb-0"><i class="bi bi-list-check me-2 text-primary"></i>Application Status Breakdown</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th class="text-end">Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($applicationsByStatus as $stat)
                                <tr>
                                    <td><x-status-badge :status="$stat->status" /></td>
                                    <td class="text-end">{{ $stat->total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Applications Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 border-bottom">
        <h5 class="fw-semibold mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Recent Applications</h5>
    </div>
    <div class="card-body p-0">
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
                                    <div class="avatar bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:30px;height:30px;font-size:11px">
                                        {{ strtoupper(substr($app->user->name, 0, 1)) }}
                                    </div>
                                    <span>{{ $app->user->name }}</span>
                                </div>
                            </td>
                            <td>{{ $app->jobVacancy->title }}</td>
                            <td>{{ $app->created_at->format('M d, Y') }}</td>
                            <td><span class="badge bg-{{ $app->status_color }}">{{ $app->status_label }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@vite('resources/js/charts.js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status Chart
    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
        const statuses = @json($applicationsByStatus->pluck('status')->map(fn($s) => ucwords(str_replace('_', ' ', $s))));
        const counts = @json($applicationsByStatus->pluck('total'));
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: statuses,
                datasets: [{
                    data: counts,
                    backgroundColor: ['#ffc107','#E3A008','#0A2540','#6f42c1','#198754','#dc3545'],
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { padding: 12, usePointStyle: true } } }
            }
        });
    }

    // Monthly Chart
    const monthlyCtx = document.getElementById('monthlyChart');
    if (monthlyCtx) {
        const months = @json($monthlyApplications->pluck('month')->map(fn($m) => \Carbon\Carbon::create(null, $m)->format('M')));
        const totals = @json($monthlyApplications->pluck('total'));
        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Applications',
                    data: totals,
                    borderColor: '#0A2540',
                    backgroundColor: 'rgba(10,37,64,0.1)',
                    fill: true,
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });
    }

    // Hide chart skeletons once both charts have rendered.
    chartReady();
});
</script>
@endpush
