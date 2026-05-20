<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $roman         = Category::where('name', 'Roman')->first()->id;
        $scifi         = Category::where('name', 'Naučna fantastika')->first()->id;
        $istorija      = Category::where('name', 'Istorija')->first()->id;
        $filozofija    = Category::where('name', 'Filozofija')->first()->id;
        $detektivski   = Category::where('name', 'Detektivski roman')->first()->id;

        $books = [
            ['title' => 'Na Drini ćuprija',          'author' => 'Ivo Andrić',            'category_id' => $roman,      'total_copies' => 5, 'available_copies' => 3],
            ['title' => 'Travnička hronika',          'author' => 'Ivo Andrić',            'category_id' => $roman,      'total_copies' => 3, 'available_copies' => 2],
            ['title' => '1984',                       'author' => 'George Orwell',          'category_id' => $scifi,      'total_copies' => 4, 'available_copies' => 2],
            ['title' => 'Hrabri novi svet',           'author' => 'Aldous Huxley',         'category_id' => $scifi,      'total_copies' => 3, 'available_copies' => 3],
            ['title' => 'Fondacija',                  'author' => 'Isaac Asimov',           'category_id' => $scifi,      'total_copies' => 2, 'available_copies' => 0],
            ['title' => 'Kratka istorija vremena',    'author' => 'Stephen Hawking',       'category_id' => $istorija,   'total_copies' => 3, 'available_copies' => 2],
            ['title' => 'Sapiens',                    'author' => 'Yuval Noah Harari',     'category_id' => $istorija,   'total_copies' => 4, 'available_copies' => 1],
            ['title' => 'Kritika čistog uma',         'author' => 'Immanuel Kant',         'category_id' => $filozofija, 'total_copies' => 2, 'available_copies' => 2],
            ['title' => 'Ubistvo u Orijent ekspresu', 'author' => 'Agatha Christie',       'category_id' => $detektivski,'total_copies' => 5, 'available_copies' => 3],
            ['title' => 'I tada ih ne ostade nijedan','author' => 'Agatha Christie',       'category_id' => $detektivski,'total_copies' => 3, 'available_copies' => 2],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
