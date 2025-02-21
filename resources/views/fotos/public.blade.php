@extends('layouts.app')

@section('content')
<section class="hero-section text-dark d-flex align-items-center bg-secondary mb-4 ">
    <div class="container">
        <div class="row align-items-center">
            <div class="">
                <h1 class="display-4 fw-bold mt-4 mb-4 text-center text-white">Gallery Public.</h1>

            </div>
        </div>
    </div>
</section>
    <div class="container">
        <style>
            .card-img-top {
                border: none;
            }
        </style>
        <h1>Galeri Foto Publik</h1>

        <form method="GET" action="{{ route('public') }}" class="mb-3 d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari foto..."
                value="{{ request('search') }}">
            <select name="sort" class="form-select me-2">
                <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                <option value="like_terbanyak" {{ request('sort') == 'like_terbanyak' ? 'selected' : '' }}>Like Terbanyak
                </option>
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <div class="row mt-4">
            @forelse ($fotos as $foto)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <a href="{{ route('fotos.show', $foto->id) }}">
                            <img style="height: 200px; object-fit: cover;" src="{{ asset('storage/' . $foto->image) }}"
                                class="card-img-top" alt="{{ $foto->judul }}">
                        </a>
                        <div class="card-body">
                            <p class="card-text"><small class="text-muted">Di unggah oleh : {{ $foto->user->name }}</small>
                            </p>
                            <h5 class="card-title">{{ $foto->judul }}</h5>
                            <p class="card-text">{{ $foto->deskripsi }}</p>

                            <div class="d-flex align-items-center">
                                <button class="btn btn-like" data-id="{{ $foto->id }}"
                                    style="background: none; border: none;" @guest disabled @endguest>
                                    <i
                                        class="fa fa-heart {{ $foto->isLikedByUser(auth()->id()) ? 'text-danger' : 'text-secondary' }}"></i>
                                </button>
                                <span class="like-count ms-2">{{ $foto->activeLikes()->count() }}</span> Likes
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <div class="bg-info p-2 text-dark bg-opacity-25">
                        Belum ada foto publik yang tersedia.
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


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.btn-like').click(function(e) {
                e.preventDefault();

                if ($(this).prop('disabled')) {
                    return;
                }

                const button = $(this);
                const fotoId = button.data('id');

                button.prop('disabled', true);

                $.ajax({
                    url: "{{ route('likes.toggle') }}",
                    type: 'POST',
                    data: {
                        foto_id: fotoId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        const icon = button.find('i');
                        const likeCount = button.siblings('.like-count');

                        if (response.status === 'liked') {
                            icon.removeClass('text-secondary').addClass('text-danger');
                        } else {
                            icon.removeClass('text-danger').addClass('text-secondary');
                        }

                        likeCount.text(response.likeCount);
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr);
                        if (xhr.status === 401) {
                            alert('Silakan login terlebih dahulu untuk menyukai foto');
                        } else {
                            alert('Terjadi kesalahan saat memproses like');
                        }
                    },
                    complete: function() {

                        button.prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endsection
