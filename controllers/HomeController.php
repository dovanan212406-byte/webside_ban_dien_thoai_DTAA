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

    public function home()
    {
        $listSanPham = $this->modelSanPham->getAllSanPham();
        if (!is_array($listSanPham)) {
            $listSanPham = [];
        }
        require_once './views/home.php';
    }

    public function trangchu()
    {
        $this->home();
    }

    public function chiTietSanPham()
    {
        $id = isset($_GET['id_san_pham']) ? (int) $_GET['id_san_pham'] : 0;
        if ($id <= 0) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        if (!$sanPham) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
        if (!is_array($listAnhSanPham)) {
            $listAnhSanPham = [];
        }

        $listBinhLuan = $this->modelSanPham->getBinhLuanFormSanPham($id);
        if (!is_array($listBinhLuan)) {
            $listBinhLuan = [];
        }

        $danhMucId = isset($sanPham['category_id']) ? (int) $sanPham['category_id'] : 0;
        $listSanPhamCungDanhMuc = [];
        if ($danhMucId > 0) {
            $listSanPhamCungDanhMuc = $this->modelSanPham->getListSanPhamDanhMuc($danhMucId);
        }
        if (!is_array($listSanPhamCungDanhMuc)) {
            $listSanPhamCungDanhMuc = [];
        }

        require_once './views/detailSanPham.php';
    }

    public function gioiThieu()
    {
        require_once './views/gioiThieu.php';
    }

    public function lienHe()
    {
        require_once './views/lienHe.php';
    }

    /* ── Auth ── */

    public function formLogin()
    {
        /* Cho phép admin mở trang đăng nhập để đăng nhập tài khoản khách (postLogin sẽ xóa session admin) */
        require_once './views/auth/formLogin.php';
        if (!empty($_SESSION['client_auth_login_flash'])) {
            unset($_SESSION['client_auth_login_flash'], $_SESSION['client_auth_login_error']);
        }
    }

    public function postLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }

        $identifier = trim($_POST['email'] ?? '');
        $password = (string) ($_POST['password'] ?? '');

        $result = $this->modelTaiKhoan->checkLoginUnified($identifier, $password);

        $cookiePath = parse_url(BASE_URL, PHP_URL_PATH) ?: '/';
        $cookiePath = rtrim($cookiePath, '/') . '/';

        if (is_array($result) && !empty($result['ok'])) {
            $rememberVal = $identifier;
            if (trim((string) ($result['email'] ?? '')) !== '') {
                $rememberVal = strtolower(trim((string) $result['email']));
            } elseif (trim((string) ($result['phone'] ?? '')) !== '') {
                $rememberVal = trim((string) $result['phone']);
            }

            $roleId = (int) $result['role_id'];

            if ($roleId === 1) {
                unset($_SESSION['user_client']);
                $_SESSION['user_admin'] = [
                    'id' => (int) $result['id'],
                    'email' => (string) $result['email'],
                    'full_name' => (string) $result['full_name'],
                ];
                if (!empty($_POST['remember'])) {
                    setcookie('client_remember_email', $rememberVal, [
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
                header('Location: ' . BASE_URL_ADMIN);
                exit;
            }

            if ($roleId === 2) {
                unset($_SESSION['user_admin']);
                $userData = $this->modelTaiKhoan->getTaiKhoanById((int) $result['id']);
                if ($userData) {
                    unset($userData['password']);
                }
                $_SESSION['user_client'] = $userData;

                if (!empty($_POST['remember'])) {
                    setcookie('client_remember_email', $rememberVal, [
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
                exit;
            }
        }

        $msg = 'Đăng nhập thất bại, vui lòng thử lại.';
        if (is_string($result)) {
            $msg = $result;
        } elseif ($result === false) {
            $msg = 'Hệ thống tạm thời không xử lý được. Vui lòng thử lại sau.';
        }
        $_SESSION['client_auth_login_error'] = $msg;
        $_SESSION['client_auth_login_flash'] = true;
        header('Location: ' . BASE_URL . '?act=login');
        exit;
    }

    public function logout()
    {
        unset($_SESSION['user_client']);
        header('Location: ' . BASE_URL);
        exit;
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
            exit;
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
            exit;
        }

        $ok = $this->modelTaiKhoan->dangKyKhach($ho_ten, $email, $so_dien_thoai, $password, $dia_chi);

        if ($ok) {
            header('Location: ' . BASE_URL . '?act=login&registered=1');
            exit;
        }

        $_SESSION['client_auth_register_errors'] = ['Không thể tạo tài khoản. Kiểm tra kết nối CSDL.'];
        $_SESSION['old_dang_ky'] = $_POST;
        header('Location: ' . BASE_URL . '?act=dang-ky');
        exit;
    }

    /* ── Tài khoản khách ── */

    public function taiKhoanKhachHang()
    {
        if (empty($_SESSION['user_client'])) {
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }
        $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
        if (!$user) {
            unset($_SESSION['user_client']);
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }
        $ds = $this->modelDonHang->getDonHangFromUser($user['id']);
        $soDonHang = is_array($ds) ? count($ds) : 0;
        $chiTietGioHang = $this->getGioHangForUser();
        require_once './views/taiKhoanKhachHang.php';
    }

    public function capNhatTaiKhoanKhach()
    {
        if (empty($_SESSION['user_client'])) {
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=tai-khoan');
            exit;
        }
        $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
        if (!$user) {
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }
        $full_name = trim($_POST['full_name'] ?? $_POST['ho_ten'] ?? '');
        $phone = trim($_POST['phone'] ?? $_POST['so_dien_thoai'] ?? '');
        $address = trim($_POST['address'] ?? $_POST['dia_chi'] ?? '');

        if ($full_name === '') {
            $_SESSION['flash_loi_tai_khoan'] = 'Vui lòng nhập họ tên.';
            header('Location: ' . BASE_URL . '?act=tai-khoan');
            exit;
        }
        if ($this->modelTaiKhoan->capNhatThongTinKhachHang((int) $user['id'], $full_name, $phone, $address)) {
            $fresh = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
            if ($fresh) {
                $_SESSION['user_client'] = $fresh;
            }
            $_SESSION['flash_thanh_cong_tai_khoan'] = 'Đã cập nhật thông tin.';
        } else {
            $_SESSION['flash_loi_tai_khoan'] = 'Không thể cập nhật. Thử lại sau.';
        }
        header('Location: ' . BASE_URL . '?act=tai-khoan');
        exit;
    }

    /* ── Giỏ hàng ── */

    private function getGioHangForUser()
    {
        $chiTietGioHang = [];
        if (!empty($_SESSION['user_client']['id'])) {
            $userId = (int) $_SESSION['user_client']['id'];
            $gioHang = $this->modelGioHang->getGioHangFromUser($userId);
            if (!$gioHang) {
                $gioHangId = $this->modelGioHang->addGioHang($userId);
                if ($gioHangId === false) {
                    return [];
                }
                $gioHang = ['id' => $gioHangId];
            }
            if (!empty($gioHang['id'])) {
                $detail = $this->modelGioHang->getDetailGioHang($gioHang['id']);
                if (is_array($detail)) {
                    $chiTietGioHang = $detail;
                }
            }
        }
        return $chiTietGioHang;
    }

    public function gioHang()
    {
        if (empty($_SESSION['user_client'])) {
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }
        $chiTietGioHang = $this->getGioHangForUser();
        require_once './views/gioHang.php';
    }

    public function addGioHang()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL);
            exit;
        }
        if (empty($_SESSION['user_client']['id'])) {
            $_SESSION['error_them_gio_hang'] = 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.';
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }

        $userId = (int) $_SESSION['user_client']['id'];
        $sanPhamId = isset($_POST['san_pham_id']) ? (int) $_POST['san_pham_id'] : 0;
        $soLuong = isset($_POST['so_luong']) ? (int) $_POST['so_luong'] : 1;

        if ($sanPhamId <= 0 || $soLuong <= 0) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $sp = $this->modelSanPham->getDetailSanPham($sanPhamId);
        if (!$sp) {
            header('Location: ' . BASE_URL);
            exit;
        }
        $stock = (int) ($sp['quantity'] ?? 0);
        if ($stock < 1) {
            $_SESSION['flash_loi_gio_hang'] = 'Sản phẩm hiện đã hết hàng.';
            header('Location: ' . BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPhamId);
            exit;
        }

        $gioHang = $this->modelGioHang->getGioHangFromUser($userId);
        if (!$gioHang) {
            $gioHangId = $this->modelGioHang->addGioHang($userId);
            if ($gioHangId === false) {
                header('Location: ' . BASE_URL);
                exit;
            }
            $gioHang = ['id' => $gioHangId];
        }

        $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
        if (!is_array($chiTietGioHang)) {
            $chiTietGioHang = [];
        }

        $checkSanPham = false;
        foreach ($chiTietGioHang as $detail) {
            if ((int) $detail['product_id'] === $sanPhamId) {
                $newSoLuong = (int) $detail['quantity'] + $soLuong;
                if ($newSoLuong > $stock) {
                    $newSoLuong = $stock;
                }
                $this->modelGioHang->updateSoLuong($gioHang['id'], $sanPhamId, $newSoLuong);
                $checkSanPham = true;
                break;
            }
        }

        if (!$checkSanPham) {
            $this->modelGioHang->addDetailGioHang($gioHang['id'], $sanPhamId, $soLuong);
        }

        if (!empty($_POST['mua_ngay'])) {
            header('Location: ' . BASE_URL . '?act=thanh-toan');
        } else {
            header('Location: ' . BASE_URL . '?act=gio-hang');
        }
        exit;
    }

    public function capNhatGioHang()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=gio-hang');
            exit;
        }
        if (empty($_SESSION['user_client']['id'])) {
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }
        $userId = (int) $_SESSION['user_client']['id'];
        $sanPhamId = (int) ($_POST['san_pham_id'] ?? 0);
        $soLuong = (int) ($_POST['so_luong'] ?? 0);
        if ($sanPhamId <= 0) {
            header('Location: ' . BASE_URL . '?act=gio-hang');
            exit;
        }
        $gioHang = $this->modelGioHang->getGioHangFromUser($userId);
        if (!$gioHang || empty($gioHang['id'])) {
            header('Location: ' . BASE_URL . '?act=gio-hang');
            exit;
        }
        $cartId = (int) $gioHang['id'];
        if ($soLuong < 1) {
            $this->modelGioHang->xoaChiTietSanPham($cartId, $sanPhamId);
        } else {
            $this->modelGioHang->updateSoLuong($cartId, $sanPhamId, $soLuong);
        }
        header('Location: ' . BASE_URL . '?act=gio-hang');
        exit;
    }

    public function xoaGioHangItem()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=gio-hang');
            exit;
        }
        if (empty($_SESSION['user_client']['id'])) {
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }
        $userId = (int) $_SESSION['user_client']['id'];
        $sanPhamId = (int) ($_POST['san_pham_id'] ?? 0);
        if ($sanPhamId <= 0) {
            header('Location: ' . BASE_URL . '?act=gio-hang');
            exit;
        }
        $gioHang = $this->modelGioHang->getGioHangFromUser($userId);
        if ($gioHang && !empty($gioHang['id'])) {
            $this->modelGioHang->xoaChiTietSanPham((int) $gioHang['id'], $sanPhamId);
        }
        header('Location: ' . BASE_URL . '?act=gio-hang');
        exit;
    }

    public function xoaGioHang()
    {
        if (empty($_SESSION['user_client']['id'])) {
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }
        $productId = (int) ($_GET['san_pham_id'] ?? 0);
        if ($productId > 0) {
            $userId = (int) $_SESSION['user_client']['id'];
            $gioHang = $this->modelGioHang->getGioHangFromUser($userId);
            if ($gioHang && !empty($gioHang['id'])) {
                $this->modelGioHang->xoaChiTietSanPham((int) $gioHang['id'], $productId);
            }
        }
        header('Location: ' . BASE_URL . '?act=gio-hang');
        exit;
    }

    /* ── Thanh toán ── */

    public function thanhToan()
    {
        if (empty($_SESSION['user_client'])) {
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }

        $userId = (int) $_SESSION['user_client']['id'];
        $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);

        $chiTietGioHang = [];
        $gioHang = $this->modelGioHang->getGioHangFromUser($userId);
        if ($gioHang) {
            $detail = $this->modelGioHang->getDetailGioHang($gioHang['id']);
            if (is_array($detail)) {
                $chiTietGioHang = $detail;
            }
        }

        if (empty($chiTietGioHang)) {
            $_SESSION['error_gio_hang'] = 'Giỏ hàng trống, không thể thanh toán.';
            header('Location: ' . BASE_URL . '?act=gio-hang');
            exit;
        }

        require_once './views/thanhToan.php';
    }

    public function postThanhToan()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=thanh-toan');
            exit;
        }

        if (empty($_SESSION['user_client'])) {
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }

        $userId = (int) $_SESSION['user_client']['id'];
        $tenNguoiNhan = trim((string) ($_POST['ten_nguoi_nhan'] ?? ''));
        $emailNguoiNhan = trim((string) ($_POST['email_nguoi_nhan'] ?? ''));
        $sdtNguoiNhan = trim((string) ($_POST['sdt_nguoi_nhan'] ?? ''));
        $diaChiNguoiNhan = trim((string) ($_POST['dia_chi_nguoi_nhan'] ?? ''));
        $ghiChu = trim((string) ($_POST['ghi_chu'] ?? ''));
        $tongTien = (int) ($_POST['tong_tien'] ?? 0);
        $phuongThucThanhToanId = (int) ($_POST['phuong_thuc_thanh_toan_id'] ?? 1);
        $dongYDatHang = isset($_POST['dong_y_dat_hang']) && (string) $_POST['dong_y_dat_hang'] === '1';

        if (!$dongYDatHang) {
            $_SESSION['error_thanh_toan'] = 'Vui lòng xác nhận thông tin và tick đồng ý đặt hàng.';
            header('Location: ' . BASE_URL . '?act=thanh-toan');
            exit;
        }

        if ($tenNguoiNhan === '' || $emailNguoiNhan === '' || $sdtNguoiNhan === '' || $diaChiNguoiNhan === '') {
            $_SESSION['error_thanh_toan'] = 'Vui lòng nhập đầy đủ thông tin người nhận.';
            header('Location: ' . BASE_URL . '?act=thanh-toan');
            exit;
        }

        if (mb_strlen($tenNguoiNhan, 'UTF-8') < 2) {
            $_SESSION['error_thanh_toan'] = 'Họ và tên cần ít nhất 2 ký tự.';
            header('Location: ' . BASE_URL . '?act=thanh-toan');
            exit;
        }

        if (!filter_var($emailNguoiNhan, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_thanh_toan'] = 'Email không hợp lệ.';
            header('Location: ' . BASE_URL . '?act=thanh-toan');
            exit;
        }

        $sdtDigits = preg_replace('/\D/', '', $sdtNguoiNhan);
        if (strlen($sdtDigits) < 9 || strlen($sdtDigits) > 15) {
            $_SESSION['error_thanh_toan'] = 'Số điện thoại cần từ 9 đến 15 chữ số.';
            header('Location: ' . BASE_URL . '?act=thanh-toan');
            exit;
        }

        $diaChiStripped = preg_replace('/[\s\-.,;:_\/\\\\]+/u', '', $diaChiNguoiNhan);
        if (strlen($diaChiNguoiNhan) < 8 || strlen($diaChiStripped) < 5) {
            $_SESSION['error_thanh_toan'] = 'Vui lòng nhập địa chỉ nhận hàng đầy đủ (số nhà, đường, khu vực).';
            header('Location: ' . BASE_URL . '?act=thanh-toan');
            exit;
        }

        if (!in_array($phuongThucThanhToanId, [1, 2], true)) {
            $_SESSION['error_thanh_toan'] = 'Vui lòng chọn phương thức thanh toán hợp lệ.';
            header('Location: ' . BASE_URL . '?act=thanh-toan');
            exit;
        }

        $gioHang = $this->modelGioHang->getGioHangFromUser($userId);
        if (!$gioHang) {
            header('Location: ' . BASE_URL . '?act=gio-hang');
            exit;
        }

        $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
        if (empty($chiTietGioHang)) {
            header('Location: ' . BASE_URL . '?act=gio-hang');
            exit;
        }

        $maDonHang = 'DH' . date('YmdHis') . $userId;

        try {
            $donHangId = $this->modelDonHang->addDonHang(
                $userId, $tenNguoiNhan, $emailNguoiNhan, $sdtNguoiNhan,
                $diaChiNguoiNhan, $ghiChu, $tongTien,
                $phuongThucThanhToanId, date('Y-m-d H:i:s'), $maDonHang, 1
            );
            if ($donHangId === false || (int) $donHangId <= 0) {
                throw new RuntimeException('Không tạo được đơn hàng trong CSDL.');
            }

            foreach ($chiTietGioHang as $item) {
                $giaSanPham = !empty($item['discount_price']) ? $item['discount_price'] : $item['price'];
                $thanhTien = $giaSanPham * (int) $item['quantity'];
                $this->modelDonHang->addChiTietDonHang(
                    $donHangId, (int) $item['product_id'],
                    $giaSanPham, (int) $item['quantity'], $thanhTien
                );
            }

            $this->modelGioHang->clearDetailGioHang($gioHang['id']);

            $_SESSION['thanh_toan_thanh_cong'] = true;
            $_SESSION['ma_don_hang'] = $maDonHang;
            header('Location: ' . BASE_URL . '?act=lich-su-mua-hang');
            exit;
        } catch (Throwable $e) {
            $_SESSION['error_thanh_toan'] = 'Đặt hàng thất bại: ' . $e->getMessage();
            header('Location: ' . BASE_URL . '?act=thanh-toan');
            exit;
        }
    }

    /* ── Lịch sử mua hàng ── */

    public function lichSuMuaHang()
    {
        if (empty($_SESSION['user_client'])) {
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }

        $user = $this->modelTaiKhoan->getTaiKhoanFormEmail($_SESSION['user_client']['email']);
        if (!$user) {
            unset($_SESSION['user_client']);
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }
        $taiKhoanId = (int) $user['id'];

        $donHangs = $this->modelDonHang->getDonHangFromUser($taiKhoanId);
        if (!is_array($donHangs)) {
            $donHangs = [];
        }

        $trangThaiDonHang = $this->modelDonHang->getTrangThaiDonHang();
        $trangThaiMap = [];
        if (is_array($trangThaiDonHang)) {
            foreach ($trangThaiDonHang as $tt) {
                $trangThaiMap[$tt['id']] = $tt['name'];
            }
        }

        $phuongThucThanhToan = $this->modelDonHang->getPhuongThucThanhToan();
        $phuongThucMap = [];
        if (is_array($phuongThucThanhToan)) {
            foreach ($phuongThucThanhToan as $pt) {
                $phuongThucMap[$pt['id']] = $pt['name'];
            }
        }

        require_once './views/lichSuMuaHang.php';
    }

    public function chiTietMuaHang()
    {
        if (empty($_SESSION['user_client'])) {
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }

        $donHangId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($donHangId <= 0) {
            header('Location: ' . BASE_URL . '?act=lich-su-mua-hang');
            exit;
        }

        $donHang = $this->modelDonHang->getDonHangById($donHangId);
        if (!$donHang || (int) $donHang['user_id'] !== (int) $_SESSION['user_client']['id']) {
            header('Location: ' . BASE_URL . '?act=lich-su-mua-hang');
            exit;
        }

        $chiTietDonHang = $this->modelDonHang->getChiTietDonHangByDonHangId($donHangId);
        if (!is_array($chiTietDonHang)) {
            $chiTietDonHang = [];
        }

        $trangThaiDonHang = $this->modelDonHang->getTrangThaiDonHang();
        $trangThaiMap = [];
        if (is_array($trangThaiDonHang)) {
            foreach ($trangThaiDonHang as $tt) {
                $trangThaiMap[$tt['id']] = $tt['name'];
            }
        }

        $phuongThucThanhToan = $this->modelDonHang->getPhuongThucThanhToan();
        $phuongThucMap = [];
        if (is_array($phuongThucThanhToan)) {
            foreach ($phuongThucThanhToan as $pt) {
                $phuongThucMap[$pt['id']] = $pt['name'];
            }
        }

        require_once './views/chiTietMuaHang.php';
    }

    public function huyDonHang()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=lich-su-mua-hang');
            exit;
        }

        if (empty($_SESSION['user_client'])) {
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }

        $donHangId = isset($_POST['don_hang_id']) ? (int) $_POST['don_hang_id'] : 0;
        if ($donHangId <= 0) {
            header('Location: ' . BASE_URL . '?act=lich-su-mua-hang');
            exit;
        }

        $donHang = $this->modelDonHang->getDonHangById($donHangId);
        if (!$donHang || (int) $donHang['user_id'] !== (int) $_SESSION['user_client']['id']) {
            header('Location: ' . BASE_URL . '?act=lich-su-mua-hang');
            exit;
        }

        if ((int) $donHang['status_id'] !== 1) {
            $_SESSION['error_huy_don'] = 'Chỉ có thể hủy đơn hàng khi đang chờ xác nhận.';
            header('Location: ' . BASE_URL . '?act=lich-su-mua-hang');
            exit;
        }

        $this->modelDonHang->updateTrangThaiDonHang($donHangId, 5);
        $_SESSION['huy_don_thanh_cong'] = true;
        header('Location: ' . BASE_URL . '?act=lich-su-mua-hang');
        exit;
    }
}
