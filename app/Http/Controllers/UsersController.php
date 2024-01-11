<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\DateRangeRequest;
use App\Services\Users\UsersService;
use Illuminate\Contracts\View\View;

/**
 * Users controller class.
 */
class UsersController extends Controller
{
    public function __construct(private readonly UsersService $usersService)
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
        return $this->usersService->getActivities($request);
    }
}
