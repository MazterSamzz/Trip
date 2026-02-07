<?php

declare(strict_types=1);

namespace App\Modules\User\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Application\Services\RegisterUserService;
use App\Modules\User\Presentation\Http\Requests\RegisterUserRequest;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function __invoke(
        RegisterUserRequest $request,
        RegisterUserService $register
    ) {


        $user = $register->execute($request->validated());

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    // public function redirectGoogle()
    // {
    //     return Socialite::driver('google')->redirect();
    // }

    // public function handleGoogle(UserService $service)
    // {
    //     $googleUser = Socialite::driver('google')->user();

    //     $user = $service->findOrCreateGoogleUser(
    //         $googleUser->getId(),
    //         $googleUser->getEmail(),
    //         $googleUser->getName()
    //     );

    //     Auth::login($user);

    //     return redirect()->route('trip.index');
    // }
}
