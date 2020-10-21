<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;

class UserController extends Controller {

	public function __construct() {
		$this->middleware('admin');
        $this->middleware('auth');
	}

	public function index(Request $request)
    {

        $users = User::UserInfo($request->input('search'))->paginate();

        return view('admin.users.manageUsers', compact('users', $users));

	}

    public function create() {

		return view('admin.create');
	}

	public function store(Request $request) {
		//
	}
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $id
     * @return RedirectResponse
     */

	public function update( Request $request, $id) : RedirectResponse {

		$user = User::findOrFail($id);

		$user->first_name  = $request->get('first_name');
        $user->last_name  = $request->get('last_name');
		$user->email = $request->get('email');
		$user->role  = $request->get('role_id');

		$user->save();

		return redirect()->route('admin.index')
                         ->with('status', 'Usuario actualizado correctamente');

	}

	public function show($id) {
		//
	}

	public function edit( $id) {
		return view('admin.users.editUsers', ['user' => User::findOrFail($id)]);
	}

	/**
	 * @return RedirectResponse
	 */

	public function destroy($id) : RedirectResponse
    {
		$userToDelete = User::findOrFail($id);

		$userToDelete->delete();

		return redirect()
                ->route('admin.index')
                ->with('status', 'Se ha eliminado el usuario correctamente');
	}

}
