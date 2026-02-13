<?php

namespace Database\Factories\Modules\User\Domain\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\User\Domain\models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UserFactory extends Factory
{
    /**
     * Model associated with the factory.
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => $this->faker->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'name' => $this->faker->name(),
        ];
    }
}
