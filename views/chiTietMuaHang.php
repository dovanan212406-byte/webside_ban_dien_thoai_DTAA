<?php require_once 'layout/header.php'; ?>
<?php require_once 'layout/menu.php'; ?>
<main>
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="shop.html">shop</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Bill detail</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- cart main wrapper start -->
    <div class="cart-main-wrapper section-padding">
        <div class="container">
            <div class="section-bg-color">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Thông tin sản phẩm của đơn hàng -->
                        <div class="cart-table table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                   <tr>
                                    <th colspan="5">Thông tin sản phẩm</th>
                                   </tr>
                                </thead>
                                <>
                                    <tr class="text-center">
                                        <th>Hình ảnh</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Đơn giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                    <?php foreach($chiTietDonHang as $item) : ?>
                                        <tr>
                                            <td><img class="img-fluid" src="<?= BASE_URL . $item['image'] ?>" alt="Product" width="100px" alt=""></td>
                                            <td><?=$item['name']?></td>
                                            <td><?=formatPrice($item['price'])?></td>
                                            <td><?=$item['quantity']?></td>
                                            <td><?=formatPrice($item['total_price'])?></td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                        <!-- Cart Update Option -->
                    </div>
                    <div class="col-lg-12">
                        <!-- Thông tin sản phẩm của đơn hàng -->
                        <div class="cart-table table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                   <tr>
                                    <th colspan="5">Thông tin sản phẩm</th>
                                   </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <th colspan="2">Người nhận</th>
                                    <td><?=$donHang['ten_nguoi_nhan']?></td>
                                   </tr>
                                  <tr>
                                    <th colspan="2">Email</th>
                                    <td><?=$donHang['email_nguoi_nhan']?></td>
                                   </tr>
                                  <tr>
                                    <th colspan="2">Số điện thoại</th>
                                    <td><?=$donHang['sdt_nguoi_nhan']?></td>
                                   </tr>
                                  <tr>
                                    <th colspan="2">Địa chỉ</th>
                                    <td><?=$donHang['dia_chi_nguoi_nhan']?></td>
                                   </tr>
                                  <tr>
                                    <th colspan="2">Ngày đặt</th>
                                    <td><?=$donHang['ngay_dat']?></td>
                                   </tr>
                                  <tr>
                                    <th colspan="2">Ghi chú</th>
                                    <td><?=$donHang['ghi_chu']?></td>
                                   </tr>
                                  <tr>
                                    <th colspan="2">Tổng tiền</th>
                                    <td><?=formatPrice( $donHang['tong_tien'])?></td>
                                   </tr>
                                  <tr>
                                    <th colspan="2">Phương thức thanh toán</th>
                                    <td><?=$phuongThucThanhToan[$donHang['phuong_thuc_thanh_toan_id']]?></td>
                                   </tr>
                                  <tr>
                                    <th colspan="2">Trangj thái đơn hàng</th>
                                    <td><?=$trangThaiDonHang[$donHang['trang_thai_id']]?></td>
                                   </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Cart Update Option -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cart main wrapper end -->
</main>

<?php require_once 'views/miniCart.php'; ?>

<?php require_once 'layout/footer.php'; ?>