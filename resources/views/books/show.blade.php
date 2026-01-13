@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $book->title }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Penulis:</strong> {{ $book->author ?? '-' }}</p>
            <p><strong>Stok:</strong> {{ $book->stock }}</p>

            @auth
                @if(auth()->user()->role !== 'admin')
                    @if($book->stock > 0)
                        <form method="POST" action="{{ url('borrow/'.$book->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-success">Pinjam</button>
                        </form>
                    @else
                        <span class="text-muted">Stok kosong</span>
                    @endif
                @else
                    <div class="alert alert-info">Admin tidak dapat meminjam buku.</div>
                @endif
            @else
                <p><a href="/login">Login untuk meminjam</a></p>
            @endauth
        </div>
        <div class="card-footer">
            <a href="/" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
