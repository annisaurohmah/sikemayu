@include('layouts.welcome')


<!-- ***** Preloader Start ***** -->
<div id="js-preloader" class="js-preloader">
  <div class="preloader-inner">
    <span class="dot"></span>
    <div class="dots">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
</div>
<!-- ***** Preloader End ***** -->

<!-- ***** Header Area Start ***** -->
<header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
  <div class="container">
    <div class="row">
      <div class="col-12 mt-3">
        <nav class="main-navbar d-flex justify-content-between align-items-center">
          <!-- Menu -->
          <ul class="navbar mb-0">
            <!-- tambahkan menu lain di sini jika ada -->
          </ul>

          <!-- Tombol Login di kanan -->
          <div class="main-white-button ms-auto">
            <a href="{{ route('getLogin') }}"><i class="bx bx-log-in"></i> Login Admin</a>
          </div>
        </nav>

      </div>
    </div>
  </div>
</header>
<!-- ***** Header Area End ***** -->

<!-- ***** Hero Image Section ***** -->
<section class="hero-image-section">
  <div class="container-fluid p-0">
    <div class="hero-image-wrapper">
      <img src="{{ asset('assets/images/fotobareng.jpeg') }}" alt="Kegiatan PKK Desa Margaluyu" class="img-fluid w-100 hero-image">
      <div class="hero-overlay"></div>
    </div>
  </div>
</section>
<!-- ***** Hero Image Section End ***** -->

<!-- ***** Title Section ***** -->
<section class="title-section py-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <div class="top-text header-text">
          <h6 class="text-primary mb-3">SIKEMAYU</h6>
          <h2 class="mb-4">Sistem Pelaporan Kegiatan PKK Desa Margaluyu</h2>
          <p class="lead text-muted">Platform digital untuk mengelola dan memantau seluruh kegiatan PKK di Desa Margaluyu</p>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ***** Title Section End ***** -->

<!-- ***** Menu Cards Section ***** -->
<section class="menu-cards-section py-5 bg-light">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 offset-lg-1">
        <!-- Card Menu Grid -->
        <div class="row g-4">

            <!-- Card Template -->
            <div class="col-12 col-sm-6 col-lg-3 mb-3">
              <a class="text-decoration-none">
                <div class="card h-100 shadow-sm border-0 bg-primary text-white transform-hover">
                  <div class="card-body text-center">
                    <h5 class="card-title">Laporan Hari Buka Posyandu</h5>
                    <p class="card-text text-white small">Rangkuman kegiatan yang dilakukan pada hari Posyandu</p>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-12 col-sm-6 col-lg-3 mb-3">
              <a class="text-decoration-none">
                <div class="card h-100 shadow-sm border-0 bg-success text-white transform-hover">
                  <div class="card-body text-center">
                    <h5 class="card-title">Sistem Informasi Posyandu</h5>
                    <p class="card-text text-white small">Sistem digital untuk mengelola dan memantau kegiatan Posyandu</p>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-12 col-sm-6 col-lg-3 mb-3">
              <a class="text-decoration-none">
                <div class="card h-100 shadow-sm border-0 bg-warning text-white transform-hover">
                  <div class="card-body text-center">
                    <h5 class="card-title">F1 Gizi</h5>
                    <p class="card-text text-white small">Laporan bulanan kegiatan penimbangan balita dan program gizi</p>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-12 col-sm-6 col-lg-3 mb-3">
              <a class="text-decoration-none">
                <div class="card h-100 shadow-sm border-0 text-white transform-hover" style="background-color: #6f42c1;">
                  <div class="card-body text-center">
                    <h5 class="card-title">Dasawisma</h5>
                    <p class="card-text text-white small">Catatan dasawisma dalam struktur PKK di wilayah RW</p>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ***** Menu Cards Section End ***** -->

<!-- ***** Additional Content Section ***** -->
<section class="additional-content py-5">
<div class="container py-5">
  <div class="row justify-content-center">

    <!-- Baris 1: Mars PKK -->
    <div class="col-12 col-md-10 mb-4">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body d-flex flex-column justify-content-between">
          <div>
            <h5 class="card-title"><i class="fas fa-music me-2 text-primary mr-2"></i>Mars PKK</h5>
            <p class="card-text text-muted">Dengarkan lagu Mars PKK melalui YouTube Music.</p>
          </div>
          <a href="https://music.youtube.com/watch?v=ryCaKwBsn4w" target="_blank" class="btn btn-primary mt-3 w-100">
            <i class="fas fa-play-circle me-1"></i> Dengarkan Sekarang
          </a>
        </div>
      </div>
    </div>

    <!-- Baris 2: Lokasi Google Maps -->
    <div class="col-12 col-md-10">
      <div class="card shadow-sm border-0 h-150">
        <div class="card-body">
          <h5 class="card-title"><i class="fas fa-map-marker-alt me-2 text-danger mr-2"></i>Lokasi Kegiatan</h5>
          <p class="card-text text-muted">Lihat lokasi kegiatan langsung melalui peta.</p>
          <!-- Embedded Map -->
          <div class="w-100 ratio ratio-4x3 rounded overflow-hidden shadow-sm">
            <iframe
              src="https://www.google.com/maps?q=-7.2231573,107.5536364&hl=id&z=16&output=embed"
              class="w-100 h-100"
              style="border:0; " allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
</section>
<!-- ***** Additional Content Section End ***** -->

<!-- Custom CSS for new layout -->
<style>
  /* Hero Image Section */
  .hero-image-section {
    position: relative;
    overflow: hidden;
  }
  
  .hero-image-wrapper {
    position: relative;
    height: 400px;
    overflow: hidden;
  }
  
  .hero-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
  }
  
  .hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.1) 100%);
  }

  /* Title Section */
  .title-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  }
  
  .title-section h6 {
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
  }
  
  .title-section h2 {
    font-weight: 700;
    color: #2c3e50;
    line-height: 1.3;
  }

  /* Menu Cards Section */
  .menu-cards-section {
    background: #f8f9fa;
  }

  /* Card Styling */
  .bg-purple {
    background-color: #6f42c1;
  }

  .transform-hover {
    transition: all 0.3s ease;
    border-radius: 15px;
  }

  .transform-hover:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
  }

  .card {
    border-radius: 15px;
    overflow: hidden;
  }

  .card-title {
    font-weight: 600;
    font-size: 1.1rem;
  }

  /* Responsive adjustments */
  @media (max-width: 768px) {
    .hero-image-wrapper {
      height: 300px;
    }
    
    .title-section h2 {
      font-size: 1.8rem;
    }
    
    .title-section h6 {
      font-size: 0.9rem;
    }
  }

  @media (max-width: 576px) {
    .hero-image-wrapper {
      height: 250px;
    }
    
    .title-section {
      padding: 3rem 0;
    }
  }

  .full-height {
    min-height: 100vh;
  }
</style>