<?php
/**
 * Trang auth thống nhất: đăng nhập + đăng ký (tab).
 * Biến: $authTab = 'login' | 'register' (set từ controller).
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$authTab = $authTab ?? 'login';
$loginUrl    = BASE_URL_ADMIN . '?act=login-admin';
$registerUrl = BASE_URL_ADMIN . '?act=dang-ky-admin';

$errMsg = $_SESSION['error'] ?? null;
$errDisplay = '';
if (is_array($errMsg)) {
    $errDisplay = implode(' ', $errMsg);
} elseif (is_string($errMsg)) {
    $errDisplay = $errMsg;
}

if ($authTab === 'login') {
    unset($_SESSION['error']);
}

$registeredOk = isset($_GET['registered']) && $_GET['registered'] === '1';
$old = $_SESSION['old_register_admin'] ?? [];

?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $authTab === 'login' ? 'Đăng nhập' : 'Đăng ký' ?> quản trị — Phone Store</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="./assets/css/auth-split.css">
</head>
<body class="auth-split-body">
<div class="auth-split-wrap">
  <div class="auth-split-inner">
    <aside class="auth-aside">
      <div class="auth-brand">
        <i class="fas fa-mobile-alt" aria-hidden="true"></i>
        <span>Phone Store</span>
      </div>
      <?php if ($authTab === 'login'): ?>
        <h1>Đăng nhập khu vực quản trị</h1>
        <p class="auth-lead">Truy cập an toàn để quản lý sản phẩm, đơn hàng và hỗ trợ khách hàng.</p>
        <ul class="auth-features">
          <li><i class="fas fa-check-circle" aria-hidden="true"></i><span>Bảo mật phiên đăng nhập</span></li>
          <li><i class="fas fa-check-circle" aria-hidden="true"></i><span>Quản lý đơn &amp; kho nhanh chóng</span></li>
          <li><i class="fas fa-check-circle" aria-hidden="true"></i><span>Hỗ trợ vận hành 24/7</span></li>
        </ul>
      <?php else: ?>
        <h1>Tạo tài khoản quản trị</h1>
        <p class="auth-lead">Đăng ký bằng email công việc — an toàn, rõ ràng và dễ khôi phục tài khoản.</p>
        <ul class="auth-features">
          <li><i class="fas fa-check-circle" aria-hidden="true"></i><span>Xác thực qua email chuẩn</span></li>
          <li><i class="fas fa-check-circle" aria-hidden="true"></i><span>Thêm số điện thoại để liên hệ khi cần</span></li>
          <li><i class="fas fa-check-circle" aria-hidden="true"></i><span>Đồng ý điều khoản trước khi kích hoạt</span></li>
        </ul>
      <?php endif; ?>
    </aside>

    <div class="auth-main">
      <div class="auth-tabs" role="tablist">
        <a href="<?= htmlspecialchars($loginUrl) ?>" class="auth-tab <?= $authTab === 'login' ? 'is-active' : '' ?>" role="tab" aria-selected="<?= $authTab === 'login' ? 'true' : 'false' ?>">
          <i class="fas fa-sign-in-alt" aria-hidden="true"></i> Đăng nhập
        </a>
        <a href="<?= htmlspecialchars($registerUrl) ?>" class="auth-tab <?= $authTab === 'register' ? 'is-active' : '' ?>" role="tab" aria-selected="<?= $authTab === 'register' ? 'true' : 'false' ?>">
          <i class="fas fa-user-plus" aria-hidden="true"></i> Đăng ký
        </a>
      </div>

      <?php if ($authTab === 'login'): ?>
        <h2 class="auth-title">Đăng nhập tài khoản</h2>
        <p class="auth-sub">Nhập email hoặc số điện thoại đã đăng ký — chỉ mất vài giây.</p>

        <?php if ($registeredOk): ?>
          <div class="auth-alert auth-alert--success">Đăng ký thành công. Vui lòng đăng nhập.</div>
        <?php endif; ?>

        <?php if ($errDisplay !== ''): ?>
          <div class="auth-alert auth-alert--danger"><?= htmlspecialchars($errDisplay) ?></div>
        <?php endif; ?>

        <form action="<?= htmlspecialchars(BASE_URL_ADMIN) ?>?act=check-login-admin" method="post" autocomplete="off" class="auth-form-block">
          <div class="auth-field">
            <label for="login-email">Email hoặc số điện thoại</label>
            <div class="auth-input-wrap">
              <span class="auth-input-icon"><i class="fas fa-user" aria-hidden="true"></i></span>
              <input id="login-email" type="text" name="email" required
                     placeholder="your@email.com hoặc 09xx xxx xxx"
                     value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>
          </div>
          <div class="auth-field">
            <label for="login-password">Mật khẩu</label>
            <div class="auth-input-wrap">
              <span class="auth-input-icon"><i class="fas fa-lock" aria-hidden="true"></i></span>
              <input id="login-password" type="password" name="password" required placeholder="Mật khẩu">
            </div>
          </div>
          <button type="submit" class="auth-submit">
            <i class="fas fa-right-to-bracket" aria-hidden="true"></i>
            Đăng nhập
          </button>
        </form>

        <p class="auth-footer-link">
          Chưa có tài khoản quản trị? <a href="<?= htmlspecialchars($registerUrl) ?>">Đăng ký ngay</a>
        </p>

      <?php else: ?>
        <h2 class="auth-title">Đăng ký tài khoản</h2>
        <p class="auth-sub">Điền thông tin liên hệ, đặt mật khẩu và đồng ý điều khoản để hoàn tất.</p>

        <?php if ($errDisplay !== ''): ?>
          <div class="auth-alert auth-alert--danger"><?= htmlspecialchars($errDisplay) ?></div>
        <?php endif; ?>

        <form action="<?= htmlspecialchars(BASE_URL_ADMIN) ?>?act=check-dang-ky-admin" method="post" id="form-register" class="auth-form-block" novalidate>
          <div class="auth-register-banner" role="status">
            <div class="auth-register-banner__icon" aria-hidden="true">
              <i class="fas fa-envelope-open-text"></i>
            </div>
            <div class="auth-register-banner__text">
              <strong>Đăng ký qua email</strong>
              <span>Dùng địa chỉ email thật để đăng nhập và nhận thông báo quan trọng.</span>
            </div>
          </div>

          <div class="auth-field">
            <label for="reg-name">Họ và tên</label>
            <div class="auth-input-wrap">
              <span class="auth-input-icon"><i class="fas fa-id-card" aria-hidden="true"></i></span>
              <input id="reg-name" type="text" name="ho_ten" required maxlength="120" placeholder="Nguyễn Văn A"
                value="<?= htmlspecialchars($old['ho_ten'] ?? '') ?>">
            </div>
          </div>

          <div class="auth-field">
            <label for="reg-email">Email</label>
            <div class="auth-input-wrap">
              <span class="auth-input-icon"><i class="fas fa-envelope" aria-hidden="true"></i></span>
              <input id="reg-email" type="email" name="email" inputmode="email" autocomplete="email" required
                placeholder="ban@congty.com" value="<?= htmlspecialchars($old['email'] ?? '') ?>">
            </div>
          </div>
          <div class="auth-field">
            <label for="reg-phone-g">Số điện thoại <span class="auth-optional">(tuỳ chọn)</span></label>
            <div class="auth-input-wrap">
              <span class="auth-input-icon"><i class="fas fa-phone" aria-hidden="true"></i></span>
              <input id="reg-phone-g" type="tel" name="so_dien_thoai" autocomplete="tel" placeholder="09xx xxx xxx"
                value="<?= htmlspecialchars($old['so_dien_thoai'] ?? '') ?>">
            </div>
          </div>

          <div class="auth-row-2">
            <div class="auth-field">
              <label for="reg-pass">Mật khẩu</label>
              <div class="auth-input-wrap">
                <span class="auth-input-icon"><i class="fas fa-lock" aria-hidden="true"></i></span>
                <input id="reg-pass" type="password" name="password" autocomplete="new-password" required minlength="6" placeholder="Tối thiểu 6 ký tự">
              </div>
            </div>
            <div class="auth-field">
              <label for="reg-pass2">Xác nhận mật khẩu</label>
              <div class="auth-input-wrap">
                <span class="auth-input-icon"><i class="fas fa-lock" aria-hidden="true"></i></span>
                <input id="reg-pass2" type="password" name="password_confirm" autocomplete="new-password" required placeholder="Nhập lại mật khẩu">
              </div>
            </div>
          </div>

          <div class="auth-terms">
            <label class="auth-checkbox">
              <input type="checkbox" name="dieu_khoan" value="1" <?= !empty($old['dieu_khoan']) ? 'checked' : '' ?> required>
              <span>Tôi đã đọc và đồng ý với <button type="button" class="auth-link-btn" id="open-terms">Điều khoản dịch vụ</button> &amp; chính sách bảo mật.</span>
            </label>
          </div>

          <button type="submit" class="auth-submit">
            <i class="fas fa-user-check" aria-hidden="true"></i>
            Hoàn tất đăng ký
          </button>
        </form>

        <p class="auth-footer-link">
          Đã có tài khoản? <a href="<?= htmlspecialchars($loginUrl) ?>">Đăng nhập</a>
        </p>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="auth-modal" id="modal-terms" aria-hidden="true" role="dialog" aria-labelledby="terms-title">
  <div class="auth-modal__backdrop" id="terms-backdrop"></div>
  <div class="auth-modal__box">
    <div class="auth-modal__head">
      <h3 id="terms-title">Điều khoản dịch vụ</h3>
      <button type="button" class="auth-modal__close" id="close-terms" aria-label="Đóng"><i class="fas fa-times"></i></button>
    </div>
    <div class="auth-modal__body">
      <p><strong>1. Phạm vi sử dụng</strong> Tài khoản quản trị chỉ dùng cho mục đích vận hành cửa hàng Phone Store. Không chia sẻ thông tin đăng nhập cho bên thứ ba.</p>
      <p><strong>2. Bảo mật</strong> Bạn có trách nhiệm bảo vệ mật khẩu. Mọi thao tác từ tài khoản của bạn được coi là đã được bạn ủy quyền.</p>
      <p><strong>3. Dữ liệu</strong> Chúng tôi xử lý dữ liệu theo chính sách bảo mật nội bộ phù hợp quy định hiện hành.</p>
    </div>
    <div class="auth-modal__foot">
      <button type="button" class="auth-submit auth-submit--sm" id="terms-ok">Đã hiểu</button>
    </div>
  </div>
</div>

<script>
(function () {
  var modal = document.getElementById('modal-terms');
  var openBtn = document.getElementById('open-terms');
  var closeBtn = document.getElementById('close-terms');
  var backdrop = document.getElementById('terms-backdrop');
  var okBtn = document.getElementById('terms-ok');

  function openM() { if (modal) { modal.classList.add('is-open'); modal.setAttribute('aria-hidden', 'false'); document.body.style.overflow = 'hidden'; } }
  function closeM() { if (modal) { modal.classList.remove('is-open'); modal.setAttribute('aria-hidden', 'true'); document.body.style.overflow = ''; } }

  if (openBtn) openBtn.addEventListener('click', openM);
  if (closeBtn) closeBtn.addEventListener('click', closeM);
  if (backdrop) backdrop.addEventListener('click', closeM);
  if (okBtn) okBtn.addEventListener('click', closeM);
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeM(); });
})();
</script>
</body>
</html>
