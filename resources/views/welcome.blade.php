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

<div class="main-banner">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="top-text header-text">
          <h6>SIKEMAYU</h6>
          <h2>Sistem Pelaporan Kegiatan PKK Desa Margaluyu</h2>
        </div>
      </div>
      <div class="col-lg-10 offset-lg-1">
        <!-- Card Menu Grid -->
        <div class="container">
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
</div>

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

<!-- Custom CSS for hover effect and purple color -->
<style>
  .bg-purple {
    background-color: #6f42c1;
    /* Custom purple color */
  }

  .transform-hover {
    transition: transform 0.3s ease;
  }

  .transform-hover:hover {
    transform: scale(1.05);
  }

  .full-height {
    min-height: 100vh;
  }
</style>