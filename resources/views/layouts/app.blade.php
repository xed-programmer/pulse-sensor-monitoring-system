<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pulse Monitoring System</title>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">    
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">    
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">    
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    @stack('links')    
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">    
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
</head>
<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        
        @yield('preload')
        
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <div class="container">
                <a href="{{ route('home') }}" class="navbar-brand">
                    <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">Pulse Monitoring</span>
                  </a>
            
                  <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                      <!-- Left navbar links -->
                      <ul class="navbar-nav">   
                          <li class="nav-item d-none d-sm-inline-block">
                              <a href="{{ route('home') }}" class="nav-link">Home</a>
                          </li>
                          <li class="nav-item d-none d-sm-inline-block">
                              <a href="#" class="nav-link">Contact</a>
                          </li>
                      </ul>
          
                      <!-- Right navbar links -->
                      <ul class="navbar-nav ml-auto">
                        @auth
                            <li class="nav-item d-none d-sm-inline-block">
                                <a href="{{ route('user.index') }}" class="nav-link">Patients</a>
                            </li>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <input type="submit" value="Logout" class="btn">
                            </form>
                        @else
                            <li class="nav-item d-none d-sm-inline-block">
                                <a href="{{ route('login') }}" class="nav-link">Login</a>
                            </li>
                            <li class="nav-item d-none d-sm-inline-block">
                                <a href="{{ route('register') }}" class="btn btn-block btn-outline-primary">Register</a>
                            </li>
                        @endauth
                      </ul>
                  </div>
            </div>
        </nav>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">            
            @yield('header')


            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">                    
                    @yield('content')
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>

    </div>
    <!-- ./wrapper -->
    
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>    
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Toastr -->
    <x-toastr-links/>
    @stack('scripts')
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
</body>
</html>
