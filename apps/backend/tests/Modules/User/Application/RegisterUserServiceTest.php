<?php

declare(strict_types=1);

namespace Tests\Modules\User\Application;

use App\Modules\User\Application\Data\RegisterUserData;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\User\Application\Services\RegisterUserService;
use App\Modules\User\Domain\Models\User;
use App\Modules\User\Domain\ValueObjects\PasswordHash;
use DomainException;

final class RegisterUserServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_registers_a_new_user(): void
    {
        $service = app(RegisterUserService::class);

        $user = $service->execute(new RegisterUserData(
            'testuser',
            'test@mail.com',
            'secret123',
            'Test User'
        ));

        $this->assertInstanceOf(User::class, $user);

        $this->assertDatabaseHas('users', [
            'username' => 'testuser',
            'email' => 'test@mail.com',
        ]);

        $this->assertTrue(
            $user->verifyPassword('secret123')
        );
    }

    /** @test */

    public function it_rejects_duplicate_email(): void
    {
        User::factory()->create([
            'email' => 'ivan@test.com',
        ]);

        $service = app(RegisterUserService::class);

        $this->expectException(DomainException::class);

        $service->execute(new RegisterUserData(
            username: 'anotheruser',
            email: 'ivan@test.com',
            password: 'secret123',
            name: 'Another User',
        ));
    }
}
