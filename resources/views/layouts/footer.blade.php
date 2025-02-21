
<footer id="footer" class="footer white-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">Gallery</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Banyuwangi</p>
            <p>Sempu, Jambewangi</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+62 88888888888</span></p>
            <p><strong>Email:</strong> <span>info@gmail.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Link</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="{{route('albums.index')}}">Album</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="{{route('fotos.index')}}">Foto</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="{{route('public')}}">Foto Public</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="{{route('profile.edit')}}">Profile</a></li>

          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Layanan Kami</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Service 1</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Service 2</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Service 3</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Service 4</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Service 5</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12 footer-newsletter">
          <h4>Kirim Masukan</h4>
          <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nisi maxime totam illum excepturi voluptate inventore, quo quisquam veritatis molestias. Iste et facere quasi ratione repellendus vel aut ad officiis rerum.</p>
          <form action="forms/newsletter.php" method="post" class="php-email-form">
            <div class="newsletter-form"><input type="email" name="email"><button type="submit" class="btn btn-primary">kirim</button></div>
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your subscription request has been sent. Thank you!</div>
          </form>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Gallery</strong> <span>All Rights Reserved</span></p>
      <div class="credits">

      </div>
    </div>

  </footer>
