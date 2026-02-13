<?php

declare(strict_types=1);

namespace App\Modules\User\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\User\Domain\Repositories\UserRepository;
use App\Modules\User\Infrastructure\Repositories\EloquentUserRepository;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UserRepository::class,
            EloquentUserRepository::class
        );
    }

    public function boot(): void
    {
        // Kosong dulu.
        // Dipakai nanti kalau ada:
        // - event listener
        // - policy
        // - observer
    }
}
