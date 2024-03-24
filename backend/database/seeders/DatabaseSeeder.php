<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['admin', 'customer'];

        foreach ($roles as $role) {
            Role::create([
                'name' => $role
            ]);
        }

        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'role_id' => 1,
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'customer',
                'email' => 'customer@gmail.com',
                'role_id' => 2,
                'password' => Hash::make('12345678'),
            ]
        ];
        for ($i = 1; $i <= 10; $i++) {
            Product::create([
                'name' => 'nama barang ' . $i,
                'price' => 200 . $i,
                'description' => 'deskripsi' . $i,
                'stock' => $i,
            ]);
        }

        foreach ($users as $user) {
            \App\Models\User::create($user);
        }
    }
}
