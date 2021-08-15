<?php

namespace App\Http\Controllers\Web;

use App\Events\UserLoggedEvent;
use App\Http\Controllers\BaseController;
use App\Http\Services\AuthService;
use App\Models\User;
use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Password;
use Str;
use View;
use App\Http\Requests;
use App\Http\Requests\Web\ForgotPasswordRequest;
use App\Http\Requests\Web\ConfirmResetPasswordRequest;
use Auth;
use App\Http\Requests\Web\LoginAttemptRequest;
use App\Http\Requests\Web\RegisterRequest;
use App\Constants\UserTypes;

class AuthController extends BaseController
{

    public function attempt(LoginAttemptRequest $request, AuthService $authService)
    {
        if (!$authService->attempt($request)) {
            session()->flash('error', trans('invalid_credentials'));

            return redirect()->back();
        }

        /** @var User $user */
        $user = auth()->user();
        event(new UserLoggedEvent($user));

        if (!$user->token || $user->token_expires_at < Carbon::now()) {
            $token = $user->createToken('User Personal Token #' . $user->id);
            $user->token = $token->accessToken;
            $user->token_expires_at = $token->token->expires_at;
            $user->save();
        }

        return redirect()->intended();
    }

    public function logout()
    {
        Auth::logout();
        Session()->flush();

        return redirect('/');
    }

    public function login()
    {
        if (!auth()->user()) {
            return View::make('web.auth.login');
        }
        if (auth()->user()->type != UserTypes::ADMIN && auth()->user()->type != UserTypes::VENDOR) {
            return View::make('web.auth.login');
        }

        return redirect(route(UserTypes::getOneTypesUrl(auth()->user()->type) . '.home.index'));
    }

    public function register()
    {
        return View::make('web.auth.register');
    }

    public function registerAction(RegisterRequest $request, AuthService $authService)
    {
        $user = $authService->registerFromRequest($request);
        auth()->login($user);
        session()->flash('success', trans('register_success_message'));

        return redirect('/');
    }

    public function reset(Request $request)
    {
        if ($request->query->has('token')) {
            return View::make('web.auth.resetter');
        }

        return View::make('web.auth.reset');
    }

    public function sendReset(ForgotPasswordRequest $request)
    {

        Password::broker()->sendResetLink(
            $request->only('email')
        );
        session()->flash('success', trans('passwords.sent'));

        return redirect()->back();
    }

    public function resetPassword(ConfirmResetPasswordRequest $request)
    {
        $response = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),

            function (User $user, $password) {
                $user->password = $password;
                $user->setRememberToken(Str::random(60));
                $user->save();
                //event(new PasswordReset($user));
                //Auth::guard()->login($user);
            }
        );

        if ($response != Password::PASSWORD_RESET) {
            return redirect()->back()->with('error', trans($response));
        }

        return redirect()->back()->with('success', trans("password_changed_success"));
    }
}
