<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\Store;
use App\Models\Book;
use App\Models\Config;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class BookController extends Controller
{
    public function index(Request $request, Book $bookModel)
    {
        $wd = trim($request->input('wd', ''));

        $books = Book::orderBy('created_at', 'desc')
            ->when($wd !== '', function ($query) use ($wd) {
                return $query->whereIn('id', Book::getIdsGivenSearchWord($wd));
            })
            ->withTrashed()
            ->paginate(15);
        $assign = compact('books');

        return view('admin.book.index', $assign);
    }

    public function create()
    {
        $author   = Config::where('name', 'AUTHOR')->value('value');
        $assign   = compact('author');

        return view('admin.book.create', $assign);
    }

    public function store(Store $request)
    {
        $book = $request->except('_token');

        Book::create($book);

        return redirect(url('admin/book/index'));
    }

    public function edit($id)
    {
        $book  = Book::withTrashed()->find($id);
        $book->toArray();

        return view('admin.book.edit', compact('book'));
    }

    public function update(Store $request, $id)
    {
        $book = $request->except('_token');

        $result = Book::withTrashed()->find($id)->update($book);

        return redirect()->back();
    }

    public function destroy($id)
    {
        Book::destroy($id);

        return redirect()->back();
    }

    public function restore($id)
    {
        Book::onlyTrashed()->find($id)->restore();

        return redirect()->back();
    }

    public function forceDelete($id)
    {
        Book::onlyTrashed()->find($id)->forceDelete();

        return redirect()->back();
    }
}
