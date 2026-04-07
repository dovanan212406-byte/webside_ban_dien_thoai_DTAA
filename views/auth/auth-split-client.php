<?php
/**
 * Khách hàng: đăng nhập / đăng ký — nền hồng, form căn giữa.
 * $clientAuthTab = 'login' | 'register'
 */
$clientAuthTab = $clientAuthTab ?? 'login';
$authPageTitle = $clientAuthTab === 'login' ? 'Đăng nhập' : 'Đăng ký';

$rememberEmail = $_COOKIE['client_remember_email'] ?? '';
$prefillEmail = $rememberEmail !== '' ? $rememberEmail : ($_POST['email'] ?? '');
$justRegistered = isset($_GET['registered']) && $_GET['registered'] === '1';

$errLogin = '';
if ($clientAuthTab === 'login') {
    $e = $_SESSION['client_auth_login_error'] ?? '';
    $errLogin = is_string($e) ? $e : '';
}

$errRegList = [];
$old = $_SESSION['old_dang_ky'] ?? [];
if ($clientAuthTab === 'register') {
    $e = $_SESSION['client_auth_register_errors'] ?? null;
    if (is_array($e)) {
        $errRegList = array_values(array_filter(array_map('strval', $e), function ($m) {
            return $m !== '';
        }));
    } elseif (is_string($e) && $e !== '') {
        $errRegList = [$e];
    }
}

$loginUrl = BASE_URL . '?act=login';
$regUrl   = BASE_URL . '?act=dang-ky';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="theme-color" content="#fce7f3">
  <title><?= htmlspecialchars($authPageTitle) ?> — DTAA</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/vendor/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/client-auth.css">
  <link rel="icon" href="assets/img/logo/LOGO.png" type="image/png">
</head>
<body class="smember-auth-page">

  <main class="smember-form-panel">
    <!-- Back link -->
    <a class="smember-back" href="<?= htmlspecialchars(BASE_URL) ?>">
      <i class="fa fa-arrow-left" aria-hidden="true"></i> Về cửa hàng
    </a>

    <div class="smember-form-wrap">
      <!-- Tabs -->
      <div class="smember-tabs" role="tablist">
        <a href="<?= htmlspecialchars($loginUrl) ?>"
           class="smember-tab <?= $clientAuthTab === 'login' ? 'is-active' : '' ?>"
           role="tab" aria-selected="<?= $clientAuthTab === 'login' ? 'true' : 'false' ?>">
          <i class="fa fa-sign-in" aria-hidden="true"></i> Đăng nhập
        </a>
        <a href="<?= htmlspecialchars($regUrl) ?>"
           class="smember-tab <?= $clientAuthTab === 'register' ? 'is-active' : '' ?>"
           role="tab" aria-selected="<?= $clientAuthTab === 'register' ? 'true' : 'false' ?>">
          <i class="fa fa-user-plus" aria-hidden="true"></i> Đăng ký
        </a>
      </div>

      <!-- ========== LOGIN ========== -->
      <?php if ($clientAuthTab === 'login'): ?>
        <div class="smember-form-box" role="tabpanel">
          <header class="smember-form-head smember-form-head--tight">
            <h1 class="smember-form-title">Đăng nhập</h1>
          </header>

          <?php if ($justRegistered): ?>
            <div class="smember-alert smember-alert--ok" role="status">
              <i class="fa fa-check-circle" aria-hidden="true"></i>
              <span>Đăng ký thành công! Bạn có thể đăng nhập ngay.</span>
            </div>
          <?php endif; ?>

          <?php if ($errLogin !== ''): ?>
            <div class="smember-alert smember-alert--error" role="alert" aria-live="polite">
              <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
              <span><?= htmlspecialchars($errLogin) ?></span>
            </div>
          <?php endif; ?>

          <form action="<?= htmlspecialchars(BASE_URL) ?>?act=check-login" method="post" autocomplete="on" novalidate>
            <!-- Phone / Email field -->
            <div class="smember-field">
              <label for="sf-phone">Số điện thoại / Email</label>
              <div class="smember-input-wrap">
                <span class="smember-input-icon"><i class="fa fa-user" aria-hidden="true"></i></span>
                <input id="sf-phone" type="text" name="email" required
                       placeholder="Nhập số điện thoại hoặc email"
                       autocomplete="username tel email"
                       value="<?= htmlspecialchars($prefillEmail) ?>">
              </div>
            </div>

            <!-- Password field -->
            <div class="smember-field">
              <label for="sf-pass">Mật khẩu</label>
              <div class="smember-input-wrap">
                <span class="smember-input-icon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                <input id="sf-pass" class="smember-toggle-target" type="password" name="password" required
                       placeholder="Nhập mật khẩu" autocomplete="current-password">
                <button type="button" class="smember-toggle-pass" data-target="sf-pass" aria-label="Hiện mật khẩu">
                  <i class="fa fa-eye" aria-hidden="true"></i>
                </button>
              </div>
            </div>

            <!-- Remember + Forgot -->
            <div class="smember-row smember-row--between">
              <label class="smember-check">
                <input type="checkbox" name="remember" value="1" <?= $rememberEmail !== '' ? 'checked' : '' ?>>
                <span>Ghi nhớ đăng nhập</span>
              </label>
              <button type="button" class="smember-link-btn" id="sf-btn-forgot">Quên mật khẩu?</button>
            </div>

            <!-- Submit -->
            <button type="submit" class="smember-btn-primary">
              <i class="fa fa-sign-in" aria-hidden="true"></i> Đăng nhập
            </button>
          </form>

          <p class="smember-form-footer">
            Chưa có tài khoản? <a href="<?= htmlspecialchars($regUrl) ?>">Đăng ký ngay</a>
          </p>
        </div>

      <!-- ========== REGISTER ========== -->
      <?php else: ?>
        <div class="smember-form-box" role="tabpanel">
          <header class="smember-form-head smember-form-head--tight">
            <h1 class="smember-form-title">Đăng ký</h1>
          </header>

          <?php if (!empty($errRegList)): ?>
            <div class="smember-alert smember-alert--error" role="alert" aria-live="polite">
              <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
              <div>
                <?php if (count($errRegList) === 1): ?>
                  <span><?= htmlspecialchars($errRegList[0]) ?></span>
                <?php else: ?>
                  <strong>Vui lòng sửa các mục sau:</strong>
                  <ul>
                    <?php foreach ($errRegList as $msg): ?>
                      <li><?= htmlspecialchars($msg) ?></li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
              </div>
            </div>
          <?php endif; ?>

          <form action="<?= htmlspecialchars(BASE_URL) ?>?act=check-dang-ky" method="post" novalidate>
            <!-- Ho ten -->
            <div class="smember-field">
              <label for="rf-name">Họ và tên <span class="smember-required">*</span></label>
              <div class="smember-input-wrap">
                <span class="smember-input-icon"><i class="fa fa-user" aria-hidden="true"></i></span>
                <input id="rf-name" type="text" name="ho_ten" required maxlength="120"
                       placeholder="Nhập họ và tên" autocomplete="name"
                       value="<?= htmlspecialchars($old['ho_ten'] ?? '') ?>">
              </div>
            </div>

            <!-- So dien thoai -->
            <div class="smember-field">
              <label for="rf-phone">Số điện thoại <span class="smember-required">*</span></label>
              <div class="smember-input-wrap">
                <span class="smember-input-icon"><i class="fa fa-phone" aria-hidden="true"></i></span>
                <input id="rf-phone" type="tel" name="so_dien_thoai" required
                       placeholder="Nhập số điện thoại" inputmode="tel" autocomplete="tel"
                       value="<?= htmlspecialchars($old['so_dien_thoai'] ?? '') ?>">
              </div>
            </div>

            <!-- Email (optional) -->
            <div class="smember-field">
              <label for="rf-email">Email <span class="smember-optional">(tuỳ chọn)</span></label>
              <div class="smember-input-wrap">
                <span class="smember-input-icon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                <input id="rf-email" type="email" name="email"
                       placeholder="Nhập email (bỏ trống nếu đăng ký bằng SĐT)"
                       inputmode="email" autocomplete="email"
                       value="<?= htmlspecialchars($old['email'] ?? '') ?>">
              </div>
            </div>

            <!-- Mat khau + Xac nhan -->
            <div class="smember-field-row">
              <div class="smember-field">
                <label for="rf-pass">Mật khẩu <span class="smember-required">*</span></label>
                <div class="smember-input-wrap">
                  <span class="smember-input-icon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                  <input id="rf-pass" class="smember-toggle-target" type="password" name="password" required
                         minlength="6" placeholder="Tối thiểu 6 ký tự" autocomplete="new-password">
                  <button type="button" class="smember-toggle-pass" data-target="rf-pass" aria-label="Hiện mật khẩu">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                  </button>
                </div>
              </div>
              <div class="smember-field">
                <label for="rf-pass2">Xác nhận mật khẩu <span class="smember-required">*</span></label>
                <div class="smember-input-wrap">
                  <span class="smember-input-icon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                  <input id="rf-pass2" class="smember-toggle-target" type="password" name="password_confirm" required
                         placeholder="Nhập lại mật khẩu" autocomplete="new-password">
                  <button type="button" class="smember-toggle-pass" data-target="rf-pass2" aria-label="Hiện mật khẩu">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                  </button>
                </div>
              </div>
            </div>

            <!-- Terms -->
            <div class="smember-terms">
              <label>
                <input type="checkbox" name="dong_y_dieu_khoan" value="1"
                       <?= !empty($old['dong_y_dieu_khoan']) ? 'checked' : '' ?> required>
                <span>Tôi đồng ý với <button type="button" class="smember-link-btn" id="sf-open-terms">Điều khoản dịch vụ</button> và <button type="button" class="smember-link-btn" id="sf-open-privacy">Chính sách bảo mật</button>.</span>
              </label>
            </div>

            <button type="submit" class="smember-btn-primary smember-btn-primary--register">
              <i class="fa fa-user-plus" aria-hidden="true"></i> Đăng ký ngay
            </button>
          </form>

          <p class="smember-form-footer">
            Đã có tài khoản? <a href="<?= htmlspecialchars($loginUrl) ?>">Đăng nhập</a>
          </p>
        </div>
      <?php endif; ?>
    </div>
  </main>

  <!-- ========== MODALS ========== -->
  <div class="smember-modal" id="sm-modal-forgot" aria-hidden="true" role="dialog">
    <div class="smember-modal__bg" data-close="forgot"></div>
    <div class="smember-modal__box">
      <h3>Quên mật khẩu?</h3>
      <p>Liên hệ hotline / cửa hàng DTAA để được hỗ trợ đặt lại mật khẩu.</p>
      <button type="button" class="smember-btn-primary smember-btn-sm" data-close="forgot">Đã hiểu</button>
    </div>
  </div>

  <div class="smember-modal" id="sm-modal-terms" aria-hidden="true" role="dialog">
    <div class="smember-modal__bg" data-x="terms"></div>
    <div class="smember-modal__box">
      <h3>Điều khoản dịch vụ</h3>
      <p>Bạn cam kết sử dụng tài khoản đúng mục đích mua sắm tại DTAA. Mọi thông tin cá nhân được bảo mật theo chính sách của công ty.</p>
      <button type="button" class="smember-btn-primary smember-btn-sm" data-x="terms">Đã hiểu</button>
    </div>
  </div>

  <div class="smember-modal" id="sm-modal-privacy" aria-hidden="true" role="dialog">
    <div class="smember-modal__bg" data-x="privacy"></div>
    <div class="smember-modal__box">
      <h3>Chính sách bảo mật</h3>
      <p>Dữ liệu phục vụ đơn hàng. Không bán cho bên thứ ba. Thông tin được bảo vệ theo quy định pháp luật hiện hành.</p>
      <button type="button" class="smember-btn-primary smember-btn-sm" data-x="privacy">Đã hiểu</button>
    </div>
  </div>

  <script>
  (function () {
    // Toggle password
    document.querySelectorAll('.smember-toggle-pass').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var id = btn.getAttribute('data-target');
        var input = id && document.getElementById(id);
        if (!input) return;
        var show = input.getAttribute('type') === 'password';
        input.setAttribute('type', show ? 'text' : 'password');
        var icon = btn.querySelector('i');
        if (icon) icon.className = 'fa ' + (show ? 'fa-eye-slash' : 'fa-eye');
        btn.setAttribute('aria-label', show ? 'Ẩn mật khẩu' : 'Hiện mật khẩu');
      });
    });

    // Forgot modal
    var forgotModal = document.getElementById('sm-modal-forgot');
    var btnForgot = document.getElementById('sf-btn-forgot');
    if (btnForgot && forgotModal) {
      btnForgot.addEventListener('click', function () { forgotModal.classList.add('is-open'); });
      forgotModal.querySelectorAll('[data-close="forgot"]').forEach(function (el) {
        el.addEventListener('click', function () { forgotModal.classList.remove('is-open'); });
      });
    }

    // Terms / Privacy modals
    function bindModal(modalId, openId) {
      var modal = document.getElementById(modalId);
      var open = document.getElementById(openId);
      if (!modal) return;
      if (open) open.addEventListener('click', function () { modal.classList.add('is-open'); });
      var key = modalId.replace('sm-modal-', '');
      modal.querySelectorAll('[data-x="' + key + '"]').forEach(function (el) {
        el.addEventListener('click', function () { modal.classList.remove('is-open'); });
      });
    }
    bindModal('sm-modal-terms', 'sf-open-terms');
    bindModal('sm-modal-privacy', 'sf-open-privacy');
  })();
  </script>
</body>
</html>
