<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Mganilwa',
            'email' => 'mganilwa@gmail.com',
            'phone' => '0712345678',
            'role_id' => '1',
            'department_id' => '1',
            'password' => Hash::make('00000000'),
            'reference' => uniqid(),
            'reg' => 'NIT/REC/001',
        ]);
    }
}
