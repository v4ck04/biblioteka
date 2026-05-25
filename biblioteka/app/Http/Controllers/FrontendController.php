<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        $featuredBooks = Book::with('category')->latest()->take(8)->get();
        $categories    = Category::withCount('books')->orderBy('name')->get();
        $stats = [
            'books'      => Book::count(),
            'categories' => Category::count(),
            'available'  => Book::where('available_copies', '>', 0)->count(),
        ];

        return view('frontend.home', compact('featuredBooks', 'categories', 'stats'));
    }

    public function books(Request $request)
    {
        $query = Book::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('author', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('availability')) {
            if ($request->availability === 'available') {
                $query->where('available_copies', '>', 0);
            } elseif ($request->availability === 'unavailable') {
                $query->where('available_copies', 0);
            }
        }

        $books      = $query->orderBy('title')->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('frontend.books', compact('books', 'categories'));
    }

    public function show(Book $book)
    {
        $book->load('category');
        $relatedBooks = Book::with('category')
            ->where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->take(4)
            ->get();

        return view('frontend.show', compact('book', 'relatedBooks'));
    }
}
