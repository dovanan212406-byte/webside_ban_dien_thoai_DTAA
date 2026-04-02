<?php
/**
 * Khách hàng: một thẻ form nhỏ căn giữa (login / đăng ký).
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
$regUrl = BASE_URL . '?act=dang-ky';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="theme-color" content="#fdf2f8">
  <title><?= htmlspecialchars($authPageTitle) ?> — Phone Store</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/vendor/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/client-auth.css">
  <link rel="icon" href="assets/img/logo/LOGO.png" type="image/png">
</head>
<body class="client-auth-page client-auth-page--compact">
<div class="client-auth-compact-sparkle" aria-hidden="true"></div>

<div class="client-auth-compact-shell">
<a class="client-auth-back client-auth-back--compact" href="<?= htmlspecialchars(BASE_URL) ?>"><i class="fa fa-arrow-left"></i> Về cửa hàng</a>

<main class="client-auth-compact-wrap">
  <div class="client-auth-compact-card<?= $clientAuthTab === 'login' ? ' client-auth-compact-card--login' : ' client-auth-compact-card--register' ?>">
    <div class="client-auth-tabs client-auth-tabs--compact" role="tablist">
      <a href="<?= htmlspecialchars($loginUrl) ?>" class="client-auth-tab <?= $clientAuthTab === 'login' ? 'is-active' : '' ?>" role="tab">Đăng nhập</a>
      <a href="<?= htmlspecialchars($regUrl) ?>" class="client-auth-tab <?= $clientAuthTab === 'register' ? 'is-active' : '' ?>" role="tab">Đăng ký</a>
    </div>

    <?php if ($clientAuthTab === 'login'): ?>
      <div class="client-auth-panel client-auth-panel--login" role="tabpanel">
        <header class="client-auth-compact-head">
          <h1 class="client-auth-compact-head__title">Đăng nhập</h1>
          <p class="client-auth-compact-head__sub">Chào mừng bạn quay trở lại!</p>
        </header>

        <?php if ($justRegistered): ?>
          <div class="client-auth-alert client-auth-alert--ok" role="status">
            <span class="client-auth-alert__icon" aria-hidden="true"><i class="fa fa-check-circle"></i></span>
            <p>Đăng ký thành công! Bạn có thể đăng nhập ngay.</p>
          </div>
        <?php endif; ?>
        <?php if ($errLogin !== ''): ?>
          <div class="client-auth-alert client-auth-alert--error" role="alert" aria-live="polite">
            <span class="client-auth-alert__icon" aria-hidden="true"><i class="fa fa-exclamation-circle"></i></span>
            <p><?= htmlspecialchars($errLogin) ?></p>
          </div>
        <?php endif; ?>

        <form action="<?= htmlspecialchars(BASE_URL) ?>?act=check-login" method="post" autocomplete="on" novalidate>
          <div class="client-ca-field client-ca-field--compact client-ca-field--with-icon">
            <label for="cl-email">Email</label>
            <div class="client-ca-input-wrap">
              <span class="client-ca-input-wrap__icon" aria-hidden="true"><i class="fa fa-envelope-o"></i></span>
              <input id="cl-email" type="email" name="email" required placeholder="your@email.com" inputmode="email"
                     autocomplete="username"
                     value="<?= htmlspecialchars($prefillEmail) ?>">
            </div>
          </div>
          <div class="client-ca-field client-ca-field--compact client-ca-field--password">
            <label for="cl-pass">Mật khẩu</label>
            <div class="client-ca-input-wrap">
              <span class="client-ca-input-wrap__icon" aria-hidden="true"><i class="fa fa-lock"></i></span>
              <input id="cl-pass" class="client-ca-input--has-toggle" type="password" name="password" required placeholder="Nhập mật khẩu" autocomplete="current-password">
              <button type="button" class="client-ca-toggle-pass" data-target="cl-pass" aria-label="Hiện mật khẩu" title="Hiện/ẩn mật khẩu">
                <i class="fa fa-eye" aria-hidden="true"></i>
              </button>
            </div>
          </div>
          <div class="client-ca-row client-ca-row--compact">
            <label class="client-ca-check">
              <input type="checkbox" name="remember" value="1" <?= $rememberEmail !== '' ? 'checked' : '' ?>>
              Ghi nhớ đăng nhập
            </label>
            <button type="button" class="client-ca-link" id="btn-forgot" style="background:none;border:none;cursor:pointer;padding:0;font:inherit;">Quên mật khẩu?</button>
          </div>
          <button type="submit" class="client-ca-submit client-ca-submit--compact">
            Đăng nhập
          </button>
        </form>
        <p class="client-auth-footer client-auth-footer--compact">Chưa có tài khoản? <a href="<?= htmlspecialchars($regUrl) ?>">Đăng ký ngay</a></p>
      </div>

    <?php else: ?>
      <div class="client-auth-panel client-auth-panel--register" role="tabpanel">
        <header class="client-auth-compact-head client-auth-compact-head--register">
          <h1 class="client-auth-compact-head__title">Đăng ký</h1>
          <p class="client-auth-compact-head__sub">Tạo tài khoản để mua hàng và theo dõi đơn dễ dàng.</p>
        </header>

        <?php if (!empty($errRegList)): ?>
          <div class="client-auth-alert client-auth-alert--error" role="alert" aria-live="polite">
            <span class="client-auth-alert__icon" aria-hidden="true"><i class="fa fa-exclamation-circle"></i></span>
            <div class="client-auth-alert__body">
              <?php if (count($errRegList) === 1): ?>
                <p><?= htmlspecialchars($errRegList[0]) ?></p>
              <?php else: ?>
                <p class="client-auth-alert__lead">Vui lòng sửa các mục sau:</p>
                <ul class="client-auth-alert__list">
                  <?php foreach ($errRegList as $msg): ?>
                    <li><?= htmlspecialchars($msg) ?></li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>

        <form action="<?= htmlspecialchars(BASE_URL) ?>?act=check-dang-ky" method="post" id="form-dang-ky" class="client-ca-form-register" novalidate>
          <div class="client-ca-field client-ca-field--compact client-ca-field--reg client-ca-field--with-icon">
            <label for="r-name">Họ và tên</label>
            <div class="client-ca-input-wrap">
              <span class="client-ca-input-wrap__icon" aria-hidden="true"><i class="fa fa-user-o"></i></span>
              <input id="r-name" type="text" name="ho_ten" required maxlength="120" placeholder="Nguyễn Văn A" autocomplete="name"
                     value="<?= htmlspecialchars($old['ho_ten'] ?? '') ?>">
            </div>
          </div>
          <div class="client-ca-field client-ca-field--compact client-ca-field--reg client-ca-field--with-icon">
            <label for="r-email">Email</label>
            <div class="client-ca-input-wrap">
              <span class="client-ca-input-wrap__icon" aria-hidden="true"><i class="fa fa-envelope-o"></i></span>
              <input id="r-email" type="email" name="email" required placeholder="your@email.com" inputmode="email" autocomplete="email"
                     value="<?= htmlspecialchars($old['email'] ?? '') ?>">
            </div>
          </div>
          <div class="client-ca-field client-ca-field--compact client-ca-field--reg client-ca-field--with-icon">
            <label for="r-phone-g">Số điện thoại <span class="client-ca-optional">(tuỳ chọn)</span></label>
            <div class="client-ca-input-wrap">
              <span class="client-ca-input-wrap__icon" aria-hidden="true"><i class="fa fa-phone"></i></span>
              <input id="r-phone-g" type="tel" name="so_dien_thoai" placeholder="0123 456 789" inputmode="tel" autocomplete="tel"
                     value="<?= htmlspecialchars($old['so_dien_thoai'] ?? '') ?>">
            </div>
          </div>
          <div class="client-ca-reg-pass-grid">
            <div class="client-ca-field client-ca-field--compact client-ca-field--reg client-ca-field--password">
              <label for="r-pass">Mật khẩu</label>
              <div class="client-ca-input-wrap">
                <span class="client-ca-input-wrap__icon" aria-hidden="true"><i class="fa fa-lock"></i></span>
                <input id="r-pass" class="client-ca-input--has-toggle" type="password" name="password" required minlength="6" autocomplete="new-password" placeholder="Tối thiểu 6 ký tự">
                <button type="button" class="client-ca-toggle-pass" data-target="r-pass" aria-label="Hiện mật khẩu" title="Hiện/ẩn mật khẩu">
                  <i class="fa fa-eye" aria-hidden="true"></i>
                </button>
              </div>
            </div>
            <div class="client-ca-field client-ca-field--compact client-ca-field--reg client-ca-field--password">
              <label for="r-pass2">Xác nhận mật khẩu</label>
              <div class="client-ca-input-wrap">
                <span class="client-ca-input-wrap__icon" aria-hidden="true"><i class="fa fa-lock"></i></span>
                <input id="r-pass2" class="client-ca-input--has-toggle" type="password" name="password_confirm" required autocomplete="new-password" placeholder="Nhập lại">
                <button type="button" class="client-ca-toggle-pass" data-target="r-pass2" aria-label="Hiện mật khẩu" title="Hiện/ẩn mật khẩu">
                  <i class="fa fa-eye" aria-hidden="true"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="client-ca-terms client-ca-terms--compact client-ca-terms--register">
            <label>
              <input type="checkbox" name="dong_y_dieu_khoan" value="1" <?= !empty($old['dong_y_dieu_khoan']) ? 'checked' : '' ?> required>
              <span>Tôi đồng ý với <button type="button" class="link" id="open-terms">Điều khoản dịch vụ</button> và <button type="button" class="link" id="open-privacy">Chính sách bảo mật</button>.</span>
            </label>
          </div>
          <button type="submit" class="client-ca-submit client-ca-submit--compact client-ca-submit--register">
            Đăng ký
          </button>
        </form>
        <p class="client-auth-footer client-auth-footer--compact">Đã có tài khoản? <a href="<?= htmlspecialchars($loginUrl) ?>">Đăng nhập</a></p>
      </div>
    <?php endif; ?>
  </div>
</main>
</div>

<div class="client-ca-modal" id="modal-forgot" aria-hidden="true" role="dialog">
  <div class="client-ca-modal__bg" data-close="forgot"></div>
  <div class="client-ca-modal__box">
    <h3>Quên mật khẩu?</h3>
    <p>Liên hệ hotline / cửa hàng Phone Store để được hỗ trợ đặt lại mật khẩu.</p>
    <button type="button" class="client-ca-submit" data-close="forgot">Đã hiểu</button>
  </div>
</div>
<div class="client-ca-modal" id="modal-terms" aria-hidden="true">
  <div class="client-ca-modal__bg" data-x="terms"></div>
  <div class="client-ca-modal__box">
    <h3>Điều khoản dịch vụ</h3>
    <p>Bạn cam kết sử dụng tài khoản đúng mục đích mua sắm.</p>
    <button type="button" class="client-ca-submit" data-x="terms">Đã đọc</button>
  </div>
</div>
<div class="client-ca-modal" id="modal-privacy" aria-hidden="true">
  <div class="client-ca-modal__bg" data-x="privacy"></div>
  <div class="client-ca-modal__box">
    <h3>Chính sách bảo mật</h3>
    <p>Dữ liệu phục vụ đơn hàng. Không bán cho bên thứ ba.</p>
    <button type="button" class="client-ca-submit" data-x="privacy">Đã đọc</button>
  </div>
</div>

<script>
(function () {
  var forgot = document.getElementById('modal-forgot');
  var bf = document.getElementById('btn-forgot');
  if (bf && forgot) {
    bf.addEventListener('click', function () { forgot.classList.add('is-open'); });
    forgot.querySelectorAll('[data-close="forgot"]').forEach(function (el) {
      el.addEventListener('click', function () { forgot.classList.remove('is-open'); });
    });
  }
  function bindModal(id, openId) {
    var modal = document.getElementById(id);
    var open = document.getElementById(openId);
    if (!modal) return;
    if (open) open.addEventListener('click', function () { modal.classList.add('is-open'); });
    var key = id.replace('modal-', '');
    modal.querySelectorAll('[data-x="' + key + '"]').forEach(function (el) {
      el.addEventListener('click', function () { modal.classList.remove('is-open'); });
    });
  }
  bindModal('modal-terms', 'open-terms');
  bindModal('modal-privacy', 'open-privacy');

  document.querySelectorAll('.client-ca-toggle-pass').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var id = btn.getAttribute('data-target');
      var input = id && document.getElementById(id);
      if (!input) return;
      var show = input.getAttribute('type') === 'password';
      input.setAttribute('type', show ? 'text' : 'password');
      var icon = btn.querySelector('i');
      if (icon) {
        icon.className = 'fa ' + (show ? 'fa-eye-slash' : 'fa-eye');
      }
      btn.setAttribute('aria-label', show ? 'Ẩn mật khẩu' : 'Hiện mật khẩu');
    });
  });
})();
</script>
</body>
</html>
