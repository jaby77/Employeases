<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleInterviewRequest;
use App\Models\Application;
use App\Models\Interview;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Interview::with(['application.user', 'application.jobVacancy'])->latest('scheduled_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $interviews = $query->paginate(15)->withQueryString();

        return view('admin.interviews.index', compact('interviews'));
    }

    public function create(Application $application)
    {
        $application->load(['user', 'jobVacancy']);
        return view('admin.interviews.create', compact('application'));
    }

    public function store(ScheduleInterviewRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $interview = Interview::create($data);

        // Update application status to interview_scheduled
        $application = Application::findOrFail($data['application_id']);
        $application->update([
            'status' => 'interview_scheduled',
            'reviewed_at' => now(),
        ]);

        // Notify the job seeker
        $application->user->notifications()->create([
            'type' => 'interview_scheduled',
            'title' => 'Interview Scheduled',
            'message' => "An interview has been scheduled for \"{$application->jobVacancy->title}\" on " . $interview->scheduled_at->format('F d, Y h:i A'),
            'icon' => 'bi-calendar-event-fill',
            'color' => 'success',
            'action_url' => route('jobseeker.applications.show', $application),
        ]);

        return redirect()->route('admin.interviews.index')
            ->with('success', 'Interview scheduled successfully.');
    }

    public function show(Interview $interview)
    {
        $interview->load(['application.user.profile', 'application.jobVacancy']);
        return view('admin.interviews.show', compact('interview'));
    }

    public function edit(Interview $interview)
    {
        $interview->load(['application.user', 'application.jobVacancy']);
        return view('admin.interviews.edit', compact('interview'));
    }

    public function update(ScheduleInterviewRequest $request, Interview $interview)
    {
        $interview->update($request->validated());

        return redirect()->route('admin.interviews.index')
            ->with('success', 'Interview updated successfully.');
    }

    public function updateStatus(Request $request, Interview $interview)
    {
        $request->validate([
            'status' => ['required', 'in:scheduled,completed,cancelled,rescheduled'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $interview->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Interview status updated successfully.',
        ]);
    }

    public function destroy(Interview $interview)
    {
        $interview->delete();

        return redirect()->route('admin.interviews.index')
            ->with('success', 'Interview deleted successfully.');
    }
}
