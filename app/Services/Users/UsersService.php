<?php

declare(strict_types=1);

namespace App\Services\Users;

use App\Http\Requests\DateRangeRequest;
use App\Models\Activity;
use Illuminate\Contracts\View\View;
use App\Services\Admin\UsersService as AdminUsersService;

/**
 * Users service class.
 */
readonly class UsersService
{
    public function __construct(private AdminUsersService $usersService)
    {
    }

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
        $mergedActivities = $userSpecificActivities->merge($globalActivities);

        $allActivities = $this->usersService->filterActivities($mergedActivities, $request);

        //TODO: implement pagination
        return view('users.activities', compact('allActivities'));
    }
}
