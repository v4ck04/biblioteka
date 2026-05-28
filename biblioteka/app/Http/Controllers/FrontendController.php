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
        $heroBooks     = Book::with('category')->latest()->take(3)->get();
        $popularBooks  = Book::withCount('borrowings')->with('category')
                             ->orderByDesc('borrowings_count')->take(6)->get();
        $categories    = Category::withCount('books')->orderBy('name')->get();
        $stats = [
            'books'      => Book::count(),
            'categories' => Category::count(),
            'available'  => Book::where('available_copies', '>', 0)->count(),
        ];

        return view('frontend.home', compact(
            'featuredBooks', 'heroBooks', 'popularBooks', 'categories', 'stats'
        ));
    }

    public function catalog(Request $request)
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

        if ($request->boolean('dostupne')) {
            $query->where('available_copies', '>', 0);
        }

        $sort = $request->get('sort', 'naslov');
        match ($sort) {
            'autor'    => $query->orderBy('author'),
            'najnovije' => $query->orderByDesc('id'),
            default    => $query->orderBy('title'),
        };

        $books      = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('frontend.books', compact('books', 'categories', 'sort'));
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

    public function confirmation()
    {
        $data = session('request_confirmation');

        if (! $data) {
            return redirect()->route('home');
        }

        return view('frontend.confirmation', compact('data'));
    }
}
