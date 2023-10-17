<?php include "Views/template/header.php"; ?>

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="<?php echo BASE_URL; ?>public/img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Categoria</h2>
                    <div class="breadcrumb__option">
                        <a href="<?php echo BASE_URL; ?>">Inicio</a>
                        <span><?php echo $data['categoria']['categoria']; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="row" id="content-productos">
                    <?php foreach ($data['productos'] as $producto) { ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 mix cat_<?php echo $producto['id_categoria']; ?> fresh-meat">
                            <div class="featured__item">
                                <div class="featured__item__pic set-bg" data-setbg="<?php echo BASE_URL . 'public/img/productos/' . $producto['imagen']; ?>">
                                    <ul class="featured__item__pic__hover">
                                        <li><a href="https://api.whatsapp.com/send?phone=<?php echo $data['negocio']['whatsapp'] . '&text=Productos= ' . $producto['nombre'] . ' Precio(' . $producto['precio'] . ')' ; ?>"  target="_blank"><i class="fa fa-whatsapp"></i></a></li>
                                        <!-- <li><a href="#"><i class="fa fa-retweet"></i></a></li> -->
                                        <li><a href="#" stock="<?php echo $producto['cantidad']; ?>" class="producto-agregar" id="<?php echo $producto['id']; ?>"><i class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                                <div class="featured__item__text">
                                    <h6><a href="#"><?php echo $producto['nombre']; ?></a></h6>
                                    <h5>$<?php echo $producto['precio']; ?></h5>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Section End -->

<?php include "Views/template/footer.php"; ?>

<script src="<?php echo BASE_URL; ?>public/js/cart.js"></script>

</body>

</html>