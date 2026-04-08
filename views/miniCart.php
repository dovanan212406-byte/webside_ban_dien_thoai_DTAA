<?php
if (!isset($chiTietGioHang) || !is_array($chiTietGioHang)) {
    $chiTietGioHang = [];
}
$miniCartCount = 0;
$miniCartSubtotal = 0;
foreach ($chiTietGioHang as $row) {
    $miniCartCount += (int) ($row['quantity'] ?? 0);
    $gia = !empty($row['discount_price']) ? (float) $row['discount_price'] : (float) ($row['price'] ?? 0);
    $miniCartSubtotal += $gia * (int) ($row['quantity'] ?? 0);
}
?>
<!-- offcanvas mini cart start -->
<div class="offcanvas-minicart-wrapper">
    <div class="minicart-inner">
        <div class="offcanvas-overlay"></div>
        <div class="minicart-inner-content">
            <div class="minicart-close">
                <i class="pe-7s-close"></i>
            </div>
            <div class="minicart-content-box">
                <div class="minicart-item-wrapper">
                    <ul>
                        <?php if (empty($chiTietGioHang)) : ?>
                            <li class="minicart-item">
                                <p class="text-muted">Chưa có sản phẩm trong giỏ.</p>
                            </li>
                        <?php else :
                            foreach ($chiTietGioHang as $sanPham) :
                                $pid = (int) ($sanPham['product_id'] ?? 0);
                                $name = htmlspecialchars((string) ($sanPham['name'] ?? ''), ENT_QUOTES, 'UTF-8');
                                $img = htmlspecialchars((string) ($sanPham['image'] ?? ''), ENT_QUOTES, 'UTF-8');
                                $qty = (int) ($sanPham['quantity'] ?? 0);
                                $price = !empty($sanPham['discount_price']) ? (float) $sanPham['discount_price'] : (float) ($sanPham['price'] ?? 0);
                                $detailUrl = htmlspecialchars(BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $pid, ENT_QUOTES, 'UTF-8');
                                $removeUrl = htmlspecialchars(BASE_URL . '?act=xoa-gio-hang&san_pham_id=' . $pid, ENT_QUOTES, 'UTF-8');
                                ?>
                                <li class="minicart-item">
                                    <div class="minicart-thumb">
                                        <a href="<?= $detailUrl ?>">
                                            <img src="<?= htmlspecialchars(BASE_URL . $img, ENT_QUOTES, 'UTF-8') ?>" alt="<?= $name ?>">
                                        </a>
                                    </div>
                                    <div class="minicart-content">
                                        <h3 class="product-name">
                                            <a href="<?= $detailUrl ?>"><?= $name ?></a>
                                        </h3>
                                        <p>
                                            <span class="cart-quantity"><?= $qty ?><strong>&times;</strong></span>
                                            <span class="cart-price"><?= formatPrice((int) $price) ?></span>
                                        </p>
                                    </div>
                                    <a href="<?= $removeUrl ?>" class="minicart-remove" title="Xóa"><i class="pe-7s-close"></i></a>
                                </li>
                            <?php endforeach;
                        endif; ?>
                    </ul>
                </div>

                <?php if (!empty($chiTietGioHang)) : ?>
                <div class="minicart-pricing-box border-top pt-2">
                    <p><strong>Tạm tính:</strong> <?= formatPrice($miniCartSubtotal) ?></p>
                </div>
                <?php endif; ?>

                <div class="minicart-button">
                    <a href="<?= htmlspecialchars(BASE_URL . '?act=gio-hang', ENT_QUOTES, 'UTF-8') ?>"><i class="fa fa-shopping-cart"></i> Xem giỏ hàng</a>
                    <a href="<?= htmlspecialchars(BASE_URL . '?act=thanh-toan', ENT_QUOTES, 'UTF-8') ?>"><i class="fa fa-share"></i> Thanh toán</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- offcanvas mini cart end -->
