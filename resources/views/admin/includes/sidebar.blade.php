<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('admin.index') }}" class="brand-link">
    <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Админ панель</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <ul class="pt-3 nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <a href="{{ route('admin.card.index') }}" class="nav-link">
          <i class="nav-icon fas fa-image"></i>
          <p>Карточки</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.category.index') }}" class="nav-link">
          <i class="nav-icon fas fa-toggle-on"></i>
          <p>Категории</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('admin.user.index')}}" class="nav-link">
          <i class="nav-icon fas fa-users"></i>
          <p>Пользователи</p>
        </a>
      </li>
      <li class="nav-item mt-3 text-center">
        <form action="{{route('logout')}}" method="POST">
          @csrf
          <input type="submit" class="btn btn-outline-danger" value="Выйти">
        </form>
      </li>
    </ul>
  </div>
  <!-- /.sidebar -->
</aside>