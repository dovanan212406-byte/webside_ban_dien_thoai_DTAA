<?php
require_once 'layout/header.php';
require_once 'layout/menu.php';

$tongGioHang = 0;
$tongSoLuong = 0;
foreach ($chiTietGioHang as $row) {
    $gia = !empty($row['discount_price']) ? (float) $row['discount_price'] : (float) $row['price'];
    $qty = (int) ($row['quantity'] ?? 0);
    $tongGioHang += (int) round($gia * $qty);
    $tongSoLuong += $qty;
}
$phiVanChuyen = 250000;
$tongDon = $tongGioHang + $phiVanChuyen;

$errThanhToan = '';
if (!empty($_SESSION['error_thanh_toan'])) {
    $errThanhToan = (string) $_SESSION['error_thanh_toan'];
    unset($_SESSION['error_thanh_toan']);
}

$uTen = htmlspecialchars(trim((string) ($user['ho_ten'] ?? '')), ENT_QUOTES, 'UTF-8');
$uEmail = htmlspecialchars(trim((string) ($user['email'] ?? '')), ENT_QUOTES, 'UTF-8');
$uSdt = htmlspecialchars(trim((string) ($user['so_dien_thoai'] ?? '')), ENT_QUOTES, 'UTF-8');
$uDcRaw = trim((string) ($user['dia_chi'] ?? ''));
$uDc = htmlspecialchars($uDcRaw, ENT_QUOTES, 'UTF-8');
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/checkout-steps.css">

<main>
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Cửa hàng</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="checkout-page-wrapper section-padding checkout-dtaa">
        <div class="container">
            <div class="checkout-dtaa__inner">
                <?php if ($errThanhToan !== ''): ?>
                    <div class="checkout-dtaa-alert" role="alert"><?= htmlspecialchars($errThanhToan, ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>

                <form id="checkout-dtaa-form" action="<?= htmlspecialchars(BASE_URL . '?act=xu-ly-thanh-toan', ENT_QUOTES, 'UTF-8') ?>" method="POST" novalidate>
                    <input type="hidden" name="tong_tien" value="<?= (int) $tongDon ?>">

                    <div class="checkout-dtaa-appbar">
                        <a class="checkout-dtaa-appbar__back" href="<?= htmlspecialchars(BASE_URL . '?act=gio-hang', ENT_QUOTES, 'UTF-8') ?>" aria-label="Quay lại giỏ hàng"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                        <h2 class="checkout-dtaa-appbar__title" id="ck-app-title">Thông tin</h2>
                    </div>

                    <div class="checkout-dtaa-tabs" role="tablist">
                        <button type="button" class="checkout-dtaa-tab is-active" id="ck-tab-1" role="tab" aria-selected="true" aria-controls="ck-panel-1" data-go="1">
                            1. THÔNG TIN
                        </button>
                        <button type="button" class="checkout-dtaa-tab" id="ck-tab-2" role="tab" aria-selected="false" aria-controls="ck-panel-2" data-go="2">
                            2. THANH TOÁN
                        </button>
                    </div>

                    <!-- Bước 1: Thông tin -->
                    <div class="checkout-dtaa-panel" id="ck-panel-1" role="tabpanel" aria-labelledby="ck-tab-1" data-step="1">
                        <div class="checkout-dtaa-card">
                            <h2 class="checkout-dtaa-section-title">Đơn hàng</h2>
                            <?php foreach ($chiTietGioHang as $sp):
                                $giaBan = !empty($sp['discount_price']) ? (float) $sp['discount_price'] : (float) $sp['price'];
                                $giaGoc = !empty($sp['discount_price']) ? (float) $sp['price'] : null;
                                $qty = (int) ($sp['quantity'] ?? 0);
                                $lineTotal = (int) round($giaBan * $qty);
                                ?>
                                <div class="checkout-dtaa-line">
                                    <img class="checkout-dtaa-line__img" src="<?= htmlspecialchars(BASE_URL . $sp['image'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars((string) ($sp['name'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                                    <div class="checkout-dtaa-line__body">
                                        <p class="checkout-dtaa-line__name"><?= htmlspecialchars((string) ($sp['name'] ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
                                        <div class="checkout-dtaa-line__meta">
                                            <span class="checkout-dtaa-price"><?= formatPrice($lineTotal) ?></span>
                                            <?php if ($giaGoc !== null): ?>
                                                <span class="checkout-dtaa-price--old"><?= formatPrice((int) round($giaGoc * $qty)) ?></span>
                                            <?php endif; ?>
                                            <span class="checkout-dtaa-qty">Số lượng: <strong><?= $qty ?></strong></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="checkout-dtaa-card">
                            <h2 class="checkout-dtaa-section-title">Thông tin khách hàng</h2>
                            <div class="checkout-dtaa-cust-head">
                                <div class="checkout-dtaa-cust-head__left">
                                    <input class="checkout-dtaa-cust-name" type="text" id="ten_nguoi_nhan" name="ten_nguoi_nhan" required minlength="2" maxlength="120"
                                           value="<?= $uTen ?>" placeholder="Họ và tên" autocomplete="name" aria-label="Họ và tên">
                                    <span class="checkout-dtaa-badge" title="Khách hàng">KH</span>
                                </div>
                                <input class="checkout-dtaa-cust-tel" type="text" id="sdt_nguoi_nhan" name="sdt_nguoi_nhan" required
                                       value="<?= $uSdt ?>" placeholder="SĐT" inputmode="tel" autocomplete="tel" aria-label="Số điện thoại">
                            </div>
                            <div class="checkout-dtaa-field checkout-dtaa-field--line">
                                <label for="email_nguoi_nhan">Email <span class="req">*</span></label>
                                <input type="email" id="email_nguoi_nhan" name="email_nguoi_nhan" required
                                       value="<?= $uEmail ?>" placeholder="Nhập email" autocomplete="email">
                                <p class="checkout-dtaa-hint">(*) Hóa đơn VAT (nếu có) sẽ được gửi qua email này.</p>
                            </div>
                            <label class="checkout-dtaa-check-line">
                                <input type="checkbox" id="ck-email-promo" name="nhan_uu_dai_email" value="1">
                                <span>Nhận email thông báo và ưu đãi từ cửa hàng DTAA.</span>
                            </label>
                        </div>

                        <div class="checkout-dtaa-card">
                            <h2 class="checkout-dtaa-section-title">Thông tin nhận hàng</h2>
                            <div class="checkout-dtaa-field">
                                <label for="dia_chi_nguoi_nhan">Địa chỉ nhận hàng <span class="req">*</span></label>
                                <input type="text" id="dia_chi_nguoi_nhan" name="dia_chi_nguoi_nhan" required
                                       value="<?= $uDc ?>" placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố..." autocomplete="street-address">
                            </div>
                            <label class="checkout-dtaa-check-line">
                                <input type="checkbox" id="ck-save-addr" name="luu_dia_chi" value="1">
                                <span>Lưu địa chỉ cho lần mua kế tiếp (gợi ý — cần cập nhật hồ sơ sau).</span>
                            </label>
                            <div class="checkout-dtaa-field checkout-dtaa-field--note-top">
                                <label for="ghi_chu">Ghi chú</label>
                                <textarea name="ghi_chu" id="ghi_chu" rows="3" placeholder="Ghi chú giao hàng (tuỳ chọn)"></textarea>
                            </div>
                        </div>

                        <div class="checkout-dtaa-card">
                            <div class="checkout-dtaa-vat-row">
                                <p class="checkout-dtaa-vat-row__q">Quý khách có muốn xuất hóa đơn công ty không?</p>
                                <div class="checkout-dtaa-vat-opts" role="radiogroup" aria-label="Hóa đơn công ty">
                                    <label><input type="radio" name="xuat_hd_ct" id="ck-vat-yes" value="1"><span>Có</span></label>
                                    <label><input type="radio" name="xuat_hd_ct" id="ck-vat-no" value="0" checked><span>Không</span></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bước 2: Thanh toán -->
                    <div class="checkout-dtaa-panel" id="ck-panel-2" role="tabpanel" aria-labelledby="ck-tab-2" data-step="2" hidden>
                        <div class="checkout-dtaa-card">
                            <h2 class="checkout-dtaa-section-title">Tóm tắt thanh toán</h2>
                            <div class="checkout-dtaa-promo">
                                <input type="text" readonly tabindex="-1" placeholder="Nhập mã giảm giá (sắp có)" aria-disabled="true">
                                <button type="button" tabindex="-1" disabled>Áp dụng</button>
                            </div>
                            <ul class="checkout-dtaa-rows">
                                <li><span class="k">Số lượng sản phẩm</span><span class="v"><?= str_pad((string) $tongSoLuong, 2, '0', STR_PAD_LEFT) ?></span></li>
                                <li><span class="k">Tổng tiền hàng</span><span class="v"><?= formatPrice($tongGioHang) ?></span></li>
                                <li><span class="k">Phí vận chuyển</span><span class="v"><?= formatPrice($phiVanChuyen) ?></span></li>
                            </ul>
                            <div class="checkout-dtaa-total-block">
                                <span class="lbl">Tổng thanh toán</span>
                                <span class="sum"><?= formatPrice($tongDon) ?></span>
                            </div>
                            <p class="checkout-dtaa-vat-note">Số tiền cuối cùng có thể được điều chỉnh theo chính sách cửa hàng.</p>
                        </div>

                        <div class="checkout-dtaa-card">
                            <h2 class="checkout-dtaa-section-title">Phương thức thanh toán</h2>
                            <div class="checkout-dtaa-pay">
                                <input type="radio" id="cashon" name="phuong_thuc_thanh_toan_id" value="1" checked>
                                <div>
                                    <label for="cashon">Thanh toán khi nhận hàng (COD)</label>
                                    <p>Thanh toán bằng tiền mặt khi nhận được hàng. Đơn hàng sẽ được xác nhận trước khi giao.</p>
                                </div>
                            </div>
                            <div class="checkout-dtaa-pay">
                                <input type="radio" id="directbank" name="phuong_thuc_thanh_toan_id" value="2">
                                <div>
                                    <label for="directbank">Chuyển khoản ngân hàng</label>
                                    <p>Chuyển khoản theo hướng dẫn sau khi đặt hàng (nếu cửa hàng hỗ trợ).</p>
                                </div>
                            </div>
                        </div>

                        <div class="checkout-dtaa-card">
                            <h2 class="checkout-dtaa-section-title">Xác nhận</h2>
                            <label class="checkout-dtaa-terms">
                                <input type="checkbox" id="terms" name="dong_y_dat_hang" value="1" required>
                                <span>Tôi xác nhận thông tin giao hàng là chính xác và đồng ý đặt hàng theo chính sách của cửa hàng.</span>
                            </label>
                        </div>
                    </div>

                    <!-- Chân trang bước 1 -->
                    <div class="checkout-dtaa-sticky" id="ck-footer-1">
                        <div class="checkout-dtaa-sticky__row">
                            <span>Tổng tiền tạm tính:</span>
                            <strong><?= formatPrice($tongDon) ?></strong>
                        </div>
                        <p class="checkout-dtaa-sticky__warn" id="ck-warn-1" hidden>
                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                            Vui lòng nhập đầy đủ thông tin bắt buộc trước khi tiếp tục.
                        </p>
                        <button type="button" class="checkout-dtaa-sticky__btn" id="ck-btn-next" disabled aria-disabled="true">Tiếp tục</button>
                    </div>

                    <!-- Chân trang bước 2 -->
                    <div class="checkout-dtaa-sticky" id="ck-footer-2" hidden>
                        <div class="checkout-dtaa-sticky__row">
                            <span>Tổng thanh toán:</span>
                            <strong><?= formatPrice($tongDon) ?></strong>
                        </div>
                        <p class="checkout-dtaa-sticky__warn" id="ck-warn-2" hidden>
                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                            Vui lòng xác nhận thông tin và chọn phương thức thanh toán để đặt hàng.
                        </p>
                        <button type="button" class="checkout-dtaa-sticky__btn checkout-dtaa-sticky__btn--ghost" id="ck-btn-back">Quay lại</button>
                        <button type="submit" class="checkout-dtaa-sticky__btn" id="ck-btn-submit" disabled aria-disabled="true">Đặt hàng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
(function () {
  var form = document.getElementById('checkout-dtaa-form');
  if (!form) return;

  var tab1 = document.getElementById('ck-tab-1');
  var tab2 = document.getElementById('ck-tab-2');
  var p1 = document.getElementById('ck-panel-1');
  var p2 = document.getElementById('ck-panel-2');
  var f1 = document.getElementById('ck-footer-1');
  var f2 = document.getElementById('ck-footer-2');
  var btnNext = document.getElementById('ck-btn-next');
  var btnBack = document.getElementById('ck-btn-back');
  var btnSubmit = document.getElementById('ck-btn-submit');
  var appTitle = document.getElementById('ck-app-title');
  var termsEl = document.getElementById('terms');

  function trimVal(id) {
    var el = document.getElementById(id);
    return el ? String(el.value).trim() : '';
  }

  function isMeaningfulAddress(s) {
    if (s.length < 8) return false;
    var stripped = s.replace(/[\s\-.,;:_/\\]+/g, '');
    return stripped.length >= 5;
  }

  function isValidPhone(s) {
    var digits = String(s).replace(/\D/g, '');
    return digits.length >= 9 && digits.length <= 15;
  }

  function isPanel1Valid() {
    var name = trimVal('ten_nguoi_nhan');
    if (name.length < 2) return false;
    var emailEl = document.getElementById('email_nguoi_nhan');
    if (!emailEl) return false;
    var email = String(emailEl.value).trim();
    if (email === '' || !emailEl.checkValidity()) return false;
    if (!isValidPhone(trimVal('sdt_nguoi_nhan'))) return false;
    if (!isMeaningfulAddress(trimVal('dia_chi_nguoi_nhan'))) return false;
    return true;
  }

  function hasPaymentMethod() {
    return !!form.querySelector('input[name="phuong_thuc_thanh_toan_id"]:checked');
  }

  function canPlaceOrder() {
    return isPanel1Valid() && termsEl && termsEl.checked && hasPaymentMethod();
  }

  function setBtnDisabled(btn, on) {
    if (!btn) return;
    btn.disabled = on;
    btn.setAttribute('aria-disabled', on ? 'true' : 'false');
  }

  function refreshStickyButtons() {
    setBtnDisabled(btnNext, !isPanel1Valid());
    setBtnDisabled(btnSubmit, !canPlaceOrder());
    var warn1 = document.getElementById('ck-warn-1');
    var warn2 = document.getElementById('ck-warn-2');
    if (warn1) warn1.hidden = isPanel1Valid();
    if (warn2) warn2.hidden = termsEl && termsEl.checked && hasPaymentMethod();
  }

  function setStep(n) {
    var isOne = n === 1;
    p1.hidden = !isOne;
    p2.hidden = isOne;
    f1.hidden = !isOne;
    f2.hidden = isOne;
    tab1.classList.toggle('is-active', isOne);
    tab2.classList.toggle('is-active', !isOne);
    tab1.setAttribute('aria-selected', isOne ? 'true' : 'false');
    tab2.setAttribute('aria-selected', isOne ? 'false' : 'true');
    if (appTitle) appTitle.textContent = isOne ? 'Thông tin' : 'Thanh toán';
    refreshStickyButtons();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function validatePanel1WithHints() {
    var ten = document.getElementById('ten_nguoi_nhan');
    var emailEl = document.getElementById('email_nguoi_nhan');
    var phone = document.getElementById('sdt_nguoi_nhan');
    var addr = document.getElementById('dia_chi_nguoi_nhan');
    if (ten && !ten.checkValidity()) { ten.reportValidity(); return false; }
    if (emailEl && !emailEl.checkValidity()) { emailEl.reportValidity(); return false; }
    if (phone && !phone.checkValidity()) { phone.reportValidity(); return false; }
    if (addr && !addr.checkValidity()) { addr.reportValidity(); return false; }
    if (trimVal('ten_nguoi_nhan').length < 2) {
      ten.setCustomValidity('Vui lòng nhập họ và tên ít nhất 2 ký tự.');
      ten.reportValidity();
      ten.setCustomValidity('');
      return false;
    }
    if (!isValidPhone(trimVal('sdt_nguoi_nhan'))) {
      phone.setCustomValidity('Số điện thoại cần từ 9–15 chữ số.');
      phone.reportValidity();
      phone.setCustomValidity('');
      return false;
    }
    if (!isMeaningfulAddress(trimVal('dia_chi_nguoi_nhan'))) {
      addr.setCustomValidity('Vui lòng nhập địa chỉ đầy đủ (số nhà, đường, khu vực), không chỉ dấu gạch hoặc ký tự đơn.');
      addr.reportValidity();
      addr.setCustomValidity('');
      return false;
    }
    return true;
  }

  function enrichGhiChuOnce() {
    var ta = document.getElementById('ghi_chu');
    if (!ta || ta.dataset.ckEnriched === '1') return;
    var inv = form.querySelector('input[name="xuat_hd_ct"]:checked');
    if (inv) {
      var extra = '\n[Hóa đơn công ty: ' + (inv.value === '1' ? 'Có' : 'Không') + ']';
      ta.value = (ta.value + extra).trim();
    }
    ta.dataset.ckEnriched = '1';
  }

  var step1Ids = ['ten_nguoi_nhan', 'email_nguoi_nhan', 'sdt_nguoi_nhan', 'dia_chi_nguoi_nhan'];
  step1Ids.forEach(function (id) {
    var el = document.getElementById(id);
    if (el) {
      el.addEventListener('input', refreshStickyButtons);
      el.addEventListener('change', refreshStickyButtons);
    }
  });
  if (termsEl) {
    termsEl.addEventListener('change', refreshStickyButtons);
  }
  form.querySelectorAll('input[name="phuong_thuc_thanh_toan_id"]').forEach(function (r) {
    r.addEventListener('change', refreshStickyButtons);
  });

  tab1.addEventListener('click', function () { setStep(1); });
  tab2.addEventListener('click', function () {
    if (validatePanel1WithHints()) setStep(2);
  });
  if (btnNext) btnNext.addEventListener('click', function () {
    if (validatePanel1WithHints()) setStep(2);
  });
  if (btnBack) btnBack.addEventListener('click', function () { setStep(1); });

  form.addEventListener('submit', function (e) {
    if (!isPanel1Valid()) {
      e.preventDefault();
      setStep(1);
      validatePanel1WithHints();
      return;
    }
    if (!termsEl || !termsEl.checked) {
      e.preventDefault();
      setStep(2);
      if (termsEl) termsEl.focus();
      return;
    }
    if (!hasPaymentMethod()) {
      e.preventDefault();
      setStep(2);
      return;
    }
    enrichGhiChuOnce();
  });

  refreshStickyButtons();
})();
</script>

<?php require_once 'views/miniCart.php'; ?>
<?php require_once 'layout/footer.php'; ?>
