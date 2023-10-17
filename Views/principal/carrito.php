<?php include "Views/template/header.php"; ?>

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="<?php echo BASE_URL; ?>public/img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Carrito</h2>
                    <div class="breadcrumb__option">
                        <a href="<?php echo BASE_URL; ?>">Inicio</a>
                        <span>Carrito</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Shoping Cart Section Begin -->
<section class="shoping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="shoping__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th class="shoping__product">Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tblCarrito">
                        </tbody>
                    </table>
                </div>
                <div class="shoping__cart__btns">
                    <!-- <a href="#" class="primary-btn cart-btn">CONTINUE SHOPPING</a> -->
                    <a href="#" class="primary-btn cart-btn cart-btn-right" id="botonVaciar"><span class="icon_loading"></span>
                        Vaciar carrito</a>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- <div class="col-lg-6">
                <div class="shoping__continue">
                    <div class="shoping__discount">
                        <h5>Discount Codes</h5>
                        <form action="#">
                            <input type="text" placeholder="Enter your coupon code">
                            <button type="submit" class="site-btn">APPLY COUPON</button>
                        </form>
                    </div>
                </div>
            </div> -->
                <div class="shoping__checkout">
                    <h5>Cart Total</h5>
                    <ul>
                        <!-- <li>Subtotal <span>$454.98</span></li> -->
                        <li>Total <span id="total">$454.98</span></li>
                    </ul>
                    <a href="<?php echo BASE_URL . 'principal/order'; ?>" class="primary-btn mb-2">CHECKOUT</a>
                    <input type="hidden" id="whatsapp-negocio" value="<?php echo $data['negocio']['whatsapp']; ?>">
                    <a href="#" class="btn btn-success btn-block" id="carrito-whatsapp">WHATSAPP</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shoping Cart Section End -->

<?php include "Views/template/footer.php"; ?>

<script src="<?php echo BASE_URL; ?>public/js/carrito.js"></script>
</body>

</html>