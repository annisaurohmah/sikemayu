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

                      <!-- SIP Menu - Admin dan Kader Posyandu -->
                      @if($userRole === 'admin_desa' || ($userRole === 'admin_kader' && !empty($userPosyandu)))
                      <li class="waves-effect"><a href="#"><i class="ti-pencil"></i> <span> Sistem Informasi Posyandu </span> <i class='mdi mdi-chevron-down'></i></a>
                          <ul class="side-dropdown">
                              @foreach ($posyandus as $posyandu)
                                  @if($userRole === 'admin_desa' || $posyandu->nama_posyandu === $userPosyandu)
                                  <li><a href="{{ route('sip.index', $posyandu->posyandu_id) }}"><i class='bx bxs-circle icon-dot'></i>{{ $posyandu->nama_posyandu }}</a></li>
                                  @endif
                              @endforeach
                          </ul>
                      </li>
                      @endif

                      <!-- Gizi Menu - Admin only -->
                      @if($userRole === 'admin_desa')
                      <li class="">
                          <a href="{{ route('gizi.index')}}" class="waves-effect">
                              <i class="ti-cup"></i> <span> F1 Gizi </span>
                          </a>
                      </li>
                      @endif

                      <!-- Dasawisma Menu - Admin dan Kader RW -->
                      @if($userRole === 'admin_desa' || ($userRole === 'admin_rw' && !empty($userRW) && empty($userPosyandu)))
                      <li class="">
                          <a href="{{ route('dasawisma.rekap') }}" class="waves-effect">
                              <i class="ti-home"></i> <span> Dasawisma </span>
                          </a>
                      </li>
                      @endif

                      <!-- Master Data Menu - Admin only -->
                      @if($userRole === 'admin_desa')
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
                      @endif

                      <!-- Pengaturan Menu - Admin only -->
                      @if($userRole === 'admin_desa')
                      <li class="menu-title">Pengaturan</li>

                      <li class="">
                          <a href="{{ route('user.index') }}" class="waves-effect">
                              <i class="ti-key"></i> <span>Daftar Akun </span>
                          </a>
                      </li>
                      @endif



                  </ul>
                  <!-- Log on to codeastro.com for more projects! -->
              </div>
              <!-- Sidebar -->
              <div class="clearfix"></div>

          </div>
          <!-- Sidebar -left -->

      </div>
      <!-- Left Sidebar End -->