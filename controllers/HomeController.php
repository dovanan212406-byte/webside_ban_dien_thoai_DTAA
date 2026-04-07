<?php

class HomeController
{
    public $modelSanPham;
    public $modelTaiKhoan;

    public $modelGioHang;
    public $modelDonHang;

    public function __construct()
    {
        $this->modelSanPham = new SanPham();
        $this->modelTaiKhoan = new TaiKhoan();
        $this->modelGioHang = new GioHang();
        $this->modelDonHang = new DonHang();
    }

    /** Trang mặc định khi mở / — cùng logic với trangchu. */
    public function home()
    {
        $this->trangchu();
    }

    public function trangchu()
    {
        $listSanPham = $this->modelSanPham->getAllSanPham();
        if (!is_array($listSanPham)) {
            $listSanPham = [];
        }
        require_once './views/home.php';
    }

    // public function chiTietSanPham()
    // {
    //     $id = $_GET['id_san_pham'];
    //     $sanPham = $this->modelSanPham->getDetailSanPham($id);
    //     $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
    //     $listBinhLuan = $this->modelSanPham->getBinhLuanFormSanPham($id);
    //     $listSanPhamCungDanhMuc = $this->modelSanPham->getListSanPhamDanhMuc($sanPham['danh_muc_id']);
    //     // var_dump($listSanPhamCungDanhMuc);die;

    //     if ($sanPham) {
    //         require_once './views/detailSanPham.php';
    //     } else {
    //         header("Location: " . BASE_URL);
    //         exit();
    //     }
    // }

    public function formLogin()
    {
        require_once './views/auth/formLogin.php';
        if (!empty($_SESSION['client_auth_login_flash'])) {
            unset($_SESSION['client_auth_login_flash'], $_SESSION['client_auth_login_error']);
        }
    }

    public function postLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=login');
            exit();
        }

        $identifier = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $result = $this->modelTaiKhoan->checkLoginClient($identifier, $password);

        if (is_string($result) && str_contains($result, '@')) {
            $sql = 'SELECT * FROM users WHERE LOWER(TRIM(email)) = :email LIMIT 1';
            $stmt = $this->modelTaiKhoan->conn->prepare($sql);
            $stmt->execute([':email' => $result]);
            $userData = $stmt->fetch();
            if ($userData) {
                unset($userData['password']);
                $userData['ho_ten'] = $userData['full_name'] ?? '';
                $userData['so_dien_thoai'] = $userData['phone'] ?? '';
                $userData['dia_chi'] = $userData['address'] ?? '';
                $userData['chuc_vu_id'] = isset($userData['role_id']) ? (int) $userData['role_id'] : null;
                $userData['trang_thai'] = isset($userData['status']) ? (int) $userData['status'] : null;
            }

            $_SESSION['user_client'] = $userData;

            $cookiePath = parse_url(BASE_URL, PHP_URL_PATH) ?: '/';
            $cookiePath = rtrim($cookiePath, '/') . '/';
            if (!empty($_POST['remember'])) {
                setcookie('client_remember_email', $result, [
                    'expires' => time() + 30 * 86400,
                    'path' => $cookiePath,
                    'httponly' => true,
                    'samesite' => 'Lax',
                ]);
            } else {
                setcookie('client_remember_email', '', [
                    'expires' => time() - 3600,
                    'path' => $cookiePath,
                    'httponly' => true,
                    'samesite' => 'Lax',
                ]);
            }

            header('Location: ' . BASE_URL);
            exit();
        }

        $_SESSION['client_auth_login_error'] = is_string($result) ? $result : 'Đăng nhập thất bại, vui lòng thử lại.';
        $_SESSION['client_auth_login_flash'] = true;
        header('Location: ' . BASE_URL . '?act=login');
        exit();
    }

    public function logout()
    {
        unset($_SESSION['user_client']);
        header('Location: ' . BASE_URL);
        exit();
    }

    public function formRegister()
    {
        require_once './views/auth/formRegister.php';
        unset($_SESSION['client_auth_register_errors'], $_SESSION['old_dang_ky']);
    }

    public function postRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=dang-ky');
            exit();
        }

        $ho_ten = trim($_POST['ho_ten'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';
        $dong_y = isset($_POST['dong_y_dieu_khoan']) && $_POST['dong_y_dieu_khoan'] === '1';

        $errors = [];
        if ($ho_ten === '') {
            $errors[] = 'Vui lòng nhập họ tên.';
        }
        if (!$dong_y) {
            $errors[] = 'Bạn cần đồng ý điều khoản dịch vụ và chính sách bảo mật.';
        }
        if (strlen($password) < 6) {
            $errors[] = 'Mật khẩu tối thiểu 6 ký tự.';
        }
        if ($password !== $password_confirm) {
            $errors[] = 'Xác nhận mật khẩu không khớp.';
        }

        $so_dien_thoai = preg_replace('/\D/', '', (string) ($_POST['so_dien_thoai'] ?? ''));
        $dia_chi = '';

        if ($so_dien_thoai === '') {
            $errors[] = 'Vui lòng nhập số điện thoại.';
        } elseif (strlen($so_dien_thoai) < 9 || strlen($so_dien_thoai) > 10) {
            $errors[] = 'Số điện thoại phải 9–10 chữ số (VD: 0369389330).';
        }

        $email = strtolower(trim($_POST['email'] ?? ''));
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email không hợp lệ.';
        }
        if ($email !== '' && $this->modelTaiKhoan->emailDaTonTai($email)) {
            $errors[] = 'Email này đã được sử dụng.';
        }
        if ($so_dien_thoai !== '' && $this->modelTaiKhoan->soDienThoaiDaTonTai($so_dien_thoai)) {
            $errors[] = 'Số điện thoại này đã được sử dụng.';
        }

        if (!empty($errors)) {
            $_SESSION['client_auth_register_errors'] = $errors;
            $_SESSION['old_dang_ky'] = $_POST;
            header('Location: ' . BASE_URL . '?act=dang-ky');
            exit();
        }

        $ok = $this->modelTaiKhoan->dangKyKhach($ho_ten, $email, $so_dien_thoai, $password, $dia_chi);

        if ($ok) {
            header('Location: ' . BASE_URL . '?act=login&registered=1');
            exit();
        }

        $_SESSION['client_auth_register_errors'] = ['Không thể tạo tài khoản. Kiểm tra kết nối CSDL hoặc bảng users (full_name, email, phone, address, password, role_id, status).'];
        $_SESSION['old_dang_ky'] = $_POST;
        header('Location: ' . BASE_URL . '?act=dang-ky');
        exit();
    }

    public function gioHang()
    {
        $chiTietGioHang = [];
        if (!empty($_SESSION['user_client']['email'])) {
            $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
            if ($user && !empty($user['id'])) {
                try {
                    $gioHang = $this->modelGioHang->getGioHangFromUser($user['id']);
                    if (!$gioHang) {
                        $gioHangId = $this->modelGioHang->addGioHang($user['id']);
                        if ($gioHangId) {
                            $gioHang = ['id' => $gioHangId];
                        }
                    }
                    if (!empty($gioHang['id'])) {
                        $detail = $this->modelGioHang->getDetailGioHang($gioHang['id']);
                        if (is_array($detail)) {
                            $chiTietGioHang = $detail;
                        }
                    }
                } catch (Throwable $e) {
                    $chiTietGioHang = [];
                }
            }
        }
        require_once './views/gioHang.php';
    }

    // public function addGioHang()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         if (isset($_SESSION['user_client']['email'])) {
    //             $mail = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
    //             //lấy dữ liệu giỏ hàng của người dùng
    //             $gioHang = $this->modelGioHang->getGioHangFromUser($mail['id']);
    //             if (!$gioHang) {
    //                 $gioHangId = $this->modelGioHang->addGioHang($mail['id']);
    //                 $gioHang = ['id' => $gioHangId];
    //                 $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
    //             } else {
    //                 $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);

    //             }


    //             $san_pham_id = $_POST['san_pham_id'];
    //             $so_luong = $_POST['so_luong'];

    //             $checkSanPham = false;
    //             foreach ($chiTietGioHang as $detail) {
    //                 if ($detail['san_pham_id'] == $san_pham_id) {
    //                     $newSoLuong = $detail['so_luong'] + $so_luong;
    //                     $this->modelGioHang->updateSoLuong($gioHang['id'], $san_pham_id, $newSoLuong);
    //                     $checkSanPham = true;
    //                     break;
    //                 }
    //             }
    //             if (!$checkSanPham) {
    //                 $this->modelGioHang->addDetailGioHang($gioHang['id'], $san_pham_id, $so_luong);
    //             }
    //             header('Location: ' . BASE_URL . '?act=gio-hang');

    //         } else {
    //             var_dump('Lỗi chưa đăng nhập');
    //             die;
    //         }
    //     }
    // }
    // public function gioHang()
    // {
    //     if (isset($_SESSION['user_client']['email'])) {
    //         $mail = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
    //         //lấy dữ liệu giỏ hàng của người dùng
    //         $gioHang = $this->modelGioHang->getGioHangFromUser($mail['id']);
    //         if (!$gioHang) {
    //             $gioHangId = $this->modelGioHang->addGioHang($mail['id']);
    //             $gioHang = ['id' => $gioHangId];
    //             $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
    //         } else {
    //             $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);

    //         }
    //         require_once './views/gioHang.php';
    //         header('Location: ' . BASE_URL . '?act=gio-hang');

    //     } else {
    //         header('Location: ' . BASE_URL . '?act=login');

    //     }
    // }
    // public function thanhToan()
    // {

    //     if (isset($_SESSION['user_client']['email'])) {
    //         $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
    //         //lấy dữ liệu giỏ hàng của người dùng
    //         $gioHang = $this->modelGioHang->getGioHangFromUser($user['id']);
    //         if (!$gioHang) {
    //             $gioHangId = $this->modelGioHang->addGioHang($user['id']);
    //             $gioHang = ['id' => $gioHangId];
    //             $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
    //         } else {
    //             $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);

    //         }
    //         require_once './views/thanhToan.php';
    //         header('Location: ' . BASE_URL . '?act=gio-hang');

    //     } else {
    //         var_dump('Lỗi chưa đăng nhập');
    //         die;
    //     }

    // }
    // public function postThanhToan()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         $ten_nguoi_nhan = $_POST['ten_nguoi_nhan'];
    //         $email_nguoi_nhan = $_POST['email_nguoi_nhan'];
    //         $sdt_nguoi_nhan = $_POST['sdt_nguoi_nhan'];
    //         $dia_chi_nguoi_nhan = $_POST['dia_chi_nguoi_nhan'];
    //         $ghi_chu = $_POST['ghi_chu'];
    //         $tong_tien = $_POST['tong_tien'];
    //         $phuong_thuc_thanh_toan_id = $_POST['phuong_thuc_thanh_toan_id'];

    //         $ngay_dat = date('y-m-d ');
    //         $trang_thai_id = 1;
    //         $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
    //         $tai_khoan_id = $user['id'];
    //         $ma_don_hang = 'DH' . rand(1000, 9999);

    //         $donHang=$this->modelDonHang->addDonHang($tai_khoan_id, $ten_nguoi_nhan, $email_nguoi_nhan, $sdt_nguoi_nhan, $dia_chi_nguoi_nhan, $ghi_chu, $tong_tien, $phuong_thuc_thanh_toan_id, $ngay_dat, $ma_don_hang, $trang_thai_id);
    //         $gioHang = $this->modelGioHang->getGioHangFromUser($tai_khoan_id);
    //         if ($donHang) {
    //             // lay ra toan bo san pham trong gio hang
    //             $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
    //             //them tung san pham tu gio hang vao bang chi tiet don hang
    //             foreach($chiTietGioHang as $item){
    //                 $donGia=$item['gia_khuyen_mai'] ?? $item['gia_san_pham'];
    //                 $this->modelDonHang->addChiTietDonHang(
    //                     $donHang,// id don hang vua tao
    //                     $item['san_pham_id'],// id san pham
    //                     $donGia,// don gia cua san pham
    //                     $item['so_luong'],// so luong san pham
    //                     $donGia * $item['so_luong']// thanh tien cua san pham
    //                 );
    //             }
    //             // sau khi thanh toán thì xác nhận xóa sản phẩm trong giỏ hàng
    //             // Xóa toàn bộ sản phẩm trong chi tiết giỏ hàng
    //             $this->modelGioHang->clearDetailGioHang($gioHang['id']);
    //             // Xóa toàn bộ giỏ hàng người dùng
    //             $this->modelGioHang->clearGioHang($gioHang['id']);

    //             // Chuyển hướng về trang lịch sử mua hàng 
    //             header('Location: ' . BASE_URL . '?act=lich-su-mua-hang');
    //             exit();
    //         }else{
    //             var_dump('Lỗi khi đặt hàng,vui lòng thử lại sau');
    //         }
    //     }

    // }
    // public function lichSuMuaHang(){
    //     if(isset($_SESSION['user_client'])){
    //          $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
    //         $tai_khoan_id = $user['id'];
    //         //lấy ra đơn sách trạng thái đơn hàng 
    //         $arrTrangThaiDonHang = $this->modelDonHang->getAllTrangThaiDonHang();

    //         // lẩy ra danh sách trạngt thái thanh toán 
    //         $arrPhuongThucThanhToan = $this->modelDonHang->getAllPhuongThucThanhToan();
    //         //lấy ra danh sách tất cả đơn hang của tài khoản
    //         $donHangs = $this->modelDonHang->getDonHangFormUser($tai_khoan_id);
    //        require_once './views/lichSuMuaHang.php';
          
    //     }else{
    //         var_dump('Bạn chưa đăng nhập');  
    //         die;
    //     }
    // }
    // public function chiTietMuaHang(){

    // }
    // public function huyDonHang(){

    // }
}   