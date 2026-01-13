<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();
        $borrowings = Borrowing::with('user', 'book')
            ->whereIn('status', ['pending', 'approved'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.borrowings.index', compact('borrowings'));
    }

    public function history()
    {
        $this->authorizeAdmin();
        $borrowings = Borrowing::with('user', 'book')
            ->where('status', 'returned')
            ->orderBy('return_date', 'desc')
            ->get();

        return view('admin.borrowings.history', compact('borrowings'));
    }

    public function approve($id)
    {
        $this->authorizeAdmin();
        $borrowing = Borrowing::findOrFail($id);
        if ($borrowing->status !== 'pending') {
            return redirect()->back()->with('status', 'Transaksi sudah diproses.');
        }

        $book = $borrowing->book;
        if ($book->stock < 1) {
            $borrowing->update(['status' => 'rejected']);
            return redirect()->back()->with('status', 'Stok tidak mencukupi, permintaan ditolak.');
        }

        $book->decrement('stock');
        $borrowing->update(['status' => 'approved', 'borrow_date' => now()]);

        return redirect()->back()->with('status', 'Permintaan disetujui.');
    }

    public function reject($id)
    {
        $this->authorizeAdmin();
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->update(['status' => 'rejected']);
        return redirect()->back()->with('status', 'Permintaan ditolak.');
    }

    public function markReturned($id)
    {
        $this->authorizeAdmin();
        $borrowing = Borrowing::findOrFail($id);
        if ($borrowing->status !== 'approved') {
            return redirect()->back()->with('status', 'Hanya transaksi aktif yang bisa dikembalikan.');
        }

        $borrowing->update(['status' => 'returned', 'return_date' => now()]);
        $borrowing->book->increment('stock');

        return redirect()->back()->with('status', 'Buku ditandai sebagai dikembalikan.');
    }

    protected function authorizeAdmin()
    {
        $user = Auth::user();
        if (! $user || $user->role !== 'admin') {
            abort(403);
        }
    }
}
