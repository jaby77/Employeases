@extends('layouts.admin')

@section('title', 'Create Job Vacancy')

@section('breadcrumbs')
    <x-breadcrumbs :items="[
        ['label' => 'Job Vacancies', 'url' => route('admin.job-vacancies.index')],
        ['label' => 'Create'],
    ]" />
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Create Job Vacancy</h4>
        <p class="text-muted mb-0">Post a new job opportunity</p>
    </div>
    <a href="{{ route('admin.job-vacancies.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to List
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.job-vacancies.store') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-medium">Job Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}" placeholder="e.g., Municipal Administrative Assistant">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-medium">Category <span class="text-danger">*</span></label>
                            <select name="job_category_id" class="form-select @error('job_category_id') is-invalid @enderror">
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('job_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('job_category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-medium">Employment Type <span class="text-danger">*</span></label>
                            <select name="employment_type" class="form-select @error('employment_type') is-invalid @enderror">
                                <option value="full_time" {{ old('employment_type') == 'full_time' ? 'selected' : '' }}>Full Time</option>
                                <option value="part_time" {{ old('employment_type') == 'part_time' ? 'selected' : '' }}>Part Time</option>
                                <option value="contract" {{ old('employment_type') == 'contract' ? 'selected' : '' }}>Contractual</option>
                                <option value="temporary" {{ old('employment_type') == 'temporary' ? 'selected' : '' }}>Temporary</option>
                                <option value="seasonal" {{ old('employment_type') == 'seasonal' ? 'selected' : '' }}>Seasonal</option>
                                <option value="internship" {{ old('employment_type') == 'internship' ? 'selected' : '' }}>Internship</option>
                            </select>
                            @error('employment_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-medium">Location <span class="text-danger">*</span></label>
                            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                                   value="{{ old('location', 'Tagudin, Ilocos Sur') }}" placeholder="e.g., Poblacion, Tagudin">
                            @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-medium">Company / Department</label>
                            <input type="text" name="company" class="form-control @error('company') is-invalid @enderror"
                                   value="{{ old('company', 'Municipal Government of Tagudin') }}" placeholder="e.g., Municipal PESO">
                            @error('company') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-medium">Salary Minimum (₱)</label>
                            <input type="number" name="salary_min" class="form-control @error('salary_min') is-invalid @enderror"
                                   value="{{ old('salary_min') }}" step="0.01" min="0">
                            @error('salary_min') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-medium">Salary Maximum (₱)</label>
                            <input type="number" name="salary_max" class="form-control @error('salary_max') is-invalid @enderror"
                                   value="{{ old('salary_max') }}" step="0.01" min="0">
                            @error('salary_max') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-medium">Slots Available</label>
                            <input type="number" name="slots_available" class="form-control @error('slots_available') is-invalid @enderror"
                                   value="{{ old('slots_available', 1) }}" min="1">
                            @error('slots_available') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-medium">Application Deadline</label>
                            <input type="date" name="application_deadline" class="form-control @error('application_deadline') is-invalid @enderror"
                                   value="{{ old('application_deadline') }}">
                            @error('application_deadline') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-medium">Job Description <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                      rows="5" placeholder="Describe the job responsibilities...">{{ old('description') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-medium">Requirements</label>
                            <textarea name="requirements" class="form-control @error('requirements') is-invalid @enderror"
                                      rows="5" placeholder="List the job requirements...">{{ old('requirements') }}</textarea>
                            @error('requirements') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-medium">Benefits</label>
                            <textarea name="benefits" class="form-control @error('benefits') is-invalid @enderror"
                                      rows="3" placeholder="e.g., PhilHealth, SSS, Pag-IBIG...">{{ old('benefits') }}</textarea>
                            @error('benefits') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-lg me-1"></i> Create Vacancy
                            </button>
                            <a href="{{ route('admin.job-vacancies.index') }}" class="btn btn-outline-secondary px-4 ms-2">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-3"><i class="bi bi-info-circle me-1"></i> Tips</h6>
                <ul class="text-muted small form-tips" style="padding-left:1rem">
                    <li class="mb-2">Use clear and descriptive job titles</li>
                    <li class="mb-2">Include specific qualifications</li>
                    <li class="mb-2">Mention salary range for transparency</li>
                    <li class="mb-2">Set a reasonable application deadline</li>
                    <li class="mb-2">List complete job responsibilities</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
