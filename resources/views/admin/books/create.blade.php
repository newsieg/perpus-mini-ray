@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Form Tambah Buku</h3>
        </div>
        <form method="POST" action="/admin/books">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="title">Judul</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                        </div>
                        <input id="title" name="title" class="form-control" placeholder="Masukkan judul" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="author">Author</label>
                    <input id="author" name="author" class="form-control" placeholder="Nama penulis">
                </div>

                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input id="stock" type="number" name="stock" class="form-control" value="0">
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="/admin/books" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
