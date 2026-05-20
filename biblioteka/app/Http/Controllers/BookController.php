<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
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

        $books = $query->orderBy('title')->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('books.index', compact('books', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'author'           => ['required', 'string', 'max:255'],
            'category_id'      => ['required', 'exists:categories,id'],
            'total_copies'     => ['required', 'integer', 'min:0'],
            'available_copies' => ['required', 'integer', 'min:0', 'lte:total_copies'],
        ]);

        Book::create($data);

        return redirect()->route('admin.books.index')
            ->with('success', 'Knjiga je uspješno kreirana.');
    }

    public function show(Book $book)
    {
        $book->load('category');
        $borrowings = $book->borrowings()->with('book')->orderByDesc('borrowed_at')->paginate(10);

        return view('books.show', compact('book', 'borrowings'));
    }

    public function edit(Book $book)
    {
        $categories = Category::orderBy('name')->get();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $activeBorrowed = $book->activeBorrowingsCount();

        $data = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'author'           => ['required', 'string', 'max:255'],
            'category_id'      => ['required', 'exists:categories,id'],
            'total_copies'     => ['required', 'integer', 'min:' . $activeBorrowed],
            'available_copies' => ['required', 'integer', 'min:0', 'lte:total_copies'],
        ], [
            'total_copies.min' => "Ukupan broj primeraka ne može biti manji od broja aktivnih pozajmica ({$activeBorrowed}).",
        ]);

        $book->update($data);

        return redirect()->route('admin.books.index')
            ->with('success', 'Knjiga je uspješno ažurirana.');
    }

    public function destroy(Book $book)
    {
        if ($book->activeBorrowingsCount() > 0) {
            return back()->with('error', 'Nije moguće obrisati knjigu koja ima aktivne pozajmice.');
        }

        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Knjiga je obrisana.');
    }
}
