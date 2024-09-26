<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Pustipanda </title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('asset/images/logos/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('asset/css/styles.min.css') }}" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    @include('layout.sidebar')
    <!--  Sidebar End -->
    
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      @include('layout.navbar')
      <!--  Header End -->
                
      <!-- Content fluid -->
      <div class="container-fluid">
        <!-- Tambahkan elemen-elemen chart di sini -->
        <div id="chart"></div>
        <div id="breakup"></div>
        <div id="earning"></div>
        
        <section>
          @yield('content')
        </section>
      </div>
      <!-- / Content fluid -->
    </div>
  </div>
</body>
</html>
