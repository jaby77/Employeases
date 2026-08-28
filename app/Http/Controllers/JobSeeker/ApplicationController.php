<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApplicationRequest;
use App\Models\Application;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->applications()->with('jobVacancy.category');

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        $applications = $query->latest()->paginate(10)->withQueryString();

        return view('jobseeker.applications.index', compact('applications'));
    }

    public function create(JobVacancy $jobVacancy)
    {
        if (!$jobVacancy->is_active || !$jobVacancy->is_open) {
            return redirect()->route('jobseeker.jobs.index')
                ->with('error', 'This job vacancy is no longer accepting applications.');
        }

        $hasApplied = auth()->user()->applications()
            ->where('job_vacancy_id', $jobVacancy->id)
            ->exists();

        if ($hasApplied) {
            return redirect()->route('jobseeker.jobs.show', $jobVacancy)
                ->with('error', 'You have already applied for this position.');
        }

        $jobVacancy->load('category');
        $user = auth()->user()->load('profile');

        return view('jobseeker.applications.create', compact('jobVacancy', 'user'));
    }

    public function store(StoreApplicationRequest $request, JobVacancy $jobVacancy)
    {
        if (!$jobVacancy->is_active || !$jobVacancy->is_open) {
            return redirect()->route('jobseeker.jobs.index')
                ->with('error', 'This job vacancy is no longer accepting applications.');
        }

        $hasApplied = auth()->user()->applications()
            ->where('job_vacancy_id', $jobVacancy->id)
            ->exists();

        if ($hasApplied) {
            return redirect()->route('jobseeker.jobs.show', $jobVacancy)
                ->with('error', 'You have already applied for this position.');
        }

        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['job_vacancy_id'] = $jobVacancy->id;

        if ($request->hasFile('resume')) {
            $data['resume_path'] = $request->file('resume')->store('application-resumes', 'public');
        }

        $application = Application::create($data);

        // Create notification
        auth()->user()->notifications()->create([
            'type' => 'application_submitted',
            'title' => 'Application Submitted',
            'message' => "Your application for \"{$jobVacancy->title}\" has been submitted successfully.",
            'icon' => 'bi-check-circle-fill',
            'color' => 'success',
            'action_url' => route('jobseeker.applications.show', $application),
        ]);

        return redirect()->route('jobseeker.applications.show', $application)
            ->with('success', 'Application submitted successfully!');
    }

    public function show(Application $application)
    {
        if ($application->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $application->load(['jobVacancy.category', 'interview']);
        return view('jobseeker.applications.show', compact('application'));
    }
}
