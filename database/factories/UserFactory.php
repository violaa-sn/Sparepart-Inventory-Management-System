<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            
            'nama_user' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'nomor_telepon' => fake()->unique()->numerify('08##########'),
            'password' => 'password',
            'role' => fake()->randomElement([
                'manager',
                'admin',
                'staff'
            ]),
            'status_user' => fake()->randomElement([
                'aktif',
                'nonaktif'
            ]),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
