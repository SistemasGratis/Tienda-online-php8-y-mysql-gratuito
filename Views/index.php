<?php include "Views/template/header.php"; ?>

<!-- Categories Section Begin -->
<section class="categories">
    <div class="container">
        <div class="row">
            <div class="categories__slider owl-carousel">
                <?php foreach ($data['categorias'] as $categoria) { ?>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="<?php echo BASE_URL . 'public/img/categorias/' . $categoria['imagen']; ?>">
                            <h5><a href="#"><?php echo $categoria['categoria']; ?></a></h5>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<!-- Categories Section End -->

<!-- Featured Section Begin -->
<section class="featured spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Nuevos productos</h2>
                </div>
                <div class="featured__controls">
                    <ul>
                        <li class="active" data-filter="*">Todas</li>
                        <?php foreach ($data['categorias'] as $categoria) { ?>
                            <li data-filter=".cat_<?php echo $categoria['id']; ?>"><?php echo $categoria['categoria']; ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row featured__filter">
            <?php foreach ($data['destacados'] as $producto) { ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mix cat_<?php echo $producto['id_categoria']; ?> fresh-meat">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="<?php echo BASE_URL . 'public/img/productos/' . $producto['imagen']; ?>">
                            <ul class="featured__item__pic__hover">
                                <li><a href="https://api.whatsapp.com/send?phone=<?php echo $data['negocio']['whatsapp'] . '&text=Productos= ' . $producto['nombre'] . ' Precio(' . $producto['precio'] . ')'; ?>" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
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
</section>
<!-- Featured Section End -->

<!-- Banner Begin -->
<div class="banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="<?php echo BASE_URL; ?>public/img/banner/banner-1.jpg" alt="">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="<?php echo BASE_URL; ?>public/img/banner/banner-2.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner End -->

<!-- Latest Product Section Begin -->
<section class="latest-product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Últimos productos</h4>
                    <div class="latest-product__slider owl-carousel">
                        <?php
                        $productos = $data['destacados']; // Aquí deberías tener tus productos desde la consulta SQL
                        shuffle($productos); // Reordena los productos aleatoriamente
                        $count = 0;
                        foreach ($productos as $producto) {
                            if ($count % 3 === 0) {
                                echo '<div class="latest-prdouct__slider__item">';
                            }
                            echo '<a href="#" class="latest-product__item">';
                            echo '<div class="latest-product__item__pic">';
                            echo '<img src="' . BASE_URL . 'public/img/productos/' . $producto['imagen'] . '" alt="">';
                            echo '</div>';
                            echo '<div class="latest-product__item__text">';
                            echo '<h6>' . $producto['nombre'] . '</h6>';
                            echo '<span>$' . $producto['precio'] . '</span>';
                            echo '</div>';
                            echo '</a>';
                            if ($count % 3 === 2) {
                                echo '</div>';
                            }
                            $count++;
                        }
                        if ($count % 3 !== 0) {
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Productos agotados</h4>
                    <div class="latest-product__slider owl-carousel">
                        <?php
                        $productos = $data['agotados']; // Aquí deberías tener tus productos desde la consulta SQL
                        shuffle($productos); // Reordena los productos aleatoriamente
                        $count = 0;
                        foreach ($productos as $producto) {
                            if ($count % 3 === 0) {
                                echo '<div class="latest-prdouct__slider__item">';
                            }
                            echo '<a href="#" class="latest-product__item">';
                            echo '<div class="latest-product__item__pic">';
                            echo '<img src="' . BASE_URL . 'public/img/productos/' . $producto['imagen'] . '" alt="">';
                            echo '</div>';
                            echo '<div class="latest-product__item__text">';
                            echo '<h6>' . $producto['nombre'] . '</h6>';
                            echo '<span>$' . $producto['precio'] . '</span>';
                            echo '</div>';
                            echo '</a>';
                            if ($count % 3 === 2) {
                                echo '</div>';
                            }
                            $count++;
                        }
                        if ($count % 3 !== 0) {
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Top productos</h4>
                    <div class="latest-product__slider owl-carousel">
                        <?php
                        $productos = $data['tops']; // Aquí deberías tener tus productos desde la consulta SQL
                        shuffle($productos); // Reordena los productos aleatoriamente
                        $count = 0;
                        foreach ($productos as $producto) {
                            if ($count % 3 === 0) {
                                echo '<div class="latest-prdouct__slider__item">';
                            }
                            echo '<a href="#" class="latest-product__item">';
                            echo '<div class="latest-product__item__pic">';
                            echo '<img src="' . BASE_URL . 'public/img/productos/' . $producto['imagen'] . '" alt="">';
                            echo '</div>';
                            echo '<div class="latest-product__item__text">';
                            echo '<h6>' . $producto['nombre'] . '</h6>';
                            echo '<span>$' . $producto['precio'] . '</span>';
                            echo '</div>';
                            echo '</a>';
                            if ($count % 3 === 2) {
                                echo '</div>';
                            }
                            $count++;
                        }
                        if ($count % 3 !== 0) {
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Latest Product Section End -->

<?php include "Views/template/footer.php"; ?>

<script src="<?php echo BASE_URL; ?>public/js/cart.js"></script>

</body>

</html>