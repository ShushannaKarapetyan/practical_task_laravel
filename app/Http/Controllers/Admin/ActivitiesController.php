<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use App\Services\Admin\ActivitiesService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Activities controller class.
 */
class ActivitiesController extends Controller
{
    public function __construct(private readonly ActivitiesService $activitiesService)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $activities = Activity::paginate();

        return view('admin.activities.index', compact('activities'));
    }

    /**
     * Show an activity
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        $activity = Activity::findOrFail($id);

        return view('admin.activities.show', compact('activity'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.activities.create');
    }

    /**
     * Store an activity
     *
     * @param CreateActivityRequest $request
     * @return RedirectResponse
     */
    public function store(CreateActivityRequest $request): RedirectResponse
    {
        return $this->activitiesService->store($request);
    }

    /**
     * Edit an activity
     *
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $activity = Activity::findOrFail($id);

        return view('admin.activities.edit', compact('activity'));
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
        return $this->activitiesService->update($id, $request);
    }

    /**
     * Delete an activity
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        return $this->activitiesService->destroy($id);
    }
}
