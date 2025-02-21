@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

        <img src="image/white.jpg" alt="" data-aos="fade-in">

        <div class="container d-flex flex-column align-items-center">
            <h2 data-aos="fade-up" data-aos-delay="100">Foto Anda.</h2>
            <p data-aos="fade-up" data-aos-delay="200">Gallery Foto.</p>
        </div>

    </section><!-- /Hero Section -->
    <div class="container">
        <style>
            .card {
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            }

            .card-img-top {
                border: none;
            }
        </style>

        <h1>Galeri Foto</h1>

        <div class="mb-3">
            <a href="{{ route('fotos.create') }}" class="btn btn-primary">Unggah Foto</a>
            <a href="{{ route('public') }}" class="btn btn-secondary">Lihat Foto Publik</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
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

        <form method="GET" action="{{ route('fotos.index') }}" class="mb-4 d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Cari foto..."
                value="{{ request('search') }}">

            <select name="visibility" class="form-select">
                <option value="">Semua</option>
                <option value="public" {{ request('visibility') == 'public' ? 'selected' : '' }}>Public</option>
                <option value="private" {{ request('visibility') == 'private' ? 'selected' : '' }}>Private</option>
            </select>

            <select name="sort" class="form-select">
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Terlama</option>
            </select>

            <button type="submit" class="btn btn-info">Filter</button>
        </form>

        <div class="row mt-4">
            @forelse ($fotos as $foto)
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <a href="{{ route('fotos.show', $foto->id) }}">
                            <img style="height: 200px; object-fit: cover;" src="{{ asset('storage/' . $foto->image) }}"
                                class="card-img-top" alt="{{ $foto->judul }}">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{{ $foto->judul }}</h5>
                            <small class="card-text">Deskripsi: {{ $foto->deskripsi }}</small><br>
                            <small class="text-muted">Album: {{ $foto->album->nama_album }}</small><br>
                            <small class="text-muted">Visibilitas: {{ ucfirst($foto->visibility) }}</small><br>
                            <small class="text-muted">Dibuat Pada: {{ $foto->created_at }}</small>

                            <div class="mt-2">
                                <a href="{{ route('fotos.show', $foto->id) }}" class="btn btn-sm btn-info">Lihat</a>

                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#albumModal-{{ $foto->id }}">
                                    Masukkan ke Album
                                </button>

                                <form action="{{ route('fotos.destroy', $foto->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="albumModal-{{ $foto->id }}" tabindex="-1"
                    aria-labelledby="albumModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Pilih Album</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('fotos.updateAlbum', $foto->id) }}" method="POST">
                                    @csrf
                                    <label for="album_id">Pilih Album:</label>
                                    <select name="album_id" class="form-select" required>
                                        <option value="">Pilih Album</option>
                                        @foreach ($albums as $album)
                                            <option value="{{ $album->id }}">{{ $album->nama_album }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                </form>
                            </div>
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

        <div class="mt-3 d-flex justify-content-center">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item {{ $fotos->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link"
                            href="{{ $fotos->previousPageUrl() }}&search={{ request('search') }}&visibility={{ request('visibility') }}&sort={{ request('sort') }}"
                            aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    @for ($page = 1; $page <= $fotos->lastPage(); $page++)
                        <li class="page-item {{ $fotos->currentPage() == $page ? 'active' : '' }}">
                            <a class="page-link"
                                href="{{ $fotos->url($page) }}&search={{ request('search') }}&visibility={{ request('visibility') }}&sort={{ request('sort') }}">
                                {{ $page }}
                            </a>
                        </li>
                    @endfor
                    <li class="page-item {{ $fotos->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link"
                            href="{{ $fotos->nextPageUrl() }}&search={{ request('search') }}&visibility={{ request('visibility') }}&sort={{ request('sort') }}"
                            aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

@endsection
