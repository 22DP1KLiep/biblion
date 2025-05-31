<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Book;


class BookController extends Controller
{
    /**
     * Get all books.
     */
    public function index()
    {
        $books = Book::limit(10)->get();

        return response()->json($books);
    }

    public function get_all()
    {
        return response()->json(Book::all());
    }


    public function show($id)
    {
        $book = Book::findOrFail($id);
        return response()->json($book);
    }


}

class FeedbackController extends Controller
{
    public function index($bookId)
    {
        $feedback = Feedback::where('book_id', $bookId)
            ->orderByDesc('created_at')
            ->get(['comment', 'rating']);

        return response()->json($feedback);
    }

    public function store(Request $request, $bookId)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $feedback = Feedback::create([
            'book_id' => $bookId,
            'comment' => $request->input('comment'),
            'rating' => $request->input('rating'),
        ]);

        return response()->json(['message' => 'Feedback submitted!'], 201);
    }
}
