<?php require_once 'layout/header.php'; ?>
<?php require_once 'layout/menu.php'; ?>
<style>
    .product-item img {
        width: 263px;
        height: 263px;
    }
    .banner-slide-item {
        width: 454px;
        height: 454px;
    }
</style>

<main>
    <!-- hero slider area start -->
    <section class="slider-area">
        <div class="hero-slider-active slick-arrow-style slick-arrow-style_hero slick-dot-style">
            <div class="hero-single-slide hero-overlay">
                <div class="hero-slider-item bg-img" data-bg="assets/img/slider/Gemini_Generated_Image_fz9yzefz9yzefz9y.png">
                    <div class="container"><div class="row"></div></div>
                </div>
            </div>
            <div class="hero-single-slide hero-overlay">
                <div class="hero-slider-item bg-img" data-bg="assets/img/slider/Gemini_Generated_Image_qo5i82qo5i82qo5i.png">
                    <div class="container"><div class="row"></div></div>
                </div>
            </div>
            <div class="hero-single-slide hero-overlay">
                <div class="hero-slider-item bg-img" data-bg="assets/img/slider/Gemini_Generated_Image_x3bu09x3bu09x3bu.png">
                    <div class="container"><div class="row"></div></div>
                </div>
            </div>
        </div>
    </section>
    <!-- hero slider area end -->

    <!-- service policy area start -->
    <div class="service-policy section-padding">
        <div class="container">
            <div class="row mtn-30">
                <div class="col-sm-6 col-lg-3">
                    <div class="policy-item">
                        <div class="policy-icon"><i class="pe-7s-plane"></i></div>
                        <div class="policy-content">
                            <h6>Giao hàng</h6>
                            <p>Miễn phí giao hàng</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="policy-item">
                        <div class="policy-icon"><i class="pe-7s-help2"></i></div>
                        <div class="policy-content">
                            <h6>Hỗ trợ</h6>
                            <p>Hỗ trợ 24/7</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="policy-item">
                        <div class="policy-icon"><i class="pe-7s-back"></i></div>
                        <div class="policy-content">
                            <h6>Hoàn trả</h6>
                            <p>Miễn phí hoàn trả 30 ngày đầu tiên</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="policy-item">
                        <div class="policy-icon"><i class="pe-7s-credit"></i></div>
                        <div class="policy-content">
                            <h6>Thanh toán</h6>
                            <p>Bảo mật thanh toán</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- service policy area end -->

    <!-- banner statistics area start -->
    <div class="banner-statistics-area">
        <div class="container">
            <div class="row row-20 mtn-20">
                <div class="col-sm-6">
                    <figure class="banner-statistics mt-20">
                        <a href="#"><img src="assets/img/slider/Gemini_Generated_Image_fz9yzefz9yzefz9y.png" alt="product banner"></a>
                        <div class="banner-content text-right"></div>
                    </figure>
                </div>
                <div class="col-sm-6">
                    <figure class="banner-statistics mt-20">
                        <a href="#"><img src="assets/img/slider/Gemini_Generated_Image_qo5i82qo5i82qo5i.png" alt="product banner"></a>
                        <div class="banner-content text-right"></div>
                    </figure>
                </div>
            </div>
        </div>
    </div>
    <!-- banner statistics area end -->

    <!-- product area start -->
    <section class="product-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="title">Sản phẩm của chúng tôi</h2>
                        <p class="sub-title">Sản phẩm được cập nhật liên tục</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-container">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab1">
                                <div class="product-carousel-4 slick-row-10 slick-arrow-style">
                                    <?php foreach ($listSanPham as $key => $sanPham):
                                        $ngayNhap = new DateTime($sanPham['import_date']);
                                        $ngayHienTai = new DateTime();
                                        $tinhNgay = $ngayHienTai->diff($ngayNhap);
                                        $isNew = $tinhNgay->days <= 7;
                                        $hasDiscount = !empty($sanPham['discount_price']);
                                        ?>
                                        <div class="product-item">
                                            <figure class="product-thumb">
                                                <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id']; ?>">
                                                    <img class="pri-img" src="<?= $sanPham['image'] ?>" alt="product">
                                                    <img class="sec-img" src="<?= $sanPham['image'] ?>" alt="product">
                                                </a>
                                                <div class="product-badge">
                                                    <?php if ($isNew): ?>
                                                        <div class="product-label new"><span>Mới</span></div>
                                                    <?php endif; ?>
                                                    <?php if ($hasDiscount): ?>
                                                        <div class="product-label discount"><span>Giảm giá sâu</span></div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="cart-hover">
                                                    <form action="<?= BASE_URL . '?act=them-gio-hang' ?>" method="POST">
                                                        <input type="hidden" name="san_pham_id" value="<?= (int) $sanPham['id'] ?>">
                                                        <input type="hidden" name="so_luong" value="1">
                                                        <button type="submit" class="btn btn-cart2"
                                                            <?= (int) ($sanPham['quantity'] ?? 0) < 1 ? 'disabled style="opacity:0.6;cursor:not-allowed;"' : '' ?>>
                                                            <?= (int) ($sanPham['quantity'] ?? 0) < 1 ? 'Hết hàng' : 'Thêm vào giỏ' ?>
                                                        </button>
                                                    </form>
                                                </div>
                                            </figure>
                                            <div class="product-caption text-center">
                                                <h6 class="product-name">
                                                    <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id']; ?>"><?= $sanPham['name'] ?></a>
                                                </h6>
                                                <div class="price-box">
                                                    <?php if ($hasDiscount) { ?>
                                                        <span class="price-regular"><?= formatPrice($sanPham['discount_price']) . ' VNĐ'; ?></span>
                                                        <span class="price-old"><del><?= formatPrice($sanPham['price']) . ' VNĐ'; ?></del></span>
                                                    <?php } else { ?>
                                                        <span class="price-regular"><?= formatPrice($sanPham['price']) . ' VNĐ'; ?></span>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product area end -->

    <!-- product banner statistics area start -->
    <section class="product-banner-statistics">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="product-banner-carousel slick-row-10">
                        <?php foreach ($listSanPham as $sanPham): ?>
                            <div class="banner-slide-item">
                                <figure class="banner-statistics">
                                    <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id']; ?>">
                                        <img src="<?= $sanPham['image'] ?>" alt="product banner">
                                    </a>
                                </figure>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product banner statistics area end -->

    <!-- featured product area start -->
    <section class="feature-product section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="title">Sản phẩm nổi bật</h2>
                        <p class="sub-title">Những sản phẩm được yêu thích nhất</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-carousel-4 slick-row-10 slick-arrow-style">
                        <?php foreach ($listSanPham as $sanPham):
                            $ngayNhap = new DateTime($sanPham['import_date']);
                            $ngayHienTai = new DateTime();
                            $tinhNgay = $ngayHienTai->diff($ngayNhap);
                            ?>
                            <div class="product-item">
                                <figure class="product-thumb">
                                    <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id']; ?>">
                                        <img class="pri-img" src="<?= $sanPham['image'] ?>" alt="product">
                                        <img class="sec-img" src="<?= $sanPham['image'] ?>" alt="product">
                                    </a>
                                    <div class="product-badge">
                                        <?php if ($tinhNgay->days <= 7): ?>
                                            <div class="product-label new"><span>Mới</span></div>
                                        <?php endif; ?>
                                        <?php if ($sanPham['discount_price']): ?>
                                            <div class="product-label discount"><span>Giảm giá sâu</span></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="cart-hover">
                                        <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id']; ?>" class="btn btn-cart">Xem chi tiết</a>
                                    </div>
                                </figure>
                                <div class="product-caption text-center">
                                    <h6 class="product-name">
                                        <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id']; ?>"><?= $sanPham['name'] ?></a>
                                    </h6>
                                    <div class="price-box">
                                        <?php if ($sanPham['discount_price']) { ?>
                                            <span class="price-regular"><?= formatPrice($sanPham['discount_price']) . ' VNĐ'; ?></span>
                                            <span class="price-old"><del><?= formatPrice($sanPham['price']) . ' VNĐ'; ?></del></span>
                                        <?php } else { ?>
                                            <span class="price-regular"><?= formatPrice($sanPham['price']) . ' VNĐ'; ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- featured product area end -->

    <!-- brand logo area start -->
    <div class="brand-logo section-padding pt-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="brand-logo-carousel slick-row-10 slick-arrow-style">
                        <?php foreach ($listSanPham as $sanPham): ?>
                            <div class="brand-item">
                                <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id']; ?>">
                                    <img src="<?= $sanPham['image'] ?>" alt="">
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- brand logo area end -->
</main>

<?php require_once './views/miniCart.php'; ?>
<?php require_once 'layout/footer.php'; ?>
