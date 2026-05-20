<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Database\Seeder;

class BorrowingSeeder extends Seeder
{
    public function run(): void
    {
        $borrowings = [
            // Vraćena pozajmica
            [
                'book_title'    => 'Na Drini ćuprija',
                'borrower_name' => 'Marko Petrović',
                'borrowed_at'   => now()->subDays(30),
                'due_date'      => now()->subDays(16),
                'returned_at'   => now()->subDays(18),
            ],
            // Vraćena pozajmica
            [
                'book_title'    => '1984',
                'borrower_name' => 'Ana Jovanović',
                'borrowed_at'   => now()->subDays(25),
                'due_date'      => now()->subDays(11),
                'returned_at'   => now()->subDays(12),
            ],
            // Aktivna pozajmica – u roku
            [
                'book_title'    => 'Na Drini ćuprija',
                'borrower_name' => 'Stefan Nikolić',
                'borrowed_at'   => now()->subDays(5),
                'due_date'      => now()->addDays(9),
                'returned_at'   => null,
            ],
            // Aktivna pozajmica – u roku
            [
                'book_title'    => 'Travnička hronika',
                'borrower_name' => 'Milica Đorđević',
                'borrowed_at'   => now()->subDays(3),
                'due_date'      => now()->addDays(11),
                'returned_at'   => null,
            ],
            // Aktivna pozajmica – u roku
            [
                'book_title'    => 'Sapiens',
                'borrower_name' => 'Nikola Stojanović',
                'borrowed_at'   => now()->subDays(7),
                'due_date'      => now()->addDays(7),
                'returned_at'   => null,
            ],
            // Kasna pozajmica (overdue)
            [
                'book_title'    => '1984',
                'borrower_name' => 'Jovana Lazić',
                'borrowed_at'   => now()->subDays(30),
                'due_date'      => now()->subDays(5),
                'returned_at'   => null,
            ],
            // Kasna pozajmica (overdue)
            [
                'book_title'    => 'Fondacija',
                'borrower_name' => 'Dragan Kovačević',
                'borrowed_at'   => now()->subDays(45),
                'due_date'      => now()->subDays(10),
                'returned_at'   => null,
            ],
            // Kasna pozajmica (overdue)
            [
                'book_title'    => 'Kratka istorija vremena',
                'borrower_name' => 'Maja Pešić',
                'borrowed_at'   => now()->subDays(40),
                'due_date'      => now()->subDays(20),
                'returned_at'   => null,
            ],
            // Kasna pozajmica (overdue)
            [
                'book_title'    => 'Ubistvo u Orijent ekspresu',
                'borrower_name' => 'Aleksandar Simić',
                'borrowed_at'   => now()->subDays(35),
                'due_date'      => now()->subDays(3),
                'returned_at'   => null,
            ],
        ];

        foreach ($borrowings as $item) {
            $book = Book::where('title', $item['book_title'])->firstOrFail();
            Borrowing::create([
                'book_id'       => $book->id,
                'borrower_name' => $item['borrower_name'],
                'borrowed_at'   => $item['borrowed_at'],
                'due_date'      => $item['due_date'],
                'returned_at'   => $item['returned_at'],
            ]);
        }
    }
}
