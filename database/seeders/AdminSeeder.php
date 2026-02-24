<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'posma',
                'username' => 'posma',
                'email' => 'posma@northsumateratrip.com',
                'password' => \Illuminate\Support\Facades\Hash::make('Bismillah00'),
                'role' => 'super_admin',
            ],
            [
                'name' => 'ridho',
                'username' => 'ridho',
                'email' => 'ridho@northsumateratrip.com',
                'password' => \Illuminate\Support\Facades\Hash::make('Bismillah00'),
                'role' => 'super_admin',
            ],
        ];

        foreach ($admins as $admin) {
            \App\Models\User::updateOrCreate(
                ['username' => $admin['username']],
                $admin
            );
        }
    }
}
