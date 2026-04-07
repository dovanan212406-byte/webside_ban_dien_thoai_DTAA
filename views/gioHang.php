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
                                <li class="breadcrumb-item active" aria-current="page">cart</li>
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
                        <!-- Cart Table Area -->
                        <div class="cart-table table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="pro-thumbnail">Ảnh sản phẩm</th>
                                        <th class="pro-title">Tên sản phẩm</th>
                                        <th class="pro-price">Giá</th>
                                        <th class="pro-quantity">Số lượng</th>
                                        <th class="pro-subtotal">Tổng tiền</th>
                                        <th class="pro-remove">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                     $tongGioHang=0;
                                    foreach ($chiTietGioHang as $key => $sanPham): 
                                       
                                        ?>
                                        <tr>
                                            <td class="pro-thumbnail"><a href="#"><img class="img-fluid"
                                                        src="<?= BASE_URL . $sanPham['image'] ?>" alt="Product" /></a></td>
                                            <td class="pro-title"><a href="#"><?= $sanPham['name'] ?></a></td>
                                            <td class="pro-price"><span>
                                                    <?php if ($sanPham['discount_price']) { ?>
                                                        <?= formatPrice($sanPham['discount_price']) ?>
                                                    <?php }else{ ?>
                                                        <?= formatPrice($sanPham['price']) ?>
                                                    <?php }?>    
                                                </span></td>

                                            <td class="pro-quantity">
                                                <div class="pro-qty"><input type="text" value="<?=$sanPham['quantity']?>"></div>
                                            </td>
                                            <td class="pro-subtotal"><span>
                                                        <?php
                                                        if($sanPham['discount_price']) {
                                                           $tong_tien=$sanPham['discount_price'] * $sanPham['quantity'];
                                                        } else {
                                                            $tong_tien=$sanPham['price'] * $sanPham['quantity'];
                                                        }
                                                          $tongGioHang += $tong_tien;
                                                         echo formatPrice($tong_tien);
                                                        ?>
                                            </span></td>
                                            <td class="pro-remove"><a href="#"><i class="fa fa-trash-o"></i></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                        <!-- Cart Update Option -->
                       
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5 ml-auto">
                        <!-- Cart Calculation Area -->
                        <div class="cart-calculator-wrapper">
                            <div class="cart-calculate-items">
                                <h6>Cart Totals</h6>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td>Tổng tiền sản phâm</td>
                                            <td><?=formatPrice($tongGioHang)?></td>
                                        </tr>
                                        <tr>
                                            <td>Phí vận chuyển</td>
                                            <td>250000</td>
                                        </tr>
                                        <tr class="total">
                                            <td>Tổng thanh toán</td>
                                            <td class="total-amount">
                                                <?php
                                                $tong_tien=$tongGioHang + 250000;
                                                echo formatPrice($tong_tien);
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <a href="<?=BASE_URL . '?act=thanh-toan'?>" class="btn btn-sqr d-block">Tiến hành đặt hàng</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cart main wrapper end -->
</main>

<?php require_once 'views/miniCart.php'; ?>

<?php require_once 'layout/footer.php'; ?>