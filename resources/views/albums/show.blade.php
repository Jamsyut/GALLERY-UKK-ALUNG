@extends('layouts.app')

@section('content')
<section class="hero-section text-dark d-flex align-items-center bg-secondary mb-4 ">
    <div class="container">
        <div class="row align-items-center">
            <div class="">
                <h1 class="display-4 fw-bold mt-4 mb-4 text-center text-white">Foto Album.</h1>

            </div>
        </div>
    </div>
</section>
<div class="container">
    <style>
        .card {
            border: none;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }
    </style>
        <div class="mb-1 mt-3">
            <div class="row ">
                <div class="col-6">
                    <h3>{{ $album->nama_album }}</h3>
                </div>
                <div class="col d-flex justify-content-end d-grid gap-2">
                    <a href="{{route('fotos.index')}}" class="btn btn-info mr-1 text-white" >Foto Anda</a>
                    <a href="{{route('albums.index')}}" class="btn btn-secondary ">Kembali ke album</a>

                </div>
            </div>

        </div>
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close mt-3" data-bs-dismiss="alert" aria-label="Close"></button>
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



    <div class="row mt-3">

            @forelse ($album->fotos as $foto)
                <div class="col-md-3">
                    <div class="card">
                        <a href="{{ route('fotos.show', $foto->id) }}">
                            <img style="height: 200px; object-fit: cover;" src="{{ asset('storage/' . $foto->image) }}" class="card-img-top" alt="{{ $foto->judul }}">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{{ $foto->judul }}</h5>
                            <p class="card-text">{{ $foto->deskripsi }}</p>
                            <form action="{{ route('albums.removePhoto', ['album' => $album->id, 'foto' => $foto->id]) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini dari album?');">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Hapus dari Album</button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <div class="bg-info p-2 text-dark bg-opacity-25">
                        Belum ada foto.
                    </div>
                </div>
            @endforelse

    </div>
</div>
@endsection
