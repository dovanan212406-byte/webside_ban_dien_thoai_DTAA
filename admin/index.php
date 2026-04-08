<?php
session_start();
// Require file Common
require_once '../commons/env.php'; // Khai báo biến môi trường
require_once '../commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/AdminCategoryController.php';
require_once './controllers/AdminSanPhamController.php';
require_once './controllers/AdminTaiKhoanController.php';
require_once './controllers/AdminBaoCaoThongKeController.php';
require_once './controllers/AdminVaiTroController.php';
require_once './controllers/AdminDonHangController.php'; 
require_once './models/AdminDonHang.php';
require_once './controllers/AdminVaiTroController.php';




// Require toàn bộ file Models
require_once './models/AdminBaoCaoThongKe.php';
require_once './models/AdminCategory.php';
require_once './models/AdminSanPham.php';
require_once './models/AdminTaiKhoan.php';
require_once './models/AdminVaiTro.php';



// Route
$act = $_GET['act'] ?? '/';

$adminPublicActs = ['login-admin', 'check-login-admin', 'dang-ky-admin', 'check-dang-ky-admin', 'logout-admin'];
if (!in_array($act, $adminPublicActs, true)) {
    checkLoginAdmin();
}

// if ($act !== 'login-admin' && $act !== 'check-login-admin' && $act !== 'check-logout-admin') {
//     // Kiểm tra đăng nhập admin
//     checkLoginAdmin();
// }
// if ($act !== 'login-hdv' && $act !== 'check-loginHDV' && $act !== 'check-logout-hdv') {
//     // Kiểm tra đăng nhập admin
//     checkLoginAdmin();
// }

// if($act!== 'login-admin'&& $act!=='check-login-admin' && $act!=='check-logout-admin'){
//     // Kiểm tra đăng nhập admin
//     checkLoginAdmin();
// }


// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {

    // ================= DANH MỤC =================
    'category' => (new AdminCategoryController())->listCategory(),
    'form-them-category' => (new AdminCategoryController())->formAddCategory(),
    'them-category' => (new AdminCategoryController())->postAddCategory(),
    'form-sua-category' => (new AdminCategoryController())->formEditCategory(),
    'sua-category' => (new AdminCategoryController())->postEditCategory(),
    'xoa-category' => (new AdminCategoryController())->deleteCategory(),

    // ================= SẢN PHẨM =================
    'san-pham'               => (new AdminSanPhamController())->danhSachSanPham(),
    'form-them-san-pham'     => (new AdminSanPhamController())->formAddSanPham(),
    'them-san-pham'          => (new AdminSanPhamController())->postAddSanPham(),
    'form-sua-san-pham'      => (new AdminSanPhamController())->formEditSanPham(),
    'sua-san-pham'           => (new AdminSanPhamController())->postEditSanPham(),
    'xoa-san-pham'           => (new AdminSanPhamController())->deleteSanPham(),
    'chi-tiet-san-pham'      => (new AdminSanPhamController())->chiTietSanPham(),
    'sua-anh-san-pham'       => (new AdminSanPhamController())->postEditAnhSanPham(),

    // ================= ĐƠN HÀNG =================
    'don-hang'               => (new AdminDonHangController())->danhSachDonHang(),
    'chi-tiet-don-hang'      => (new AdminDonHangController())->detailDonHang(),
    'form-sua-don-hang'      => (new AdminDonHangController())->formEditDonHang(),
    'sua-don-hang'           => (new AdminDonHangController())->postEditDonHang(),

    // ================= TRANG CHỦ =================
    '/'                      => (new AdminBaoCaoThongKeController())->home(),


    // ================= VAI TRÒ =================
    'vai-tro'                => (new AdminVaiTroController())->listVaiTro(),
    'form-them-vai-tro'      => (new AdminVaiTroController())->formAddVaiTro(),
    'them-vai-tro'           => (new AdminVaiTroController())->postAddVaiTro(),
    'form-sua-vai-tro'       => (new AdminVaiTroController())->formEditVaiTro(),
    'sua-vai-tro'            => (new AdminVaiTroController())->postEditVaiTro(),
    'xoa-vai-tro'            => (new AdminVaiTroController())->deleteVaiTro(),

    // ================= TÀI KHOẢN - QUẢN TRỊ =================
    'list-tai-khoan-quan-tri' => (new AdminTaiKhoanController())->danhSachQuanTri(),
    'form-them-quan-tri'      => (new AdminTaiKhoanController())->formAddQuanTri(),
    'them-quan-tri'           => (new AdminTaiKhoanController())->postAddQuanTri(),
    'form-sua-quan-tri'       => (new AdminTaiKhoanController())->formEditQuanTri(),
    'sua-quan-tri'            => (new AdminTaiKhoanController())->postEditQuanTri(),
    'xoa-quan-tri'            => (new AdminTaiKhoanController())->deleteQuanTri(),

    // ================= TÀI KHOẢN - KHÁCH HÀNG =================
    'list-tai-khoan-khach-hang' => (new AdminTaiKhoanController())->danhSachKhachHang(),
    'form-sua-khach-hang'       => (new AdminTaiKhoanController())->formEditKhachHang(),
    'sua-khach-hang'            => (new AdminTaiKhoanController())->postEditKhachHang(),
    'chi-tiet-khach-hang'       => (new AdminTaiKhoanController())->detailKhachHang(),
    'khach-hang' => (new AdminTaiKhoanController())->listKhachHang(),

    // THÊM CÁC CASE CHO TÀI KHOẢN CÁ NHÂN QUẢN TRỊ VIÊN
    'form-sua-thong-tin-ca-nhan-quan-tri' => (new AdminTaiKhoanController())->formEditCaNhanQuanTri(),
    'sua-thong-tin-ca-nhan-quan-tri'      => (new AdminTaiKhoanController())->postEditCaNhanQuanTri(),
    'sua-mat-khau-ca-nhan-quan-tri'       => (new AdminTaiKhoanController())->postEditMatKhauCaNhan(),
     // route reset password

    'reset-password-khach-hang' => (new AdminTaiKhoanController())->resetPasswordKhachHang(),
    'reset-password-quan-tri'   => (new AdminTaiKhoanController())->resetPasswordQuanTri(),


    'login-admin'  => (new AdminTaiKhoanController())->formLoginAdmin(), // Nếu bạn có hàm hiển thị form
    'check-login-admin' => (new AdminTaiKhoanController())->postLoginAdmin(),
    'dang-ky-admin'      => (new AdminTaiKhoanController())->formRegisterAdmin(),
    'check-dang-ky-admin'=> (new AdminTaiKhoanController())->postRegisterAdmin(),
    'logout-admin' => (new AdminTaiKhoanController())->logout(),
};
   
    



