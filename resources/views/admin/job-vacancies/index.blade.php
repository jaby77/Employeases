@extends('layouts.admin')

@section('title', 'Job Vacancies')

@section('breadcrumbs')
    <x-breadcrumbs :items="[['label' => 'Job Vacancies']]" />
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Job Vacancies</h4>
        <p class="text-muted mb-0">Manage all job vacancy postings</p>
    </div>
    <a href="{{ route('admin.job-vacancies.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Create New
    </a>
</div>

<!-- Filters -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.job-vacancies.index') }}" class="row g-2">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search vacancies..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="employment_type" class="form-select">
                    <option value="">All Types</option>
                    <option value="full_time" {{ request('employment_type') == 'full_time' ? 'selected' : '' }}>Full Time</option>
                    <option value="part_time" {{ request('employment_type') == 'part_time' ? 'selected' : '' }}>Part Time</option>
                    <option value="contract" {{ request('employment_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                    <option value="temporary" {{ request('employment_type') == 'temporary' ? 'selected' : '' }}>Temporary</option>
                </select>
            </div>
            <div class="col-md-1">
                <select name="status" class="form-select">
                    <option value="">All</option>
                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel"></i> Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Vacancies List -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @if($vacancies->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th>Salary</th>
                            <th>Applicants</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vacancies as $vacancy)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.job-vacancies.show', $vacancy) }}" class="text-decoration-none fw-medium">
                                        {{ $vacancy->title }}
                                    </a>
                                </td>
                                <td><span class="badge bg-light text-dark">{{ $vacancy->category?->name ?? 'N/A' }}</span></td>
                                <td><span class="badge bg-primary-subtle text-primary-emphasis">{{ $vacancy->employment_type_label }}</span></td>
                                <td><i class="bi bi-geo-alt me-1"></i>{{ $vacancy->location }}</td>
                                <td class="small">{{ $vacancy->salary_formatted }}</td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill">
                                        {{ $vacancy->applicants_count }}
                                    </span>
                                </td>
                                <td class="small">
                                    @if($vacancy->application_deadline)
                                        {{ $vacancy->application_deadline->format('M d, Y') }}
                                    @else
                                        <span class="text-muted">No deadline</span>
                                    @endif
                                </td>
                                <td>
                                    @if($vacancy->is_open && $vacancy->is_active)
                                        <x-status-badge status="open" label="Active" />
                                    @elseif(!$vacancy->is_open)
                                        <x-status-badge status="closed" label="Closed" />
                                    @else
                                        <x-status-badge status="inactive" label="Inactive" />
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.job-vacancies.edit', $vacancy) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.job-vacancies.toggle-status', $vacancy) }}" method="POST" class="d-inline confirm-form"
                                              data-confirm-title="{{ $vacancy->is_open ? 'Close this vacancy?' : 'Reopen this vacancy?' }}"
                                              data-confirm-text="{{ $vacancy->is_open ? 'Applicants will no longer be able to apply for this position.' : 'This vacancy will be reopened for applications.' }}"
                                              data-confirm-ok="{{ $vacancy->is_open ? 'Yes, close it' : 'Yes, reopen it' }}"
                                              data-confirm-color="#d97706">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-{{ $vacancy->is_open ? 'danger' : 'success' }}"
                                                    title="{{ $vacancy->is_open ? 'Close' : 'Open' }}">
                                                <i class="bi bi-{{ $vacancy->is_open ? 'lock' : 'unlock' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.job-vacancies.destroy', $vacancy) }}" method="POST" class="d-inline delete-form">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($vacancies->hasPages())
                <div class="p-3 border-top">
                    {{ $vacancies->links() }}
                </div>
            @endif
        @else
            <x-empty-state
                icon="bi-briefcase"
                title="No job vacancies yet"
                text="Post your first vacancy to start receiving applications from local job seekers."
                :action-url="route('admin.job-vacancies.create')"
                action-label="Create First Vacancy" />
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Delete Vacancy?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then(result => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
});
</script>
@endpush
