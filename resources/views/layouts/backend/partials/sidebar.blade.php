<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('assets/backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Ecc Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('assets/backend/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview">
            <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="{{ route('category.index') }}" class="nav-link {{ Request::is('category*') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Category</p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="{{ route('brand.index') }}" class="nav-link {{ Request::is('brand*') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Brand</p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="{{ route('color.index') }}" class="nav-link {{ Request::is('color*') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Color</p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="{{ route('size.index') }}" class="nav-link {{ Request::is('size*') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Size</p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="{{ route('product.index') }}" class="nav-link {{ Request::is('product*') ? 'active' : '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Product</p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>