<?php
   class SanPham {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getAllSanPham() {
        try {
            $sql = 'SELECT products.*, categories.name as ten_danh_muc
                    FROM products
                    INNER JOIN categories ON products.category_id = categories.id';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

     public function getDetailSanPham($id){
    try {
        $sql = "SELECT products.*, categories.name as ten_danh_muc
                    FROM products
                    INNER JOIN categories ON products.category_id = categories.id WHERE products.id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch();
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}

public function getListAnhSanPham($id){
    try {
        $sql = "SELECT * FROM product_images WHERE product_id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetchAll(); // lấy danh sách ảnh nên dùng fetchAll()
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
    public function getBinhLuanFormSanPham($id)
    {
        try {
            $sql = 'SELECT reviews.*, products.name, users.avatar
                    FROM reviews
                    INNER JOIN products ON reviews.product_id = products.id
                    INNER JOIN users ON reviews.user_id = users.id
                    WHERE reviews.product_id = :id';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
        }
    }

    public function getListSanPhamDanhMuc($danh_muc_id) {
        try {
            $sql = 'SELECT products.*, categories.name as ten_danh_muc
                    FROM products
                    INNER JOIN categories ON products.category_id = categories.id 
                     WHERE products.category_id = :category_id';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':category_id' => $danh_muc_id]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
}

?>