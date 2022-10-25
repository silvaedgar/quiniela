<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
// use App\Http\Requests\UserRequest;
// use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('users.index', compact('users'));
    }

    public function create() {
        return view('users.create');
    }

    public function store(Request $request) {

        $request->validate ([
            'name' => 'required|string|max:30',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6'
        ]);

        DB::beginTransaction();
        $user = User::create([
            'name' =>$request->name,
            'email' =>$request->email,
            'password' => bcrypt($request->password),
        ]);

        DB::commit();
        return redirect()->route('user.index')->with('message',"Usuario $request->name creado con exito");
    }

    public function edit(User $user) {

        if (Auth::user()->id == $user->id || Auth::user()->hasRole('Admin'))
            return view('users.edit',compact('user'));
        else
            return view('home-auth');
    }

    public function update(Request $request,$id) {

        $request->validate ([
            'name' => 'required|string|max:30',
            'email' => "required|string|email|unique:users,email,$id",
            'password' => 'required|string|min:6'
        ]);

        DB::beginTransaction();
        $user = User::find($id);
        $user->update([
            'name' =>$request->name,
            'email' =>$request->email,
            'password' => bcrypt($request->password),
        ]);
        DB::commit();
        return redirect()->route('user.index')->with('message',"Usuario $request->name actualizado con exito");
    }


}
