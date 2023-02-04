<?php

namespace Database\Factories\Employee;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name'        => $this->faker->firstName,
            'last_name'         => $this->faker->lastName,
            'company_id'        => $this->faker->numberBetween(1, 50),
            'department'        => $this->faker->title,
            'email'             => $this->faker->unique()->safeEmail,
            'phone'             => $this->faker->phoneNumber,
            'staff_id'          => $this->faker->regexify('[A-Za-z0-9]{14}'),
            'staff_id'          => $this->faker->address,
            'created_at'        => now(),
            'updated_at'        => now()
        ];
    }
}
