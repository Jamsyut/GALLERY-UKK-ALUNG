@extends('layouts.app')

@section('content')

<section class="hero-section text-dark d-flex align-items-center bg-secondary mb-4 ">
    <div class="container">
        <div class="row align-items-center">
            <div class="">
                <h1 class="display-4 fw-bold mt-4 mb-4 text-center text-white">Tambahkan Foto Baru.</h1>

            </div>
        </div>
    </div>
</section>
<div class="container">
    <style>
        .form-control {
            border: 1px solid black;
        }
        .form-select {
            border: 1px solid black;
        }
    </style>



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

    <form action="{{ route('fotos.store') }}" method="POST" enctype="multipart/form-data" >
        @csrf

        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul') }}" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control" required>{{ old('deskripsi') }}</textarea>
        </div>

        <div class="row">
            <div class="col">

                <div class="mb-3">
                    <label for="visibility" class="form-label">Visibility</label>
                    <select name="visibility" id="visibility" class="form-select" required>
                        <option selected>Pilih Visibilitas</option>
                        <option value="public" {{ old('visibility') == 'public' ? 'selected' : '' }}>Public</option>
                        <option value="private" {{ old('visibility') == 'private' ? 'selected' : '' }}>Private</option>
                    </select>
                </div>
            </div>

            <div class="col">


                        <div class="mb-3">
                            <label for="album" class="form-label">Album</label>

                            <select name="album_id" id="album_id" class="form-select">
                                <option value>Pilih Album (Opsional)</option>
                                @foreach ($albums as $album)
                                    <option value="{{ $album->id }}" {{ old('album_id') == $album->id ? 'selected' : '' }}>
                                        {{ $album->nama_album }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
            </div>
        </div>


        <div class="mb-3">
            <label for="image" class="form-label">Gambar</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
