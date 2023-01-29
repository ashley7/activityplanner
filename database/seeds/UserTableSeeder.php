<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $user = new User();

        $user->name = "Thembo Charles Lwanga";

        $user->email = "thembo@agrosupplyltd.com";

        $user->password = Hash::make('admin123@');

        $user->user_type = "admin";

        $user->remember_token = \Str::random(32);

        try {

            $user->save();

        } catch (\Throwable $th) {}
        
    }
}
