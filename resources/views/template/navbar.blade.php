
<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: #00728f">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
          {{-- <span class="badge badge-danger navbar-badge">3</span> --}}
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="{{ route('profile.form') }}" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{ asset('AdminLTE/dist/img/avatar4.png') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                    @auth
                        {{ Auth::user()->name  }}
                    @endauth
                </h3>
                <p class="text-sm">

                    @auth
                        {{ auth()->user()->email }}
                    @endauth
                </p>
                <p class="text-sm text-muted"><span class="text-sm" style="color:

                @auth
                        {{ auth()->user()->color }}
                @endauth
                "><i class="fas fa-star"></i></span>

                @auth
                {{ auth()->user()->type }}
                @endauth</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{ route('logout') }}" class="dropdown-item dropdown-footer" id="logout_btn">Log Out</a>
        </div>
      </li>
    </ul>
  </nav>
