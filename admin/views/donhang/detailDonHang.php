<?php require './views/layout/sidebar.php' ?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chi tiết đơn hàng #<?= $donHang['order_code'] ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { background: #f4f7f6; font-family: 'Inter', sans-serif; }
    .admin-panel { max-width: 1100px; margin: 40px auto; background: #fff; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow: hidden; }
    .header { background: linear-gradient(135deg, #5755c9 0%, #5257d6 100%); padding: 25px 40px; color: white; display: flex; justify-content: space-between; align-items: center; }
    .info-label { font-weight: 700; color: #676ad6; font-size: 0.7rem; text-transform: uppercase; margin-top: 15px; }
    .info-value { color: #1f2937; font-weight: 500; margin-bottom: 5px; }
  </style>
</head>
<body>
  <div class="admin-panel">
    <div class="header">
      <div class="flex items-center gap-6">
        <a href="<?= BASE_URL_ADMIN . '?act=don-hang' ?>" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg text-sm font-bold transition">← QUAY LẠI</a>
        <div>
            <h1 class="text-xl font-bold">Mã đơn: <?= $donHang['order_code'] ?></h1>
            <p class="text-xs opacity-80">ID hệ thống: #<?= $donHang['id'] ?> | <?= date('d/m/Y H:i', strtotime($donHang['order_date'])) ?></p>
        </div>
      </div>
      <span class="bg-white text-emerald-700 px-4 py-1.5 rounded-full font-bold uppercase text-xs shadow-sm">
          <?= $donHang['ten_trang_thai'] ?>
      </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 p-10">
      <div class="md:col-span-1 border-r border-gray-100 pr-8">
        <h3 class="font-bold text-gray-400 uppercase text-xs tracking-widest mb-4">Thông tin khách hàng</h3>
        
        <p class="info-label">Người nhận</p>
        <p class="info-value text-lg text-indigo-700 font-bold"><?= $donHang['receiver_name'] ?></p>

        <p class="info-label">Số điện thoại</p>
        <p class="info-value"><?= $donHang['receiver_phone'] ?></p>

        <p class="info-label">Email liên hệ</p>
        <p class="info-value text-blue-600 font-medium"><?= $donHang['receiver_email'] ?></p>

        <p class="info-label">Địa chỉ giao hàng</p>
        <p class="info-value italic text-gray-600"><?= $donHang['receiver_address'] ?></p>

        <p class="info-label">Phương thức thanh toán</p>
        <p class="info-value px-2 py-1 bg-gray-100 rounded inline-block text-xs"><?= $donHang['ten_phuong_thuc'] ?></p>
      </div>

      <div class="md:col-span-2">
        <h3 class="font-bold text-gray-400 uppercase text-xs tracking-widest mb-4">Sản phẩm đơn hàng</h3>
        <div class="space-y-3">
          <?php foreach ($sanPhamDonHang as $sp): ?>
          <div class="flex items-center justify-between p-3 border rounded-xl hover:bg-gray-50 transition">
            <div class="flex items-center gap-4">
               <img src="<?= BASE_URL . $sp['image'] ?>" class="w-12 h-12 object-cover rounded-md shadow-sm">
               <div>
                  <p class="font-bold text-sm text-gray-800"><?= $sp['name'] ?></p>
                  <p class="text-xs text-gray-500"><?= number_format($sp['price'], 0, ',', '.') ?>đ x <?= $sp['quantity'] ?></p>
               </div>
            </div>
            <p class="font-bold text-gray-700"><?= number_format($sp['price'] * $sp['quantity'], 0, ',', '.') ?>đ</p>
          </div>
          <?php endforeach; ?>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-between items-end">
            <div>
                <p class="text-xs text-gray-400 uppercase font-bold">Ghi chú</p>
                <p class="text-sm italic text-gray-500"><?= $donHang['note'] ?: 'Không có ghi chú từ khách hàng.' ?></p>
            </div>
            <div class="text-right">
                <p class="text-gray-400 text-sm">Tổng cộng</p>
                <p class="text-3xl font-black text-red-600"><?= number_format($donHang['total_price'], 0, ',', '.') ?>đ</p>
            </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>