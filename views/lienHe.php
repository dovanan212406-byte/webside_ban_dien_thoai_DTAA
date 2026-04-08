<?php require_once 'layout/header.php'; ?>
<?php require_once 'layout/menu.php'; ?>

<main>
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Liên hệ</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="contact-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="contact-message">
                        <h4 class="contact-title">Gửi phản hồi cho chúng tôi</h4>
                        <form id="contact-form" action="#" method="post" class="contact-form">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input name="name" placeholder="Họ tên *" type="text" required>
                                </div>
                                <div class="col-lg-6">
                                    <input name="email" placeholder="Email *" type="email" required>
                                </div>
                                <div class="col-12">
                                    <input name="subject" placeholder="Tiêu đề" type="text">
                                </div>
                                <div class="col-12">
                                    <textarea name="message" placeholder="Nội dung *"></textarea>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-sqr" type="submit">Gửi tin nhắn</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-info">
                        <h4 class="contact-title">Thông tin cửa hàng</h4>
                        <ul>
                            <li><i class="fa fa-map-marker"></i> Địa chỉ: Trịnh Văn Bô, Nam Từ Liêm, Hà Nội</li>
                            <li><i class="fa fa-phone"></i> Điện thoại: 0123 456 789</li>
                            <li><i class="fa fa-envelope"></i> Email: support@dtaa.vn</li>
                        </ul>
                        <div class="working-time mt-4">
                            <h5>Giờ làm việc</h5>
                            <p>Sáng: 08:00 - 12:00 | Chiều: 13:30 - 21:00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once 'layout/footer.php'; ?>