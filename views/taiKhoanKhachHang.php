<?php
$ok = $_SESSION['flash_thanh_cong_tai_khoan'] ?? null;
$err = $_SESSION['flash_loi_tai_khoan'] ?? null;
unset($_SESSION['flash_thanh_cong_tai_khoan'], $_SESSION['flash_loi_tai_khoan']);
$soMatHangGio = isset($chiTietGioHang) && is_array($chiTietGioHang) ? count($chiTietGioHang) : 0;
?>
<?php require_once 'layout/header.php'; ?>
<?php require_once 'layout/menu.php'; ?>
<main>
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Tài khoản khách hàng</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cart-main-wrapper section-padding">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h4 class="mb-1">Xin chào, <?= htmlspecialchars($user['full_name'] ?? 'Khách hàng') ?></h4>
                    <p class="text-muted mb-0"><small><?= htmlspecialchars($user['email'] ?? '') ?></small></p>
                </div>
            </div>

            <?php if ($ok) : ?>
                <div class="alert alert-success"><?= htmlspecialchars($ok) ?></div>
            <?php endif; ?>
            <?php if ($err) : ?>
                <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
            <?php endif; ?>

            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="section-bg-color p-4 text-center h-100">
                        <h6 class="text-muted">Giỏ hàng</h6>
                        <p class="h4 mb-0"><?= (int) $soMatHangGio ?> sản phẩm</p>
                        <a href="<?= BASE_URL ?>?act=gio-hang" class="btn btn-sqr btn-sm mt-2">Xem giỏ</a>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="section-bg-color p-4 text-center h-100">
                        <h6 class="text-muted">Đơn hàng</h6>
                        <p class="h4 mb-0"><?= (int) $soDonHang ?> đơn</p>
                        <a href="<?= BASE_URL ?>?act=lich-su-mua-hang" class="btn btn-sqr btn-sm mt-2">Lịch sử mua hàng</a>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="section-bg-color p-4 text-center h-100">
                        <h6 class="text-muted">Đăng xuất</h6>
                        <p class="small text-muted mb-2">Thoát khỏi tài khoản trên thiết bị này</p>
                        <a href="<?= BASE_URL ?>?act=dang-xuat" class="btn btn-outline-secondary btn-sm">Đăng xuất</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="section-bg-color p-4">
                        <h5 class="mb-4">Thông tin cá nhân</h5>
                        <form action="<?= BASE_URL ?>?act=cap-nhat-tai-khoan" method="post">
                            <div class="single-input-item mb-3">
                                <label>Email</label>
                                <input type="email" class="form-control" value="<?= htmlspecialchars($user['email'] ?? '') ?>" disabled readonly>
                                <small class="text-muted">Email không đổi được tại đây.</small>
                            </div>
                            <div class="single-input-item mb-3">
                                <label for="full_name">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" name="full_name" id="full_name" class="form-control" required
                                    value="<?= htmlspecialchars($user['full_name'] ?? '') ?>">
                            </div>
                            <div class="single-input-item mb-3">
                                <label for="phone">Số điện thoại</label>
                                <input type="text" name="phone" id="phone" class="form-control"
                                    value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                            </div>
                            <div class="single-input-item mb-3">
                                <label for="address">Địa chỉ</label>
                                <textarea name="address" id="address" class="form-control" rows="3"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-sqr">Lưu thông tin</button>
                                <a href="<?= BASE_URL ?>" class="btn btn-sqr bg-secondary border-secondary">Quay lại</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'views/miniCart.php'; ?>
<?php require_once 'layout/footer.php'; ?>
