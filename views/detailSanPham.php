<?php require_once 'layout/header.php'; ?>
<?php require_once 'layout/menu.php'; ?>
<link rel="stylesheet" href="assets/css/detail-product-shop.css">
<?php
$giaBanCt = !empty($sanPham['discount_price']) ? (float) $sanPham['discount_price'] : (float) $sanPham['price'];
$traGopGoiY = (int) round($giaBanCt / 3);
$pdpImg = function ($path) {
    if ($path === null || $path === '') {
        return BASE_URL . 'assets/img/product/product-1.jpg';
    }
    if (preg_match('#^https?://#i', $path)) {
        return $path;
    }
    return BASE_URL . ltrim($path, '/');
};
if (!empty($listAnhSanPham[0]['image_url'])) {
    $pdpMainImgSrc = $pdpImg($listAnhSanPham[0]['image_url']);
} elseif (!empty($sanPham['image'])) {
    $pdpMainImgSrc = $pdpImg($sanPham['image']);
} else {
    $pdpMainImgSrc = BASE_URL . 'assets/img/product/product-1.jpg';
}
$countComment = isset($listBinhLuan) ? count($listBinhLuan) : 0;
?>
<main>
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="shop.html">Sản phẩm</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Chi tiết sản phẩm</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- page main wrapper start -->
    <div class="shop-main-wrapper section-padding pb-0">
        <div class="container">
            <div class="row">
                <!-- product details wrapper start -->
                <div class="col-lg-12 order-1 order-lg-2">
                    <!-- product details inner end -->
                    <div class="product-details-inner">
                        <div class="row pdp-shop-wrap align-items-start">
                            <div class="col-lg-5">
                                <div class="pdp-shop-feature">
                                    <div class="pdp-shop-feature__img">
                                        <img id="pdp-main-feature-img" src="<?= htmlspecialchars($pdpMainImgSrc) ?>"
                                            alt="<?= htmlspecialchars($sanPham['name']) ?>">
                                    </div>
                                    <ul class="pdp-shop-feature__list">
                                        <li>Bảo hành chính hãng, hỗ trợ đổi trả theo chính sách cửa hàng.</li>
                                        <li>Giao hàng nhanh toàn quốc, kiểm tra hàng trước khi nhận.</li>
                                        <?php
                                        $pdpDescPlain = strip_tags((string) ($sanPham['description'] ?? ''));
                                        $pdpDescShort = function_exists('mb_substr')
                                            ? mb_substr($pdpDescPlain, 0, 120, 'UTF-8')
                                            : substr($pdpDescPlain, 0, 120);
                                        $pdpDescLen = function_exists('mb_strlen')
                                            ? mb_strlen($pdpDescPlain, 'UTF-8')
                                            : strlen($pdpDescPlain);
                                        ?>
                                        <li><?= htmlspecialchars($pdpDescShort) ?><?= $pdpDescLen > 120 ? '…' : '' ?></li>
                                    </ul>
                                </div>
                                <?php if (!empty($listAnhSanPham)) : ?>
                                    <div class="product-large-slider mt-3">
                                        <?php foreach ($listAnhSanPham as $anhRow) : ?>
                                            <div class="pro-large-img img-zoom">
                                                <img src="<?= BASE_URL . $anhRow['image_url'] ?>" alt="product-details">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="pro-nav slick-row-10 slick-arrow-style">
                                        <?php foreach ($listAnhSanPham as $anhRow) : ?>
                                            <div class="pro-nav-thumb">
                                                <img src="<?= BASE_URL . $anhRow['image_url'] ?>" alt="thumb"
                                                    data-full-src="<?= BASE_URL . $anhRow['image_url'] ?>">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-lg-7">
                                <div class="product-details-des pdp-shop-aside">
                                    <div class="pdp-shop-breadcrumb">
                                        <a href="<?= BASE_URL ?>">Trang chủ</a> — <a
                                            href="<?= BASE_URL ?>?act=trangchu">Sản phẩm</a> —
                                        <span><?= htmlspecialchars($sanPham['ten_danh_muc'] ?? '') ?></span>
                                    </div>
                                    <h1 class="pdp-shop-title"><?= htmlspecialchars($sanPham['name']) ?></h1>
                                    <div class="ratings d-flex mb-2">
                                        <div class="pro-review">
                                            <span><?= $countComment ?> bình luận</span>
                                        </div>
                                    </div>
                                    <div>
                                        <?php if (!empty($sanPham['discount_price'])) { ?>
                                            <span class="pdp-shop-price-main"><?= formatPrice($sanPham['discount_price']) ?>đ</span>
                                            <span class="pdp-shop-price-old"><?= formatPrice($sanPham['price']) ?>đ</span>
                                        <?php } else { ?>
                                            <span class="pdp-shop-price-main"><?= formatPrice($sanPham['price']) ?>đ</span>
                                        <?php } ?>
                                    </div>
                                    <p class="pdp-shop-installment-hint">Trả góp chỉ với: <?= formatPrice($traGopGoiY) ?>đ/tháng (ước tính 3 tháng)</p>
                                    <div class="pdp-shop-stock">
                                        <i class="fa fa-check-circle"></i>
                                        <span>Còn <?= (int) $sanPham['quantity'] ?> trong kho</span>
                                    </div>
                                    <form action="<?= BASE_URL ?>?act=them-gio-hang" method="POST" id="form-them-gio-hang">
                                        <input type="hidden" name="san_pham_id" value="<?= (int) $sanPham['id'] ?>">
                                        <input type="hidden" name="so_luong" value="1" id="so_luong-input">
                                        <label class="pdp-shop-qty-label" for="so-luong-display">Số lượng</label>
                                        <div class="pdp-shop-stepper">
                                            <button type="button" aria-label="Giảm" id="pdp-qty-minus">−</button>
                                            <input type="text" value="1" inputmode="numeric" pattern="[0-9]*"
                                                name="so_luong_display" id="so-luong-display" maxlength="4">
                                            <button type="button" aria-label="Tăng" id="pdp-qty-plus">+</button>
                                        </div>
                                    </form>
                                    <button type="button" class="pdp-shop-btn-buy" onclick="muaNgay(<?= (int) $sanPham['id'] ?>)">
                                        MUA NGAY
                                        <small>Giao hàng hoặc nhận tại cửa hàng</small>
                                    </button>
                                    <div class="pdp-shop-btn-row">
                                        <button type="button" class="pdp-shop-btn-installment" data-bs-toggle="modal" data-bs-target="#modalTraGop">
                                            TRẢ GÓP
                                            <small>Xét duyệt nhanh qua điện thoại</small>
                                        </button>
                                        <button type="submit" form="form-them-gio-hang" class="pdp-shop-btn-addcart">
                                            THÊM VÀO GIỎ HÀNG
                                            <small>Lưu sản phẩm để mua sau</small>
                                        </button>
                                    </div>
                                    <p class="pro-desc mt-4"><?= $sanPham['description'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- product details inner end -->

                    <!-- product details reviews start -->
                    <div class="product-details-reviews section-padding pb-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="product-review-info">
                                    <ul class="nav review-tab">

                                        <li>
                                            <a class="active" data-bs-toggle="tab" href="#tab_three">Bình luận
                                                (<?= $countComment ?>)</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content reviews-tab">
                                        <div class="tab-pane fade show active" id="tab_three">
                                            <?php foreach ($listBinhLuan as $binhLuan): ?>
                                                <div class="total-reviews">
                                                    <div class="rev-avatar">
                                                        <img src="<?= $binhLuan['avatar'] ?>" alt="">
                                                    </div>
                                                    <div class="review-box">

                                                        <div class="post-author">
                                                            <p><span>Khách hàng-</span><?= $binhLuan['review_date'] ?></p>
                                                        </div>
                                                        <p><?= $binhLuan['content'] ?></p>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                            <form action="#" class="review-form">
                                                <div class="form-group row">
                                                    <div class="col">
                                                        <label class="col-form-label"><span class="text-danger">*</span>
                                                            Bình luận của bạn</label>
                                                        <textarea class="form-control" required></textarea>

                                                    </div>
                                                </div>

                                                <div class="buttons">
                                                    <button class="btn btn-sqr" type="submit">Bình luận</button>
                                                </div>
                                            </form> <!-- end of review-form -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- product details reviews end -->
                </div>
                <!-- product details wrapper end -->
            </div>
        </div>
    </div>
    <!-- page main wrapper end -->

    <!-- related products area start -->
    <section class="related-products section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- section title start -->
                    <div class="section-title text-center">
                        <h2 class="title">Sản phẩm liên quan</h2>
                    </div>
                    <!-- section title start -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-carousel-4 slick-row-10 slick-arrow-style">
                        <!-- product item start -->
                        <?php foreach ($listSanPhamCungDanhMuc as $key => $spLienQuan): ?>

                            <div class="product-item">
                                <figure class="product-thumb">
                                    <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $spLienQuan['id']; ?>">
                                        <img class="pri-img" src="<?= $spLienQuan['image'] ?>" alt="product">
                                        <img class="sec-img" src="<?= $spLienQuan['image'] ?>" alt="product">
                                    </a>
                                    <div class="product-badge">
                                        <?php
                                        $ngayNhap = new DateTime($spLienQuan['import_date']);
                                        $ngayHienTai = new DateTime();
                                        $tinhNgay = $ngayHienTai->diff($ngayNhap);

                                        if ($tinhNgay->days <= 7) {
                                            ?>
                                            <div class="product-label new">
                                                <span>Mới</span>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <?php
                                        if ($spLienQuan['discount_price']) {
                                            ?>

                                            <div class="product-label discount">
                                                <span>Giảm giá sâu</span>
                                            </div>

                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="cart-hover">
                                        <button class="btn btn-cart">Xem chi tiết</button>
                                    </div>
                                </figure>
                                <div class="product-caption text-center">

                                    <h6 class="product-name">
                                        <a
                                            href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $spLienQuan['id']; ?>"><?= $spLienQuan['name'] ?></a>
                                    </h6>
                                    <div class="price-box">
                                        <?php if ($spLienQuan['discount_price']) { ?>
                                            <span
                                                class="price-regular"><?= formatPrice($spLienQuan['discount_price']) . 'VNĐ'; ?></span>
                                            <span
                                                class="price-old"><del><?= formatPrice($spLienQuan['price']) . 'VNĐ'; ?></del></span>
                                        <?php } else { ?>
                                            <span
                                                class="price-regular"><?= formatPrice($spLienQuan['price']) . 'VNĐ'; ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- product item end -->
                        <?php endforeach; ?>

                        <!-- product item end -->


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- related products area end -->

    <div class="modal fade" id="modalTraGop" tabindex="-1" aria-labelledby="modalTraGopLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTraGopLabel">Trả góp</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Vui lòng liên hệ hotline cửa hàng hoặc đến trực tiếp để được tư vấn trả góp và thủ tục
                        xét duyệt.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
(function () {
    var display = document.getElementById('so-luong-display');
    var hidden = document.getElementById('so_luong-input');
    var maxQty = <?= max(1, (int) $sanPham['quantity']) ?>;
    function syncQty(v) {
        v = parseInt(v, 10);
        if (isNaN(v) || v < 1) v = 1;
        if (v > maxQty) v = maxQty;
        display.value = String(v);
        if (hidden) hidden.value = String(v);
    }
    if (display && hidden) {
        display.addEventListener('input', function () { syncQty(display.value); });
        document.getElementById('pdp-qty-minus') && document.getElementById('pdp-qty-minus').addEventListener('click', function () {
            syncQty(parseInt(display.value, 10) - 1);
        });
        document.getElementById('pdp-qty-plus') && document.getElementById('pdp-qty-plus').addEventListener('click', function () {
            syncQty(parseInt(display.value, 10) + 1);
        });
    }
    document.querySelectorAll('.pro-nav-thumb img[data-full-src]').forEach(function (img) {
        img.addEventListener('click', function () {
            var main = document.getElementById('pdp-main-feature-img');
            if (main && img.getAttribute('data-full-src')) main.src = img.getAttribute('data-full-src');
        });
    });
})();
</script>
<!-- Quick view modal start -->

<!-- Quick view modal end -->



<?php require_once 'layout/footer.php'; ?>
