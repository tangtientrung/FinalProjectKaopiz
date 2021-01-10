<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Eshop</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          @if(Session('admin_avatar'))
          
            <img src="img/avatar/{{Session::Get('admin_avatar')}}" class="img-circle elevation-2" alt="User Image" width="160px" height="160px">
          
          @else
          
            <img src="admin/dist/img/AdminLTELogo.png" class="img-circle elevation-2" alt="User Image">
          
          @endif
          
        </div>
        <div class="info">
          <a href="logout" class="d-block">{{Session::Get('admin_name')}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="admin/dashboard" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
            
          </li>
          <li class="nav-item">
            <a href="admin/danh-muc" class="nav-link">
              <i class="nav-icon fab fa-delicious"></i>
              <p>
                Danh mục
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="admin/danh-muc/hien-thi" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hiển thị</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin/danh-muc/them" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thêm danh mục</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-file-contract"></i>
              <p>
                Danh mục chi tiết
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="admin/danh-muc-con/hien-thi" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Quản lí danh mục chi tiết</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin/danh-muc-con/them-moi" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thêm danh mục chi tiết</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-barcode"></i>
              <p>
                Sản phẩm
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="admin/san-pham/hien-thi" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Quản lí</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin/san-pham/them" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thêm sản phẩm</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin/san-pham/giam-gia" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Giảm giá</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="admin/danh-muc" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                Slider
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="admin/slider/hien-thi" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hiển thị</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin/slider/them" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thêm slider</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-inbox"></i>
              <p>
                Đơn đặt hàng
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="admin/don-hang/don-hang-moi" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Đơn hàng mới</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin/don-hang/don-hang-dang-giao" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Đơn hàng đang giao</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin/don-hang/don-hang-da-giao" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Đơn hàng đã giao</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="admin/danh-muc" class="nav-link">
              <i class="nav-icon fas fa-calculator"></i>
              <p>
                Mã giảm giá
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="admin/ma-giam-gia/hien-thi" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Quản lí</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin/ma-giam-gia/them" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thêm mã</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="admin/danh-muc" class="nav-link">
              <i class="nav-icon fas fa-file-image"></i>
              <p>
                Thumbnail
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="admin/slider/hien-thi" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hiển thị</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="admin/thumbnail/them" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thêm thumbnail</p>
                </a>
              </li>
            </ul>
          </li>
          
          
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>