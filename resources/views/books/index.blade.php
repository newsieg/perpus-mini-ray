@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ url('/books') }}" class="form-inline">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Cari judul..." value="{{ request('q') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Cari</button>
                        @if(request('q')) <a href="/books" class="btn btn-outline-danger">Reset</a> @endif
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($books as $book)
                    <div class="col-sm-6 col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ $book->title }}</h5>
                                <p class="card-text">{{ $book->author ?? '-' }}</p>
                                <p class="card-text"><small class="text-muted">Stok: {{ $book->stock }}</small></p>
                                <a href="/books/{{ $book->id }}" class="btn btn-sm btn-primary">Lihat</a>
                                @auth
                                    @if(auth()->user()->role !== 'admin')
                                        <form method="POST" action="{{ url('borrow/'.$book->id) }}" style="display:inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Pinjam</button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
