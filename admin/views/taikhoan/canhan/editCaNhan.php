<?php require './views/layout/sidebar.php' ?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cài đặt tài khoản cá nhân</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { margin: 0; font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
    .admin-panel { max-width: 1100px; margin: 40px auto; background: #fff; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); overflow: hidden; }
    .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px 40px; color: white; }
    .content-body { padding: 40px; }
    .input-field { width: 100%; border: 1px solid #e2e8f0; padding: 12px; border-radius: 8px; outline: none; transition: all 0.3s; background: #f8f9fa; }
    .input-field:focus { border-color: #667eea; background: #fff; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
    .btn-primary { padding: 12px 25px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px; font-weight: 600; transition: opacity 0.3s; }
    .btn-primary:hover { opacity: 0.9; }
    .btn-dark { padding: 12px 25px; background: #2d3436; color: white; border-radius: 8px; font-weight: 600; transition: background 0.3s; }
    .btn-dark:hover { background: #000; }
    .section-title { font-size: 18px; font-weight: 700; color: #4a5568; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #f1f5f9; display: flex; align-items: center; }
    .avatar-container { border: 4px solid #f1f5f9; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
  </style>
</head>
<body>
  <div class="admin-panel">
    <div class="header">
      <h1 class="text-3xl font-bold">Hồ Sơ Cá Nhân</h1>
      <p>Quản lý thông tin và bảo mật tài khoản quản trị viên</p>
    </div>

    <div class="content-body">
      <?php if (isset($_SESSION['success'])): ?>
        <div class="mb-8 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg flex items-center">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <span class="font-medium"><?= $_SESSION['success']; unset($_SESSION['success']); ?></span>
        </div>
      <?php endif; ?>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        
        <div class="lg:col-span-4 flex flex-col items-center">
            <?php 
                $displayName = $thongTin['ho_ten'] ?? $thongTin['full_name'] ?? 'Admin';
                $roleName = ($thongTin['chuc_vu_id'] ?? $thongTin['role_id'] ?? 0) == 1 ? 'Quản trị viên' : 'Nhân viên';
            ?>
            <div class="avatar-container w-48 h-48 rounded-full overflow-hidden mb-6">
                <img src="<?= BASE_URL . ($thongTin['avatar'] ?? '') ?>" 
                     class="w-full h-full object-cover"
                     onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($displayName) ?>&size=200&background=667eea&color=fff'">
            </div>
            <h3 class="text-2xl font-bold text-gray-800"><?= $displayName ?></h3>
            <span class="mt-2 px-4 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-bold uppercase tracking-wider">
                <?= $roleName ?>
            </span>
            
            <div class="mt-10 w-full">
                <a href="<?= BASE_URL_ADMIN ?>" class="flex items-center justify-center text-gray-500 hover:text-purple-600 font-semibold transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Quay lại bảng điều khiển
                </a>
            </div>
        </div>

        <div class="lg:col-span-8">
            <div class="mb-12">
                <h4 class="section-title">
                    <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Thông tin cơ bản
                </h4>
                <form action="<?= BASE_URL_ADMIN . '?act=sua-thong-tin-ca-nhan-quan-tri' ?>" method="POST" class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Họ và tên</label>
                        <input type="text" name="ho_ten" value="<?= htmlspecialchars($displayName) ?>" class="input-field" required placeholder="Nhập họ tên...">
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email hệ thống</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($thongTin['email'] ?? '') ?>" class="input-field" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Số điện thoại</label>
                            <input type="text" name="so_dien_thoai" value="<?= htmlspecialchars($thongTin['so_dien_thoai'] ?? $thongTin['phone'] ?? '') ?>" class="input-field" placeholder="0123.456.789">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Địa chỉ liên hệ</label>
                        <input type="text" name="dia_chi" value="<?= htmlspecialchars($thongTin['dia_chi'] ?? $thongTin['address'] ?? '') ?>" class="input-field" placeholder="Số nhà, tên đường, thành phố...">
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="btn-primary shadow-lg">Lưu Thay Đổi</button>
                    </div>
                </form>
            </div>

            <div class="bg-gray-50 p-8 rounded-xl border border-gray-100">
                <h4 class="section-title">
                    <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Bảo mật & Mật khẩu
                </h4>
                <form action="<?= BASE_URL_ADMIN . '?act=sua-mat-khau-ca-nhan-quan-tri' ?>" method="POST" class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Mật khẩu hiện tại</label>
                        <input type="password" name="old_pass" class="input-field" required placeholder="••••••••">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Mật khẩu mới</label>
                            <input type="password" name="new_pass" class="input-field" required placeholder="Tối thiểu 6 ký tự">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Xác nhận mật khẩu</label>
                            <input type="password" name="confirm_pass" class="input-field" required placeholder="Nhập lại mật khẩu mới">
                        </div>
                    </div>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="p-3 bg-red-50 text-red-600 text-sm rounded-lg border border-red-100">
                            <?php 
                                if(is_array($_SESSION['error'])) {
                                    echo implode('<br>', $_SESSION['error']);
                                } else {
                                    echo $_SESSION['error'];
                                }
                                unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="btn-dark shadow-md">Cập Nhật Mật Khẩu</button>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>