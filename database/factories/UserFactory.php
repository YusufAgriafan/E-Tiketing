<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
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
            'nama' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'no_telepon' => $this->faker->phoneNumber(),
            'jumlah_peserta' => $this->faker->numberBetween(1, 50),
            'dewasa' => $this->faker->numberBetween(1, 30),
            'anak' => $this->faker->numberBetween(0, 20),
            'harga' => $this->faker->numberBetween(100000, 500000),
            'status' => $this->faker->randomElement(['belum', 'lunas', 'gagal']),
            'tanggal_lunas' => $this->faker->optional()->dateTime(),
            'jersei' => $this->faker->boolean(),
            'kapal' => $this->faker->boolean(),
            'naik_kapal' => $this->faker->optional()->numberBetween(0, 5),
            'qr_code' => Str::random(20),
            'qr_token' => Str::random(10),
            'invoice' => 'INV-' . strtoupper(Str::random(8)),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
