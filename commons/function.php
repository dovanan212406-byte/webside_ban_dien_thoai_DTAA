<?php

// Kết nối CSDL qua PDO
function connectDB() {
    // Kết nối CSDL
    $host = DB_HOST;
    $port = DB_PORT;
    $dbname = DB_NAME;

    try {
        $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", DB_USERNAME, DB_PASSWORD);

        // cài đặt chế độ báo lỗi là xử lý ngoại lệ
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // cài đặt chế độ trả dữ liệu
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
        return $conn;
    } catch (PDOException $e) {
        error_log('connectDB: ' . $e->getMessage());
    }

    return null;
}
function uploadFile($file,$folderUpload){
    $pathStorage=$folderUpload . time() . $file['name'];

    $from= $file['tmp_name'];
    $to=PATH_ROOT .$pathStorage;

    if(move_uploaded_file($from,$to)){
        return $pathStorage;
    }
    return null;
}
function deleteFile($file){
    $pathDelete= PATH_ROOT .$file;
    if(file_exists($pathDelete)){
        unlink($pathDelete);
    }
}

// xoa session sau khi load trang    
function deleteSessionError(){
    if (isset($_SESSION['flash'])) {
        unset($_SESSION['flash']);
        unset($_SESSION['error']);
    }
}
function uploadFileAlbum($file,$folderUpload, $key){
    $pathStorage=$folderUpload . time() . $file['name'][$key];

    $from= $file['tmp_name'][$key];
    $to=PATH_ROOT .$pathStorage;

    if(move_uploaded_file($from,$to)){
        return $pathStorage;
    }
    return null;
}
function checkLoginAdmin(){
    if(!isset($_SESSION['user_admin'])){
        header('Location: ' . BASE_URL . '?act=login');
        exit();
    }

}
function formatPrice($price){
    return number_format($price, 0, ',', '.');
}
function donHangCoTheHuy($trangThaiId): bool
{
    $id = (int) $trangThaiId;
    if (defined('TRANG_THAI_DON_HUY') && $id === (int) TRANG_THAI_DON_HUY) {
        return false;
    }
    if (defined('TRANG_THAI_DON_HOAN_THANH') && $id === (int) TRANG_THAI_DON_HOAN_THANH) {
        return false;
    }
    $allowed = defined('TRANG_THAI_DUOC_HUY_BOI_KHACH') ? TRANG_THAI_DUOC_HUY_BOI_KHACH : [1];
    return in_array($id, (array) $allowed, true);
}