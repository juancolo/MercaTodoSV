<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller {

	public function __construct() {
		$this->middleware('admin');
	}

	public function index() {
		$users = User::orderBy('id', 'ASC')->paginate(15);

		return view('admin.usermanage', compact('users'));
	}

	public function create() {

		return view('admin.create');
	}

	public function store(Request $request) {
		//
	}

	public function update( $request, string $id) {

		$user = User::findOrFail($id);

		$user->first_name  = $request->get('first_name');
        $user->last_name  = $request->get('last_name');
		$user->email = $request->get('email');
		$user->role  = $request->get('role_id');

		$user->save();

		return redirect(route('admin.index'));

	}

	public function show($id) {
		//
	}

	public function edit( $id) {
		return view('admin.editusers', ['user' => User::findOrFail($id)]);

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
                ->with('info', 'Se ha eliminado el usuario correctamente');
	}

}
