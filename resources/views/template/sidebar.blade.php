
@section('custom-css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>

.navbar-white {
    background-color: #3c8dbc!important;
}
/* {
    background-color: #3c8dbc!important; */
/* } */

    .blue-color {
        color:blue;
    }

    .green-color {
        color:green;
    }

    .teal-color {
        color:teal;
    }

    .yellow-color {
    color:yellow;
    }

    .red-color {
        color:red;
    }
   </style>

@endsection
<aside class="main-sidebar sidebar-dark-lightblue elevation-4" style="background-color: #00728f">
    <!-- Brand Logo -->
    <a href="#" class="brand-link" style="background-color: #00728f">
      <img src="{{ asset('AdminLTE/dist/img/aaui-logo.png') }}" alt="AAUI Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"> APP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        {{-- <div class="image">
          <img src="{{ asset('AdminLTE/dist/img/avatar4.png') }}" class="img-circle elevation-2" alt="User Image">
        </div> --}}
        <div class="info">
          <a href="#" class="d-block">
            @auth
                {{ Auth::user()->name  }}
            @endauth
        </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link @if (Route::currentRouteName() == 'dashboard') active @endif">
                <i class="nav-icon fas fa-home"></i>
                <p>Beranda</p>
              </a>
            </li>



        @if (auth()->user()->type == 'admin')
          <li class="nav-header">Admin</li>
          <li class="nav-item @if (Route::currentRouteName() == 'master-anggaran.create' || Route::currentRouteName() == 'master-anggaran.index' || Route::currentRouteName() == 'master-anggaran.index') menu-open @endif">
            <a href="#" class="nav-link @if (Route::currentRouteName() == 'master-anggaran.create' || Route::currentRouteName() == 'master-anggaran.index' || Route::currentRouteName() == 'seksi.index') active @endif">
              <i class="nav-icon fas fa-money-check-alt text-warning"></i>
              <p>
                Master Anggaran
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('master-anggaran.create') }}" class="nav-link @if (Route::currentRouteName() == 'master-anggaran.create') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>New</p>
                    </a>
                </li>
              <li class="nav-item">
                <a href="{{ route('master-anggaran.index') }}" class="nav-link @if (Route::currentRouteName() == 'master-anggaran.index') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item @if (Route::currentRouteName() == 'seksi.create' || Route::currentRouteName() == 'seksi.index' || Route::currentRouteName() == 'seksi.index') menu-open @endif">
            <a href="#" class="nav-link @if (Route::currentRouteName() == 'seksi.create' || Route::currentRouteName() == 'seksi.index' || Route::currentRouteName() == 'seksi.index') active @endif">
              <i class="nav-icon fas fa-newspaper text-warning"></i>
              <p>
                Seksi
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('seksi.create') }}" class="nav-link @if (Route::currentRouteName() == 'seksi.create') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>New</p>
                    </a>
                </li>
              <li class="nav-item">
                <a href="{{ route('seksi.index') }}" class="nav-link @if (Route::currentRouteName() == 'seksi.index') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item @if (Route::currentRouteName() == 'profiles.create' || Route::currentRouteName() == 'profiles.index' || Route::currentRouteName() == 'profiles-upload.create') menu-open @endif">
            <a href="#" class="nav-link @if (Route::currentRouteName() == 'profiles.create' || Route::currentRouteName() == 'profiles.index') active @endif">
              <i class="nav-icon fas fa-users-cog text-warning"></i>
              <p>
                Profiles
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('profiles.create') }}" class="nav-link @if (Route::currentRouteName() == 'profiles.create') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create</p>
                    </a>
                </li>

                {{-- <li class="nav-item">
                    <a href="{{ route('profiles-upload.create') }}" class="nav-link @if (Route::currentRouteName() == 'profiles-upload.create') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Upload</p>
                    </a>
                </li> --}}
              {{-- @endif --}}
              <li class="nav-item">
                <a href="{{ route('profiles.index') }}" class="nav-link @if (Route::currentRouteName() == 'profiles.index') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item @if (Route::currentRouteName() == 'users.create' || Route::currentRouteName() == 'users.index' || Route::currentRouteName() == 'user.profile') menu-open @endif">
            <a href="#" class="nav-link @if (Route::currentRouteName() == 'users.create' || Route::currentRouteName() == 'users.index') active @endif">
              <i class="nav-icon fas fa-users-cog text-warning"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              {{-- @if (Auth::user()->type == 'partner' || Auth::user()->type == 'business_owner') --}}
                <li class="nav-item">
                    <a href="{{ route('users.create') }}" class="nav-link @if (Route::currentRouteName() == 'users.create') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create</p>
                    </a>
                </li>
              {{-- @endif --}}
              <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link @if (Route::currentRouteName() == 'users.index') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item @if (Route::currentRouteName() == 'settings.create' || Route::currentRouteName() == 'settings.index' || Route::currentRouteName() == 'settings.index') menu-open @endif">
            <a href="#" class="nav-link @if (Route::currentRouteName() == 'settings.create' || Route::currentRouteName() == 'settings.index' || Route::currentRouteName() == 'settings.index') active @endif">
              <i class="nav-icon fas fa-cogs text-warning"></i>
              <p>
                Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('settings.create') }}" class="nav-link @if (Route::currentRouteName() == 'settings.create') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>New</p>
                    </a>
                </li>
              <li class="nav-item">
                <a href="{{ route('settings.index') }}" class="nav-link @if (Route::currentRouteName() == 'settings.index') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View</p>
                </a>
              </li>
            </ul>
          </li>

          @endif

        </ul>
      </nav>

    </div>

  </aside>
