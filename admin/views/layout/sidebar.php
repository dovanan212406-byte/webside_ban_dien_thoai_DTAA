<!doctype html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Webside bán điện thoại DTAA</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/f081052a6b.js" crossorigin="anonymous"></script>
  <style>
    /* CSS cho Tailwind */
    body {
      box-sizing: border-box;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html,
    body {
      height: 100%;
      width: 100%;
    }

    .sidebar-item {
      transition: all 0.3s ease;
    }

    .sidebar-item:hover {
      transform: translateX(5px);
    }

    .submenu {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease-in-out;
      /* Dùng ease-in-out cho mượt hơn */
    }

    .submenu.active {
      max-height: 500px;
      /* Giá trị lớn hơn để đảm bảo hiển thị hết */
    }

    .card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    /* Thêm style cho nút submenu để hiển thị icon mũi tên */
    .rotated {
      transform: rotate(180deg);
    }
  </style>
</head>

<body class="w-full h-full">
  <div class="flex h-full w-full bg-gradient-to-br from-blue-50 to-indigo-100">
    <aside class="w-64 bg-gradient-to-b from-indigo-900 to-indigo-700 text-white flex-shrink-0 overflow-y-auto">
      <div class="p-6 border-b border-indigo-600">
        <a href="<?= BASE_URL_ADMIN ?? '#' ?>" class="flex items-center gap-3 mb-4">
          <!-- <img src="../uploads/logo.jpg" alt="Fantastic" class="w-10 h-10 rounded-full opacity-80 shadow-md"> -->
          <span id="website-name" class="text-xl font-bold" style="font-family: 'Arial Black', sans-serif;">Webside bán điện thoại DTAA</span>
        </a>


        <div class="flex items-center gap-3 border-t border-indigo-600 pt-4 mt-2">
          <div
            class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
            A
          </div>
          <a href="#" class="font-medium text-white block">ADMIN</a>


        </div>
      </div>

      <nav class="p-4">
  <ul class="space-y-1">

    <!-- TỔNG QUAN -->
    <!-- <li class="text-xs text-gray-300 uppercase px-4 mt-2">Tổng quan</li> -->
    <li class="sidebar-item">
      <a href="<?= BASE_URL_ADMIN ?>"
        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-600">
        <i class="fa-solid fa-house"></i>
        Dashboard
      </a>
    </li>

     <!-- SẢN PHẨM -->
    <!-- <li class="text-xs text-gray-300 uppercase px-4 mt-4">Sản phẩm</li> -->

    <li class="sidebar-item">
      <a href="<?= BASE_URL_ADMIN . '?act=category' ?>"
        class="flex items-center gap-3 px-4 py-3 hover:bg-indigo-600 rounded-lg">
        <i class="fa-solid fa-tags"></i>
        Danh mục
      </a>
    </li>

    <li class="sidebar-item">
      <a href="<?= BASE_URL_ADMIN . '?act=san-pham' ?>"
        class="flex items-center gap-3 px-4 py-3 hover:bg-indigo-600 rounded-lg">
        <i class="fa-solid fa-mobile-screen"></i>
        Sản phẩm
      </a>
    </li>

    <!-- <li class="sidebar-item">
      <a href="<?= BASE_URL_ADMIN . '?act=hinh-anh' ?>"
        class="flex items-center gap-3 px-4 py-3 hover:bg-indigo-600 rounded-lg">
        <i class="fa-solid fa-image"></i>
        Hình ảnh SP
      </a>
    </li> -->

    

    <!-- <li class="sidebar-item">
      <a href="<?= BASE_URL_ADMIN . '?act=danh-gia' ?>"
        class="flex items-center gap-3 px-4 py-3 hover:bg-indigo-600 rounded-lg">
        <i class="fa-solid fa-star"></i>
        Đánh giá
      </a>
    </li> -->

    <!-- BÁN HÀNG -->
    <!-- <li class="text-xs text-gray-300 uppercase px-4 mt-4">Bán hàng</li> -->

    <li class="sidebar-item">
      <a href="<?= BASE_URL_ADMIN . '?act=don-hang' ?>"
        class="flex items-center gap-3 px-4 py-3 hover:bg-indigo-600 rounded-lg">
        <i class="fa-solid fa-box"></i>
        Đơn hàng
      </a>
    </li>

    <!-- <li class="sidebar-item">
      <a href="<?= BASE_URL_ADMIN . '?act=chi-tiet-don-hang' ?>"
        class="flex items-center gap-3 px-4 py-3 hover:bg-indigo-600 rounded-lg">
        <i class="fa-solid fa-cube"></i>
        Chi tiết đơn hàng
      </a>
    </li> -->

    <!-- <li class="sidebar-item">
      <a href="<?= BASE_URL_ADMIN . '?act=gio-hang' ?>"
        class="flex items-center gap-3 px-4 py-3 hover:bg-indigo-600 rounded-lg">
        <i class="fa-solid fa-cart-shopping"></i>
        Giỏ hàng
      </a>
    </li> -->

    <!-- <li class="sidebar-item">
      <a href="<?= BASE_URL_ADMIN . '?act=san-pham-gio' ?>"
        class="flex items-center gap-3 px-4 py-3 hover:bg-indigo-600 rounded-lg">
        <i class="fa-solid fa-list"></i>
        Sản phẩm trong giỏ
      </a>
    </li> -->

  
    <!-- <li class="text-xs text-gray-300 uppercase px-4 mt-4">Người dùng</li> -->

   <li class="sidebar-item mt-4">

      
      <button onclick="toggleSubmenu('account')" class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-indigo-600 transition-colors group">
        <div class="flex items-center gap-3">
          <i class="fa-solid fa-user-gear"></i>
          <span>Quản lý tài khoản</span>
        </div>
        <i id="account-arrow" class="fa-solid fa-chevron-down text-xs transition-transform duration-300"></i>
      </button>

      <ul id="account-submenu" class="submenu space-y-1 mt-1 bg-indigo-800/50 rounded-lg shadow-inner">
        <li>
          <a href="<?= BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri' ?>" class="flex items-center gap-3 pl-11 pr-4 py-2.5 hover:text-white hover:bg-indigo-500 rounded-lg transition text-sm text-indigo-100">
            <i class="fa-solid fa-user-shield text-yellow-400 text-xs"></i>
            Tài khoản Admin
          </a>
        </li>
        <li>
          <a href="<?= BASE_URL_ADMIN . '?act=form-them-quan-tri' ?>" class="flex items-center gap-3 pl-11 pr-4 py-2.5 hover:text-white hover:bg-indigo-500 rounded-lg transition text-sm text-indigo-100">
            <i class="fa-solid fa-user-plus text-green-400 text-xs"></i>
            Thêm quản trị viên
          </a>
        </li>
        <li>
          <a href="<?= BASE_URL_ADMIN . '?act=list-tai-khoan-khach-hang' ?>" class="flex items-center gap-3 pl-11 pr-4 py-2.5 hover:text-white hover:bg-indigo-500 rounded-lg transition text-sm text-indigo-100">
            <i class="fa-solid fa-users text-blue-300 text-xs"></i>
            Tài khoản Khách hàng
          </a>
        </li>
        <li>
          <a href="<?= BASE_URL_ADMIN . '?act=form-sua-thong-tin-ca-nhan-quan-tri' ?>" class="flex items-center gap-3 pl-11 pr-4 py-2.5 hover:text-white hover:bg-indigo-500 rounded-lg transition text-sm text-indigo-100">
            <i class="fa-solid fa-circle-user text-xs"></i>
            Tài khoản cá nhân
          </a>
        </li>
      </ul>
    </li>

    <li class="sidebar-item">
      <a href="<?= BASE_URL_ADMIN . '?act=vai-tro' ?>"
        class="flex items-center gap-3 px-4 py-3 hover:bg-indigo-600 rounded-lg">
        <i class="fa-solid fa-shield-halved"></i>
        Vai trò
      </a>
    </li>
   <li class="sidebar-item">
 
</li>

  </ul>
</nav>
    </aside>

    <main class="flex-1 overflow-y-auto">
      <header class="bg-white shadow-md px-8 py-4">
        <div class="flex items-center justify-between">
          <h2 id="page-title" class="text-3xl font-bold text-indigo-900" style="font-family: 'Georgia', serif;">
            Management</h2>
          <div class="flex items-center gap-4">
            <button class="p-2 hover:bg-indigo-50 rounded-full transition-colors">
              <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                <path
                  d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
              </svg>
            </button>
            <div class="flex items-center gap-3">
              <div
                class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                A
              </div>
              <span class="font-medium text-gray-700">Admin</span>
              <a class="nav-link" href="<?= BASE_URL_ADMIN . '?act=logout-admin' ?>"
                onclick="return confirm('Đăng xuất tài khoản ?')">
                <i class="fas fa-sign-out-alt"></i>
              </a>
            </div>
          </div>
        </div>
      </header>
      <script>
        // Hàm chuyển đổi nội dung trang
        function showPage(pageId) {
          const pages = document.querySelectorAll('.page-content');
          pages.forEach(page => {
            page.classList.add('hidden');
          });
          document.getElementById(`${pageId}-page`).classList.remove('hidden');

          // Cập nhật tiêu đề trang
          const pageTitleElement = document.getElementById('page-title');
          let title = '';
          switch (pageId) {
            case 'home':
              title = 'Trang chủ';
              break;
            case 'customers':
              title = 'Khách hàng Tour';
              break;
            case 'categories':
              title = 'Danh mục Tour';
              break;
            case 'tours':
              title = 'Quản lý Tour';
              break;
            case 'suppliers':
              title = 'Nhà cung cấp';
              break;
            case 'requests':
              title = 'Yêu cầu đặc biệt';
              break;
            case 'accounts':
              title = 'Tài khoản Quản trị';
              break;
            case 'guides':
              title = 'Hướng dẫn viên';
              break;
            case 'bookings':
              title = 'Quản lý Booking';
              break;
            case 'booking-status':
              title = 'Trạng thái Booking';
              break;
            default:
              title = 'FANTASTIC JOURNEYS';
          }
          pageTitleElement.textContent = title;

          // Đóng tất cả các submenu khi chuyển trang
          const submenus = document.querySelectorAll('.submenu');
          submenus.forEach(submenu => {
            submenu.classList.remove('active');
          });
          const arrows = document.querySelectorAll('.transition-transform');
          arrows.forEach(arrow => {
            arrow.classList.remove('rotated');
          });
        }

        // Hàm bật/tắt submenu
        function toggleSubmenu(id) {
          const submenu = document.getElementById(`${id}-submenu`);
          const arrow = document.getElementById(`${id}-arrow`);
          submenu.classList.toggle('active');
          arrow.classList.toggle('rotated');
        }

        // Hiển thị trang chủ khi tải lần đầu
        document.addEventListener('DOMContentLoaded', () => {
          showPage('home');

          // Gán sự kiện click cho các nút trong sidebar
          const sidebarButtons = document.querySelectorAll('.nav-item > a.nav-link');
          sidebarButtons.forEach(button => {
            button.addEventListener('click', (e) => {
              // Ngăn chặn chuyển hướng mặc định của PHP base url
              e.preventDefault();

              // Lấy act từ href (ví dụ: '?act=khach-hang')
              const href = button.getAttribute('href');
              const match = href.match(/act=([^&]+)/);
              let pageId = 'home';
              if (match) {
                const act = match[1];
                switch (act) {
                  case 'khach-hang':
                    pageId = 'customers';
                    break;
                  case 'danh-muc':
                    pageId = 'categories';
                    break;
                  case 'tour':
                    pageId = 'tours';
                    break;
                  case 'ncc':
                    pageId = 'suppliers';
                    break;
                  case 'yeu-cau-dac-biet':
                    pageId = 'requests';
                    break;
                  // Submenu items are handled by the inner links
                }
              }
              showPage(pageId);
            });
          });
        });


        // Các script elementSdk, onConfigChange, mapToCapabilities, mapToEditPanelValues đã được giữ lại từ HTML ban đầu 
        // và được đặt trong thẻ <script> cuối cùng.
      </script>
</body>

</html>