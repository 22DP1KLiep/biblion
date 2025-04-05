<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
