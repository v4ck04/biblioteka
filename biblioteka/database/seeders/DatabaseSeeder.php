<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin Bibliotekar',
            'email'    => 'admin@biblioteka.rs',
            'password' => Hash::make('admin123'),
        ]);

        $this->call([
            CategorySeeder::class,
            BookSeeder::class,
            BorrowingSeeder::class,
        ]);
    }
}
