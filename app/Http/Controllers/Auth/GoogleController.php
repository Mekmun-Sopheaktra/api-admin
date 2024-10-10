<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\api\v1\AuthController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        info('Redirecting to Google');
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the Google callback.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            info(json_encode($googleUser));
//            $user = User::firstOrCreate(
//                ['email' => $googleUser->getEmail()],
//                [
//                    'name' => $googleUser->getName(),
//                    'email' => $googleUser->getEmail(),
//                    'google_id' => $googleUser->getId(),
//                    'avatar' => $googleUser->getAvatar(),
//                ]
//            );
            $name = $googleUser->getName();
            $email = $googleUser->getEmail();
            $password = sha1($googleUser->getId().$googleUser->getEmail().$googleUser->getName());
            $request = [
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ];
            $user = User::query()->create($request);

            Auth::login($user);

            return redirect()->route('home');
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors('Unable to login, please try again.');
        }
    }
}
