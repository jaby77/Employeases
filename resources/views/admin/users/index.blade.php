@extends('layouts.admin')

@section('title', 'Manage Job Seekers')

@section('breadcrumbs')
    <x-breadcrumbs :items="[['label' => 'Job Seekers']]" />
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Job Seekers</h4>
        <p class="text-muted mb-0">Manage registered job seeker accounts</p>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel"></i> Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Joined</th>
                            <th>Applications</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:35px;height:35px;font-size:13px">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span class="fw-medium">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td>{{ $user->applications()->count() }}</td>
                                <td>
                                    <x-status-badge :status="$user->is_active ? 'active' : 'inactive'" :label="$user->is_active ? 'Active' : 'Inactive'" />
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="d-inline confirm-form"
                                              data-confirm-title="{{ $user->is_active ? 'Deactivate this account?' : 'Activate this account?' }}"
                                              data-confirm-text="{{ $user->is_active ? 'The job seeker will no longer be able to sign in.' : 'The job seeker will be able to sign in again.' }}"
                                              data-confirm-ok="{{ $user->is_active ? 'Yes, deactivate' : 'Yes, activate' }}"
                                              data-confirm-color="#d97706">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-{{ $user->is_active ? 'warning' : 'success' }}"
                                                    title="{{ $user->is_active ? 'Deactivate' : 'Activate' }}">
                                                <i class="bi bi-{{ $user->is_active ? 'pause-circle' : 'play-circle' }}"></i>
                                            </button>
                                        </form>
                                        @if(!$user->isAdmin())
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline delete-form">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-3 border-top">
                {{ $users->links() }}
            </div>
        @else
            <x-empty-state
                icon="bi-people"
                title="No job seekers found"
                text="Try adjusting your search or filters, or check back once new users register." />
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Delete User?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then(result => { if (result.isConfirmed) form.submit(); });
    });
});
</script>
@endpush
