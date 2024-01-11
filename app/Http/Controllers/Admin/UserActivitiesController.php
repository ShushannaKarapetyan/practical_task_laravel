<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\User;
use App\Services\Admin\UserActivitiesService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * UserActivities controller class.
 */
class UserActivitiesController extends Controller
{
    public function __construct(private readonly UserActivitiesService $userActivitiesService)
    {
    }

    /**
     * Show the activity
     *
     * @param string $userId
     * @param string $id
     * @return View
     */
    public function show(string $userId, string $id): View
    {
        return $this->userActivitiesService->show($userId, $id);
    }

    /**
     * Create an activity for the particular user
     *
     * @param string $id
     * @return View
     */
    public function create(string $id): View
    {
        $user = User::findOrFail($id);

        return view('admin.users.activities.create', compact('user'));
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
        return $this->userActivitiesService->store($id, $request);
    }

    /**
     * Edit an activity
     *
     * @param string $userId
     * @param string $id
     * @return View
     */
    public function edit(string $userId, string $id): View
    {
        return $this->userActivitiesService->edit($userId, $id);
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
        return $this->userActivitiesService->update($userId, $id, $request);
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
        return $this->userActivitiesService->destroy($userId, $id);
    }
}
