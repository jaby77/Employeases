@extends('layouts.jobseeker')

@section('title', 'Edit Profile')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Edit Profile</h4>
        <p class="text-muted mb-0">Update your personal information</p>
    </div>
    <a href="{{ route('jobseeker.profile.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Profile
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('jobseeker.profile.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <h5 class="fw-semibold mb-4"><i class="bi bi-person-vcard me-2 text-primary"></i>Personal Information</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-medium">Full Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium">Phone</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->profile?->phone) }}" placeholder="e.g., 09123456789">
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-medium">Birth Date</label>
                    <input type="date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror" value="{{ old('birth_date', $user->profile?->birth_date?->format('Y-m-d')) }}">
                    @error('birth_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-medium">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">Select</option>
                        <option value="male" {{ old('gender', $user->profile?->gender) == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $user->profile?->gender) == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender', $user->profile?->gender) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-medium">Postal Code</label>
                    <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $user->profile?->postal_code) }}" placeholder="e.g., 2714">
                </div>
                <div class="col-12">
                    <label class="form-label fw-medium">Address</label>
                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2">{{ old('address', $user->profile?->address) }}</textarea>
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium">City/Municipality</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city', $user->profile?->city) }}" placeholder="e.g., Tagudin">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium">Province</label>
                    <input type="text" name="province" class="form-control" value="{{ old('province', $user->profile?->province ?? 'Ilocos Sur') }}">
                </div>
            </div>

            <hr class="my-4">

            <h5 class="fw-semibold mb-4"><i class="bi bi-book me-2 text-primary"></i>Education</h5>
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <textarea name="education" class="form-control @error('education') is-invalid @enderror" rows="4" placeholder="List your educational background...">{{ old('education', $user->profile?->education) }}</textarea>
                    @error('education') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <hr class="my-4">

            <h5 class="fw-semibold mb-4"><i class="bi bi-gear me-2 text-primary"></i>Skills</h5>
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <textarea name="skills" class="form-control @error('skills') is-invalid @enderror" rows="3" placeholder="Separate skills with commas (e.g., Communication, MS Office, Customer Service)">{{ old('skills', $user->profile?->skills) }}</textarea>
                    @error('skills') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-muted">Separate each skill with a comma</small>
                </div>
            </div>

            <hr class="my-4">

            <h5 class="fw-semibold mb-4"><i class="bi bi-briefcase me-2 text-primary"></i>Work Experience</h5>
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <textarea name="work_experience" class="form-control @error('work_experience') is-invalid @enderror" rows="5" placeholder="Describe your work experience...">{{ old('work_experience', $user->profile?->work_experience) }}</textarea>
                    @error('work_experience') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <hr class="my-4">

            <h5 class="fw-semibold mb-4"><i class="bi bi-image me-2 text-primary"></i>Profile Photo & Resume</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-medium">Profile Photo</label>
                    <input type="file" name="profile_photo" class="form-control @error('profile_photo') is-invalid @enderror" accept="image/*">
                    @error('profile_photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-muted">JPEG, PNG, or GIF. Max 2MB</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium">Resume (PDF only)</label>
                    <input type="file" name="resume" class="form-control @error('resume') is-invalid @enderror" accept=".pdf">
                    @error('resume') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-muted">PDF only. Max 5MB</small>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary px-5">
                    <i class="bi bi-check-lg me-1"></i> Save Changes
                </button>
                <a href="{{ route('jobseeker.profile.index') }}" class="btn btn-outline-secondary px-4 ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
