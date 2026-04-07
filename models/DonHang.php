<?php
class DonHang
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function addDonHang($tai_khoan_id, $ten_nguoi_nhan, $email_nguoi_nhan, $sdt_nguoi_nhan, $dia_chi_nguoi_nhan, $ghi_chu, $tong_tien, $phuong_thuc_thanh_toan_id, $ngay_dat, $ma_don_hang, $trang_thai_id)
    {
        try {
            $sql = 'INSERT INTO orders (user_id, receiver_name, receiver_email, receiver_phone, receiver_address, note, total_amount, payment_method_id, order_date, order_code, status_id) VALUES (:user_id, :receiver_name, :receiver_email, :receiver_phone, :receiver_address, :note, :total_amount, :payment_method_id, :order_date, :order_code, :status_id)';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute(
                [
                    ':user_id' => $tai_khoan_id,
                    ':receiver_name' => $ten_nguoi_nhan,
                    ':receiver_email' => $email_nguoi_nhan,
                    ':receiver_phone' => $sdt_nguoi_nhan,
                    ':receiver_address' => $dia_chi_nguoi_nhan,
                    ':note' => $ghi_chu,
                    ':total_amount' => $tong_tien,
                    ':payment_method_id' => $phuong_thuc_thanh_toan_id,
                    ':order_date' => $ngay_dat,
                    ':order_code' => $ma_don_hang,
                    ':status_id' => $trang_thai_id
                ]
            );

            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
    public function addChiTietDonHang($donhangId, $sanPhamId, $donGia, $soLuong, $thanhTien)
    {
        try {
            $sql = "INSERT INTO order_items (order_id, product_id, price, quantity, total_price)
            VALUE (:order_id, :product_id, :price, :quantity, :total_price)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':order_id' => $donhangId,
                ':product_id' => $sanPhamId,
                ':price' => $donGia,
                ':quantity' => $soLuong,
                ':total_price' => $thanhTien
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
    public function getDonHangFromUser($taikhoanId){
        try{
            $sql = "SELECT * FROM orders WHERE user_id = :user_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                'user_id' => $taikhoanId,
            ]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo "Lỗi". $e->getMessage();
        }
    }
    public function getTrangThaiDonHang()
    {
        try {
            $sql = "SELECT * FROM order_statuses";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
    public function getPhuongThucThanhToan()
    {
        try {
            $sql = "SELECT * FROM payment_methods";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
    public function getDonHangById($donHangId)
    {
        try {
            $sql = "SELECT * FROM orders WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id'=>$donHangId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
    public function updateTrangThaiDonHang($donHangId,$trangThaiId)
    {
        try {
            $sql = "UPDATE orders SET status_id = :status_id WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id'=>$donHangId,':status_id'=>$trangThaiId]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
    public function getChiTietDonHangByDonHangId($donHangId)
    {
        try {
            $sql = "SELECT order_items.*, products.name, products.image
            FROM order_items JOIN products ON order_items.product_id = products.id
            WHERE order_items.order_id = :order_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':order_id'=>$donHangId]);
           return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

}