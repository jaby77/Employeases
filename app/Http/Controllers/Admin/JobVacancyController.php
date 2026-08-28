<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobVacancyRequest;
use App\Http\Requests\UpdateJobVacancyRequest;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class JobVacancyController extends Controller
{
    public function index(Request $request)
    {
        $query = JobVacancy::with(['category', 'user'])->latest();

        if ($request->filled('search')) {
            $query->search($request->search);
        }
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }
        if ($request->filled('employment_type')) {
            $query->byEmploymentType($request->employment_type);
        }
        if ($request->filled('status')) {
            if ($request->status === 'open') {
                $query->where('is_open', true);
            } elseif ($request->status === 'closed') {
                $query->where('is_open', false);
            }
        }

        $vacancies = $query->paginate(10)->withQueryString();
        $categories = JobCategory::where('is_active', true)->get();

        return view('admin.job-vacancies.index', compact('vacancies', 'categories'));
    }

    public function create()
    {
        $categories = JobCategory::where('is_active', true)->get();
        return view('admin.job-vacancies.create', compact('categories'));
    }

    public function store(StoreJobVacancyRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['slug'] = Str::slug($data['title']) . '-' . uniqid();

        JobVacancy::create($data);

        return redirect()->route('admin.job-vacancies.index')
            ->with('success', 'Job vacancy created successfully.');
    }

    public function show(JobVacancy $jobVacancy)
    {
        $jobVacancy->load(['category', 'user', 'applications.user.profile']);
        return view('admin.job-vacancies.show', compact('jobVacancy'));
    }

    public function edit(JobVacancy $jobVacancy)
    {
        $categories = JobCategory::where('is_active', true)->get();
        return view('admin.job-vacancies.edit', compact('jobVacancy', 'categories'));
    }

    public function update(UpdateJobVacancyRequest $request, JobVacancy $jobVacancy)
    {
        $jobVacancy->update($request->validated());

        return redirect()->route('admin.job-vacancies.index')
            ->with('success', 'Job vacancy updated successfully.');
    }

    public function destroy(JobVacancy $jobVacancy)
    {
        $jobVacancy->delete();

        return redirect()->route('admin.job-vacancies.index')
            ->with('success', 'Job vacancy deleted successfully.');
    }

    public function toggleStatus(JobVacancy $jobVacancy)
    {
        $jobVacancy->update(['is_open' => !$jobVacancy->is_open]);

        $status = $jobVacancy->is_open ? 'opened' : 'closed';
        return redirect()->route('admin.job-vacancies.index')
            ->with('success', "Job vacancy {$status} successfully.");
    }

    public function toggleActive(JobVacancy $jobVacancy)
    {
        $jobVacancy->update(['is_active' => !$jobVacancy->is_active]);

        $status = $jobVacancy->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.job-vacancies.index')
            ->with('success', "Job vacancy {$status} successfully.");
    }
}
