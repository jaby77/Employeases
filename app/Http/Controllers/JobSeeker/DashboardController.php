<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $savedJobsCount = $user->savedJobs()->count();
        $applicationsCount = $user->applications()->count();

        $applicationStats = Application::where('user_id', $user->id)
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        $recentJobs = JobVacancy::with('category')
            ->available()
            ->latest()
            ->take(6)
            ->get();

        $recentApplications = $user->applications()
            ->with('jobVacancy')
            ->latest()
            ->take(5)
            ->get();

        $unreadNotifications = $user->unreadNotifications()->count();

        return view('jobseeker.dashboard.index', compact(
            'savedJobsCount',
            'applicationsCount',
            'applicationStats',
            'recentJobs',
            'recentApplications',
            'unreadNotifications'
        ));
    }
}
