<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
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

    public function dashboard()
    {
        $this->authorizeAdmin();

        $totalBooks = Book::count();
        $activeBorrowings = Borrowing::where('status', 'approved')->count();
        $historyCount = Borrowing::count();

        return view('admin.dashboard', compact('totalBooks', 'activeBorrowings', 'historyCount'));
    }

    public function dashboardData(Request $request)
    {
        $this->authorizeAdmin();
        $interval = $request->get('interval', 'day');

        $labels = [];
        $data = [];

        if ($interval === 'day') {
            $days = 30;
            for ($i = $days - 1; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i);
                $labels[] = $date->format('d M');
                $data[] = Borrowing::whereDate('created_at', $date->toDateString())->count();
            }
        } elseif ($interval === 'week') {
            $weeks = 12;
            for ($i = $weeks - 1; $i >= 0; $i--) {
                $start = Carbon::today()->startOfWeek()->subWeeks($i);
                $end = (clone $start)->endOfWeek();
                $labels[] = $start->format('d M') . ' - ' . $end->format('d M');
                $data[] = Borrowing::whereBetween('created_at', [$start->startOfDay(), $end->endOfDay()])->count();
            }
        } elseif ($interval === 'month') {
            $months = 12;
            for ($i = $months - 1; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $labels[] = $date->format('M Y');
                $start = $date->copy()->startOfMonth();
                $end = $date->copy()->endOfMonth();
                $data[] = Borrowing::whereBetween('created_at', [$start->startOfDay(), $end->endOfDay()])->count();
            }
        } else { // year
            $years = 5;
            for ($i = $years - 1; $i >= 0; $i--) {
                $year = Carbon::now()->subYears($i)->year;
                $labels[] = (string)$year;
                $start = Carbon::create($year, 1, 1)->startOfYear();
                $end = Carbon::create($year, 12, 31)->endOfYear();
                $data[] = Borrowing::whereBetween('created_at', [$start->startOfDay(), $end->endOfDay()])->count();
            }
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
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
