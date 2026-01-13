@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr><th>Buku</th><th>Status</th><th>Waktu</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @foreach($borrowings as $b)
                        <tr>
                            <td>{{ $b->book->title }}</td>
                            <td>{{ ucfirst($b->status) }}</td>
                            <td>
                                @if($b->borrow_date) <div>Dipinjam: {{ $b->borrow_date }}</div> @endif
                                @if($b->return_date) <div>Dikembalikan: {{ $b->return_date }}</div> @endif
                            </td>
                            <td>
                                @if($b->status === 'approved')
                                    <form method="POST" action="{{ url('borrowings/'.$b->id.'/return') }}" style="display:inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Kembalikan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <a href="/" class="btn btn-secondary">Kembali ke daftar buku</a>
        </div>
    </div>
@endsection
