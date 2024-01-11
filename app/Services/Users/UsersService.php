<?php

declare(strict_types=1);

namespace App\Services\Users;

use App\Http\Requests\DateRangeRequest;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;

/**
 * Users service class.
 */
class UsersService
{
    /**
     * Get logged-in user's activities
     *
     * @param DateRangeRequest $request
     * @return View
     */
    public function getActivities(DateRangeRequest $request): View
    {
        $userId = auth()->id();

        // User-specific activities
        $userSpecificActivities = auth()->user()->userActivities()->get();

        // Global activities
        $globalActivities = Activity::whereDoesntHave('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        // Merge global and user-specific activities
        $allActivities = $userSpecificActivities->merge($globalActivities);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($startDate && $endDate) {
            $startDateFormatted = Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
            $endDateFormatted = Carbon::createFromFormat('d/m/Y', $endDate)->format('Y-m-d');

            // Filter activities based on the date range
            $allActivities = $allActivities->filter(function ($activity) use ($startDateFormatted, $endDateFormatted) {
                $activityDate = Carbon::parse($activity->date);
                return $activityDate->between($startDateFormatted, $endDateFormatted);
            });
        }

        //TODO: implement pagination
        return view('users.activities', compact('allActivities'));
    }
}
