<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;

class UserController extends Controller {

	public function __construct() {
		$this->middleware('admin');
	}

	public function index() {
		$users = User::get();

		return view('admin.usermanage', ['users' => $users]);
	}

	public function create() {

		return view('admin.create');
	}

	public function store(Request $request) {
		//
	}

	public function update(Request $request, string $id) {

		$user = new User::findOrFail($id);

		$user->name  = $request->get('name');
		$user->email = $request->get('email');
		$user->role  = $request->get('role_id');

		$user->save();

		return redirect(route('admin.index'));

	}

	public function show($id) {
		//
	}

	public function edit($id) {
		return view('admin.editusers', ['user' => User::findOrFail($id)]);

	}

	public function destroy($id) {
		$user = User::findOrFail($id);

		$user->delete();

		return redirect('');
	}
}
