<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Http\Requests\CreateActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * UserActivities service class.
 */
class UserActivitiesService
{
    /**
     * Show the activity
     *
     * @param string $userId
     * @param string $id
     * @return View
     */
    public function show(string $userId, string $id): View
    {
        $user = User::findOrFail($userId);
        $activity = $user->userActivities()->find($id);

        if (!$activity) {
            $activity = Activity::findOrFail($id);
        }

        return view('admin.users.activities.show', compact('activity'));
    }

    /**
     * Store an activity for the particular user
     *
     * @param string $id
     * @param CreateActivityRequest $request
     * @return RedirectResponse
     */
    public function store(string $id, CreateActivityRequest $request): RedirectResponse
    {
        $user = User::findOrFail($id);
//        $activityCount = $user->userActivities()
//            ->where('date', $request->date)
//            ->count();
//
//        // Check activities count for this user
//        if ($activityCount === 4) {
//            return redirect()->route('activities.create')
//                ->with('error', 'You cannot create more than 4 activities for this day.');
//        }

        $validatedData = [
            'user_id' => $id,
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
        ];

        $imageName = $this->storeImage($request->file('image'));
        $validatedData['image'] = 'users/' . $imageName;

        UserActivity::create($validatedData);

        // Retrieve user-specific activities
        $userSpecificActivities = $user->userActivities()->get();

        // Retrieve global activities
        $globalActivities = Activity::whereDoesntHave('users', function ($query) use ($id) {
            $query->where('user_id', $id);
        })->get();

        // Merge global and user-specific activities
        $allActivities = $userSpecificActivities->merge($globalActivities);

        return redirect()->route('users.show', ['id' => $id, 'user' => $user, 'allActivities' => $allActivities])->with('success', 'Activity created successfully.');
    }

    /**
     * Edit the activity
     *
     * @param string $userId
     * @param string $id
     * @return View
     */
    public function edit(string $userId, string $id): View
    {
        $user = User::findOrFail($userId);

        // Retrieve the global activity
        $globalActivity = Activity::find($id);

        $userActivity = $user->userActivities();

        if ($globalActivity) {
            // Check if the user already has an override for this activity
            $userActivity = $userActivity->where('activity_id', $id)->first();
        } else {
            $userActivity = $userActivity->where('id', $id)->first();
        }

        $activity = $userActivity ?? $globalActivity;

        return view('admin.users.activities.edit', compact('userId', 'activity'));
    }

    /**
     * Update the activity.
     *
     * @param string $userId
     * @param string $id
     * @param UpdateActivityRequest $request
     * @return RedirectResponse
     */
    public function update(string $userId, string $id, UpdateActivityRequest $request): RedirectResponse
    {
//        User::findOrFail($userId);
//
//        // Check if global activity exists
//        $globalActivity = Activity::find($id);
//
//        // If $id represents a global activity
//        $userActivity = UserActivity::where('user_id', $userId)
//            ->where('activity_id', $id)
//            ->first();
//
//        // Check if global and specific activities are exists, update that specific one
//        if ($globalActivity && $userActivity) {
//            // Check if a new image is uploaded, if not, retain the existing image
//            if ($request->hasFile('image')) {
//                $image = $request->file('image');
//                $imageName = time() . '_' . $image->getClientOriginalName();
//
//                // Store the image in the storage directory
//                $image->storeAs('public/images/users', $imageName);
//                $activityImage = 'users/' . $imageName;
//            } else {
//                $activityImage = $request->old_image;
//            }
//
//            // Update existing user-specific activity fields as needed
//            $userActivity->title = $request->title;
//            $userActivity->description = $request->description;
//            $userActivity->date = $request->date;
//            $userActivity->image = $activityImage;
//
//            $userActivity->save();
//
//            return redirect()->back()->with('success', 'Activity updated successfully.');
//        }
//
//        // If $id represents a global activity, create a new user-specific activity for the user
//        if ($globalActivity) {
//            // Create a new user-specific activity linked to the global activity
//            $newUserActivity = new UserActivity([
//                'user_id' => $userId,
//                'activity_id' => $id,
//                'title' => $request->title,
//                'description' => $request->description,
//                'date' => $request->date,
//            ]);
//
//            // Check if a new image is uploaded, if not, retain the existing image
//            if ($request->hasFile('image')) {
//                $image = $request->file('image');
//                $imageName = time() . '_' . $image->getClientOriginalName();
//
//                // Store the image in the storage directory
//                $image->storeAs('public/images/users', $imageName);
//                $activityImage = $imageName;
//            } else {
//                // If no new image, retain the old image
//                Storage::copy('public/images/' . $request->old_image, 'public/images/users/' . $request->old_image);
//                $activityImage = $request->old_image;
//            }
//
//            $newUserActivity->image = 'users/' . $activityImage;
//            $newUserActivity->save();
//
//            return redirect()->back()->with('success', 'Activity updated successfully.');
//        }
//
//        $userActivity = UserActivity::where('user_id', $userId)
//            ->where('id', $id)
//            ->first();
//
//        // If $id represents a user-specific activity, and it's not linked with global one
//        if ($userActivity) {
//            $userActivity->title = $request->title;
//            $userActivity->description = $request->description;
//            $userActivity->date = $request->date;
//
//            // Check if a new image is uploaded, if not, retain the existing image
//            if ($request->hasFile('image')) {
//                $image = $request->file('image');
//                $imageName = time() . '_' . $image->getClientOriginalName();
//                $image->storeAs('public/images/users', $imageName);
//                $activityImage = 'users/' . $imageName;
//            } else {
//                $activityImage = $request->old_image;
//            }
//
//            $userActivity->image = $activityImage;
//            $userActivity->save();
//
//            return redirect()->back()->with('success', 'Activity updated successfully.');
//        }
//
//        // If neither a global nor a user-specific activity found for the provided $id
//        return redirect()->back()->with('error', 'Activity not found.');


        User::findOrFail($userId);

        // Check if global activity exists
        $globalActivity = Activity::find($id);

        // If $id represents a global activity
        $userActivity = UserActivity::where('user_id', $userId)
            ->where('activity_id', $id)
            ->first();

        // Check if global and specific activities are exists, update that specific one
        if ($globalActivity && $userActivity) {
            $this->updateUserSpecificActivity($userActivity, $request);

            return redirect()->back()->with('success', 'Activity updated successfully.');
        }

        // If $id represents a global activity, create a new user-specific activity for the user
        if ($globalActivity) {
            // Create a new user-specific activity linked to the global activity
            $newUserActivity = new UserActivity([
                'user_id' => $userId,
                'activity_id' => $id,
                'title' => $request->title,
                'description' => $request->description,
                'date' => $request->date,
            ]);

            // Check if a new image is uploaded, if not, retain the existing image
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $this->storeImage($image);
                $activityImage = $imageName;
            } else {
                // If no new image, retain the old image
                Storage::copy('public/images/' . $request->old_image, 'public/images/users/' . $request->old_image);
                $activityImage = $request->old_image;
            }

            $newUserActivity->image = 'users/' . $activityImage;
            $newUserActivity->save();

            return redirect()->back()->with('success', 'Activity updated successfully.');
        }

        $userActivity = UserActivity::where('user_id', $userId)
            ->where('id', $id)
            ->first();

        // If $id represents a user-specific activity, and it's not linked with global one
        if ($userActivity) {
            $this->updateUserSpecificActivity($userActivity, $request);

            return redirect()->back()->with('success', 'Activity updated successfully.');
        }

        // If neither a global nor a user-specific activity found for the provided $id
        return redirect()->back()->with('error', 'Activity not found.');
    }

    /**
     * Destroy the activity.
     *
     * @param string $userId
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $userId, string $id): RedirectResponse
    {
        $user = User::findOrFail($userId);

        $activity = $user->userActivities->find($id);

        if ($activity)
            $activity->delete();

        return redirect()->back()->with('success', 'Activity deleted successfully.');
    }

    /**
     * @param UploadedFile $image
     * @return string
     */
    private function storeImage(UploadedFile $image): string
    {
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->storeAs('public/images/users', $imageName);

        return $imageName;
    }

    /**
     * @param UserActivity $userActivity
     * @param UpdateActivityRequest $request
     * @return void
     */
    private function updateUserSpecificActivity(UserActivity $userActivity, UpdateActivityRequest $request): void
    {
        if ($request->hasFile('image')) {
            $userActivity->image = 'users/' . $this->storeImage($request->file('image'));
            $userActivity->save();
        } else {
            $userActivity->update($request->only(['title', 'description', 'date']));
        }
    }
}
