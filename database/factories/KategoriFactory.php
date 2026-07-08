<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Kategori;

class KategoriFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama_kategori' => 'Kategori ' . $this->faker->word,
            'deskripsi' => $this->faker->sentence,
        ];
    }
}
