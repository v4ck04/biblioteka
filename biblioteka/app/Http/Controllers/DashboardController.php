<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        $totalCategories = Category::count();
        $activeBorrowings = Borrowing::whereNull('returned_at')->count();
        $overdueBorrowings = Borrowing::whereNull('returned_at')
            ->whereDate('due_date', '<', today())
            ->count();

        $recentBorrowings = Borrowing::with('book')
            ->whereNull('returned_at')
            ->orderBy('due_date')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'totalBooks',
            'totalCategories',
            'activeBorrowings',
            'overdueBorrowings',
            'recentBorrowings'
        ));
    }
}
