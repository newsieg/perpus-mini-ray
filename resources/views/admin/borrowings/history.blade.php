@extends('layouts.app')

@section('title', 'Riwayat Peminjaman (Selesai)')

@section('content')
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Buku</th>
                        <th>Status</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($borrowings as $b)
                        <tr>
                            <td>{{ $b->id }}</td>
                            <td>{{ $b->user->name }}<br><small class="text-muted">{{ $b->user->email }}</small></td>
                            <td>{{ $b->book->title }}</td>
                            <td>{{ ucfirst($b->status) }}</td>
                            <td>
                                @if($b->borrow_date) <div>Dipinjam: {{ $b->borrow_date }}</div> @endif
                                @if($b->return_date) <div>Dikembalikan: {{ $b->return_date }}</div> @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
