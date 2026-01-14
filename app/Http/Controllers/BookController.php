<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index()
    {
        $q = request()->query('q');
        if ($q) {
            $books = Book::where('title', 'like', '%'.$q.'%')
                ->orWhere('author', 'like', '%'.$q.'%')
                ->get();
        } else {
            $books = Book::all();
        }
        return view('books.index', compact('books'));
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        return view('books.show', compact('book'));
    }

    // Admin: manage books
    public function create()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') abort(403);
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') abort(403);
        $data = $request->validate([
            'title' => 'required|string',
            'author' => 'nullable|string',
            'stock' => 'required|integer|min:0',
        ]);
        Book::create($data);
        return redirect('/admin/books');
    }

    public function edit($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') abort(403);
        $book = Book::findOrFail($id);
        return view('admin.books.edit', compact('book'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') abort(403);
        $book = Book::findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string',
            'author' => 'nullable|string',
            'stock' => 'required|integer|min:0',
        ]);
        $book->update($data);
        return redirect('/admin/books');
    }

    public function destroy($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') abort(403);
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect('/admin/books');
    }
}
