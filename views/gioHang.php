<?php
require_once 'layout/header.php';
require_once 'layout/menu.php';

$chiTietGioHang = is_array($chiTietGioHang ?? null) ? $chiTietGioHang : [];
$loggedIn = !empty($_SESSION['user_client']['id']);

$tongGioHang = 0;
$tongSoLuong = 0;
$tietKiem = 0;
foreach ($chiTietGioHang as $row) {
    $qty = (int) ($row['quantity'] ?? 0);
    $price = (float) ($row['price'] ?? 0);
    $disc = $row['discount_price'] !== null && $row['discount_price'] !== '' ? (float) $row['discount_price'] : null;
    $giaBan = $disc !== null ? $disc : $price;
    $tongGioHang += (int) round($giaBan * $qty);
    $tongSoLuong += $qty;
    if ($disc !== null && $price > $disc) {
        $tietKiem += (int) round(($price - $disc) * $qty);
    }
}
$phiShip = 250000;
$tongDon = $tongGioHang + $phiShip;
$capNhatUrl = htmlspecialchars(BASE_URL . '?act=cap-nhat-gio-hang', ENT_QUOTES, 'UTF-8');
$xoaUrl = htmlspecialchars(BASE_URL . '?act=xoa-gio-hang-item', ENT_QUOTES, 'UTF-8');
$hasItems = $loggedIn && count($chiTietGioHang) > 0;
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/cart-page.css">

<main class="cart-page">
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8') ?>"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8') ?>">Cửa hàng</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cart-main-wrapper section-padding">
        <div class="container">
            <div class="cart-page__toolbar">
                <a class="cart-page__back" href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8') ?>" aria-label="Về trang chủ"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                <div class="cart-page__toolbar-center">
                    <h1 class="cart-page__title">Giỏ hàng của bạn</h1>
                    <?php if ($hasItems): ?>
                        <span class="cart-page__badge"><?= (int) $tongSoLuong ?> sản phẩm</span>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!$loggedIn): ?>
                <div class="cart-page__empty">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    <h2>Đăng nhập để xem giỏ hàng</h2>
                    <p>Vui lòng đăng nhập để quản lý sản phẩm đã thêm.</p>
                    <a href="<?= htmlspecialchars(BASE_URL . '?act=login', ENT_QUOTES, 'UTF-8') ?>">Đăng nhập</a>
                </div>
            <?php elseif (!$hasItems): ?>
                <div class="cart-page__empty">
                    <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                    <h2>Giỏ hàng trống</h2>
                    <p>Hãy thêm sản phẩm yêu thích để tiếp tục mua sắm.</p>
                    <a href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8') ?>">Tiếp tục mua sắm</a>
                </div>
            <?php else: ?>
                <div class="cart-page__layout">
                <div class="cart-page__grid">
                    <div class="cart-page__items">
                        <?php foreach ($chiTietGioHang as $sanPham):
                            $pid = (int) ($sanPham['product_id'] ?? 0);
                            $qty = (int) ($sanPham['quantity'] ?? 0);
                            $price = (float) ($sanPham['price'] ?? 0);
                            $hasDisc = isset($sanPham['discount_price']) && $sanPham['discount_price'] !== '' && $sanPham['discount_price'] !== null;
                            $disc = $hasDisc ? (float) $sanPham['discount_price'] : null;
                            $giaBan = $disc !== null ? $disc : $price;
                            $lineTotal = (int) round($giaBan * $qty);
                            $name = (string) ($sanPham['name'] ?? '');
                            $img = (string) ($sanPham['image'] ?? '');
                            $detailHref = htmlspecialchars(BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $pid, ENT_QUOTES, 'UTF-8');
                            ?>
                            <article class="cart-page__item">
                                <div class="cart-page__item-top">
                                    <a href="<?= $detailHref ?>" class="cart-page__thumb-link">
                                        <img class="cart-page__thumb" src="<?= htmlspecialchars(BASE_URL . $img, ENT_QUOTES, 'UTF-8') ?>"
                                             alt="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>" loading="lazy">
                                    </a>
                                    <div class="cart-page__item-body">
                                        <form action="<?= $xoaUrl ?>" method="post" class="cart-page__remove-form" onsubmit="return confirm('Xóa sản phẩm này khỏi giỏ?');">
                                            <input type="hidden" name="san_pham_id" value="<?= $pid ?>">
                                            <button type="submit" class="cart-page__item-remove" aria-label="Xóa sản phẩm">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                        <h2 class="cart-page__item-name">
                                            <a href="<?= $detailHref ?>"><?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></a>
                                        </h2>
                                        <div class="cart-page__prices">
                                            <span class="cart-page__price-now"><?= formatPrice((int) $giaBan) ?></span>
                                            <?php if ($hasDisc && $price > $disc): ?>
                                                <span class="cart-page__price-old"><?= formatPrice((int) $price) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="cart-page__row-bottom">
                                    <div class="cart-page__qty" role="group" aria-label="Số lượng">
                                        <form action="<?= $capNhatUrl ?>" method="post">
                                            <input type="hidden" name="san_pham_id" value="<?= $pid ?>">
                                            <input type="hidden" name="so_luong" value="<?= max(0, $qty - 1) ?>">
                                            <button type="submit" aria-label="Giảm số lượng" <?= $qty <= 1 ? 'disabled' : '' ?> title="Giảm">−</button>
                                        </form>
                                        <span><?= $qty ?></span>
                                        <form action="<?= $capNhatUrl ?>" method="post">
                                            <input type="hidden" name="san_pham_id" value="<?= $pid ?>">
                                            <input type="hidden" name="so_luong" value="<?= $qty + 1 ?>">
                                            <button type="submit" aria-label="Tăng số lượng" title="Tăng">+</button>
                                        </form>
                                    </div>
                                    <p class="cart-page__line-total">Tạm tính: <strong><?= formatPrice($lineTotal) ?></strong></p>
                                </div>
                                <div class="cart-page__promo-hint">
                                    <i class="fa fa-gift" aria-hidden="true"></i>
                                    <span>Ưu đãi và bảo hành theo chính sách từng sản phẩm — xem chi tiết tại trang sản phẩm.</span>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <aside class="cart-page__summary">
                        <p class="cart-page__summary-eyebrow">Thanh toán</p>
                        <h2>Tóm tắt đơn hàng</h2>
                        <div class="cart-page__summary-row">
                            <span>Tổng tiền hàng</span>
                            <span><?= formatPrice($tongGioHang) ?></span>
                        </div>
                        <div class="cart-page__summary-row">
                            <span>Phí vận chuyển</span>
                            <span><?= formatPrice($phiShip) ?></span>
                        </div>
                        <?php if ($tietKiem > 0): ?>
                            <p class="cart-page__save">Đã tiết kiệm <?= formatPrice($tietKiem) ?> so với giá niêm yết</p>
                        <?php endif; ?>
                        <div class="cart-page__summary-row cart-page__summary-row--total">
                            <span>Tổng thanh toán</span>
                            <span><?= formatPrice($tongDon) ?></span>
                        </div>
                        <div class="cart-page__summary-spacer" aria-hidden="true"></div>
                        <a href="<?= htmlspecialchars(BASE_URL . '?act=thanh-toan', ENT_QUOTES, 'UTF-8') ?>" class="cart-page__checkout">Tiến hành đặt hàng</a>
                        <p class="cart-page__summary-foot">Giao hàng &amp; đổi trả theo chính sách cửa hàng.</p>
                    </aside>
                </div>
                </div>

                <div class="cart-page__sticky" aria-hidden="false">
                    <div class="cart-page__sticky-inner">
                        <div class="cart-page__sticky-info">
                            <p class="cart-page__sticky-label">Tạm tính (<?= (int) $tongSoLuong ?> SP)</p>
                            <p class="cart-page__sticky-sum"><?= formatPrice($tongDon) ?></p>
                            <?php if ($tietKiem > 0): ?>
                                <p class="cart-page__sticky-save">Tiết kiệm <?= formatPrice($tietKiem) ?></p>
                            <?php endif; ?>
                        </div>
                        <a href="<?= htmlspecialchars(BASE_URL . '?act=thanh-toan', ENT_QUOTES, 'UTF-8') ?>" class="cart-page__checkout">Đặt hàng</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php require_once 'views/miniCart.php'; ?>
<?php require_once 'layout/footer.php'; ?>
