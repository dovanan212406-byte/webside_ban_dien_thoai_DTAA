<!-- Scroll to top start -->
<div class="scroll-top not-visible">
    <i class="fa fa-angle-up"></i>
</div>
<!-- Scroll to Top End -->

<!-- footer area start -->
<footer class="footer-widget-area">
    <div class="footer-top section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="widget-item">
                        <div class="widget-title">
                            <div class="widget-logo">
                                <a href="<?= BASE_URL ?>">
                                    <img src="assets/img/logo/LOGO.png" alt="brand logo">
                                </a>
                            </div>
                        </div>
                        <div class="widget-body">
                            <p>DTAA là website chuyên cung cấp điện thoại chính hãng với giá tốt, cập nhật nhanh các sản phẩm mới từ những thương hiệu uy tín. Chúng tôi cam kết mang đến trải nghiệm mua sắm tiện lợi, giao hàng nhanh chóng và dịch vụ hỗ trợ tận tâm cho khách hàng.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="widget-item">
                        <h6 class="widget-title">Liên hệ</h6>
                        <div class="widget-body">
                            <address class="contact-block">
                                <ul>
                                    <li><i class="pe-7s-home"></i> Nam Từ Liêm, Hà Nội</li>
                                    <li><i class="pe-7s-mail"></i> <a href="mailto:dienthoaidtaa@gmail.com">dienthoaidtaa@gmail.com</a></li>
                                    <li><i class="pe-7s-call"></i> <a href="tel:0355732124">0355732124</a></li>
                                </ul>
                            </address>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="widget-item">
                        <h6 class="widget-title">Thông tin</h6>
                        <div class="widget-body">
                            <ul class="info-list">
                                <li><a href="<?= BASE_URL ?>?act=gioi-thieu">Về chúng tôi</a></li>
                                <li><a href="#">Chính sách bảo mật</a></li>
                                <li><a href="#">Điều khoản</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="widget-item">
                        <h6 class="widget-title">Theo dõi chúng tôi</h6>
                        <div class="widget-body social-link">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center mt-20">
                <div class="col-md-6">
                    <div class="footer-payment">
                        <img src="assets/img/payment.png" alt="payment method">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="copyright-text text-center">
                        <p>&copy; 2025 <b>DTAA</b> Made with <i class="fa fa-heart text-danger"></i></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer area end -->

<!-- JS -->
<script src="assets/js/vendor/modernizr-3.6.0.min.js"></script>
<script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
<script src="assets/js/vendor/bootstrap.bundle.min.js"></script>
<script src="assets/js/plugins/slick.min.js"></script>
<script src="assets/js/plugins/countdown.min.js"></script>
<script src="assets/js/plugins/nice-select.min.js"></script>
<script src="assets/js/plugins/jqueryui.min.js"></script>
<script src="assets/js/plugins/image-zoom.min.js"></script>
<script src="assets/js/plugins/imagesloaded.pkgd.min.js"></script>
<script src="assets/js/plugins/ajaxchimp.js"></script>
<script src="assets/js/plugins/ajax-mail.js"></script>
<script src="assets/js/main.js"></script>
<script>
function muaNgay(sanPhamId) {
    var soLuong = document.getElementById('so-luong-display').value;
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= BASE_URL ?>?act=them-gio-hang';
    var inputId = document.createElement('input');
    inputId.type = 'hidden';
    inputId.name = 'san_pham_id';
    inputId.value = sanPhamId;
    var inputQty = document.createElement('input');
    inputQty.type = 'hidden';
    inputQty.name = 'so_luong';
    inputQty.value = soLuong;
    var inputMuaNgay = document.createElement('input');
    inputMuaNgay.type = 'hidden';
    inputMuaNgay.name = 'mua_ngay';
    inputMuaNgay.value = '1';
    form.appendChild(inputId);
    form.appendChild(inputQty);
    form.appendChild(inputMuaNgay);
    document.body.appendChild(form);
    form.submit();
}
</script>
</body>
</html>
