<?php

class AdminTaiKhoanController
{
    public $modelTaiKhoan;
    public $modelDonHang;
    public $modelSanPham;

    public function __construct()
    {
        $this->modelTaiKhoan = new AdminTaiKhoan();
        $this->modelDonHang = new AdminDonHang();
        $this->modelSanPham = new AdminSanPham();
    }

    // ============================================================
    // 1. AUTHENTICATION (ĐÃ SỬA TÊN FILE VIEW THEO ẢNH)
    // ============================================================

    public function formLoginAdmin() {
        header('Location: ' . BASE_URL . '?act=login');
        exit();
    }

    public function postLoginAdmin()
    {
        header('Location: ' . BASE_URL . '?act=login');
        exit();
    }

    public function logout()
    {
        unset($_SESSION['user_admin']);
        header('Location: ' . BASE_URL . '?act=login');
        exit();
    }

    public function formRegisterAdmin() {
        if (isset($_SESSION['user_admin'])) {
            header("Location: " . BASE_URL_ADMIN);
            exit();
        }
        $authTab = 'register';
        require_once './views/auth/auth.php';
        unset($_SESSION['error']);
        unset($_SESSION['old_register_admin']);
    }

    public function postRegisterAdmin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ho_ten = trim($_POST['ho_ten'] ?? '');
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';
            $dieu_khoan = isset($_POST['dieu_khoan']) && $_POST['dieu_khoan'] === '1';

            $email = trim($_POST['email'] ?? '');
            $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');

            $errors = [];
            if (empty($ho_ten)) {
                $errors[] = "Họ tên không được để trống.";
            }
            if (!$dieu_khoan) {
                $errors[] = "Vui lòng đồng ý điều khoản dịch vụ.";
            }
            if (strlen($password) < 6) {
                $errors[] = "Mật khẩu phải từ 6 ký tự.";
            }
            if ($password !== $password_confirm) {
                $errors[] = "Xác nhận mật khẩu không khớp.";
            }
            if ($email === '') {
                $errors[] = "Email không được để trống.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email không hợp lệ.";
            }

            if (empty($errors)) {
                $hash_pass = password_hash($password, PASSWORD_BCRYPT);
                $check = $this->modelTaiKhoan->insertTaiKhoan($ho_ten, $email, $so_dien_thoai, 'Hà Nội', $hash_pass, 1, 1);

                if ($check) {
                    header('Location: ' . BASE_URL . '?act=login&registered=1');
                    exit();
                } else {
                    $errors[] = "Email hoặc số điện thoại đã tồn tại.";
                }
            }
            $_SESSION['error'] = $errors;
            $_SESSION['old_register_admin'] = $_POST;
            header("Location: " . BASE_URL_ADMIN . "?act=dang-ky-admin");
            exit();
        }
    }

    // ============================================================
    // 2. QUẢN LÝ TÀI KHOẢN CÁ NHÂN (ĐÃ SỬA THƯ MỤC canhan)
    // ============================================================

    public function formEditCaNhanQuanTri() {
        if (!isset($_SESSION['user_admin'])) {
            header('Location: ' . BASE_URL . '?act=login');
            exit();
        }

        $email = $_SESSION['user_admin']['email']; 
        $thongTin = $this->modelTaiKhoan->getTaiKhoanFromEmail($email);

        // Sửa: Theo ảnh thư mục là canhan (viết liền)
        $file_view = './views/taikhoan/canhan/editCaNhan.php';
        if (file_exists($file_view)) {
            require_once $file_view;
        } else {
            die("Lỗi: Không tìm thấy file tại " . $file_view);
        }
    }

    public function postEditCaNhanQuanTri() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_SESSION['user_admin']['id'];
            $full_name = $_POST['ho_ten'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['so_dien_thoai'] ?? '';
            $address = $_POST['dia_chi'] ?? '';

            $status = $this->modelTaiKhoan->updateTaiKhoan($id, $full_name, $email, $phone, $address, 1);

            if ($status) {
                $_SESSION['success'] = "Cập nhật thành công!";
                $_SESSION['user_admin']['email'] = $email;
                $_SESSION['user_admin']['full_name'] = $full_name;
            } else {
                $_SESSION['error'] = "Cập nhật thất bại.";
            }
            header("Location: " . BASE_URL_ADMIN . "?act=form-sua-thong-tin-ca-nhan-quan-tri");
            exit();
        }
    }

    public function postEditMatKhauCaNhan() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_SESSION['user_admin']['id'];
            $old_pass = $_POST['old_pass'];
            $new_pass = $_POST['new_pass'];
            $confirm_pass = $_POST['confirm_pass'];

            $user = $this->modelTaiKhoan->getDetailTaiKhoan($id);
            $errors = [];

            if (!password_verify($old_pass, $user['password'])) {
                $errors[] = "Mật khẩu cũ không chính xác!";
            }
            if (empty($new_pass) || strlen($new_pass) < 6) {
                $errors[] = "Mật khẩu mới phải >= 6 ký tự!";
            }
            if ($new_pass !== $confirm_pass) {
                $errors[] = "Xác nhận mật khẩu mới không khớp!";
            }

            if (empty($errors)) {
                $hash_pass = password_hash($new_pass, PASSWORD_BCRYPT);
                $this->modelTaiKhoan->resetPassword($id, $hash_pass);
                $_SESSION['success'] = "Đổi mật khẩu thành công!";
            } else {
                $_SESSION['error'] = $errors;
            }
            header("Location: " . BASE_URL_ADMIN . "?act=form-sua-thong-tin-ca-nhan-quan-tri");
            exit();
        }
    }

    // ============================================================
    // 3. QUẢN LÝ QUẢN TRỊ VIÊN (BỔ SUNG HÀM TỪ INDEX.PHP)
    // ============================================================

    public function danhSachQuanTri() {
        $listQuanTri = $this->modelTaiKhoan->getAllTaiKhoan(1);
        require_once './views/taikhoan/quantri/listQuanTri.php';
    }
 public function postAddQuanTri()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Kiểm tra đã đăng nhập admin chưa
            if (!isset($_SESSION['user_admin']) || !isset($_SESSION['user_admin']['id'])) {
                header('Location: ' . BASE_URL . '?act=login');
                exit();
            }
            
            // Lấy dữ liệu từ form
            $full_name = trim($_POST['full_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $address = trim($_POST['address'] ?? 'Hà Nội');
            
            // Validation
            $errors = [];
            if (empty($full_name)) {
                $errors[] = "Họ và tên không được để trống";
            }
            if (empty($email)) {
                $errors[] = "Email không được để trống";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email không hợp lệ";
            }
            if (empty($phone)) {
                $errors[] = "Số điện thoại không được để trống";
            }

            // Lưu dữ liệu cũ nếu có lỗi
            if (!empty($errors)) {
                $_SESSION['error'] = $errors;
                $_SESSION['old_add'] = $_POST;
                header("Location: " . BASE_URL_ADMIN . "?act=form-them-quan-tri");
                exit();
            }

            // Password mặc định là 123456 và role_id = 1 (Quản trị)
            $password = password_hash('123456', PASSWORD_BCRYPT);
            $role_id = 1; 
            $status = 1;

            // Gọi model để thêm mới
            $check = $this->modelTaiKhoan->insertTaiKhoan(
                $full_name,
                $email,
                $phone,
                $address,
                $password,
                $role_id,
                $status
            );

            if ($check) {
                $_SESSION['success'] = "Tạo tài khoản quản trị viên thành công! Mật khẩu mặc định: 123456";
                header("Location: " . BASE_URL_ADMIN . "?act=list-tai-khoan-quan-tri");
                exit();
            } else {
                $_SESSION['error'] = ["Email hoặc số điện thoại đã tồn tại trong hệ thống"];
                $_SESSION['old_add'] = $_POST;
                header("Location: " . BASE_URL_ADMIN . "?act=form-them-quan-tri");
                exit();
            }
        }
    }
    public function formAddQuanTri() {
        // Kiểm tra đã đăng nhập admin chưa
        if (!isset($_SESSION['user_admin'])) {
            header('Location: ' . BASE_URL . '?act=login');
            exit();
        }
        // Kiểm tra session admin có đầy đủ thông tin id không
        if (!isset($_SESSION['user_admin']['id'])) {
            header('Location: ' . BASE_URL . '?act=login');
            exit();
        }
        
        require_once './views/taikhoan/quantri/addQuanTri.php';
        // Xóa dữ liệu cũ khi load form
        unset($_SESSION['old_add']);
    }

    // Bổ sung hàm formEditQuanTri (act trong index.php yêu cầu)
    public function formEditQuanTri() {
        $id = $_GET['id_quan_tri'];
        $quanTri = $this->modelTaiKhoan->getDetailTaiKhoan($id);
        require_once './views/taikhoan/quantri/editQuanTri.php';
    }

    public function postEditQuanTri() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['quan_tri_id'];
            $full_name = $_POST['ho_ten'];
            $email = $_POST['email'];
            $phone = $_POST['so_dien_thoai'];
            $address = $_POST['dia_chi'];
            $status = $_POST['trang_thai'];

            $this->modelTaiKhoan->updateTaiKhoan($id, $full_name, $email, $phone, $address, $status);
            header("Location: " . BASE_URL_ADMIN . "?act=list-tai-khoan-quan-tri");
            exit();
        }
    }

    public function deleteQuanTri() {
        $id = $_GET['id_quan_tri'];
        if ($id != $_SESSION['user_admin']['id']) {
            $this->modelTaiKhoan->deleteTaiKhoan($id);
        }
        header("Location: " . BASE_URL_ADMIN . "?act=list-tai-khoan-quan-tri");
        exit();
    }

    // ============================================================
    // 4. QUẢN LÝ KHÁCH HÀNG (BỔ SUNG HÀM TỪ INDEX.PHP)
    // ============================================================

    public function danhSachKhachHang() {
        $listKhachHang = $this->modelTaiKhoan->getAllTaiKhoan(2);
        require_once './views/taikhoan/khachhang/listKhachHang.php';
    }

  public function detailKhachHang() {
    $id = $_GET['id_khach_hang'];
    $khachHang = $this->modelTaiKhoan->getDetailTaiKhoan($id);
    
    // Sửa tên hàm cho đúng với Model AdminDonHang đã tạo ở bước trước
    $listDonHang = $this->modelDonHang->getDonHangByKhachHang($id); 
    
    // Bổ sung bình luận để view không bị báo lỗi undefined variable $listBinhLuan
    $listBinhLuan = $this->modelTaiKhoan->getBinhLuanByKhachHang($id);

    require_once './views/taikhoan/khachhang/detailKhachHang.php';
}

    // Bổ sung hàm formEditKhachHang (act trong index.php yêu cầu)
    public function formEditKhachHang() {
        $id = $_GET['id_khach_hang'];
        $khachHang = $this->modelTaiKhoan->getDetailTaiKhoan($id);
        require_once './views/taikhoan/khachhang/editKhachHang.php';
    }

    public function postEditKhachHang() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['khach_hang_id'];
            $full_name = $_POST['ho_ten'];
            $email = $_POST['email'];
            $phone = $_POST['so_dien_thoai'];
            $address = $_POST['dia_chi'];
            $status = $_POST['trang_thai'];

            $this->modelTaiKhoan->updateTaiKhoan($id, $full_name, $email, $phone, $address, $status);
            header("Location: " . BASE_URL_ADMIN . "?act=list-tai-khoan-khach-hang");
            exit();
        }
    }

    // Bổ sung hàm listKhachHang (alias của danhSachKhachHang trong index.php)
    public function listKhachHang() {
        $this->danhSachKhachHang();
    }

    // Bổ sung hàm reset mật khẩu (act trong index.php)
    public function resetPasswordQuanTri() {
        $id = $_GET['id_quan_tri'];
        $new_pass = password_hash('123456', PASSWORD_BCRYPT);
        $this->modelTaiKhoan->resetPassword($id, $new_pass);
        header("Location: " . BASE_URL_ADMIN . "?act=list-tai-khoan-quan-tri&msg=reset_ok");
    }
 public function chiTietKhachHang() {
    // Lấy ID từ URL
    $id = $_GET['id_khach_hang'];

    // 1. Lấy thông tin cá nhân (đã có)
    $khachHang = $this->modelTaiKhoan->getDetailTaiKhoan($id);

    // 2. Lấy lịch sử đơn hàng (đã có)
    $listDonHang = $this->modelDonHang->getDonHangByKhachHang($id);

    // 3. QUAN TRỌNG: Lấy danh sách bình luận
    // Đảm bảo bạn gọi đúng hàm vừa tạo ở bước 1
    $listBinhLuan = $this->modelTaiKhoan->getBinhLuanByKhachHang($id);

    // 4. Kiểm tra dữ liệu (Optional)
    if (!$khachHang) {
        header("Location: " . BASE_URL_ADMIN . "?act=khach-hang");
        exit();
    }

    // Nạp file view (File bạn đã gửi ở trên)
    require_once './views/taikhoan/khachhang/chiTietKhachHang.php';
}

    public function resetPasswordKhachHang() {
        $id = $_GET['id_khach_hang'];
        $new_pass = password_hash('123456', PASSWORD_BCRYPT);
        $this->modelTaiKhoan->resetPassword($id, $new_pass);
        header("Location: " . BASE_URL_ADMIN . "?act=list-tai-khoan-khach-hang&msg=reset_ok");
    }
}