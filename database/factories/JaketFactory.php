<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jaket>
 */
class JaketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sizes = [
            'Putra - S', 'Putra - M', 'Putra - L', 'Putra - XL', 'Putra - 2XL',
            'Putri - S', 'Putri - M', 'Putri - L', 'Putri - XL', 'Putri - 2XL',
        ];

        $tshirtData = [];
        $itemCount = $this->faker->numberBetween(1, 3);

        for ($i = 0; $i < $itemCount; $i++) {
            $tshirtData[] = [
                'ukuran' => $this->faker->randomElement($sizes),
                'jumlah' => $this->faker->numberBetween(1, 5),
            ];
        }

        return [
            'user_id' => User::factory(), 
            'nama' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'tshirt_data' => json_encode($tshirtData),
            'status' => $this->faker->boolean(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
