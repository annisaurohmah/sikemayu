   <!-- Top Bar Start -->
   <div class="topbar">

<!-- LOGO -->
<div class="topbar-left">
    <a href="/" class="logo">
        <span>
        <h3 style="color: white; ">SIKEMAYU</h3>
        </span>
        
    </a>
</div>

<nav class="navbar-custom">
    <ul class="navbar-right d-flex list-inline float-right mb-0">
        <!-- Dropdown Pilihan Tahun -->
        <li class="dropdown notification-list mr-3">
            <div class="form-group mb-0">
                <label for="yearSelector" style="color: white; font-size: 11px; margin-bottom: 3px; display: block;">Tahun:</label>
                <select class="form-control form-control-sm" id="yearSelector" style="min-width: 80px; height: 30px; background-color: white; border: 1px solid #ddd; color: #333; font-size: 12px;">
                    @php
                        $currentYear = date('Y');
                        $selectedYear = request()->get('tahun', $currentYear);
                    @endphp
                    @for($year = $currentYear; $year >= ($currentYear - 10); $year--)
                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endfor
                </select>
            </div>
        </li>
        
        <!-- full screen -->
        <li class="dropdown notification-list d-none d-md-block">
            <a class="nav-link waves-effect" href="#" id="btn-fullscreen">
                <i class="mdi mdi-fullscreen noti-icon"></i>
            </a>
        </li>

        
        <li class="dropdown notification-list">
            <div class="dropdown notification-list nav-pro-img">
                <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                Administrator
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <!-- <a class="dropdown-item" href="#"><i class="mdi mdi-account-circle m-r-5"></i> Profile</a> -->
            
                    {{-- <a class="dropdown-item d-block" href="#"><span class="badge badge-success float-right">11</span><i class="mdi mdi-settings m-r-5"></i> Settings</a> --}}
                    <a class="dropdown-item" href="#"><i class="mdi mdi-lock-open-outline m-r-5"></i> Lock screen</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><i class="mdi mdi-power text-danger"></i> {{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                </div>
            </div>
        </li>

    </ul>

    <ul class="list-inline menu-left mb-0">
        <li class="float-left">
            <button class="button-menu-mobile open-left waves-effect">
                <i class="mdi mdi-menu"></i>
            </button>
        </li>
        {{-- <li class="d-none d-sm-block">
            <div class="dropdown pt-3 d-inline-block">
                <a class="btn btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Create
                    </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Separated link</a>
                </div>
            </div>
        </li> --}}
    </ul>

</nav>

</div>
<!-- Top Bar End -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const yearSelector = document.getElementById('yearSelector');
    
    if (yearSelector) {
        console.log('Year selector found:', yearSelector);
        
        yearSelector.addEventListener('change', function() {
            const selectedYear = this.value;
            console.log('Year selected:', selectedYear);
            
            const currentUrl = new URL(window.location);
            
            // Update URL parameter
            currentUrl.searchParams.set('tahun', selectedYear);
            
            console.log('Redirecting to:', currentUrl.toString());
            
            // Redirect dengan parameter tahun yang baru
            window.location.href = currentUrl.toString();
        });
    } else {
        console.error('Year selector not found!');
    }
});
</script>
