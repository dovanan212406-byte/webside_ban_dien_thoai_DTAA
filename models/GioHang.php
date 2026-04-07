<?php
class GioHang
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getGioHangFromUser($id)
    {
        try {
            $sql = 'SELECT * FROM carts WHERE user_id = :user_id';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':user_id' => $id]);

            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    public function getDetailGioHang($id)
    {
        try {
            $sql = 'SELECT cart_items.*, products.name, products.image, products.price, products.discount_price
            FROM cart_items
            INNER JOIN products ON cart_items.product_id = products.id
             WHERE cart_items.cart_id = :cart_id';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':cart_id' => $id]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    public function addGioHang($id)
    {
        try {
            $sql = 'INSERT INTO carts (user_id) VALUES (:user_id)';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':user_id' => $id]);

            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    public function updateSoLuong($cart_id, $product_id, $quantity)
    {
        try {
            $sql = 'UPDATE cart_items
            SET quantity = :quantity
            WHERE cart_id = :cart_id AND product_id = :product_id
            ';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':cart_id' => $cart_id, ':product_id' => $product_id, ':quantity' => $quantity]);

            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }


    public function addDetailGioHang($cart_id, $product_id, $quantity)
    {
        try {
            $sql = 'INSERT INTO cart_items (cart_id, product_id, quantity)
            VALUES (:cart_id, :product_id, :quantity)
            ';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':cart_id' => $cart_id, ':product_id' => $product_id, ':quantity' => $quantity]);

            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
    public function clearDetailGioHang($cart_id)
    {
        try {
            $sql = 'DELETE FROM cart_items
            WHERE cart_id = :cart_id ';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':cart_id' => $cart_id]);

            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
    public function clearGioHang($userId)
    {
        try {
            $sql = 'DELETE FROM carts
            WHERE user_id = :user_id ';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':user_id' => $userId]);

            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
    
}