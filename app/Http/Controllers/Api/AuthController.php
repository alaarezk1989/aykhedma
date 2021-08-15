<?php

namespace App\Http\Controllers\Api;

use App\Http\Services\NotificationService;
use Illuminate\Routing\Controller;
use App\Http\Services\AuthService;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\UserRequest;
use App\Http\Requests\Web\ForgotPasswordRequest;
use Password;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpFoundation\Request;
use Illuminate\Http\Request;
use App\Models\User ;
use Lcobucci\JWT\Parser;
use App\Http\Requests\Api\UpdatePasswordRequest ;

use Auth ;

class AuthController extends Controller
{
    public $authService ;

    public function __Construct(AuthService $authService)
    {
        $this->authService = $authService ;
    }

    public function register(RegisterRequest $request, NotificationService $notificationService)
    {
        $authService = new AuthService;
        $user = $authService->registerFromRequest($request);
        $sms = $notificationService->sendSMS($user, $user->phone_verify);

        return response()->json([$user, $sms]);
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::user()->AauthAcessToken()->delete();
            return response()->json(['result' => 'Logged Out'], 200);
        }
    }

    public function update(UserRequest $request)
    {
        User::where('id', auth()->user()->id)->update($request->all());

        return response(['success' => true], Response::HTTP_CREATED);
    }

    public function resetPassword(ForgotPasswordRequest $request)
    {
        Password::broker()->sendResetLink(
            $request->only('email')
        );

        return response(['success' => true], Response::HTTP_CREATED);
    }

    public function passwordUpdate(UpdatePasswordRequest $request)
    {
        return $this->authService->passwordUpdate($request) ;
    }
}
