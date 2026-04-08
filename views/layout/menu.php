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
                            <nav class="desktop-menu">
                                <ul>
                                    <li><a href="<?= BASE_URL ?>">Trang chủ</a></li>
                                    <li><a href="<?= BASE_URL ?>">Sản phẩm</a></li>
                                    <li><a href="<?= BASE_URL . '?act=gioi-thieu' ?>">Giới thiệu</a></li>
                                    <li><a href="<?= BASE_URL . '?act=lien-he' ?>">Liên hệ</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <!-- main menu area end -->

                <!-- mini cart area start -->
                <div class="col-lg-4">
                    <div class="header-right d-flex align-items-center justify-content-xl-between justify-content-lg-end">
                        <div class="header-configure-area">
                            <ul class="list-unstyled mb-0 d-flex flex-nowrap align-items-center justify-content-end client-header-toolbar">
                                <?php
                                /* Hiện Đăng nhập/Đăng ký khi chưa đăng nhập khách (kể cả đang có session admin) */
                                $showClientAuthPills = !isset($_SESSION['user_client']['email']);
                                ?>
                                <?php
                                $showAdminPill = isset($_SESSION['user_admin']) && !isset($_SESSION['user_client']['email']);
                                if ($showClientAuthPills || $showAdminPill) {
                                ?>
                                <li class="d-none d-sm-flex align-items-center client-header-auth-pills flex-shrink-0">
                                    <?php if ($showClientAuthPills) { ?>
                                    <a class="client-pill-login" href="<?= BASE_URL ?>?act=login"><i class="fa fa-user" aria-hidden="true"></i> <span class="label">Đăng nhập</span></a>
                                    <a class="client-pill-register" href="<?= BASE_URL ?>?act=dang-ky"><i class="fa fa-user-plus" aria-hidden="true"></i> <span class="label">Đăng ký</span></a>
                                    <?php } ?>
                                    <?php if ($showAdminPill) { ?>
                                    <a class="client-pill-register client-pill--quan-tri" href="<?= BASE_URL_ADMIN ?>"><i class="fa fa-shield-alt" aria-hidden="true"></i> <span class="label">Quản trị</span></a>
                                    <?php } ?>
                                </li>
                                <?php } ?>
                                <?php if (isset($_SESSION['user_client']['email'])) { ?>
                                <li class="d-none d-lg-flex align-items-center flex-shrink-1 min-w-0" style="min-width:0;">
                                    <span class="text-truncate d-inline-block" style="max-width:140px;font-size:13px;color:#555;"><?= htmlspecialchars($_SESSION['user_client']['email']) ?></span>
                                </li>
                                <?php } ?>
                                <li class="user-hover flex-shrink-0">
                                    <a href="<?= isset($_SESSION['user_client']['email']) || isset($_SESSION['user_admin']) ? '#' : BASE_URL . '?act=login' ?>">
                                        <i class="pe-7s-user"></i>
                                    </a>
                                    <ul class="dropdown-list client-user-dropdown">
                                        <?php if (!isset($_SESSION['user_client']['email'])) { ?>
                                            <?php if (isset($_SESSION['user_admin'])) { ?>
                                            <li><a href="<?= BASE_URL_ADMIN ?>?act=logout-admin" class="client-user-dropdown-item client-user-dropdown-item--logout"><i class="fa fa-sign-out client-user-menu-icon" aria-hidden="true"></i><span>Thoát quản trị</span></a></li>
                                            <li class="client-user-dropdown-divider" style="margin:4px 0;"><hr style="margin:4px 0;border-color:#eee;"></li>
                                            <li><a href="<?= BASE_URL . '?act=login' ?>" class="client-user-dropdown-item"><i class="fa fa-sign-in client-user-menu-icon client-user-menu-icon--accent" aria-hidden="true"></i><span>Đăng nhập khách hàng</span></a></li>
                                            <li><a href="<?= BASE_URL . '?act=dang-ky' ?>" class="client-user-dropdown-item"><i class="fa fa-user-plus client-user-menu-icon client-user-menu-icon--accent" aria-hidden="true"></i><span>Đăng ký khách hàng</span></a></li>
                                            <?php } else { ?>
                                            <li><a href="<?= BASE_URL . '?act=login' ?>" class="client-user-dropdown-item"><i class="fa fa-sign-in client-user-menu-icon client-user-menu-icon--accent" aria-hidden="true"></i><span>Đăng nhập</span></a></li>
                                            <li><a href="<?= BASE_URL . '?act=dang-ky' ?>" class="client-user-dropdown-item"><i class="fa fa-user-plus client-user-menu-icon client-user-menu-icon--accent" aria-hidden="true"></i><span>Đăng ký</span></a></li>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <li><a href="<?= BASE_URL . '?act=tai-khoan' ?>" class="client-user-dropdown-item"><i class="fa fa-user client-user-menu-icon client-user-menu-icon--accent" aria-hidden="true"></i><span>Tài khoản</span></a></li>
                                            <li><a href="<?= BASE_URL . '?act=lich-su-mua-hang' ?>" class="client-user-dropdown-item"><i class="fa fa-cube client-user-menu-icon client-user-menu-icon--accent" aria-hidden="true"></i><span>Đơn hàng</span></a></li>
                                            <?php if (isset($_SESSION['user_admin'])): ?>
                                            <li class="client-user-dropdown-divider"><hr style="margin:4px 0;border-color:#eee;"></li>
                                            <li><a href="<?= BASE_URL_ADMIN ?>" class="client-user-dropdown-item client-user-dropdown-item--admin"><i class="fa fa-shield-alt client-user-menu-icon" style="color:#d70018;" aria-hidden="true"></i><span style="color:#d70018;font-weight:600;">Khu quản trị</span></a></li>
                                            <?php endif; ?>
                                            <li><a href="<?= BASE_URL . '?act=dang-xuat' ?>" class="client-user-dropdown-item client-user-dropdown-item--logout"><i class="fa fa-sign-out client-user-menu-icon" aria-hidden="true"></i><span>Đăng xuất</span></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <li class="flex-shrink-0">
                                    <a href="<?= BASE_URL ?>?act=gio-hang" class="header-cart-link" title="Giỏ hàng">
                                        <i class="pe-7s-shopbag"></i>
                                        <div class="notification"><?= isset($soLuongGioHangHeader) && $soLuongGioHangHeader > 0 ? (int) $soLuongGioHangHeader : '0' ?></div>
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
</header>
