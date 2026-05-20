<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with('book.category')
            ->whereNull('returned_at')
            ->orderBy('due_date')
            ->paginate(20);

        return view('borrowings.index', compact('borrowings'));
    }

    public function all(Request $request)
    {
        $query = Borrowing::with('book.category');

        if ($request->filled('book_id')) {
            $query->where('book_id', $request->book_id);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->whereNull('returned_at');
            } elseif ($request->status === 'returned') {
                $query->whereNotNull('returned_at');
            }
        }

        if ($request->filled('date_from')) {
            $query->whereDate('borrowed_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('borrowed_at', '<=', $request->date_to);
        }

        $borrowings = $query->orderByDesc('borrowed_at')->paginate(20)->withQueryString();
        $books = Book::orderBy('title')->get();

        return view('borrowings.all', compact('borrowings', 'books'));
    }

    public function overdue()
    {
        $borrowings = Borrowing::with('book.category')
            ->whereNull('returned_at')
            ->whereDate('due_date', '<', today())
            ->orderBy('due_date')
            ->paginate(20);

        return view('borrowings.overdue', compact('borrowings'));
    }

    public function create()
    {
        $books = Book::where('available_copies', '>', 0)
            ->with('category')
            ->orderBy('title')
            ->get();

        return view('borrowings.create', compact('books'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'book_id'       => ['required', 'exists:books,id'],
            'borrower_name' => ['required', 'string', 'max:255'],
            'borrowed_at'   => ['required', 'date'],
            'due_date'      => ['required', 'date', 'gte:borrowed_at'],
        ]);

        $book = Book::findOrFail($data['book_id']);

        if ($book->available_copies < 1) {
            return back()->withErrors(['book_id' => 'Odabrana knjiga nema dostupnih primeraka.'])->withInput();
        }

        Borrowing::create($data);
        $book->decrement('available_copies');

        return redirect()->route('admin.borrowings.index')
            ->with('success', 'Pozajmica je uspješno kreirana.');
    }

    public function markReturned(Borrowing $borrowing)
    {
        if ($borrowing->isReturned()) {
            return back()->with('error', 'Ova pozajmica je već vraćena.');
        }

        $borrowing->update(['returned_at' => today()]);
        $borrowing->book->increment('available_copies');

        return back()->with('success', 'Knjiga je označena kao vraćena.');
    }
}
