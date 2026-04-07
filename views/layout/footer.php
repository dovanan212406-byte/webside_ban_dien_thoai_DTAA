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
                                <a href="index.html">
                                    <img src="assets/img/logo/logo.png" alt="brand logo">
                                </a>
                            </div>
                        </div>
                        <div class="widget-body">
                            <p>Chúng tôi là đội ngũ yêu động vật, chuyên cung cấp các sản phẩm & dịch vụ chất lượng cao
                                cho thú cưng.
                                Hãy để chúng tôi đồng hành cùng bạn trong hành trình chăm sóc những người bạn nhỏ đáng
                                yêu! </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="widget-item">
                        <h6 class="widget-title">Liên hệ </h6>
                        <div class="widget-body">
                            <address class="contact-block">
                                <ul>
                                    <li><i class="pe-7s-home"></i> 46C Mỹ đình 2 Nam Từ Liêm Hà Nội</li>
                                    <li><i class="pe-7s-mail"></i> <a
                                            href="mailto:demo@plazathemes.com">shopthucung@gmail.com </a></li>
                                    <li><i class="pe-7s-call"></i> <a href="tel:(012)800456789987">(084)355732124</a></li>
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
                                <li><a href="#">Về chúng tôi</a></li>
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
                    <div class="newsletter-wrapper">
                        <h6 class="widget-title-text">Đăng kí để nhận tin tức mới</h6>
                        <form class="newsletter-inner" id="mc-form">
                            <input type="email" class="news-field" id="mc-email" autocomplete="off"
                                placeholder="Enter your email address">
                            <button class="news-btn" id="mc-submit">Subscribe</button>
                        </form>
                        <!-- mail-chimp-alerts Start -->
                        <div class="mailchimp-alerts">
                            <div class="mailchimp-submitting"></div><!-- mail-chimp-submitting end -->
                            <div class="mailchimp-success"></div><!-- mail-chimp-success end -->
                            <div class="mailchimp-error"></div><!-- mail-chimp-error end -->
                        </div>
                        <!-- mail-chimp-alerts end -->
                    </div>
                </div>
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
                        <p>&copy; 2025 <b>Shopthucung</b> Made with <i class="fa fa-heart text-danger"></i> by <a
                                href="https://hasthemes.com/"><b>TuanAnh</b></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer area end -->
<!-- JS
============================================ -->

<!-- Modernizer JS -->
<script src="assets/js/vendor/modernizr-3.6.0.min.js"></script>
<!-- jQuery JS -->
<script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="assets/js/vendor/bootstrap.bundle.min.js"></script>
<!-- slick Slider JS -->
<script src="assets/js/plugins/slick.min.js"></script>
<!-- Countdown JS -->
<script src="assets/js/plugins/countdown.min.js"></script>
<!-- Nice Select JS -->
<script src="assets/js/plugins/nice-select.min.js"></script>
<!-- jquery UI JS -->
<script src="assets/js/plugins/jqueryui.min.js"></script>
<!-- Image zoom JS -->
<script src="assets/js/plugins/image-zoom.min.js"></script>
<!-- Images loaded JS -->
<script src="assets/js/plugins/imagesloaded.pkgd.min.js"></script>
<!-- mail-chimp active js -->
<script src="assets/js/plugins/ajaxchimp.js"></script>
<!-- contact form dynamic js -->
<script src="assets/js/plugins/ajax-mail.js"></script>
<!-- google map api -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfmCVTjRI007pC1Yk2o2d_EhgkjTsFVN8"></script>
<!-- google map active js -->
<script src="assets/js/plugins/google-map.js"></script>
<!-- Main JS -->
<script src="assets/js/main.js"></script>
<script>
function muaNgay(sanPhamId) {
    var soLuong = document.getElementById('so-luong-display').value;
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?=BASE_URL?>?act=them-gio-hang';
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


<!-- Mirrored from htmldemo.net/corano/corano/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 29 Jun 2024 09:53:43 GMT -->

</html>