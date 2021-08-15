<?php

namespace App\Http\Services;

use App\Models\User;
use Symfony\Component\HttpFoundation\Request;
use Hash ;

class AuthService
{
    public function attempt(Request $request)
    {
        if (is_numeric($request->get('email'))) {
            return auth()->attempt(
                ['phone' => $request->request->get('email'), 'password' => $request->request->get('password')]
            );
        }

        return auth()->attempt(
            ['email' => $request->request->get('email'), 'password' => $request->request->get('password')]
        );
    }

    public function registerFromRequest(Request $request, $user = null)
    {
        if (!$user) {
            $user = new User();
            $user->phone_verify = code($numbers = 4, $type = 'digits');
        }

        $user->fill($request->request->all());
        $user->password = $request->input("password");
        $user->active = 1;

        $user->save();
        return $user;
    }

    public function passwordUpdate(Request $request)
    {
        $oldPassword    = $request->get('old_password');
        $newPassword    = $request->get('password');
        $hashedPassword = auth()->user()->password;

        if (Hash::check($oldPassword, $hashedPassword)) {
            User::find(auth()->user()->id)
            ->update(['password'=> $newPassword]);
            return response()->json(['success'=> true, 'result' => trans('password_updated_successfully')]);
        }

        return response()->json(['success'=> false, 'result'=> trans('wrong_old_password')]);
    }
}
