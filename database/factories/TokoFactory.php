<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TokoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama_toko' => 'Toko ' . $this->faker->company,
            'alamat_toko' => $this->faker->address,
        ];
    }
}
