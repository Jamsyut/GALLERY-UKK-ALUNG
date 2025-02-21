@extends('layouts.app')

@section('content')
<section class="hero-section text-dark d-flex align-items-center bg-secondary mb-4 ">
    <div class="container">
        <div class="row align-items-center">
            <div class="">
                <h1 class="display-4 fw-bold mt-4 mb-4 text-center text-white">Gallery.</h1>

            </div>
        </div>
    </div>
</section>
<div class="container">

    <div class="row mt-2">
        <div class="col-md-6">
            <div class="card">
                <div class="card-img-top text-center" style="max-height: 100%; overflow: hidden;">
                    <img src="{{ asset('storage/' . $fotos->image) }}" class="img-fluid" alt="{{ $fotos->judul }}">
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $fotos->judul }}</h5>

                    <div class="d-flex align-items-center">
                        <button class="btn btn-like"
                                data-id="{{ $fotos->id }}"
                                style="background: none; border: none;"
                                @guest disabled @endguest>
                            <i class="fa fa-heart {{ $fotos->isLikedByUser(auth()->id()) ? 'text-danger' : 'text-secondary' }}"></i>
                        </button>
                        <span class="like-count ms-2">{{ $fotos->activeLikes()->count() }}</span> Likes
                    </div>

                    <p class="card-text">{{ $fotos->deskripsi }}</p>
                    <a href="{{ route('public') }}" class="btn btn-primary">Kembali ke Galeri</a>
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Komentar</h4>
                    <select id="sortKomentar" class="form-select w-auto">
                        <option value="terbaru" selected>Terbaru</option>
                        <option value="terlama">Terlama</option>
                    </select>
                </div>
                <div class="card-body">
                    @auth
                        <form action="{{ route('fotos.komentar.store', $fotos->id) }}" method="POST" class="mb-3">
                            @csrf
                            <div class="form-group">
                                <textarea name="komentar" class="form-control" rows="3" placeholder="Tambahkan komentar..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success mt-2">Kirim</button>
                        </form>
                    @else
                        <p><a href="{{ route('login') }}">Login</a> untuk menambahkan komentar.</p>
                    @endauth


                    <div class="comments-section" style="max-height: 500px; overflow-y: auto;">
                        @forelse($fotos->komentars->sortByDesc('created_at') as $komentar)
                            <div class="comment mb-3 p-2 border rounded" data-id="{{ $komentar->id }}">
                                <strong>{{ $komentar->user->name }}</strong>
                                <p>{{ $komentar->komentar }}</p>
                                <small class="text-muted">{{ $komentar->created_at->diffForHumans() }}</small>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="bg-info p-2 text-dark bg-opacity-25">
                                    Belum ada komentar.
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
$(document).ready(function() {
    // Sorting komentar
    $('#sortKomentar').change(function() {
        let sortType = $(this).val();
        let comments = $('.comments-section .comment');

        if (sortType === 'terbaru') {
            comments.sort((a, b) => $(b).data('id') - $(a).data('id'));
        } else {
            comments.sort((a, b) => $(a).data('id') - $(b).data('id'));
        }

        $('.comments-section').html(comments);
    });


    $('.btn-like').click(function(e) {
        e.preventDefault();

        if ($(this).prop('disabled')) {
            return;
        }

        const button = $(this);
        const fotoId = button.data('id');
        const csrfToken = '{{ csrf_token() }}';

        button.prop('disabled', true);

        $.ajax({
            url: "{{ route('likes.toggle') }}",
            type: 'POST',
            data: {
                foto_id: fotoId,
                _token: csrfToken
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
