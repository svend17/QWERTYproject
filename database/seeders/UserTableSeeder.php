<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
        $data = [
            ['name' => 'TestProfile1', 'email' => 'test1@gmail.com', 'password' => Hash::make('password')],
            ['name' => 'TestProfile2', 'email' => 'test2@gmail.com', 'password' => Hash::make('password')],
            ['name' => 'TestProfile3', 'email' => 'test3@gmail.com', 'password' => Hash::make('password')]
        ];

        User::insert($data);
    }
}
