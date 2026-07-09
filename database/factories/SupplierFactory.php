<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Supplier;

class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company() . ' ' . $this->faker->randomElement(['Anime', 'Toys', 'Manga']),
            'contact_person' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->optional()->email(),
            'address' => $this->faker->optional()->address(),
        ];
    }
}