<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Http\Requests\CreateActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

/**
 * Activities service class
 */
class ActivitiesService
{
    /**
     * Store an activity.
     *
     * @param CreateActivityRequest $request
     * @return RedirectResponse
     */
    public function store(CreateActivityRequest $request): RedirectResponse
    {
        $activityCount = Activity::where('date', $request->date)->count();

        if ($activityCount === 4) {
            return redirect()->route('activities.create')
                ->with('error', 'You cannot create more than 4 activities for this day.');
        }

//        $validatedData = [
//            'title' => $request->title,
//            'description' => $request->description,
//            'date' => $request->date,
//        ];
//
//        $image = $request->file('image');
//        $imageName = time() . '_' . $image->getClientOriginalName();
//
//        // Store the image in the storage directory
//        $image->storeAs('public/images', $imageName);
//        $validatedData['image'] = $imageName;
//
//        Activity::create($validatedData);

        $validatedData = $this->processActivityData($request);

        Activity::create($validatedData);

        return redirect()->route('dashboard.activities')->with('success', 'Activity created successfully.');
    }

    /**
     * Update an activity
     *
     * @param string $id
     * @param UpdateActivityRequest $request
     * @return RedirectResponse
     */
    public function update(string $id, UpdateActivityRequest $request): RedirectResponse
    {
//        $activity = Activity::findOrFail($id);
//
//        $validatedData = [
//            'title' => $request->title,
//            'description' => $request->description,
//            'date' => $request->date,
//        ];
//
//        // Check if a new image is uploaded; if not, retain the existing image
//        if ($request->hasFile('image')) {
//            $image = $request->file('image');
//            $imageName = time() . '_' . $image->getClientOriginalName();
//
//            // Store the image in the storage directory
//            $image->storeAs('public/images', $imageName);
//            $validatedData['image'] = $imageName;
//        } else {
//            // If no new image, retain the old image
//            $validatedData['image'] = $request->old_image;
//        }
//
//        $activity->update($validatedData);
//
//        return redirect()->route('dashboard.activities')->with('success', 'Activity updated successfully.');
//

        $activity = Activity::findOrFail($id);

        $validatedData = $this->processActivityData($request, $activity);

        $activity->update($validatedData);

        return redirect()->route('dashboard.activities')->with('success', 'Activity updated successfully.');
    }

    /**
     * Delete an activity
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        $activity = Activity::findOrFail($id);

        // Get users associated with this global activity
        $users = $activity->users;

        // Update related user_activities by setting activity_id to null
        foreach ($users as $user) {
            $user->userActivities()->where('activity_id', $id)
                ->update(['activity_id' => null]);
        }

        $activity->delete();

        return redirect()->route('dashboard.activities')->with('success', 'Activity deleted successfully.');
    }

    /**
     * Process common activity data from the request.
     *
     * @param FormRequest $request
     * @param Activity|null $activity
     * @return array
     */
    private function processActivityData(FormRequest $request, ?Activity $activity = null): array
    {
        $validatedData = [
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
        ];

        // Check if a new image is uploaded, if not, retain the existing image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();

            // Store the image in the storage directory
            $image->storeAs('public/images', $imageName);
            $validatedData['image'] = $imageName;

            // If updating an existing activity, delete the old image
            if ($activity && $activity->image) {
                Storage::delete('public/images/' . $activity->image);
            }
        } elseif ($activity) {
            // If no new image, retain the old image if it exists
            $validatedData['image'] = $activity->image;
        }

        return $validatedData;
    }
}
