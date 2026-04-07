<!-- Start Header Area -->
<header class="header-area header-wide">


    <!-- header middle area start -->
    <div class="header-main-area sticky">
        <div class="container">
            <div class="row align-items-center position-relative">

                <!-- start logo area -->
                <div class="col-lg-2">
                    <div class="logo">
                        <a href="<?= BASE_URL ?>">
                            <img src="assets/img/logo/LOGO.png" alt="Phone Store">
                        </a>
                    </div>
                </div>
                <!-- start logo area -->

                <!-- main menu area start -->
                <div class="col-lg-6 position-static">
                    <div class="main-menu-area">
                        <div class="main-menu">
                            <!-- main menu navbar start -->
                            <nav class="desktop-menu">
                                <ul>
                                    <li><a href="index.html">Trang chủ</a>

                                    </li>

                                    <li><a href="#">Sản phẩm <i class="fa fa-angle-down"></i></a>
                                        <ul class="dropdown">
                                            <li><a href="blog-left-sidebar.html">blog left sidebar</a></li>
                                            <li><a href="blog-list-left-sidebar.html">blog list left sidebar</a></li>
                                            <li><a href="blog-right-sidebar.html">blog right sidebar</a></li>
                                            <li><a href="blog-list-right-sidebar.html">blog list right sidebar</a></li>
                                            <li><a href="blog-grid-full-width.html">blog grid full width</a></li>
                                            <li><a href="blog-details.html">blog details</a></li>
                                            <li><a href="blog-details-left-sidebar.html">blog details left sidebar</a>
                                            </li>
                                            <li><a href="blog-details-audio.html">blog details audio</a></li>
                                            <li><a href="blog-details-video.html">blog details video</a></li>
                                            <li><a href="blog-details-image.html">blog details image</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Giới thiệu</a></li>
                                    <li><a href="#">Liên lệ</a></li>
                                </ul>
                            </nav>
                            <!-- main menu navbar end -->
                        </div>
                    </div>
                </div>
                <!-- main menu area end -->

                <!-- mini cart area start -->
                <div class="col-lg-4">
                    <div
                        class="header-right d-flex align-items-center justify-content-xl-between justify-content-lg-end">
                        <div class="header-search-container">
                            <button class="search-trigger d-xl-none d-lg-block"><i class="pe-7s-search"></i></button>
                            <form class="header-search-box d-lg-none d-xl-block">
                                <input type="text" placeholder="Nhập tên sản phẩm" class="header-search-field">
                                <button class="header-search-btn"><i class="pe-7s-search"></i></button>
                            </form>
                        </div>
                        <div class="header-configure-area">
                            <ul class="list-unstyled mb-0 d-flex flex-nowrap align-items-center justify-content-end client-header-toolbar">
                                <?php if (!isset($_SESSION['user_client']['email'])) { ?>
                                <li class="d-none d-sm-flex align-items-center client-header-auth-pills flex-shrink-0">
                                    <a class="client-pill-login" href="<?= BASE_URL ?>?act=login"><i class="fa fa-user"></i> <span class="label">Đăng nhập</span></a>
                                    <a class="client-pill-register" href="<?= BASE_URL ?>?act=dang-ky"><i class="fa fa-user-plus"></i> <span class="label">Đăng ký</span></a>
                                </li>
                                <?php } ?>
                                <li class="d-none d-md-inline-flex align-items-center flex-shrink-0">
                                    <a href="#" class="client-lang-pill" style="padding:6px 12px;border-radius:999px;background:#fff;border:1px solid #eee;font-size:12px;font-weight:600;color:#333;text-decoration:none;display:inline-block;">VN</a>
                                </li>
                                <?php if (isset($_SESSION['user_client']['email'])) { ?>
                                <li class="d-none d-lg-flex align-items-center flex-shrink-1 min-w-0" style="min-width:0;">
                                    <span class="text-truncate d-inline-block" style="max-width:140px;font-size:13px;color:#555;"><?= htmlspecialchars($_SESSION['user_client']['email']) ?></span>
                                </li>
                                <?php } ?>
                                <li class="user-hover flex-shrink-0">
                                    <a href="<?= isset($_SESSION['user_client']['email']) ? '#' : BASE_URL . '?act=login' ?>">
                                        <i class="pe-7s-user"></i>
                                    </a>
                                    <ul class="dropdown-list client-user-dropdown">
                                        <?php
                                        if (!isset($_SESSION['user_client']['email'])) { ?>
                                            <li><a href="<?= BASE_URL . '?act=login' ?>" class="client-user-dropdown-item"><i class="fa fa-sign-in client-user-menu-icon client-user-menu-icon--accent" aria-hidden="true"></i><span>Đăng nhập</span></a></li>
                                            <li><a href="<?= BASE_URL . '?act=dang-ky' ?>" class="client-user-dropdown-item"><i class="fa fa-user-plus client-user-menu-icon client-user-menu-icon--accent" aria-hidden="true"></i><span>Đăng ký</span></a></li>
                                        <?php } else { ?>
                                            <li><a href="my-account.html" class="client-user-dropdown-item"><i class="fa fa-user client-user-menu-icon client-user-menu-icon--accent" aria-hidden="true"></i><span>Tài khoản</span></a></li>
                                            <li><a href="<?= BASE_URL . '?act=lich-su-mua-hang' ?>" class="client-user-dropdown-item"><i class="fa fa-cube client-user-menu-icon client-user-menu-icon--accent" aria-hidden="true"></i><span>Đơn hàng</span></a></li>
                                            <li><a href="<?= BASE_URL . '?act=dang-xuat' ?>" class="client-user-dropdown-item client-user-dropdown-item--logout"><i class="fa fa-sign-out client-user-menu-icon" aria-hidden="true"></i><span>Đăng xuất</span></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <li class="flex-shrink-0">
                                    <a href="wishlist.html">
                                        <i class="pe-7s-like"></i>
                                        <div class="notification">0</div>
                                    </a>
                                </li>
                                <li class="flex-shrink-0">
                                    <a href="<?= BASE_URL ?>?act=gio-hang" class="header-cart-link" title="Giỏ hàng">
                                        <i class="pe-7s-shopbag"></i>
                                        <div class="notification">2</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- mini cart area end -->

            </div>
        </div>
    </div>
    <!-- header middle area end -->
    </div>
    <!-- main header start -->


</header>
<!-- end Header Area -->