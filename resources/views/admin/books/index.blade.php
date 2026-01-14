@extends('layouts.app')

@section('title', 'Kelola Buku')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <a href="/admin/books/create" class="btn btn-primary">Tambah Buku</a>
            <form method="GET" action="/admin/books" class="form-inline" style="max-width:360px">
                <div class="input-group">
                    <input type="text" name="q" value="{{ request()->get('q') }}" class="form-control form-control-sm" placeholder="Cari judul atau author">
                    <div class="input-group-append">
                        <button class="btn btn-sm btn-secondary" type="submit">Cari</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr><th>ID</th><th>Judul</th><th>Author</th><th>Stock</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                        <tr>
                            <td>{{ $book->id }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->stock }}</td>
                            <td>
                                <a href="/admin/books/{{ $book->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
                                <form method="POST" action="/admin/books/{{ $book->id }}/delete" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
