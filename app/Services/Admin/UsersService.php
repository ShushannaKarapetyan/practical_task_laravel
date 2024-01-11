<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Http\Requests\DateRangeRequest;
use App\Models\Activity;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;

/**
 * Users service class
 */
class UsersService
{
    /**
     * Show a user with activities
     *
     * @param string $id
     * @param DateRangeRequest $request
     * @return View
     */
    public function show(string $id, DateRangeRequest $request): View
    {
        $user = User::findOrFail($id);

        // User-specific activities
        $userSpecificActivities = $user->userActivities()->get();

        // Global activities
        $globalActivities = Activity::whereDoesntHave('users', function ($query) use ($id) {
            $query->where('user_id', $id);
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
        return view('admin.users.show', compact('user', 'allActivities'));
    }
}
