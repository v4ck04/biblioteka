<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequestRequest;
use App\Models\Book;
use App\Models\BookRequest;

class BookRequestController extends Controller
{
    // ─── Public ──────────────────────────────────────

    public function create(Book $book)
    {
        if ($book->available_copies <= 0) {
            return redirect()->route('knjiga.show', $book)
                ->with('error', 'Ova knjiga trenutno nije dostupna za pozajmicu.');
        }

        return view('frontend.request', compact('book'));
    }

    public function store(StoreBookRequestRequest $request, Book $book)
    {
        if ($book->available_copies <= 0) {
            return redirect()->route('knjiga.show', $book)
                ->with('error', 'Ova knjiga trenutno nije dostupna za pozajmicu.');
        }

        $bookRequest = BookRequest::create([
            'book_id'     => $book->id,
            'reader_name' => $request->reader_name,
            'contact'     => $request->contact,
            'notes'       => $request->notes,
            'status'      => 'na čekanju',
        ]);

        session()->flash('request_confirmation', [
            'ref'         => 'BIB-' . str_pad($bookRequest->id, 5, '0', STR_PAD_LEFT),
            'book_title'  => $book->title,
            'book_author' => $book->author,
            'reader_name' => $bookRequest->reader_name,
            'contact'     => $bookRequest->contact,
        ]);

        return redirect()->route('requests.confirmation');
    }

    // ─── Admin ───────────────────────────────────────

    public function adminIndex()
    {
        $requests = BookRequest::with('book.category')
            ->latest()
            ->paginate(20);

        $counts = [
            'pending'  => BookRequest::where('status', 'na čekanju')->count(),
            'approved' => BookRequest::where('status', 'odobreno')->count(),
            'rejected' => BookRequest::where('status', 'odbijeno')->count(),
        ];

        return view('requests.index', compact('requests', 'counts'));
    }

    public function adminUpdate(BookRequest $bookRequest, \Illuminate\Http\Request $request)
    {
        $request->validate([
            'status' => ['required', 'in:na čekanju,odobreno,odbijeno'],
        ]);

        $bookRequest->update(['status' => $request->status]);

        return back()->with('success', 'Status zahteva je ažuriran.');
    }
}
