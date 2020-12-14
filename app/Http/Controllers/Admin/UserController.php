<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Entities\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Repository\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    protected UserRepository $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->middleware('admin');
        $this->middleware('auth');
        $this->userRepo = $userRepo;
    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $users = $this->userRepo->getUserIndex($request);

        return view('admin.users.index', compact('users', $users));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */

    public function update(Request $request, User $user): RedirectResponse
    {
        $this->userRepo->update($user, $request->all());

        return redirect()->route('admin.index')
            ->with('status', 'Usuario actualizado correctamente');
    }

    /**
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * @param User $user
     * @return RedirectResponse
     * @throws Exception
     */

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect()
            ->route('admin.index')
            ->with('status', 'Se ha eliminado el usuario correctamente');
    }

}
