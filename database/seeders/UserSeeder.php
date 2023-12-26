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
                'kode_user' => 'AB000001',
                'nama' => 'Admin',
                'username' => 'admin',
                'telp' => '098xxxxxxxx',
                'alamat' => 'Tegal',
                'password' => bcrypt('admin'),
                'role' => 'admin'
            ],
            [
                'kode_user' => 'AB000002',
                'nama' => 'Sales 1',
                'username' => 'sales1',
                'telp' => '098xxxxxxxx',
                'alamat' => 'Tegal',
                'password' => bcrypt('sales1'),
                'role' => 'sales'
            ],
            [
                'kode_user' => 'AB000003',
                'nama' => 'Sales 2',
                'username' => 'sales2',
                'telp' => '098xxxxxxxx',
                'alamat' => 'Tegal',
                'password' => bcrypt('sales2'),
                'role' => 'sales'
            ],
            [
                'kode_user' => 'AB000004',
                'nama' => 'Sales 3',
                'username' => 'sales3',
                'telp' => '098xxxxxxxx',
                'alamat' => 'Tegal',
                'password' => bcrypt('sales3'),
                'role' => 'sales'
            ],
        ];

        User::insert($users);
    }
}