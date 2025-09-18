<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\TeacherProfile;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherProfileController extends Controller
{
    public function store(Request $request)
    {
        abort_if(auth()->guard('web')->user()->teacherProfile, 403, 'Profil sudah ada, gunakan update.');

        $data = $request->validate([
            'whatsapp_number'  => ['nullable', 'string', 'max:30'],
            'bio'              => ['nullable', 'string', 'max:5000'],
            'location' => ['nullable', 'string'],
            'profile_image'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $data['user_id'] = auth()->guard('web')->id();

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $data['profile_image_path'] = $path;
        }
        unset($data['profile_image']);

        $profile = TeacherProfile::create($data);

        if (!auth()->guard('web')->user()->activePlan) {
            $free = Plan::where('name', 'Bronze')->first();
            if ($free) {
                UserPlan::create([
                    'user_id' => auth()->id(),
                    'plan_id' => $free->id,
                    'start_date' => now(),
                    'end_date' => now()->addDays($free->duration_days),
                    'status' => 'active',
                ]);
            }
        }

        return redirect()->route('teacher.dashboard')
            ->with('success', 'Profil guru berhasil dibuat.');
    }

    public function edit()
    {
        return view('teacher/form', ['profile' => auth()->guard('web')->user()->teacherProfile]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $profile = auth()->guard('web')->user()->teacherProfile;
        abort_unless($profile, 404);


        $data = $request->validate([
            'whatsapp_number'  => ['nullable', 'string', 'max:30'],
            'bio'              => ['nullable', 'string', 'max:5000'],
            'profile_image'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        if ($request->hasFile('profile_image')) {
            if ($profile->profile_image_path) {
                Storage::disk('public')->delete($profile->profile_image_path);
            }
            $path = $request->file('profile_image')->store('profiles', 'public');
            $data['profile_image_path'] = $path;
        }
        unset($data['profile_image']);
        $profile->update($data);

        return redirect()->route('teacher.dashboard')
            ->with('success', 'Profil guru diperbarui.');
    }
}
