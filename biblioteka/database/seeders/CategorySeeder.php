<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Roman',
            'Naučna fantastika',
            'Istorija',
            'Filozofija',
            'Tehnika i tehnologija',
            'Detektivski roman',
            'Poezija',
            'Biografija',
        ];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}
