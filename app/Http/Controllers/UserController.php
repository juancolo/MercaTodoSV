<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class UserController extends Controller
{

/*public function __construct()
{
$this->middleware('admin');
}*/

public function index()
{
$users = User::get();

return view('admin.usermanage',['users'=>$users]);
}

public function create()
{
return view('admin.create');
}

public function store(Request $request)
{
//
}

public function update(Request $request, $id)
{
$user = User::findOrFail($id);

$user->name = $request->get('name');
$user->email = $request->get('email');
$user->role = $request->get('role_id');
//$user->role = request('role_id');
//$user->name = $request->get('name');

$user->update();

return redirect('admin');


}

public function show($id)
{
//
}

public function edit($id)
{
return view('admin/edit', ['user'=> User::findOrFail($id)]);

}

public function destroy($id)
{
$user = User::findOrFail($id);

$user->delete();

return redirect('admin');
}
}
