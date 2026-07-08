<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama_supplier' => $this->faker->company,
            'kontak_person' => $this->faker->name,
            'no_telepon' => $this->faker->phoneNumber,
            'alamat' => $this->faker->address,
        ];
    }
}
