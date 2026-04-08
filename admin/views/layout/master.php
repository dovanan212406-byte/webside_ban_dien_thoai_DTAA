<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tên Doanh Nghiệp - Giải Pháp Công Nghệ</title>
    <link rel="stylesheet" href="assets/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/vendor/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/img/slider/home1-slide1.jpg');
            background-size: cover;
            color: white;
            padding: 100px 0;
        }
        .service-card {
            transition: transform 0.3s;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .service-card:hover {
            transform: translateY(-10px);
        }
        .btn-corporate {
            background-color: #0056b3;
            color: white;
            border-radius: 25px;
            padding: 10px 25px;
        }
    </style>
</head>
<body>

    <?php include 'views/layout/header.php'; ?>
    <?php include 'views/layout/menu.php'; ?>

    <main>
        <section class="hero-section text-center">
            <div class="container">
                <h1 class="display-4 font-weight-bold">Dẫn Đầu Xu Hướng Công Nghệ</h1>
                <p class="lead">Cung cấp các dòng điện thoại cao cấp và giải pháp số toàn diện cho doanh nghiệp của bạn.</p>
                <a href="#contact" class="btn btn-corporate btn-lg mt-3">Hợp Tác Ngay</a>
            </div>
        </section>

        <section class="py-5 bg-light">
            <div class="container text-center">
                <h2 class="mb-5">Dịch Vụ Của Chúng Tôi</h2>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card service-card p-4 h-100">
                            <i class="fa fa-mobile fa-3x mb-3 text-primary"></i>
                            <h3>Phân Phối Sỉ</h3>
                            <p>Cung cấp nguồn hàng điện thoại chính hãng số lượng lớn với chiết khấu tốt nhất.</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card service-card p-4 h-100">
                            <i class="fa fa-gears fa-3x mb-3 text-primary"></i>
                            <h3>Bảo Hành Doanh Nghiệp</h3>
                            <p>Chế độ bảo hành tận nơi và hỗ trợ kỹ thuật 24/7 cho các đối tác chiến lược.</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card service-card p-4 h-100">
                            <i class="fa fa-rocket fa-3x mb-3 text-primary"></i>
                            <h3>Giải Pháp Quản Lý</h3>
                            <p>Tích hợp phần mềm quản lý bán hàng hiện đại giúp tối ưu hóa doanh thu.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="content-wrapper">
            <?php echo $content; ?>
        </div>
    </main>

    <?php include 'views/layout/footer.php'; ?>

    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="assets/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>