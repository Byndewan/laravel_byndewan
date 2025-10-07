<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pasien>
 */
class PasienFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Pasien::class;

    public function definition()
    {
        return [
            'nama_pasien' => $this->faker->name,
            'alamat' => $this->faker->address,
            'no_telepon' => $this->faker->numerify('0561-123456'),
            'rumah_sakit_id' => $this->faker->numberBetween(1, 2),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
