<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DateRangeRequest;
use App\Models\User;
use App\Services\Admin\UsersService;
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
     * @return View
     */
    public function index(): View
    {
        $users = User::where('is_admin', '!=', true)->paginate();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show a user with activities
     *
     * @param string $id
     * @param DateRangeRequest $request
     * @return View
     */
    public function show(string $id, DateRangeRequest $request): View
    {
        return $this->usersService->show($id, $request);
    }
}
