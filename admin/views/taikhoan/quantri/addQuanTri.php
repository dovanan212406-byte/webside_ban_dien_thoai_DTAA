<?php require './views/layout/sidebar.php' ?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thêm quản trị viên mới</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/f081052a6b.js" crossorigin="anonymous"></script>
  <style>
    body { margin: 0; font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
    .admin-panel { max-width: 800px; margin: 40px auto; background: #fff; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); overflow: hidden; }
    .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px 40px; color: white; }
  </style>
</head>
<body>
  <div class="admin-panel">
    <div class="header">
      <h1 class="text-3xl font-bold">Thêm Quản Trị Viên Mới</h1>
      <p class="mt-1 opacity-90">Chỉ tài khoản Admin mới có quyền tạo thêm Admin khác</p>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
    <div class="bg-red-100 text-red-700 p-4 mx-6 mt-6 rounded-lg border border-red-200">
      <i class="fa-solid fa-circle-exclamation mr-2"></i>
      <strong>Lỗi:</strong> <?= is_array($_SESSION['error']) ? implode(', ', $_SESSION['error']) : $_SESSION['error'] ?>
    </div>
    <?php unset($_SESSION['error']); endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
    <div class="bg-green-100 text-green-700 p-4 mx-6 mt-6 rounded-lg border border-green-200">
      <i class="fa-solid fa-check-circle mr-2"></i>
      <strong>Thành công:</strong> <?= $_SESSION['success'] ?>
    </div>
    <?php unset($_SESSION['success']); endif; ?>

    <form action="<?= BASE_URL_ADMIN . '?act=them-quan-tri' ?>" method="POST" class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
      
      <div class="col-span-1 md:col-span-2">
        <label class="block font-bold mb-2 text-gray-700">Họ và tên <span class="text-red-500">*</span></label>
        <input type="text" name="full_name" required 
               placeholder="Nhập họ và tên đầy đủ"
               value="<?= $_SESSION['old_add']['full_name'] ?? '' ?>"
               class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none transition">
      </div>

      <div>
        <label class="block font-bold mb-2 text-gray-700">Email <span class="text-red-500">*</span></label>
        <input type="email" name="email" required 
               placeholder="example@email.com"
               value="<?= $_SESSION['old_add']['email'] ?? '' ?>"
               class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none transition">
      </div>

      <div>
        <label class="block font-bold mb-2 text-gray-700">Số điện thoại <span class="text-red-500">*</span></label>
        <input type="text" name="phone" required 
               placeholder="0xxx xxx xxx"
               value="<?= $_SESSION['old_add']['phone'] ?? '' ?>"
               class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none transition">
      </div>

      <div class="col-span-1 md:col-span-2">
        <label class="block font-bold mb-2 text-gray-700">Địa chỉ</label>
        <input type="text" name="address" 
               placeholder="Nhập địa chỉ"
               value="<?= $_SESSION['old_add']['address'] ?? 'Hà Nội' ?>"
               class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none transition">
      </div>

      <div class="col-span-1 md:col-span-2 bg-indigo-50 border border-indigo-200 rounded-lg p-4">
        <div class="flex items-center gap-2 text-indigo-700 mb-2">
          <i class="fa-solid fa-info-circle"></i>
          <strong>Thông tin đăng nhập mặc định</strong>
        </div>
        <p class="text-sm text-gray-600">
          Mật khẩu mặc định: <span class="font-bold text-purple-600">123456</span><br>
          Tài khoản mới sẽ có <span class="font-bold">role_id = 1</span> (Quản trị viên).
        </p>
      </div>

      <div class="col-span-1 md:col-span-2 flex justify-end gap-4 mt-4">
        <a href="<?= BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri' ?>" 
           class="px-6 py-3 bg-gray-200 rounded-lg font-bold text-gray-700 hover:bg-gray-300 transition">
          <i class="fa-solid fa-arrow-left mr-2"></i>Hủy
        </a>
        <button type="submit" 
                class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-bold shadow-lg hover:from-indigo-700 hover:to-purple-700 transition">
          <i class="fa-solid fa-user-plus mr-2"></i>Tạo tài khoản
        </button>
      </div>
      
    </form>
  </div>
</body>
</html>
