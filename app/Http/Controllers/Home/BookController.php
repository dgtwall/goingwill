<?php

declare(strict_types=1);

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index()
    {
        $books   = Book::orderBy('created_at', 'desc')->paginate(10);
        $assign  = [
            'books'        => $books,
            'title'        => translate('Book'),
        ];

        return view('home.index.book', $assign);
    }


    public function show(Book $book, Request $request)
    {
        $prev = Book::select('id', 'title')
            ->orderBy('created_at', 'desc')
            ->where('id', '<', $book->id)
            ->limit(1)
            ->first();

        $next = Book::select('id', 'title')
            ->orderBy('created_at', 'asc')
            ->where('id', '>', $book->id)
            ->limit(1)
            ->first();

        /** @var \App\Models\SocialiteUser|null $socialiteUser */
        $socialiteUser = auth()->guard('socialite')->user();

        if ($socialiteUser === null) {
            $is_liked = false;
        } else {
            $is_liked = $socialiteUser->hasLiked($book);
        }

        $likes       = $book->likers()->get();
        $assign      = compact('book', 'prev', 'next', 'is_liked', 'likes');

        return view('home.index.bookShow', $assign);
    }
}
