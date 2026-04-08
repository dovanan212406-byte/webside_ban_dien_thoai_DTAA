<?php

class DonHang
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function addDonHang($userId, $receiverName, $receiverEmail, $receiverPhone, $receiverAddress, $note, $totalAmount, $paymentMethodId, $orderDate, $orderCode, $statusId)
    {
        try {
            $sql = 'INSERT INTO orders (user_id, receiver_name, receiver_email, receiver_phone, receiver_address, note, total_amount, payment_method_id, order_date, order_code, status_id)
                    VALUES (:user_id, :receiver_name, :receiver_email, :receiver_phone, :receiver_address, :note, :total_amount, :payment_method_id, :order_date, :order_code, :status_id)';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':user_id' => $userId,
                ':receiver_name' => $receiverName,
                ':receiver_email' => $receiverEmail,
                ':receiver_phone' => $receiverPhone,
                ':receiver_address' => $receiverAddress,
                ':note' => $note,
                ':total_amount' => $totalAmount,
                ':payment_method_id' => $paymentMethodId,
                ':order_date' => $orderDate,
                ':order_code' => $orderCode,
                ':status_id' => $statusId,
            ]);

            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            error_log('DonHang::addDonHang: ' . $e->getMessage());

            return false;
        }
    }

    public function addChiTietDonHang($orderId, $productId, $price, $quantity, $totalPrice)
    {
        try {
            $sql = "INSERT INTO order_items (order_id, product_id, price, quantity, total_price)
                    VALUES (:order_id, :product_id, :price, :quantity, :total_price)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':order_id' => $orderId,
                ':product_id' => $productId,
                ':price' => $price,
                ':quantity' => $quantity,
                ':total_price' => $totalPrice,
            ]);

            return true;
        } catch (Exception $e) {
            error_log('DonHang::addChiTietDonHang: ' . $e->getMessage());

            return false;
        }
    }

    public function getDonHangFromUser($userId)
    {
        try {
            $sql = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY order_date DESC, id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':user_id' => $userId]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('DonHang::getDonHangFromUser: ' . $e->getMessage());

            return [];
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
            error_log('DonHang::getTrangThaiDonHang: ' . $e->getMessage());

            return [];
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
            error_log('DonHang::getPhuongThucThanhToan: ' . $e->getMessage());

            return [];
        }
    }

    public function getDonHangById($orderId)
    {
        try {
            $sql = "SELECT * FROM orders WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $orderId]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('DonHang::getDonHangById: ' . $e->getMessage());

            return false;
        }
    }

    public function getDonHangByIdAndUser($orderId, $userId)
    {
        try {
            $sql = "SELECT * FROM orders WHERE id = :id AND user_id = :user_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $orderId, ':user_id' => $userId]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('DonHang::getDonHangByIdAndUser: ' . $e->getMessage());

            return false;
        }
    }

    public function updateTrangThaiDonHang($orderId, $statusId)
    {
        try {
            $sql = "UPDATE orders SET status_id = :status_id WHERE id = :id";
            $stmt = $this->conn->prepare($sql);

            return $stmt->execute([':id' => $orderId, ':status_id' => $statusId]);
        } catch (Exception $e) {
            error_log('DonHang::updateTrangThaiDonHang: ' . $e->getMessage());

            return false;
        }
    }

    public function getChiTietDonHangByDonHangId($orderId)
    {
        try {
            $sql = 'SELECT order_items.*, products.name, products.image
                    FROM order_items
                    INNER JOIN products ON order_items.product_id = products.id
                    WHERE order_items.order_id = :order_id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':order_id' => $orderId]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('DonHang::getChiTietDonHangByDonHangId: ' . $e->getMessage());

            return [];
        }
    }
}
