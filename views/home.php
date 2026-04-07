<?php require_once 'layout/header.php'; ?>
<?php require_once 'layout/menu.php'; ?>
<style>
    .product-item img {
        width: 263px;
        ;
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
                <!-- single slider item start -->
                <div class="hero-single-slide hero-overlay">
                    <div class="hero-slider-item bg-img" data-bg="assets/img/slider/slider1.png">
                        <div class="container">
                            <div class="row">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-single-slide hero-overlay">
                    <div class="hero-slider-item bg-img" data-bg="assets/img/slider/slider2.png">
                        <div class="container">
                            <div class="row">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-single-slide hero-overlay">
                    <div class="hero-slider-item bg-img" data-bg="assets/img/slider/slider3.png">
                        <div class="container">
                            <div class="row">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- single slider item start -->

               
            </div>
        </section>
    <!-- hero slider area end -->



    <!-- service policy area start -->
    <div class="service-policy section-padding">
        <div class="container">
            <div class="row mtn-30">
                <div class="col-sm-6 col-lg-3">
                    <div class="policy-item">
                        <div class="policy-icon">
                            <i class="pe-7s-plane"></i>
                        </div>
                        <div class="policy-content">
                            <h6>Giao hàng</h6>
                            <p>Miễn phí giao hàng</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="policy-item">
                        <div class="policy-icon">
                            <i class="pe-7s-help2"></i>
                        </div>
                        <div class="policy-content">
                            <h6>Hỗ trợ</h6>
                            <p>Hỗ trợ 24/7</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="policy-item">
                        <div class="policy-icon">
                            <i class="pe-7s-back"></i>
                        </div>
                        <div class="policy-content">
                            <h6>Hoàn trả</h6>
                            <p>Miễn phí hoàn trả 30 ngày đầu tiên</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="policy-item">
                        <div class="policy-icon">
                            <i class="pe-7s-credit"></i>
                        </div>
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
                        <a href="#">
                            <img src="assets/img/slider/slider1.png" alt="product banner">
                        </a>
                        <div class="banner-content text-right">
                       
                        </div>
                    </figure>
                </div>
                <div class="col-sm-6">
                    <figure class="banner-statistics mt-20">
                        <a href="#">
                            <img src="assets/img/slider/slider3.png" alt="product banner">
                        </a>
                        <div class="banner-content text-right">
                            
                        </div>
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
                    <!-- section title start -->
                    <div class="section-title text-center">
                        <h2 class="title">Sản phẩm của chúng tôi</h2>
                        <p class="sub-title">Sản phẩm được cập nhật liên tục</p>
                    </div>
                    <!-- section title start -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-container">


                        <!-- product tab content start -->
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab1">
                                <div class="product-carousel-4 slick-row-10 slick-arrow-style">

                                    <?php foreach ($listSanPham as $key => $sanPham): ?>

                                        <div class="product-item">
                                            <figure class="product-thumb">
                                                <a
                                                    href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id']; ?>">
                                                    <img class="pri-img" src="<?= $sanPham['image'] ?>" alt="product">
                                                    <img class="sec-img" src="<?= $sanPham['image'] ?>"
                                                        alt="product">
                                                </a>
                                                <div class="product-badge">
                                                    <?php
                                                    $ngayNhap = new DateTime($sanPham['import_date']);
                                                    $ngayHienTai = new DateTime();
                                                    $tinhNgay = $ngayHienTai->diff(targetObject: $ngayNhap);

                                                    if ($tinhNgay->days <= 7) {
                                                        ?>
                                                        <div class="product-label new">
                                                            <span>Mới</span>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>

                                                    <?php
                                                    if ($sanPham['discount_price']) {
                                                        ?>

                                                        <div class="product-label discount">
                                                            <span>Giảm giá sâu</span>
                                                        </div>

                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="cart-hover">
                                                    
                                                </div>
                                            </figure>
                                            <div class="product-caption text-center">

                                                <h6 class="product-name">
                                                    <a
                                                        href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id']; ?>"><?= $sanPham['name'] ?></a>
                                                </h6>
                                                <div class="price-box">
                                                    <?php if ($sanPham['discount_price']) { ?>
                                                        <span
                                                            class="price-regular"><?= formatPrice($sanPham['discount_price']) . 'VNĐ'; ?></span>
                                                        <span
                                                            class="price-old"><del><?= formatPrice($sanPham['price']) . 'VNĐ'; ?></del></span>
                                                    <?php } else { ?>
                                                        <span
                                                            class="price-regular"><?= formatPrice($sanPham['price']) . 'VNĐ'; ?></span>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- product item end -->
                                    <?php endforeach; ?>


                                    <!-- product item start -->

                                </div>
                            </div>
                        </div>
                        <!-- product tab content end -->
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
                        <!-- banner single slide start -->

                        <!-- banner single slide start -->
                        <!-- banner single slide start -->
                        <?php foreach ($listSanPham as $key => $sanPham): ?>
                            <div class="banner-slide-item">

                                <figure class="banner-statistics">
                                    <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id']; ?>">
                                        <img src="<?= $sanPham['image'] ?>">
                                    </a>

                                </figure>

                            </div>
                        <?php endforeach; ?>
                        <!-- banner single slide start -->
                        <!-- banner single slide start -->
                        <!-- <div class="banner-slide-item">


                            <figure class="banner-statistics">
                                <a href="#">
                                    <img src="<?= $sanPham['image'] ?>" alt="product banner">
                                </a>
                                <div class="banner-content banner-content_style2">
                                    <h5 class="banner-text3"><a href="#">Adidas</a></h5>
                                </div>
                            </figure>
                           
                        </div> -->
                        <!-- banner single slide start -->
                        <!-- banner single slide start -->

                        <!-- banner single slide start -->
                        <!-- banner single slide start -->

                        <!-- banner single slide start -->
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
                    <!-- section title start -->
                    <div class="section-title text-center">
                        <h2 class="title">featured products</h2>
                        <p class="sub-title">Add featured products to weekly lineup</p>
                    </div>
                    <!-- section title start -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-carousel-4_2 slick-row-10 slick-arrow-style">
                        <!-- product item start -->
                        <?php foreach ($listSanPham as $key => $sanPham): ?>

                            <div class="product-item">
                                <figure class="product-thumb">
                                    <a href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id']; ?>">
                                        <img class="pri-img" src="<?= $sanPham['image'] ?>" alt="product">
                                        <img class="sec-img" src="<?= $sanPham['image'] ?>" alt="product">
                                    </a>
                                    <div class="product-badge">
                                        <?php
                                        $ngayNhap = new DateTime($sanPham['import_date']);
                                        $ngayHienTai = new DateTime();
                                        $tinhNgay = $ngayHienTai->diff(targetObject: $ngayNhap);

                                        if ($tinhNgay->days <= 7) {
                                            ?>
                                            <div class="product-label new">
                                                <span>Mới</span>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <?php
                                        if ($sanPham['discount_price']) {
                                            ?>

                                            <div class="product-label discount">
                                                <span>Giảm giá sâu</span>
                                            </div>

                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="cart-hover">
                                        <button <?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id']; ?> type="submit" class="btn btn-cart">Xem chi tiết</button>
                                    </div>
                                </figure>
                                <div class="product-caption text-center">

                                    <h6 class="product-name">
                                        <a
                                            href="<?= BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id']; ?>"><?= $sanPham['name'] ?></a>
                                    </h6>
                                    <div class="price-box">
                                        <?php if ($sanPham['discount_price']) { ?>
                                            <span
                                                class="price-regular"><?= formatPrice($sanPham['discount_price']) . 'VNĐ'; ?></span>
                                            <span
                                                class="price-old"><del><?= formatPrice($sanPham['price']) . 'VNĐ'; ?></del></span>
                                        <?php } else { ?>
                                            <span
                                                class="price-regular"><?= formatPrice($sanPham['price']) . 'VNĐ'; ?></span>
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
    <!-- featured product area end -->

    <!-- testimonial area start -->
    <section class="testimonial-area section-padding bg-img" data-bg="assets/img/testimonial/testimonials-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- section title start -->
                    <div class="section-title text-center">
                        <h2 class="title">Nhận xét</h2>
                        <p class="sub-title">Bạn muốn nói j</p>
                    </div>
                    <!-- section title start -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="testimonial-thumb-wrapper">
                        <div class="testimonial-thumb-carousel">
                            <div class="testimonial-thumb">
                                <img src="assets/img/testimonial/testimonial-1.png" alt="testimonial-thumb">
                            </div>
                            <div class="testimonial-thumb">
                                <img src="assets/img/testimonial/testimonial-2.png" alt="testimonial-thumb">
                            </div>
                            <div class="testimonial-thumb">
                                <img src="assets/img/testimonial/testimonial-3.png" alt="testimonial-thumb">
                            </div>
                            <div class="testimonial-thumb">
                                <img src="assets/img/testimonial/testimonial-2.png" alt="testimonial-thumb">
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-content-wrapper">
                        <div class="testimonial-content-carousel">
                            <div class="testimonial-content">
                                <p>“Mình đã mua đồ cho bé cún nhà mình ở shop này vài lần và cực kỳ hài lòng! Sản phẩm đa dạng, từ thức ăn, đồ chơi đến phụ kiện đều rất chất lượng. Nhân viên tư vấn nhiệt tình, có kiến thức về thú cưng nên cảm thấy rất yên tâm. Giao hàng nhanh, đóng gói cẩn thận. Đặc biệt, mình rất thích các bài chia sẻ kiến thức chăm sóc thú cưng của shop – hữu ích và dễ hiểu. Sẽ tiếp tục ủng hộ dài dài”</p>
                                <div class="ratings">
                                    <span><i class="fa fa-star-o"></i></span>
                                    <span><i class="fa fa-star-o"></i></span>
                                    <span><i class="fa fa-star-o"></i></span>
                                    <span><i class="fa fa-star-o"></i></span>
                                    <span><i class="fa fa-star-o"></i></span>
                                </div>
                                <h5 class="testimonial-author">Đánh giá</h5>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- testimonial area end -->

    <!-- group product start -->
    <section class="group-product-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="group-product-banner">
                        <figure class="banner-statistics">
                            <a href="#">
                                <img src="https://azpet.com.vn/wp-content/uploads/2021/06/Alaska.jpg"
                                    alt="product banner">
                            </a>
                            <div class="banner-content banner-content_style3 text-center">
                                <h6 class="banner-text1">Shoe</h6>
                                <h2 class="banner-text2">All</h2>
                                <a href="shop.html" class="btn btn-text">Mua ngay</a>
                            </div>
                        </figure>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="categories-group-wrapper">
                        <!-- section title start -->
                        <div class="section-title-append">
                            <h4>Sản phẩm bán chạy nhất</h4>
                            <div class="slick-append"></div>
                        </div>
                        <!-- section title start -->

                        <!-- group list carousel start -->
                        <div class="group-list-item-wrapper">
                            <?php foreach ($listSanPham as $key => $sanPham): ?>
                                <div class="group-list-carousel">
                                    <!-- group list item start -->
                                    <div class="group-slide-item">
                                        <div class="group-item">
                                            <div class="group-item-thumb">
                                                <a href="product-details.html">
                                                    <img src="<?= $sanPham['image']; ?>" alt="">
                                                </a>
                                            </div>
                                            <div class="group-item-desc">

                                                <h5 class="group-product-name"><a href="product-details.html">

                                                        <?= $sanPham['name'] ?></a></h5>
                                                <div class="price-box">
                                                    <span class="price-regular"><?= $sanPham['price'] ?></span>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- group list carousel start -->
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="categories-group-wrapper">
                        <!-- section title start -->
                        <div class="section-title-append">
                            <h4>Sản phẩm siêu sale</h4>
                            <div class="slick-append"></div>
                        </div>
                        <!-- section title start -->

                        <!-- group list carousel start -->
                        <div class="group-list-item-wrapper">
                            <?php foreach ($listSanPham as $key => $sanPham): ?>
                                <div class="group-list-carousel">
                                    <!-- group list item start -->
                                    <div class="group-slide-item">
                                        <div class="group-item">
                                            <div class="group-item-thumb">
                                                <a href="product-details.html">
                                                    <img src="<?= $sanPham['image']; ?>" alt="">
                                                </a>
                                            </div>
                                            <div class="group-item-desc">

                                                <h5 class="group-product-name"><a href="product-details.html">

                                                        <?= $sanPham['name'] ?></a></h5>
                                                <div class="price-box">
                                                    <span class="price-regular"><?= $sanPham['price'];?><del><?= $sanPham['discount_price']; ?></span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- group list carousel start -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- group product end -->

    <!-- latest blog area start -->

    <!-- latest blog area end -->

    <!-- brand logo area start -->
    <div class="brand-logo section-padding pt-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="brand-logo-carousel slick-row-10 slick-arrow-style">
                        <!-- single brand start -->
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/1.png" alt="">
                            </a>
                        </div>
                        <!-- single brand end -->

                        <!-- single brand start -->
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/2.png" alt="">
                            </a>
                        </div>
                        <!-- single brand end -->

                        <!-- single brand start -->
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/3.png" alt="">
                            </a>
                        </div>
                        <!-- single brand end -->

                        <!-- single brand start -->
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/4.png" alt="">
                            </a>
                        </div>
                        <!-- single brand end -->

                        <!-- single brand start -->
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/5.png" alt="">
                            </a>
                        </div>
                        <!-- single brand end -->

                        <!-- single brand start -->
                        <div class="brand-item">
                            <a href="#">
                                <img src="assets/img/brand/6.png" alt="">
                            </a>
                        </div>
                        <!-- single brand end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- brand logo area end -->
</main>



<!-- Quick view modal start -->

<!-- Quick view modal end -->



<?php require_once './views/miniCart.php'; ?>
<?php require_once 'layout/footer.php'; ?>
