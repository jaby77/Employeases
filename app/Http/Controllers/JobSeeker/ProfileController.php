<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('profile');
        return view('jobseeker.profile.index', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user()->load('profile');
        return view('jobseeker.profile.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();

        // Update user name
        if (isset($data['name'])) {
            $user->update(['name' => $data['name']]);
        }

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            if ($user->profile && $user->profile->profile_photo_path) {
                Storage::disk('public')->delete($user->profile->profile_photo_path);
            }
            $data['profile_photo_path'] = $request->file('profile_photo')
                ->store('profile-photos', 'public');
        }

        // Handle resume upload
        if ($request->hasFile('resume')) {
            if ($user->profile && $user->profile->resume_path) {
                Storage::disk('public')->delete($user->profile->resume_path);
            }
            $data['resume_path'] = $request->file('resume')
                ->store('resumes', 'public');
        }

        // Remove non-profile fields
        unset($data['name'], $data['profile_photo'], $data['resume']);

        // Update or create profile
        if ($user->profile) {
            $user->profile->update($data);
        } else {
            $data['user_id'] = $user->id;
            Profile::create($data);
        }

        return redirect()->route('jobseeker.profile.index')
            ->with('success', 'Profile updated successfully.');
    }

    public function uploadResume(Request $request)
    {
        $request->validate([
            'resume' => ['required', 'file', 'mimes:pdf', 'max:5120'],
        ]);

        $user = auth()->user();

        if ($user->profile && $user->profile->resume_path) {
            Storage::disk('public')->delete($user->profile->resume_path);
        }

        $path = $request->file('resume')->store('resumes', 'public');

        if ($user->profile) {
            $user->profile->update(['resume_path' => $path]);
        } else {
            Profile::create([
                'user_id' => $user->id,
                'resume_path' => $path,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Resume uploaded successfully.',
        ]);
    }

    public function downloadResume()
    {
        $user = auth()->user()->load('profile');
        $resumePath = $user->profile?->resume_path;

        if (!$resumePath || !Storage::disk('public')->exists($resumePath)) {
            return redirect()->back()->with('error', 'No resume found.');
        }

        return Storage::disk('public')->download($resumePath, 'resume_' . str_replace(' ', '_', $user->name) . '.pdf');
    }

    public function removeProfilePhoto()
    {
        $user = auth()->user()->load('profile');

        if ($user->profile && $user->profile->profile_photo_path) {
            Storage::disk('public')->delete($user->profile->profile_photo_path);
            $user->profile->update(['profile_photo_path' => null]);
        }

        return redirect()->back()->with('success', 'Profile photo removed.');
    }
}
