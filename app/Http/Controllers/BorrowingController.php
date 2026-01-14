<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function store(Request $request, $bookId)
    {
        $user = Auth::user();
        $book = Book::findOrFail($bookId);

        Borrowing::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrow_date' => now(),
            'status' => 'pending',
        ]);

        return redirect()->back()->with('status', 'Permintaan pinjam dikirim. Menunggu konfirmasi admin.');
    }

    public function history()
    {
        $user = Auth::user();
        $borrowings = Borrowing::with('book')->where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return view('borrowings.history', compact('borrowings'));
    }

    public function markReturn($id)
    {
        $user = Auth::user();
        $borrowing = Borrowing::findOrFail($id);
        if ($borrowing->user_id !== $user->id) {
            abort(403);
        }
        if ($borrowing->status !== 'approved') {
            return redirect()->back()->with('status', 'Hanya peminjaman aktif yang dapat dikembalikan.');
        }

        $borrowing->update(['status' => 'returned', 'return_date' => now()]);
        $borrowing->book->increment('stock');

        return redirect()->back()->with('status', 'Buku berhasil dikembalikan.');
    }
}
