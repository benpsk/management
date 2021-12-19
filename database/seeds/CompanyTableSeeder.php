<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();
        for ($i = 0; $i < 50; $i++) {
            DB::table('companies')->insert([
                'name'      => $faker->company,
                'email'     => $faker->unique()->safeEmail,
                'address'   => $faker->address,
                'status'    => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
