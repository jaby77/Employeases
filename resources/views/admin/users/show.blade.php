@extends('layouts.admin')

@section('title', 'User Details')

@section('breadcrumbs')
    <x-breadcrumbs :items="[
        ['label' => 'Job Seekers', 'url' => route('admin.users.index')],
        ['label' => $user->name],
    ]" />
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">User Details</h4>
        <p class="text-muted mb-0">{{ $user->name }}</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body text-center p-4">
                @php $photo = $user->profile?->profile_photo_path; @endphp
                @if($photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($photo))
                    <img src="{{ Storage::url($photo) }}" alt="" class="rounded-circle mb-3" style="width:100px;height:100px;object-fit:cover">
                @else
                    <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width:100px;height:100px;font-size:36px;font-weight:600">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                <p class="text-muted mb-2">{{ $user->email }}</p>
                <span>
                    <x-status-badge :status="$user->is_active ? 'active' : 'inactive'" :label="$user->is_active ? 'Active' : 'Inactive'" />
                </span>
                <p class="text-muted small mt-2">Member since {{ $user->created_at->format('M d, Y') }}</p>

                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="confirm-form"
                      data-confirm-title="{{ $user->is_active ? 'Deactivate this account?' : 'Activate this account?' }}"
                      data-confirm-text="{{ $user->is_active ? 'The job seeker will no longer be able to sign in.' : 'The job seeker will be able to sign in again.' }}"
                      data-confirm-ok="{{ $user->is_active ? 'Yes, deactivate' : 'Yes, activate' }}"
                      data-confirm-color="#d97706">
                    @csrf
                    <button type="submit" class="btn btn-{{ $user->is_active ? 'warning' : 'success' }} w-100 mt-3">
                        <i class="bi bi-{{ $user->is_active ? 'pause-circle' : 'play-circle' }} me-1"></i>
                        {{ $user->is_active ? 'Deactivate' : 'Activate' }} Account
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        @if($user->profile)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-3"><i class="bi bi-person-lines-fill me-2 text-primary"></i>Profile Information</h5>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <small class="text-muted d-block">Phone</small>
                            <p>{{ $user->profile->phone ?? 'N/A' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block">Gender</small>
                            <p>{{ $user->profile->gender ? ucfirst($user->profile->gender) : 'N/A' }}</p>
                        </div>
                        <div class="col-12">
                            <small class="text-muted d-block">Address</small>
                            <p>{{ $user->profile->address ?? 'N/A' }}</p>
                        </div>
                        @if($user->profile->education)
                            <div class="col-12">
                                <small class="text-muted d-block">Education</small>
                                <p>{{ $user->profile->education }}</p>
                            </div>
                        @endif
                        @if($user->profile->skills)
                            <div class="col-12">
                                <small class="text-muted d-block">Skills</small>
                                <div>
                                    @foreach($user->profile->skills_array as $skill)
                                        <span class="badge bg-primary-subtle text-primary-emphasis me-1">{{ $skill }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-semibold mb-0"><i class="bi bi-file-text me-2 text-primary"></i>Applications ({{ $user->applications->count() }})</h5>
            </div>
            <div class="card-body p-0">
                @if($user->applications->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr><th>Position</th><th>Applied</th><th>Status</th></tr>
                            </thead>
                            <tbody>
                                @foreach($user->applications as $app)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.job-vacancies.show', $app->jobVacancy) }}" class="text-decoration-none">{{ $app->jobVacancy->title }}</a>
                                        </td>
                                        <td>{{ $app->created_at->format('M d, Y') }}</td>
                                        <td><span class="badge bg-{{ $app->status_color }}">{{ $app->status_label }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <x-empty-state
                        icon="bi-file-text"
                        title="No applications yet"
                        text="This job seeker has not submitted any applications." />
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
