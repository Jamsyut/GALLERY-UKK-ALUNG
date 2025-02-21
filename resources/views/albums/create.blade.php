@extends('layouts.app')

@section('content')
<section class="hero-section text-dark d-flex align-items-center bg-secondary mb-4 ">
    <div class="container">
        <div class="row align-items-center">
            <div class="">
                <h1 class="display-4 fw-bold mt-4 mb-4 text-center text-white">Tambahkan Album Baru.</h1>

            </div>
        </div>
    </div>
</section>
<div class="container">
    <style>
        .form-control {
            border: 1px solid black;
        }
        .card {
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }
    </style>
    <h1 class="mb-4">Tambah Album Baru</h1>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

    <div>
        <div>
            <form action="{{ route('albums.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nama_album" class="form-label">Nama Album</label>
                    <input type="text" name="nama_album" id="nama_album" class="form-control" value="{{ old('nama_album') }}" required>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control" required>{{ old('deskripsi') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('albums.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
