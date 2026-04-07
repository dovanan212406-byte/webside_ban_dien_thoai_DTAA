<?php
require_once 'layout/header.php';
require_once 'layout/menu.php';

$donHangs = is_array($donHangs ?? null) ? $donHangs : [];
$detailBase = htmlspecialchars(BASE_URL . '?act=chi-tiet-mua-hang&id=', ENT_QUOTES, 'UTF-8');
$huyAction = htmlspecialchars(BASE_URL . '?act=huy-don-hang', ENT_QUOTES, 'UTF-8');
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/order-history.css">

<main class="oh-page">
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8') ?>"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8') ?>">Cửa hàng</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Đơn mua</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cart-main-wrapper oh-section">
        <div class="container">
            <header class="oh-toolbar">
                <h1>Lịch sử đơn hàng</h1>
                <p>Theo dõi trạng thái thanh toán và giao hàng — cửa hàng điện thoại DTAA.</p>
            </header>

            <?php if (count($donHangs) === 0): ?>
                <div class="oh-empty">
                    <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                    <h2>Chưa có đơn hàng</h2>
                    <p>Bạn chưa đặt đơn nào. Khám phá smartphone mới nhất tại cửa hàng.</p>
                    <a href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8') ?>">Mua sắm ngay</a>
                </div>
            <?php else: ?>
                <div class="oh-list">
                    <div class="oh-row oh-row--head" aria-hidden="true">
                        <span>Mã đơn</span>
                        <span>Ngày đặt</span>
                        <span>Tổng tiền</span>
                        <span>Thanh toán</span>
                        <span>Trạng thái</span>
                        <span></span>
                    </div>

                    <?php foreach ($donHangs as $donhang):
                        $st = isset($trangThaiMap[$donhang['status_id']]) ? trim((string) $trangThaiMap[$donhang['status_id']]) : '—';
                        $pm = isset($phuongThucMap[$donhang['payment_method_id']]) ? trim((string) $phuongThucMap[$donhang['payment_method_id']]) : '—';
                        $isCx = (bool) preg_match('/h[uủ]y\s*đơn|^\s*h[uủ]y\s*$|đã\s*h[uủ]y|cancel/i', $st);
                        $isDone = (bool) preg_match('/hoàn\s*thành|đã\s*giao|giao\s*hàng\s*thành\s*công|đã\s*thanh\s*toán/i', $st);
                        $isPending = (bool) preg_match('/chờ|đang\s*xử\s*lý|đang\s*giao|xác\s*nhận/i', $st);

                        if ($isCx) {
                            $payClass = 'oh-pill--muted';
                            $stClass = 'oh-pill--danger';
                        } elseif ($isDone) {
                            $payClass = 'oh-pill--ok';
                            $stClass = 'oh-pill--ok';
                        } elseif ($isPending) {
                            $payClass = 'oh-pill--warn';
                            $stClass = 'oh-pill--warn';
                        } else {
                            $payClass = 'oh-pill--neutral';
                            $stClass = 'oh-pill--neutral';
                        }

                        $oid = (int) ($donhang['id'] ?? 0);
                        $ocode = htmlspecialchars((string) ($donhang['order_code'] ?? ''), ENT_QUOTES, 'UTF-8');
                        $odate = !empty($donhang['order_date'])
                            ? date('d/m/Y H:i', strtotime((string) $donhang['order_date']))
                            : '—';
                        $oamt = formatPrice((int) ($donhang['total_amount'] ?? 0));
                        ?>
                        <article class="oh-row oh-card">
                            <div>
                                <div class="oh-cell-label">Mã đơn</div>
                                <div class="oh-code"><?= $ocode ?></div>
                            </div>
                            <div>
                                <div class="oh-cell-label">Ngày đặt</div>
                                <div class="oh-date"><?= htmlspecialchars($odate, ENT_QUOTES, 'UTF-8') ?></div>
                            </div>
                            <div>
                                <div class="oh-cell-label">Tổng tiền</div>
                                <div class="oh-amount"><?= htmlspecialchars($oamt, ENT_QUOTES, 'UTF-8') ?></div>
                            </div>
                            <div>
                                <div class="oh-cell-label">Thanh toán</div>
                                <span class="oh-pill <?= htmlspecialchars($payClass, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($pm, ENT_QUOTES, 'UTF-8') ?></span>
                            </div>
                            <div>
                                <div class="oh-cell-label">Trạng thái</div>
                                <span class="oh-pill <?= htmlspecialchars($stClass, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($st, ENT_QUOTES, 'UTF-8') ?></span>
                            </div>
                            <div class="oh-actions">
                                <a class="oh-link-detail" href="<?= $detailBase . $oid ?>">Chi tiết <i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                                <?php if ((int) ($donhang['status_id'] ?? 0) === 1): ?>
                                    <form action="<?= $huyAction ?>" method="post" style="display:inline" onsubmit="return confirm('Xác nhận hủy đơn hàng?');">
                                        <input type="hidden" name="don_hang_id" value="<?= $oid ?>">
                                        <button type="submit" class="oh-btn-cancel">Hủy đơn</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php require_once 'views/miniCart.php'; ?>
<?php require_once 'layout/footer.php'; ?>
