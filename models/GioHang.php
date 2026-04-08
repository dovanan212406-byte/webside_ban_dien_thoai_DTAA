<?php

class GioHang
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getGioHangFromUser($userId)
    {
        try {
            $sql = 'SELECT * FROM carts WHERE user_id = :user_id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':user_id' => $userId]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('GioHang::getGioHangFromUser: ' . $e->getMessage());

            return false;
        }
    }

    public function getDetailGioHang($cartId)
    {
        try {
            $sql = 'SELECT cart_items.id,
                        cart_items.cart_id,
                        cart_items.product_id,
                        cart_items.quantity,
                        products.name, products.image,
                        products.price, products.discount_price,
                        products.quantity AS stock
                    FROM cart_items
                    INNER JOIN products ON cart_items.product_id = products.id
                    WHERE cart_items.cart_id = :cart_id';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':cart_id' => $cartId]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('GioHang::getDetailGioHang: ' . $e->getMessage());

            return [];
        }
    }

    public function addGioHang($userId)
    {
        try {
            $sql = 'INSERT INTO carts (user_id) VALUES (:user_id)';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':user_id' => $userId]);

            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            error_log('GioHang::addGioHang: ' . $e->getMessage());

            return false;
        }
    }

    public function updateSoLuong($cartId, $productId, $quantity)
    {
        try {
            $sql = 'UPDATE cart_items SET quantity = :quantity WHERE cart_id = :cart_id AND product_id = :product_id';
            $stmt = $this->conn->prepare($sql);

            return $stmt->execute([':cart_id' => $cartId, ':product_id' => $productId, ':quantity' => $quantity]);
        } catch (Exception $e) {
            error_log('GioHang::updateSoLuong: ' . $e->getMessage());

            return false;
        }
    }

    public function addDetailGioHang($cartId, $productId, $quantity)
    {
        try {
            $sql = 'INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)';
            $stmt = $this->conn->prepare($sql);

            return $stmt->execute([':cart_id' => $cartId, ':product_id' => $productId, ':quantity' => $quantity]);
        } catch (Exception $e) {
            error_log('GioHang::addDetailGioHang: ' . $e->getMessage());

            return false;
        }
    }

    public function clearDetailGioHang($cartId)
    {
        try {
            $sql = 'DELETE FROM cart_items WHERE cart_id = :cart_id';
            $stmt = $this->conn->prepare($sql);

            return $stmt->execute([':cart_id' => $cartId]);
        } catch (Exception $e) {
            error_log('GioHang::clearDetailGioHang: ' . $e->getMessage());

            return false;
        }
    }

    public function clearGioHang($userId)
    {
        try {
            $cart = $this->getGioHangFromUser($userId);
            if ($cart) {
                $this->clearDetailGioHang($cart['id']);
            }
            $sql = 'DELETE FROM carts WHERE user_id = :user_id';
            $stmt = $this->conn->prepare($sql);

            return $stmt->execute([':user_id' => $userId]);
        } catch (Exception $e) {
            error_log('GioHang::clearGioHang: ' . $e->getMessage());

            return false;
        }
    }

    public function xoaChiTietSanPham($cartId, $productId)
    {
        try {
            $sql = 'DELETE FROM cart_items WHERE cart_id = :cart_id AND product_id = :product_id';
            $stmt = $this->conn->prepare($sql);

            return $stmt->execute([':cart_id' => $cartId, ':product_id' => $productId]);
        } catch (Exception $e) {
            error_log('GioHang::xoaChiTietSanPham: ' . $e->getMessage());

            return false;
        }
    }
}
