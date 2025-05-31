<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index($bookId)
    {
        return Rating::where('book_id', $bookId)->get();
    }

    public function store(Request $request, $bookId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        return Rating::updateOrCreate(
            ['book_id' => $bookId, 'user_id' => auth()->id()],
            ['rating' => $request->rating]
        );
    }
}

