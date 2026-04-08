<?php
session_start();
// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/HomeController.php';

// Require toàn bộ file Models
require_once './models/TaiKhoan.php';
require_once './models/Sanpham.php';
require_once './models/GioHang.php';
require_once './models/DonHang.php';

// Route
$act = $_GET['act'] ?? '/';

// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    // Trang chủ
    '/'=>(new HomeController())->home(),
    'trangchu'=>(new HomeController())->trangchu(),
    'chi-tiet-san-pham'=>(new HomeController())->chiTietSanPham(),
    'them-gio-hang'=>(new HomeController())->addGioHang(),
    'cap-nhat-gio-hang'=>(new HomeController())->capNhatGioHang(),
    'xoa-gio-hang'=>(new HomeController())->xoaGioHang(),
    'gio-hang'=>(new HomeController())->gioHang(),
    'xoa-gio-hang-item'=>(new HomeController())->xoaGioHangItem(),
    'thanh-toan'=>(new HomeController())->thanhToan(),
    'xu-ly-thanh-toan'=>(new HomeController())->postThanhToan(),
    'lich-su-mua-hang'=>(new HomeController())->lichSuMuaHang(),
    'chi-tiet-mua-hang'=>(new HomeController())->chiTietMuaHang(),
    'huy-don-hang'=>(new HomeController())->huyDonHang(),
    // Đăng nhập / đăng ký khách
    'login'=>(new HomeController())->formLogin(),
    'check-login'=>(new HomeController())->postLogin(),
    'dang-ky'=>(new HomeController())->formRegister(),
    'check-dang-ky'=>(new HomeController())->postRegister(),
    'dang-xuat'=>(new HomeController())->logout(),
    // Tài khoản khách hàng
    'tai-khoan'=>(new HomeController())->taiKhoanKhachHang(),
    'cap-nhat-tai-khoan'=>(new HomeController())->capNhatTaiKhoanKhach(),
    // Trang thông tin
    'gioi-thieu'=>(new HomeController())->gioiThieu(),
    'lien-he'=>(new HomeController())->lienHe(),
    default=> (new HomeController())->home(),
};