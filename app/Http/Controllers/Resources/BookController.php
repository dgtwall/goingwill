<?php

declare(strict_types=1);

namespace App\Http\Controllers\Resources;

use App\Http\Requests\Book\Store;
use App\Http\Resources\Book as BookResource;
use App\Models\Book;
use Baijunyao\LaravelRestful\Traits\Destroy;
use Baijunyao\LaravelRestful\Traits\ForceDelete;
use Baijunyao\LaravelRestful\Traits\Index;
use Baijunyao\LaravelRestful\Traits\Restore;
use Baijunyao\LaravelRestful\Traits\Show;

class BookController extends Controller
{
    use Index, Show, Destroy, Restore, ForceDelete;

    protected const FILTERS = [
        'title', 'markdown',
    ];

    protected const SORTS = [
        'created_at',
    ];

    public function store(Store $request)
    {
        $book = Book::create(
            $request->only('title', 'author', 'markdown')
        );

        return new BookResource($book);
    }

    public function update(Store $request)
    {
        $book = Book::find($request->route('book'));

        $result = $book->update(
            $request->only('title', 'author', 'markdown')
        );

        return new BookResource($book);
    }
}
