<!-- Sidebar -->
    <ul style="background-color:#303446" class="pr-0 navbar-nav bg-gradient sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center mb-2 mt-2" href="/">
        <div class="sidebar-brand-icon ">
          <img style="width: 75%" src="{{ asset('logo3.png') }}">
        </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item {{ request()->is('admin') ? 'active' : '' }}">
        <a class="nav-link " href="{{route('admin.index')}}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Control Panel</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">


      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item {{ request()->is('admin/books*') ? 'active' : '' }}">
        <a class="nav-link " href="{{route('books.index')}}">
        <i class="fas fa-book-open"></i>
          <span>Books</span>
        </a>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item {{ request()->is('admin/categories*') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('categories.index')}}">
        <i class="fas fa-folder"></i>
          <span>Categories</span>
        </a>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item {{ request()->is('admin/authors*') ? 'active' : '' }}">
        <a class="nav-link " href="{{route('authors.index')}}">
        <i class="fas fa-pen-fancy"></i>
          <span>Authors</span>
        </a>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item {{ request()->is('admin/publishers*') ? 'active' : '' }}">
        <a class="nav-link " href="{{route('publishers.index')}}">
        <i class="fas fa-table"></i>
          <span>Publishers</span></a>
      </li>

      <!-- Nav Item - Tables -->
      <li class="nav-item {{ request()->is('admin/users*') ? 'active' : '' }}">
        <a class="nav-link " href="{{route('users.index')}}">
        <i class="fas fa-users"></i>
          <span>Users</span></a>
      </li>

      <li class="nav-item {{ request()->is('admin/allproduct*') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('all.product')}}">
        <i class="fas fa-shopping-bag"></i>
          <span>Purchases</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->
