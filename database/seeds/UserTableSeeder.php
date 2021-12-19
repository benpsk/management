<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->truncate();

        $user = new User;
        $user->name = 'Admin';
        $user->email = 'admin@admin.com';
        $user->password = Hash::make('admin');
        $user->status = 1;
        $user->save();
        $user::first()->roles()->attach(1);


        $user = new User;
        $user->name = 'Employee';
        $user->email = 'emp@emp.com';
        $user->password = Hash::make('1122');
        $user->status = 1;
        $user->save();

        $user::find(2)->roles()->attach(2);
    }
}
