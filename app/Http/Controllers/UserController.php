<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

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

        return redirect('admin.index');


    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        return view('admin.editusers', ['user'=> User::findOrFail($id)]);

    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect('');
    }
}
