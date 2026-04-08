<?php 

// Biến môi trường, dùng chung toàn hệ thống
// Khai báo dưới dạng HẰNG SỐ để không phải dùng $GLOBALS

// Phải khớp thư mục trong www (ví dụ: webise_ban_dien_thoai_DTAA/webside_ban_dien_thoai_DTAA/)
define('BASE_URL', 'http://localhost/webise_ban_dien_thoai_DTAA/webside_ban_dien_thoai_DTAA/');

define('BASE_URL_ADMIN', 'http://localhost/webise_ban_dien_thoai_DTAA/webside_ban_dien_thoai_DTAA/admin/');

define('DB_HOST'    , 'localhost');
define('DB_PORT'    , 3306);
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME'    , 'duan1_dtaa');  // Tên database

define('PATH_ROOT'    , __DIR__ . '/../');



/** Phí vận chuyển cố định (đồng) — dùng chung giỏ hàng / thanh toán */
define('PHI_VAN_CHUYEN', 250000);
/** order_statuses.id — Hủy đơn (theo bảng order_statuses) */
define('TRANG_THAI_DON_HUY', 5);
/** order_statuses.id — Đã giao (hoàn thành), không cho hủy */
define('TRANG_THAI_DON_HOAN_THANH', 4);
/**
 * order_statuses.id — Cho phép khách hủy: Đang xử lý (1), Đã xác nhận (2). Trước khi Đang giao (3).
 */
define('TRANG_THAI_DUOC_HUY_BOI_KHACH', [1, 2]);
