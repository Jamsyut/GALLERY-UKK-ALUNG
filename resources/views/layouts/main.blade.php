<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div >

        <header id="header" class="header d-flex align-items-center fixed-top">
            <div class="container-fluid container-xl position-relative d-flex align-items-center">

              <a href="index.html" class="logo d-flex align-items-center me-auto">
                <h1 class="sitename">Gallery</h1>
              </a>

              <nav id="navmenu" class="navmenu">
              <ul >
                                @auth
                                    <li class="nav-item">
                                        <a href="{{ route('albums.index') }}" class="nav-link text-gray-700">Albums</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('fotos.index') }}" class="nav-link text-gray-700">Photos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('profile.edit') }}" class="nav-link text-gray-700">Profile</a>
                                    </li>
                                    <li class="nav-item">
                                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-link nav-link text-gray-700">Logout</button>
                                        </form>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a href="{{ route('login') }}" class="nav-link text-gray-700">Masuk</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('register') }}" class="nav-link text-gray-700">Daftar</a>
                                    </li>
                                @endauth
                            </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
              </nav>

            </div>
          </header>
    </div>

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 5000);
    </script>
</body>

</html>
