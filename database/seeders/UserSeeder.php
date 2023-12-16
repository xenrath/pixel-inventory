<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'nama' => 'Admin',
                'username' => 'admin',
                'password' => bcrypt('admin'),
                'role' => 'admin'
            ],
            [
                'nama' => 'Sales 1',
                'username' => 'sales1',
                'password' => bcrypt('sales1'),
                'role' => 'sales'
            ],
            [
                'nama' => 'Sales 2',
                'username' => 'sales2',
                'password' => bcrypt('sales2'),
                'role' => 'sales'
            ],
            [
                'nama' => 'Sales 3',
                'username' => 'sales3',
                'password' => bcrypt('sales3'),
                'role' => 'sales'
            ],
        ];

        User::insert($users);
    }
}
