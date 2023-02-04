<?php

use App\Models\Employee\Employee;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::factory()->count(50)->create();
        $faker = Faker::create();
        for ($i = 0; $i < 50; $i++) {
            DB::table('employees')->insert([
                'first_name'      => $faker->firstName,
                'last_name'     => $faker->lastName,
                'company_id'   => $faker->numberBetween(1, 50),
                'department'    => $faker->title,
                'email'     => $faker->unique()->safeEmail,
                'phone'     => $faker->phoneNumber,
                'staff_id'  => $faker->regexify('[A-Za-z0-9]{14}'),
                'staff_id'  => $faker->address,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
