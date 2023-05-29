<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()->latest()->paginate(10);
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required',
            'email'=> 'required|email|unique:users',
            'password'=> 'required|min:8',
            'image'=> 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
        ]);

        $fileName = time().'.'.$request->image->extension();
        $request->image->storeAs('public/images', $fileName);

        $user = new User;
        $user->name = $request->input('name');
        $user->email = trim($request->input('email'));
        $user->password = bcrypt($request->input('password'));
        $user->image = $fileName;
        $user->save();

        return redirect()->route('user.index')->with([
            'message' => 'User added successfully!',
            'status'=> 'success'
        ]);
    }

    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('user.edit',compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $fileName = '';

        if($request->hasFile('image')) {
            $fileName = time().'.'.$request->image->extension();
            $request->image->storeAs('public/images', $fileName);
            if($user->image) {
                Storage::delete('public/images/' . $user->image);
            }
        } else {
            $fileName = $user->image;
        }

        $user->name = $request->input('name');
        $user->email = trim($request->input('email'));
        $user->password = bcrypt($request->input('password'));
        $user->image = $fileName;
        $user->save();

        return redirect()->route('user.index')->with([
            'message' => 'User updated successfully!',
            'status'=> 'success'
        ]);
    }

    public function destroy(User $user) {

        if($user->image){
            Storage::delete('public/images/' . $user->image);
        }

        $user->delete();

        return redirect()->route('user.index')->with([
            'message' => 'User deleted successfully!',
            'status'=> 'success'
        ]);
    }

}
