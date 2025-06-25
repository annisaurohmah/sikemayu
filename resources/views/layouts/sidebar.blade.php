      <!-- ========== Left Sidebar Start ========== -->
      <div class="left side-menu">
          <div class="slimscroll-menu" id="remove-scroll">

              <!--- Sidemenu -->
              <!-- Log on to codeastro.com for more projects! -->
              <div id="sidebar-menu">

                  <!-- Left Menu Start -->
                  <ul class="metismenu" id="side-menu">
                      <li class="">
                          <a href="{{ route('dashboard') }}" class="waves-effect">
                              <i class="ti-dashboard"></i> <span> Home </span>
                          </a>
                      </li>
                      <li class="menu-title">Utama</li>

                      <li class="waves-effect"><a href="#"><i class="ti-pencil"></i> <span> Sistem Informasi Posyandu </span> <i class='mdi mdi-chevron-down'></i></a>
                          <ul class="side-dropdown">
                              <li><a href=""><i class='bx bxs-circle icon-dot'></i>Dashboard Balkon SKDN</a></li>
                              @foreach ($posyandus as $posyandu)
                              <li><a href="{{ route('sip.index', $posyandu->posyandu_id) }}"><i class='bx bxs-circle icon-dot'></i>{{ $posyandu->nama_posyandu }}</a></li>
                              @endforeach
                          </ul>
                      </li>
                      <li class="">
                          <a href="{{ route('gizi.index') ? 'active' : '' }}" class="waves-effect">
                              <i class="ti-cup"></i> <span> F1 Gizi </span>
                          </a>
                      </li>
                      <li class="">
                          <a href="{{ route('dasawisma.rekap') }}" class="waves-effect">
                              <i class="ti-home"></i> <span> Dasawisma </span>
                          </a>
                      </li>
                      <li class="menu-title">Master Data</li>
                      <li class="">
                          <a href="{{ route('bayi.show')}}" class="waves-effect">
                              <i class="ti-heart"></i> <span>Data Bayi</span>
                          </a>
                      </li>
                      <li class="">
                          <a href="{{ route('balita.show') }}" class="waves-effect">
                              <i class="ti-user"></i> <span>Data Balita</span>
                          </a>
                      </li>
                      <li class="">
                          <a href="{{ route('penduduk.index') }}" class="waves-effect">
                              <i class="ti-calendar"></i> <span>Data Penduduk</span>
                          </a>
                      </li>
                      <li class="">
                          <a href="{{ route('posyandu.index') }}" class="waves-effect">
                              <i class="ti-book"></i> <span>Data Posyandu</span>
                          </a>
                      </li>
                      <li class="">
                          <a href="{{ route('dasawisma.index') }}" class="waves-effect">
                              <i class="ti-archive"></i> <span>Data Dasawisma</span>
                          </a>
                      </li>
                      <li class="">
                          <a href="{{ route('rw.index') }}" class="waves-effect">
                              <i class="ti-announcement"></i> <span>Data RW</span>
                          </a>
                      </li>

                      <li class="menu-title">Pengaturan</li>

                      <li class="">
                          <a href="{{ route('user.index') }}" class="waves-effect">
                              <i class="ti-key"></i> <span>Daftar Akun </span>
                          </a>
                      </li>



                  </ul>
                  <!-- Log on to codeastro.com for more projects! -->
              </div>
              <!-- Sidebar -->
              <div class="clearfix"></div>

          </div>
          <!-- Sidebar -left -->

      </div>
      <!-- Left Sidebar End -->