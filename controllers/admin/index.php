<?php
session_start();
// Require file Common
require_once '../commons/env.php'; // Khai báo biến môi trường
require_once '../commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/AdminDanhMucController.php';
require_once './controllers/AdminSanPhamController.php';
require_once './controllers/AdminDonHangController.php';
require_once './controllers/AdminBaoCaoThongKeController.php';
require_once './controllers/AdminTaiKhoanController.php';

// Require toàn bộ file Models
require_once './models/AdminDanhMuc.php';
require_once './models/AdminSanPham.php';
require_once './models/AdminDonHang.php';
require_once './models/AdminTaiKhoan.php';

// Route
$act = $_GET['act'] ?? '/';

$adminPublicActs = ['login-admin', 'check-login-admin', 'dang-ky-admin', 'check-dang-ky-admin', 'logout-admin'];
if (!in_array($act, $adminPublicActs, true)) {
    checkLoginAdmin();
}

// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    // route danh mục
    'danh-muc' => (new AdminCategoryController())->listCategory(),
    'form-them-danh-muc' => (new AdminCategoryController())->formAddCategory(),
    'them-danh-muc' => (new AdminCategoryController())->postAddCategory(),
    'form-sua-danh-muc' => (new AdminCategoryController())->formEditCategory(),
    'sua-danh-muc' => (new AdminCategoryController())->postEditCategory(),
    'xoa-danh-muc' => (new AdminCategoryController())->deleteCategory(),

    // route Sản phẩm
    'san-pham' => (new AdminSanPhamController())->danhSachSanPham(),
    'form-them-san-pham' => (new AdminSanPhamController())->formAddSanPham(),
    'them-san-pham' => (new AdminSanPhamController())->postAddSanPham(),
    'form-sua-san-pham' => (new AdminSanPhamController())->formEditSanPham(),
    'sua-san-pham' => (new AdminSanPhamController())->postEditSanPham(),
    'xoa-san-pham' => (new AdminSanPhamController())->deleteSanPham(),
    'chi-tiet-san-pham' => (new AdminSanPhamController())->chiTietSanPham(),


     // route đơn hàng
    'don-hang' => (new AdminDonHangController())->danhSachDonHang(),
    'sua-don-hang' => (new AdminDonHangController())->postEditDonHang(),
    'chi-tiet-don-hang' => (new AdminDonHangController())->detailDonHang(),
    'form-sua-don-hang' => (new AdminDonHangController())->formEditDonHang(),
    // route Trang chủ
    '/'=>(new AdminBaoCaoThongKeController())->home(),


    // route quản lí tài khoản
        //Quản lí tài khoản quản trị
        'list-tai-khoan-quan-tri' => (new AdminTaiKhoanController())->danhSachQuanTri(),
        'form-them-quan-tri' => (new AdminTaiKhoanController())->formAddQuanTri(),
        'them-quan-tri' => (new AdminTaiKhoanController())->postAddQuanTri(),
        'form-sua-quan-tri' => (new AdminTaiKhoanController())->formEditQuanTri(),
        'sua-quan-tri' => (new AdminTaiKhoanController())->postEditQuanTri(),

        //route reset password
        'reset-password' => (new AdminTaiKhoanController())->resetPassword(),

        //route quản lý tài khoản khach hàng
        'list-tai-khoan-khach-hang' => (new AdminTaiKhoanController())->danhSachKhachHang(),
        'form-sua-khach-hang' => (new AdminTaiKhoanController())->formEditKhachHang(),
        'sua-khach-hang' => (new AdminTaiKhoanController())->postEditKhachHang(),
        'chi-tiet-khach-hang' => (new AdminTaiKhoanController())->detailKhachHang(),

        // route quản lý tài khoản cá nhân
        'form-sua-thong-tin-ca-nhan-quan-tri'=>(new AdminTaiKhoanController())->formEditCaNhanQuanTri(),
        'sua-thong-tin-ca-nhan-quan-tri'=>(new AdminTaiKhoanController())->postEditCaNhanQuanTri(),
        'sua-mat-khau-ca-nhan-quan-tri'=>(new AdminTaiKhoanController())->postEditMatKhauCaNhan(),


        //route login — chuyển hướng về trang đăng nhập chung
        'login-admin'=> function() { header('Location: ' . BASE_URL . '?act=login'); exit(); },
        'check-login-admin'=> function() { header('Location: ' . BASE_URL . '?act=login'); exit(); },
        'dang-ky-admin'=> (new AdminTaiKhoanController())->formRegisterAdmin(),
        'check-dang-ky-admin'=> (new AdminTaiKhoanController())->postRegisterAdmin(),
        'logout-admin'=> (new AdminTaiKhoanController())->logout(),
};