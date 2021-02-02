<div class="wrapper position-relative">
  @include('layouts.navbars_user.sidebar', ['breadcrumbs' => $breadcrumbs])
  <div class="main-panel pl-3 pr-3 " style="min-height:calc(100vh) !important;">
    @include('layouts.navbars_user.navs.auth')
    <div class="col" id="wrapper" style="margin-top:100px; position: relative;">
      @yield('title')
        @yield('content')


        
    </div>
    @include('layouts.footers.auth')
  </div>
  <div class="box-peminjaman">
    <div class="navigator">
      <i class="fa fa-shopping-cart"></i>
    </div>
    <div class="peminjaman d-none" data-toggle="modal" data-target="#peminjaman">
      <i class="fa fa-address-book"></i>
    </div>
    <div class="pengembalian d-none">
      <i class="fa fa-sign-out"></i>
    </div>
  </div>
</div>
