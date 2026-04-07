<?php
require_once 'layout/header.php';
require_once 'layout/menu.php';

$statusName = isset($trangThaiMap[(int) ($donHang['status_id'] ?? 0)])
    ? trim((string) $trangThaiMap[(int) $donHang['status_id']])
    : 'Không xác định';
$paymentLabel = isset($phuongThucMap[(int) ($donHang['payment_method_id'] ?? 0)])
    ? (string) $phuongThucMap[(int) $donHang['payment_method_id']]
    : '—';

$isCancelled = (bool) preg_match('/h[uủ]y\s*đơn|^\s*h[uủ]y\s*$|đã\s*h[uủ]y|cancel/i', $statusName);

if ($isCancelled) {
    $badgeClass = 'od-badge--cancel';
    $badgeText = 'Hủy đơn';
    $statusCardMod = 'od-status-card--cancel';
    $statusIcon = 'fa-times-circle';
    $statusTitle = 'Đơn hàng đã hủy';
    $statusText = 'Đơn này đã bị hủy. Nếu bạn đã chuyển khoản hoặc thanh toán trước đó, vui lòng liên hệ cửa hàng để được hỗ trợ.';
} else {
    if (preg_match('/hoàn\s*thành|đã\s*giao|giao\s*hàng\s*thành\s*công|đã\s*thanh\s*toán/i', $statusName)) {
        $badgeClass = 'od-badge--paid';
        $badgeText = 'Thanh toán';
        $statusCardMod = '';
        $statusIcon = 'fa-check-circle';
        $statusTitle = 'Thanh toán';
        $statusText = 'Cảm ơn bạn đã thanh toán / nhận hàng. Phương thức: ' . htmlspecialchars($paymentLabel, ENT_QUOTES, 'UTF-8')
            . '. Trạng thái: ' . htmlspecialchars($statusName, ENT_QUOTES, 'UTF-8') . '.';
    } elseif (preg_match('/chờ|đang\s*xử\s*lý|đang\s*giao|xác\s*nhận/i', $statusName)) {
        $badgeClass = 'od-badge--pending';
        $badgeText = 'Chờ thanh toán';
        $statusCardMod = 'od-status-card--pending';
        $statusIcon = 'fa-clock-o';
        $statusTitle = 'Thanh toán';
        $statusText = 'Đơn đang được xử lý. Phương thức: ' . htmlspecialchars($paymentLabel, ENT_QUOTES, 'UTF-8')
            . '. Trạng thái hiện tại: ' . htmlspecialchars($statusName, ENT_QUOTES, 'UTF-8') . '.';
    } else {
        $badgeClass = 'od-badge--neutral';
        $badgeText = $statusName;
        $statusCardMod = 'od-status-card--pending';
        $statusIcon = 'fa-credit-card';
        $statusTitle = 'Thanh toán';
        $statusText = 'Phương thức thanh toán: ' . htmlspecialchars($paymentLabel, ENT_QUOTES, 'UTF-8')
            . '. Trạng thái đơn: ' . htmlspecialchars($statusName, ENT_QUOTES, 'UTF-8') . '.';
    }
}

$orderCode = htmlspecialchars((string) ($donHang['order_code'] ?? ''), ENT_QUOTES, 'UTF-8');
if ($orderCode === '') {
    $orderCode = '#' . (int) ($donHang['id'] ?? 0);
}
$orderDateStr = !empty($donHang['order_date'])
    ? date('d/m/Y H:i', strtotime((string) $donHang['order_date']))
    : '—';

$tongHang = 0;
foreach ($chiTietDonHang as $row) {
    $tongHang += (int) ($row['total_price'] ?? 0);
}
$listUrl = htmlspecialchars(BASE_URL . '?act=lich-su-mua-hang', ENT_QUOTES, 'UTF-8');
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/order-detail.css">

<main class="od-page">
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8') ?>"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="<?= $listUrl ?>">Đơn mua</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Chi tiết đơn</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cart-main-wrapper od-section-padding">
        <div class="container">
            <a class="od-back" href="<?= $listUrl ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Quay lại danh sách</a>

            <header class="od-hero">
                <div>
                    <h1 class="od-hero__code">Mã đơn <span>#<?= $orderCode ?></span></h1>
                    <p class="od-hero__date">Đặt lúc <?= htmlspecialchars($orderDateStr, ENT_QUOTES, 'UTF-8') ?></p>
                </div>
                <div class="od-hero__badges">
                    <span class="od-badge <?= htmlspecialchars($badgeClass, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($badgeText, ENT_QUOTES, 'UTF-8') ?></span>
                    <p class="od-hero__sub"><?php if ($isCancelled): ?>Đơn hàng không còn hiệu lực<?php else: ?>Phương thức: <?= htmlspecialchars($paymentLabel, ENT_QUOTES, 'UTF-8') ?><?php endif; ?></p>
                </div>
            </header>

            <div class="od-grid">
                <section class="od-card od-card--products" aria-labelledby="od-products-heading">
                    <h2 id="od-products-heading" class="od-card__head">
                        <i class="fa fa-mobile" aria-hidden="true"></i>
                        Sản phẩm điện thoại
                    </h2>

                    <div class="od-card__lines">
                        <?php foreach ($chiTietDonHang as $item):
                            $name = (string) ($item['name'] ?? '');
                            $img = (string) ($item['image'] ?? '');
                            $qty = (int) ($item['quantity'] ?? 0);
                            $price = (int) ($item['price'] ?? 0);
                            $line = (int) ($item['total_price'] ?? 0);
                            ?>
                            <div class="od-line">
                                <div class="od-line__img-wrap">
                                    <img class="od-line__img" src="<?= htmlspecialchars(BASE_URL . $img, ENT_QUOTES, 'UTF-8') ?>"
                                         alt="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>" loading="lazy">
                                </div>
                                <div class="od-line__body">
                                    <h3 class="od-line__name"><?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></h3>
                                    <div class="od-line__meta">
                                        <span>Đơn giá: <strong><?= formatPrice($price) ?></strong></span>
                                        <span>Số lượng: <strong><?= $qty ?></strong></span>
                                    </div>
                                    <p class="od-line__price">Thành tiền: <?= formatPrice($line) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="od-card__foot">
                        <div class="od-total-bar">
                            <span class="od-total-bar__lbl">Tổng tiền hàng</span>
                            <span class="od-total-bar__sum"><?= formatPrice($tongHang) ?></span>
                        </div>
                        <p class="od-pay-note">
                            Tổng thanh toán (gồm phí nếu có):
                            <strong><?= formatPrice((int) ($donHang['total_amount'] ?? 0)) ?></strong>
                        </p>
                    </div>
                </section>

                <section class="od-card od-card--soft od-card--ship" aria-labelledby="od-ship-heading">
                    <h2 id="od-ship-heading" class="od-card__head">
                        <i class="fa fa-truck" aria-hidden="true"></i>
                        Thông tin giao hàng
                    </h2>
                    <dl class="od-dl od-dl--fill">
                        <div>
                            <dt>Người nhận</dt>
                            <dd><?= htmlspecialchars((string) ($donHang['receiver_name'] ?? ''), ENT_QUOTES, 'UTF-8') ?></dd>
                        </div>
                        <div>
                            <dt>Email</dt>
                            <dd><?= htmlspecialchars((string) ($donHang['receiver_email'] ?? ''), ENT_QUOTES, 'UTF-8') ?></dd>
                        </div>
                        <div>
                            <dt>Số điện thoại</dt>
                            <dd><?= htmlspecialchars((string) ($donHang['receiver_phone'] ?? ''), ENT_QUOTES, 'UTF-8') ?></dd>
                        </div>
                        <div>
                            <dt>Địa chỉ</dt>
                            <dd><?= htmlspecialchars((string) ($donHang['receiver_address'] ?? ''), ENT_QUOTES, 'UTF-8') ?></dd>
                        </div>
                        <div>
                            <dt>Ghi chú</dt>
                            <dd><?= nl2br(htmlspecialchars((string) ($donHang['note'] ?? ''), ENT_QUOTES, 'UTF-8')) ?></dd>
                        </div>
                        <div>
                            <dt>Trạng thái hệ thống</dt>
                            <dd><?= htmlspecialchars($statusName, ENT_QUOTES, 'UTF-8') ?></dd>
                        </div>
                    </dl>
                </section>

                <div class="od-status-card od-status-card--grid<?= $statusCardMod !== '' ? ' ' . htmlspecialchars($statusCardMod, ENT_QUOTES, 'UTF-8') : '' ?>">
                    <div class="od-status-card__icon" aria-hidden="true">
                        <i class="fa <?= htmlspecialchars($statusIcon, ENT_QUOTES, 'UTF-8') ?>"></i>
                    </div>
                    <div>
                        <h3><?= htmlspecialchars($statusTitle, ENT_QUOTES, 'UTF-8') ?></h3>
                        <p><?= $statusText ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'views/miniCart.php'; ?>
<?php require_once 'layout/footer.php'; ?>
