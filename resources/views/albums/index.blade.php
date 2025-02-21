@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

        <img src="image/hero.jpg" alt="" data-aos="fade-in">

        <div class="container d-flex flex-column align-items-center">
          <h2 data-aos="fade-up" data-aos-delay="100">Album Anda.</h2>
          <p data-aos="fade-up" data-aos-delay="200">Gallery Foto.</p>
        </div>

      </section><!-- /Hero Section -->

    <div class="container" >
        <style>
            .card {
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            }
            .alt {
                text-align: center;
                margin-top: 100px;
            }
        </style>


        <div class="mb-3">
            <a href="{{ route('albums.create') }}" class="btn btn-primary  mt-3">Buat Album</a>
        </div>

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



        <div class="row">
            @forelse ($albums as $album)
                <div class="col-md-4 mt-4">
                    <div class="card">
                        @php
                            $thumbnail = $album->fotos->first();
                        @endphp
                        <a href="{{route('albums.show', $album->id)}}">
                        <img style="height: 200px; object-fit: cover;" src="{{ $thumbnail ? asset('storage/' . $thumbnail->image) : 'https://via.placeholder.com/150' }}"
                             class="card-img-top"
                             alt="masukkkan foto terlebih dahulu agar menjadi thumbnail">
                            </a>
                        <div class="card-body">
                            <h5 class="card-title">{{ $album->nama_album }}</h5>
                            <p class="card-text">{{ $album->deskripsi }}</p>
                            <a href="{{ route('albums.show', $album->id) }}" class="btn btn-info">Lihat</a>

                            <form action="{{ route('albums.destroy', $album->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus album ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 mt-5 text-center">
                    <div class="bg-info p-2 text-dark bg-opacity-25">
                        Album belum ada.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
