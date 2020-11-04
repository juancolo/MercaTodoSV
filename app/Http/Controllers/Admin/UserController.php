<?php

namespace App\Http\Controllers\Admin;

use App\Entities\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $users = User::UserInfo($request->input('search'))->paginate();

        return view('admin.users.manageUsers', compact('users', $users));

    }

    public function create(): View
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        //
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
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->email = $request->get('email');
        $user->role = $request->get('role_id');
        $user->save();

        return redirect()->route('admin.index')
            ->with('status', 'Usuario actualizado correctamente');
    }

    public function show($id)
    {
        //
    }

    /**
     * @param $id
     * @return View
     */
    public function edit($id): View
    {
        return view('admin.users.editUsers', ['user' => User::findOrFail($id)]);
    }

    /**
     * @return RedirectResponse
     */

    public function destroy($id): RedirectResponse
    {
        $userToDelete = User::findOrFail($id);

        $userToDelete->delete();

        return redirect()
            ->route('admin.index')
            ->with('status', 'Se ha eliminado el usuario correctamente');
    }

}
