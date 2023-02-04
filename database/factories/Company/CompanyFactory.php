<?php

namespace Database\Factories\Company;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'      => $this->faker->company,
            'email'     => $this->faker->unique()->safeEmail,
            'address'   => $this->faker->address,
            'status'    => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
