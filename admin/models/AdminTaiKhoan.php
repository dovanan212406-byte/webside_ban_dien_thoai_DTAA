<?php

class AdminTaiKhoan
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // 1. Lấy danh sách tài khoản theo role_id (1: Admin, 2: Khách hàng)
 public function getAllTaiKhoan($role_id)
    {
        try {
            $sql = "SELECT * FROM users WHERE role_id = :role_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':role_id' => $role_id]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return false;
        }
    }

    // 2. Thêm mới tài khoản quản trị
    public function insertTaiKhoan($full_name, $email, $phone, $address, $password, $role_id, $status) {
        try {
            $sql = "INSERT INTO users (full_name, email, phone, address, password, role_id, status) 
                    VALUES (:full_name, :email, :phone, :address, :password, :role_id, :status)";
            
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':full_name' => $full_name,
                ':email'     => $email,
                ':phone'     => $phone,
                ':address'   => $address,
                ':password'  => $password,
                ':role_id'   => $role_id,
                ':status'    => $status
            ]);
        } catch (Exception $e) {
            return false;
        }
    }

    // 3. Lấy chi tiết một tài khoản theo ID
    public function getDetailTaiKhoan($id) {
        try {
            $sql = "SELECT * FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(); 
        } catch (Exception $e) {
            return false;
        }
    }

    // 4. Cập nhật thông tin tài khoản (Dùng cho cả Admin sửa Admin và Cá nhân tự sửa)
    public function updateTaiKhoan($id, $full_name, $email, $phone, $address, $status)
    {
        try {
            $sql = "UPDATE users SET 
                    full_name = :full_name,
                    email = :email,
                    phone = :phone,
                    address = :address,
                    status = :status
                    WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':full_name' => $full_name,
                ':email'     => $email,
                ':phone'     => $phone,
                ':address'   => $address,
                ':status'    => $status,
                ':id'        => $id,
            ]);
        } catch (Exception $e) {
            return false;
        }
    }

    // 5. Xóa tài khoản
    public function deleteTaiKhoan($id) {
        try {
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (Exception $e) {
            return false;
        }
    }

    // 6. Reset hoặc Đổi mật khẩu
    public function resetPassword($id, $password)
    {
        try {
            $sql = "UPDATE users SET password = :password WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':password' => $password,
                ':id'       => $id,
            ]);
        } catch (Exception $e) {
            return false;
        }
    }

    // 7. Kiểm tra đăng nhập (Sử dụng password_verify để bảo mật)
  // Trong AdminTaiKhoan.php
public function checkLogin($emailOrPhone, $password) {
    $v = trim((string) $emailOrPhone);
    $sql = "SELECT * FROM users WHERE email = :v1 OR phone = :v2";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([':v1' => $v, ':v2' => $v]);
    $user = $stmt->fetch();

    if (!$user) {
        return false;
    }
    $stored = $user['password'] ?? '';
    $ok = false;
    if ($stored !== '' && (password_verify($password, $stored) || hash_equals($stored, $password))) {
        $ok = true;
    }
    if ($ok) {
        return $user;
    }
    return "Email/số điện thoại hoặc mật khẩu không đúng.";
}

    // 8. Lấy thông tin tài khoản bằng Email (Dùng cho Session)
    public function getTaiKhoanFromEmail($email)
    {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email]);
            return $stmt->fetch();
        } catch (Exception $e) {
            return false;
        }
    }

    // 9. Đếm số lượng Admin (Để chặn xóa Admin cuối cùng)
    public function countAdmin() {
        try {
            $sql = "SELECT COUNT(*) as total FROM users WHERE role_id = 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result['total'];
        } catch (Exception $e) {
            return 0;
        }
    }

    // 10. Cập nhật chi tiết khách hàng (Đầy đủ trường)
    public function updateKhachHang($id, $full_name, $email, $phone, $birthday, $gender, $address, $status)
    {
        try {
            $sql = "UPDATE users SET 
                    full_name = :full_name,
                    email = :email,
                    phone = :phone,
                    birthday = :birthday,
                    gender = :gender,
                    address = :address,
                    status = :status
                    WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':full_name' => $full_name,
                ':email'     => $email,
                ':phone'     => $phone,
                ':birthday'  => $birthday,
                ':gender'    => $gender,
                ':address'   => $address,
                ':status'    => $status,
                ':id'        => $id,
            ]);
        } catch (Exception $e) {
            return false;
        }
    }
   public function getBinhLuanByKhachHang($id) {
    try {
        // JOIN bảng reviews với products để lấy tên sản phẩm
        $sql = "SELECT reviews.*, products.name as product_name 
                FROM reviews 
                INNER JOIN products ON reviews.product_id = products.id 
                WHERE reviews.user_id = :id 
                ORDER BY reviews.review_date DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        return $stmt->fetchAll();
    } catch (Exception $e) {
        error_log("Lỗi getBinhLuanByKhachHang: " . $e->getMessage());
        return [];
    }
}
}