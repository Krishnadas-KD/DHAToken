<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{ asset('assets/vendors/iconfonts/mdi/css/materialdesignicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/shared/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo_1/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title')</title>
    <style>
      .page-body .page-content-wrapper .page-content-wrapper-inner {
        max-width :100%;
      }
      .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-size: 10%;
            background-color: rgba(0,0,0,0.5);
        }
        .r-center {
          position: absolute;
          width: 200px;
          height: 50px;
          top: 50%;
          left: 50%;
          margin-top: -25px;
          margin-left: -50px;
          color:white;
      }
 /* Add this CSS for the profile icon */
 /* Add this style to ensure the image doesn't overflow */
 .profile-dropdown-toggle {
        overflow: hidden;
        border-radius: 50%;
        width: 40px; /* Adjust the width as needed */
        height: 40px; /* Adjust the height as needed */
        cursor: pointer;
    }

    .profile-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    </style>
    @yield('style-css')

  </head>
  <body class="header-fixed">
    <div id="loader" class="loader d-none">
      <h5 class="r-center">Please wait...</h5>
    </div>
    <nav class="t-header" id="header-div">
        <div class="t-header-content-wrapper">
            <div class="t-header-content">
                <button class="t-header-toggler t-header-mobile-toggler d-block d-lg-none">
                    <i class="mdi mdi-menu"></i>
                </button>
                <h2 style="color: black">Dubai Health</h2>
            </div>

            <!-- Profile icon with dropdown menu -->
            <div class="t-header-profile">
                <div class="dropdown">
                    <div class="profile-dropdown-toggle" id="profileDropdown" data-toggle="dropdown"  alt="{{ auth()->user()->email }}" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('assets/img/male-user.png') }}" alt="{{ auth()->user()->email }}" class="profile-image">
                    </div>
                    <div class="dropdown-menu" aria-labelledby="profileDropdown">
                    @if(auth()->user()->is_admin == 1)
                        <a class="dropdown-item" href="{{ url('/display') }}">Switch User</a>
                    
                        @endif
          
                        <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

      </div>
    </nav>
    <!-- partial -->
    <div class="page-body">
      <div class="sidebar" style="background:#fff">
        <ul class="navigation-menu">
          <li class="nav-category-divider" style="background:#fff;color:#525c5d;font-size:20px">Menu</li>
          @if(auth()->user()->is_admin == 1)
             <li>
            <a href="/home">
              <span class="link-title">Dashboard</span>
              <i class="mdi mdi-home link-icon"></i>
            </a>
          </li>
          <li>
            <a href="{{ route('assign_counter') }}">
              <span class="link-title">Assign-Counter</span>
              <i class="mdi mdi-assistant link-icon"></i>
            </a>
          </li>
       
          <li>
            <a href="{{ route('service.index') }}">
              <span class="link-title">Service</span>
              <i class="mdi mdi-paperclip link-icon"></i>
            </a>
          </li>
          
          <li>
            <a href="/counter">
              <span class="link-title">Counter</span>
              <i class="mdi mdi-counter link-icon"></i>
            </a>
          </li>

          <li>
             <a href="{{ route('new_user') }}">
              <span class="link-title">Add User</span>
              <i class="mdi mdi-account link-icon"></i>
            </a>
          </li>
          <li>
             <a href="{{ route('assign_user') }}">
              <span class="link-title">Assign User</span>
              <i class="mdi mdi-account-network link-icon"></i>
            </a>
          </li>
           
          <li>
             <a href="#ui-elements" data-toggle="collapse" aria-expanded="false">
              <span class="link-title">Report</span>
              <i class="mdi mdi-book link-icon"></i>
            </a>
             <ul class="collapse navigation-submenu"  style="background:#fff;" id="ui-elements">
                  <li>
                    <a href="{{ route('token_list_home')}}">
                      <i class="mdi mdi-history link-icon"></i>
                      <span class="link-title" style="color:#000">Token List</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('token_count_home')}}">
                      <i class="mdi  mdi-counter link-icon"></i>
                      <span class="link-title" style="color:#000">Token Count</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('token_count_hour_home')}}">
                      <i class="mdi  mdi-timelapse link-icon"></i>
                      <span class="link-title" style="color:#000">Token Hour Wise Count</span>
                    </a>
                  </li>

                  </ul>
          </li>
         

          @endif

          @if(auth()->user()->type == 'Counter')
          <li>
             <a href="{{ route('counter_user_index') }}">
              <span class="link-title">Counter Dashboard</span>
              <i class="mdi mdi-gauge link-icon"></i>
            </a>
          </li>

          @endif

          @if(auth()->user()->type == 'Token')
          <li>
            <a href="{{ route('token_index' ) }}">
              <span class="link-title">Token</span>
              <i class="mdi mdi-ticket-account link-icon"></i>
            </a>
          </li>

          @endif

          
          @if(auth()->user()->type == 'Report')
          <li>
            <a href="/report-home">
              <span class="link-title">Dashboard</span>
              <i class="mdi mdi-home link-icon"></i>
            </a>
          </li>
         <li>
             <a href="#ui-elements" data-toggle="collapse" aria-expanded="false">
              <span class="link-title">Report</span>
              <i class="mdi mdi-book link-icon"></i>
            </a>
             <ul class="collapse navigation-submenu" id="ui-elements">
                  <li>
                    <a href="{{ route('token_list_home')}}">
                      <i class="mdi mdi-history link-icon"></i>
                      <span class="link-title" style="color:#000">Token List</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('token_count_home')}}">
                      <i class="mdi mdi-counter link-icon"></i>
                      <span class="link-title" style="color:#000">Token Count</span>
                    </a>
                  </li>
                  </ul>
          </li>
          @endif
          
        </ul>
      </div>


      <!-- partial -->
      <div class="page-content-wrapper" id="cont-top" style="background: #ededf1">

        <div class="page-content-wrapper-inner">
            @if ($msg = Session::get('success'))
                <div class="alert alert-primary" role="alert" id="succesmsg">
                    {{ $msg }}
                </div>
            @endif
            @foreach ($errors->all() as $error)
                <div class="alert alert-warning" role="alert">
                    {{ $error }}
                </div>
            @endforeach
            @if ($exist_message = Session::get('exist'))
                <div class="alert alert-warning" role="alert">
                    {{ $exist_message }}
                </div>
            @endif

            @yield('content', 'Default Content')

        </div>


      </div>
    </div>
    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/core.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    
    {{-- <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> --}}
    @yield('script')

    @yield('data-table')
  </body>
</html>
