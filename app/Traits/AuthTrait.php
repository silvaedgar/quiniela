<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;



trait AuthTrait {

    public function isLogged($request) {
        return  Auth::attempt(['email' => $request->email, 'password' => $request->password]);
    }

    public function logoutSession($request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return;
    }

    public function confirmPassword($request) {
        return ($request->password === $request->password1);
    }

    public function createUser($request) {

        try {
            $user = User::create([
                'name' =>$request->name,
                'email' =>$request->email,
                'password' => bcrypt($request->password),
            ]);
        } catch (\Throwable $th) {
            return false;
        }
        return true;
    }

}
