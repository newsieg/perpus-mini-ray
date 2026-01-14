@extends('layouts.app')

@section('title', 'Peminjaman Masuk')

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
                        <th>Aksi</th>
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
                            <td>
                                @if($b->status === 'pending')
                                    <form method="POST" action="{{ url('admin/borrowings/'.$b->id.'/approve') }}" style="display:inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                                    </form>
                                    <form method="POST" action="{{ url('admin/borrowings/'.$b->id.'/reject') }}" style="display:inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                                    </form>
                                @elseif($b->status === 'approved')
                                    <form method="POST" action="{{ url('admin/borrowings/'.$b->id.'/return') }}" style="display:inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary">Tandai Dikembalikan</button>
                                    </form>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
