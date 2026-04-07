<!-- Quick view modal start -->

<!-- Quick view modal end -->

<!-- offcanvas mini cart start -->
<div class="offcanvas-minicart-wrapper">
    <div class="minicart-inner">
        <div class="offcanvas-overlay"></div>
        <div class="minicart-inner-content">
            <div class="minicart-close">
                <i class="pe-7s-close"></i>
            </div>
            <div class="minicart-content-box">
                <div class="minicart-item-wrapper">
                    <ul>
                        <li class="minicart-item">
                            <div class="minicart-thumb">
                                <a href="product-details.html">
                                    <img src="<?=$sanPham['image']?>" alt="product">
                                </a>
                            </div>
                            <div class="minicart-content">
                                <h3 class="product-name">
                                    <a href="product-details.html"><?=$sanPham['name']?></a>
                                </h3>
                                <p>
                                    <span class="cart-quantity"> <?=$sanPham['quantity']?><strong>&times;</strong></span>
                                    <span class="cart-price"><?=$sanPham['price']?></span>
                                </p>
                            </div>
                            <button class="minicart-remove"><i class="pe-7s-close"></i></button>
                        </li>
                        <li class="minicart-item">
                            <div class="minicart-thumb">
                                <a href="product-details.html">
                                    <img src="<?=$sanPham['image']?>" alt="product">
                                </a>
                            </div>
                            <div class="minicart-content">
                                <h3 class="product-name">
                                    <a href="product-details.html"><?=$sanPham['name']?></a>
                                </h3>
                                <p>
                                    <span class="cart-quantity"> <?=$sanPham['quantity']?><strong>&times;</strong></span>
                                    <span class="cart-price"><?=$sanPham['price']?></span>
                                </p>
                            </div>
                            <button class="minicart-remove"><i class="pe-7s-close"></i></button>
                        </li>
                       
                    </ul>
                </div>

                

                <div class="minicart-button">
                    <a href="<?=BASE_URL . '?act=gio-hang'?>"><i class="fa fa-shopping-cart"></i>Xem Giỏ Hàng</a>
                    <a href="cart.html"><i class="fa fa-share"></i>Thanh Toán</a>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
<!-- offcanvas mini cart end -->
