<?php
class AdminDonHang {
    public $conn;

    public function __construct(){
        $this->conn = connectDB();
    }

    // 1. Lấy danh sách tất cả đơn hàng (Hiển thị ở trang List)
    public function getAllDonHang(){
        try {
            $sql = "SELECT orders.*, 
                           orders.total_amount AS total_price, 
                           order_statuses.name AS ten_trang_thai
                    FROM orders
                    INNER JOIN order_statuses ON orders.status_id = order_statuses.id
                    ORDER BY orders.order_date DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll();
        } catch(Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // 2. Lấy danh sách tất cả trạng thái đơn hàng (Dùng cho dropdown select)
    public function getAllTrangThaiDonHang(){
        try {
            $sql = "SELECT * FROM order_statuses";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch(Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // 3. Lấy chi tiết 1 đơn hàng (Dùng cho trang Detail và Edit)
    public function getDetailDonHang($id){
        try {
            $sql = "SELECT orders.*, 
                           orders.total_amount AS total_price,
                           order_statuses.name AS ten_trang_thai, 
                           users.full_name, users.email AS user_email, users.phone AS user_phone,
                           payment_methods.name AS ten_phuong_thuc
                    FROM orders
                    INNER JOIN order_statuses ON orders.status_id = order_statuses.id 
                    INNER JOIN users ON orders.user_id = users.id 
                    INNER JOIN payment_methods ON orders.payment_method_id = payment_methods.id 
                    WHERE orders.id = :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);

            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // 4. Lấy danh sách sản phẩm thuộc đơn hàng (Dùng cho trang Detail)
    public function getListSpDonHang($id){
        try {
            $sql = "SELECT order_items.*, products.name, products.image
                    FROM order_items 
                    INNER JOIN products ON order_items.product_id = products.id
                    WHERE order_items.order_id = :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // 5. Cập nhật thông tin đơn hàng
    public function updateDonHang($id, $receiver_name, $receiver_phone, $receiver_email, $receiver_address, $note, $status_id){
        try {
            $sql = "UPDATE orders SET 
                        receiver_name = :receiver_name,
                        receiver_phone = :receiver_phone,
                        receiver_email = :receiver_email,
                        receiver_address = :receiver_address,
                        note = :note,
                        status_id = :status_id
                    WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':receiver_name' => $receiver_name,
                ':receiver_phone' => $receiver_phone,
                ':receiver_email' => $receiver_email,
                ':receiver_address' => $receiver_address,
                ':note' => $note,
                ':status_id' => $status_id,
                ':id' => $id,
            ]);
        } catch(Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
    // Trong file models/AdminDonHang.php (hoặc class AdminDonHang)
public function getDonHangFromKhachHang($id) {
    try {
        $sql = "SELECT 
                    orders.*, 
                    order_statuses.name AS status_name 
                FROM orders 
                JOIN order_statuses ON orders.status_id = order_statuses.id
                WHERE orders.user_id = :id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        return $stmt->fetchAll();
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
public function getDonHangByKhachHang($id) {
        try {
            // SQL JOIN giữa bảng orders và order_statuses
            // Lấy các cột cần thiết cho view chi tiết khách hàng
            $sql = "SELECT orders.*, order_statuses.name as status_name 
                    FROM orders 
                    INNER JOIN order_statuses ON orders.status_id = order_statuses.id 
                    WHERE orders.user_id = :id 
                    ORDER BY orders.id DESC";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Lỗi getDonHangByKhachHang: " . $e->getMessage());
            return [];
        }
    }

public function resetPassword($id, $password) {
    try {
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':password' => $password,
            ':id' => $id
        ]);
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
}