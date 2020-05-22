<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => config('custom.user.name'),
            'email' => config('custom.user.email'),
            'password' => Hash::make(config('custom.user.password')),
        ]);
    }
}
