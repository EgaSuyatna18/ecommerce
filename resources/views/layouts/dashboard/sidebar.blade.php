<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="/dashboard">
        <img src="assets/dashboard/assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white">E-Commerce</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Core</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="/dashboard">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        @if (auth()->user()->role == 'Admin')
            
          <li class="nav-item mt-3">
              <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Master</h6>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white " href="/admin">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">admin_panel_settings</i>
              </div>
              <span class="nav-link-text ms-1">Admin</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white " href="/seller">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">store</i>
              </div>
              <span class="nav-link-text ms-1">Seller</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white " href="/buyer">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">shopping_cart</i>
              </div>
              <span class="nav-link-text ms-1">Buyer</span>
            </a>
          </li>
        @elseif (auth()->user()->role == 'Seller')

          <li class="nav-item">
            <a class="nav-link text-white" href="/store_setting">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">store</i>
              </div>
              <span class="nav-link-text ms-1">Store Setting</span>
            </a>
          </li>
          <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Master</h6>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="/product">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">home_repair_service</i>
              </div>
              <span class="nav-link-text ms-1">Product</span>
            </a>
          </li>
      
        @elseif (auth()->user()->role == 'Buyer')
            
        @endif
      </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
      <div class="mx-3">
        <p class="text-white text-center">{{ auth()->user()->name }}</p>
        <p class="text-white text-center">{{ auth()->user()->role }}</p>
        <a class="btn bg-gradient-primary w-100" href="/logout" type="button">Logout</a>
      </div>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <a href="/"><i class="fa fa-home"></i> Home</a>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">

          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            
            <div class="input-group input-group-outline">
              <a href="/logout" class="nav-link text-body font-weight-bold px-0">
                  <i class="fa fa-user me-sm-1"></i>
                  <span class="d-sm-inline d-none">Logout</span>
                </a>
            </div>

          </div>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->