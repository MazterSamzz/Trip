<?php

declare(strict_types=1);

namespace App\Modules\User\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Presentation\Http\Requests\LoginRequest;
use App\Modules\User\Application\Services\AuthenticateUserService;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(
        LoginRequest $request,
        AuthenticateUserService $auth
    ) {

        $credentials = $request->validated();
        $user = $auth->execute($credentials['login'], $credentials['password']);

        if (!$user) {
            return back()->withErrors(['login' => 'Invalid credentials']);
        }

        // Laravel session login
        Auth::login($user);
        return redirect()->intended('/dashboard');
    }
}
