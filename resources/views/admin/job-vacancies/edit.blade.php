@extends('layouts.admin')

@section('title', 'Edit Job Vacancy')

@section('breadcrumbs')
    <x-breadcrumbs :items="[
        ['label' => 'Job Vacancies', 'url' => route('admin.job-vacancies.index')],
        ['label' => 'Edit'],
    ]" />
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Edit Job Vacancy</h4>
        <p class="text-muted mb-0">Update job vacancy details</p>
    </div>
    <div>
        <a href="{{ route('admin.job-vacancies.show', $jobVacancy) }}" class="btn btn-outline-info me-2">
            <i class="bi bi-eye me-1"></i> View
        </a>
        <a href="{{ route('admin.job-vacancies.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.job-vacancies.update', $jobVacancy) }}">
            @csrf @method('PUT')

            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-medium">Job Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $jobVacancy->title) }}">
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium">Category <span class="text-danger">*</span></label>
                    <select name="job_category_id" class="form-select @error('job_category_id') is-invalid @enderror">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ (old('job_category_id', $jobVacancy->job_category_id) == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('job_category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium">Employment Type <span class="text-danger">*</span></label>
                    <select name="employment_type" class="form-select @error('employment_type') is-invalid @enderror">
                        @foreach(['full_time'=>'Full Time','part_time'=>'Part Time','contract'=>'Contractual','temporary'=>'Temporary','seasonal'=>'Seasonal','internship'=>'Internship'] as $val=>$label)
                            <option value="{{ $val }}" {{ (old('employment_type', $jobVacancy->employment_type) == $val) ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('employment_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium">Location <span class="text-danger">*</span></label>
                    <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                           value="{{ old('location', $jobVacancy->location) }}">
                    @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium">Company</label>
                    <input type="text" name="company" class="form-control @error('company') is-invalid @enderror"
                           value="{{ old('company', $jobVacancy->company) }}">
                    @error('company') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-medium">Salary Min (₱)</label>
                    <input type="number" name="salary_min" class="form-control" value="{{ old('salary_min', $jobVacancy->salary_min) }}" step="0.01" min="0">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-medium">Salary Max (₱)</label>
                    <input type="number" name="salary_max" class="form-control" value="{{ old('salary_max', $jobVacancy->salary_max) }}" step="0.01" min="0">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-medium">Slots Available</label>
                    <input type="number" name="slots_available" class="form-control" value="{{ old('slots_available', $jobVacancy->slots_available) }}" min="1">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium">Application Deadline</label>
                    <input type="date" name="application_deadline" class="form-control" value="{{ old('application_deadline', $jobVacancy->application_deadline?->format('Y-m-d')) }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-medium">Is Open?</label>
                    <div class="form-check form-switch mt-2">
                        <input type="checkbox" name="is_open" class="form-check-input" value="1" id="isOpen" {{ $jobVacancy->is_open ? 'checked' : '' }}>
                        <label class="form-check-label" for="isOpen">Accepting applications</label>
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-medium">Is Active?</label>
                    <div class="form-check form-switch mt-2">
                        <input type="checkbox" name="is_active" class="form-check-input" value="1" id="isActive" {{ $jobVacancy->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="isActive">Visible to job seekers</label>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label fw-medium">Job Description <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5">{{ old('description', $jobVacancy->description) }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-medium">Requirements</label>
                    <textarea name="requirements" class="form-control @error('requirements') is-invalid @enderror" rows="5">{{ old('requirements', $jobVacancy->requirements) }}</textarea>
                    @error('requirements') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-medium">Benefits</label>
                    <textarea name="benefits" class="form-control" rows="3">{{ old('benefits', $jobVacancy->benefits) }}</textarea>
                </div>

                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-lg me-1"></i> Update Vacancy
                    </button>
                    <a href="{{ route('admin.job-vacancies.index') }}" class="btn btn-outline-secondary px-4 ms-2">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
