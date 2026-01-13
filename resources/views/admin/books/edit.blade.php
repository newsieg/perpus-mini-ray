@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Buku</h3>
        </div>
        <form method="POST" action="/admin/books/{{ $book->id }}/update">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="title">Judul</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                        </div>
                        <input id="title" name="title" class="form-control" value="{{ $book->title }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="author">Author</label>
                    <input id="author" name="author" class="form-control" value="{{ $book->author }}">
                </div>

                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input id="stock" type="number" name="stock" class="form-control" value="{{ $book->stock }}">
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="/admin/books" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
