<?php

namespace App\Modules\User\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Application\Services\OAuthUserService;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class OAuthController extends Controller
{
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(
        string $provider,
        OAuthUserService $oauth
    ) {
        $oauthUser = Socialite::driver($provider)->user();

        $user = $oauth->execute(
            $provider,
            $oauthUser->getId(),
            $oauthUser->getEmail(),
            $oauthUser->getName()
        );

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
