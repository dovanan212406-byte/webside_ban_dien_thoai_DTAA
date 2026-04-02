<?php
class TaiKhoan
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    /** Ánh xạ dòng users → field tên cũ dùng trong view (không gồm password). */
    private static function rowClient(array $row): array
    {
        $row['ho_ten'] = $row['full_name'] ?? '';
        $row['so_dien_thoai'] = $row['phone'] ?? '';
        $row['dia_chi'] = $row['address'] ?? '';
        $row['chuc_vu_id'] = isset($row['role_id']) ? (int) $row['role_id'] : null;
        $row['trang_thai'] = isset($row['status']) ? (int) $row['status'] : null;
        unset($row['password']);

        return $row;
    }

    public function checkLogin($email, $mat_khau)
    {
        try {
            $emailNorm = strtolower(trim((string) $email));
            $sql = 'SELECT * FROM users WHERE LOWER(TRIM(email)) = :email LIMIT 1';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $emailNorm]);
            $user = $stmt->fetch();

            if (!$user) {
                return 'Bạn nhập sai thông tin mật khẩu hoặc tài khoản';
            }

            $stored = $user['password'] ?? '';
            $ok = $stored !== '' && (password_verify($mat_khau, $stored) || hash_equals($stored, $mat_khau));

            if ($ok) {
                if ((int) ($user['role_id'] ?? 0) === 2) {
                    if ((int) ($user['status'] ?? 0) === 1) {
                        return strtolower(trim((string) ($user['email'] ?? '')));
                    }

                    return 'Tài khoản bị cấm';
                }

                return 'Tài khoản không có quyền đăng nhập';
            }

            return 'Bạn nhập sai thông tin mật khẩu hoặc tài khoản';
        } catch (Exception $e) {
            echo 'lỗi: ' . $e->getMessage();

            return false;
        }
    }

    public function getTaiKhoanFormEmail($email)
    {
        try {
            $emailNorm = strtolower(trim((string) $email));
            $sql = 'SELECT * FROM users WHERE LOWER(TRIM(email)) = :email LIMIT 1';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $emailNorm]);
            $row = $stmt->fetch();

            return $row ? self::rowClient($row) : false;
        } catch (Exception $e) {
            echo 'Lỗi' . $e->getMessage();
        }
    }

    /** Kiểm tra email đã dùng (khách hoặc admin), không phân biệt hoa thường. */
    public function emailDaTonTai($email)
    {
        try {
            $emailNorm = strtolower(trim((string) $email));
            if ($emailNorm === '') {
                return false;
            }
            $sql = 'SELECT id FROM users WHERE LOWER(TRIM(email)) = :email LIMIT 1';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $emailNorm]);

            return (bool) $stmt->fetch();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Đăng ký khách hàng (role_id = 2, status = 1) — bảng users.
     */
    public function dangKyKhach($ho_ten, $email, $so_dien_thoai, $mat_khau, $dia_chi = '')
    {
        try {
            $hash = password_hash($mat_khau, PASSWORD_DEFAULT);
            $addr = $dia_chi !== '' ? $dia_chi : '-';
            $sql = 'INSERT INTO users (full_name, email, phone, gender, address, password, role_id, status)
                    VALUES (:full_name, :email, :phone, 1, :address, :password, 2, 1)';
            $stmt = $this->conn->prepare($sql);

            return $stmt->execute([
                ':full_name' => $ho_ten,
                ':email' => $email,
                ':phone' => $so_dien_thoai,
                ':address' => $addr,
                ':password' => $hash,
            ]);
        } catch (Exception $e) {
            return false;
        }
    }
}
