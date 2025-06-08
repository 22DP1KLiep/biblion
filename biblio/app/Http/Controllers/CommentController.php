<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($bookId)
    {
        return Comment::with('user')->where('book_id', $bookId)->latest()->get();
    }

    public function store(Request $request, $bookId)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        return Comment::create([
            'book_id' => $bookId,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);
    }

    public function destroy($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        // Ja nav īpašnieks un nav admin
        if ($comment->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $comment->delete();
        return response()->noContent();
    }


}

