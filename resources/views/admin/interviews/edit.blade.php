@extends('layouts.admin')

@section('title', 'Reschedule Interview')

@section('breadcrumbs')
    <x-breadcrumbs :items="[
        ['label' => 'Interviews', 'url' => route('admin.interviews.index')],
        ['label' => 'Reschedule'],
    ]" />
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">Reschedule Interview</h4>
        <p class="text-muted mb-0">{{ $interview->application->user->name }} &mdash; {{ $interview->application->jobVacancy->title }}</p>
    </div>
    <a href="{{ route('admin.interviews.show', $interview) }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.interviews.update', $interview) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-medium">Interview Date & Time <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="scheduled_at" class="form-control @error('scheduled_at') is-invalid @enderror"
                           value="{{ old('scheduled_at', $interview->scheduled_at->format('Y-m-d\TH:i')) }}"
                           min="{{ now()->format('Y-m-d\TH:i') }}">
                    @error('scheduled_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium">Interview Type <span class="text-danger">*</span></label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror">
                        <option value="in_person" {{ old('type', $interview->type) == 'in_person' ? 'selected' : '' }}>In Person</option>
                        <option value="online" {{ old('type', $interview->type) == 'online' ? 'selected' : '' }}>Online</option>
                        <option value="phone" {{ old('type', $interview->type) == 'phone' ? 'selected' : '' }}>Phone Call</option>
                    </select>
                    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-medium">Location / Meeting Link</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location', $interview->location) }}">
                </div>
                <div class="col-12">
                    <label class="form-label fw-medium">Notes</label>
                    <textarea name="notes" class="form-control" rows="4">{{ old('notes', $interview->notes) }}</textarea>
                </div>
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-calendar-check me-1"></i> Update Interview
                    </button>
                    <a href="{{ route('admin.interviews.show', $interview) }}" class="btn btn-outline-secondary px-4 ms-2">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
