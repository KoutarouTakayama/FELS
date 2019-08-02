<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function exists($userId)
    {
        try {
            User::findOrFail($userId);
        } catch (ModelNotFoundException $e) {
            return abort(404);
        }
    }

    public function accountIdNameEmail($userId)
    {
        return User::select('id', 'name', 'email')->find($userId);
    }

    public function store($request)
    {
        $request->validate([
            'name' => 'required | min:3 | max:20',
            'email' => 'required | email | unique:users',
            'password' => 'required | min:6 | confirmed'
        ]);
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }

    public function restore($userId, $request)
    {
        $this->exists($userId);
        if ($request->name !== User::find($userId)->name) {
            $request->validate([
                'name' => 'required | min:3 | max:20',
            ]);
        }
        if ($request->email !== User::find($userId)->email) {
            $request->validate([
                'email' => 'required | email | unique:users',
            ]);
        }
        return User::find($userId)->fill([
            'name' => $request->name,
            'email' => $request->email
        ])->save();
    }

    public function delete($accountId)
    {
        $this->exists($accountId);
        return User::find($accountId)->delete();
    }

    public function passwordRestore($request)
    {
        $request->validate([
            'newPassword' => 'required | min:6 | confirmed'
        ]);
        if (Hash::check($request->currentPassword, Auth::user()->password)) {
            User::find(Auth::id())->fill([
                'password' => Hash::make($request->newPassword)
            ])->save();
            return true;
        }
        return false;
    }

    public function avatarRestore(Request $request)
    {
        $request->validate([
            'avatar' => 'required | file | image | mimes:jpeg,png'
        ]);
        if ($request->file('avatar')->isValid()) {
            $filename = Auth::user()->id . "-" . time() . '.jpg';
            $request->avatar->storeAs('dropbox', $filename);

            if (Auth::user()->avatar_url != 'default.jpg') {
                Storage::disk('dropbox')->delete(Auth::user()->avatar_url);
            }

            User::find(Auth::id())->fill(['avatar_url' => $filename])->save();

            return true;
        } else {
            return false;
        }
    }
}
