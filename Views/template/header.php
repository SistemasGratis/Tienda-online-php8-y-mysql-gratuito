<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tienda online</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>public/css/toastify.min.css" />
    <link href="<?php echo BASE_URL . 'public/admin/DataTables/datatables.min.css'; ?>" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/login.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="#"><img src="<?php echo BASE_URL; ?>public/img/logo.png" alt="" width="50"></a>
        </div>
        <div class="humberger__menu__cart">
            <ul>
                <!-- <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li> -->
                <li><a href="<?php echo BASE_URL . 'principal/carrito'; ?>"><i class="fa fa-shopping-bag"></i> <span id="numerito">0</span></a></li>
            </ul>
            <!-- <div class="header__cart__price">item: <span>$150.00</span></div> -->
        </div>
        <div class="humberger__menu__widget">
            <div class="header__top__right__auth">
                <?php if (empty($_SESSION['id_usuario'])) { ?>
                    <a href="<?php echo BASE_URL . 'principal/login'; ?>"><i class="fa fa-user"></i> Login</a>
                <?php } else {  ?>
                    <a href="<?php echo BASE_URL . 'profile'; ?>"><i class="fa fa-user"></i> Tu cuenta</a>
                <?php } ?>
            </div>
        </div>
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <li class="active"><a href="<?php echo BASE_URL; ?>">Inicio</a></li>
                <li><a href="<?php echo BASE_URL . 'principal/productos'; ?>">Productos</a></li>
                <li><a href="<?php echo BASE_URL . 'principal/contactos'; ?>">Contactos</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="header__top__right__social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
            <a href="#"><i class="fa fa-pinterest-p"></i></a>
        </div>
        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-envelope"></i> <?php echo $data['negocio']['correo']; ?></li>
                <li>Tienda online</li>
            </ul>
        </div>
    </div>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <li><i class="fa fa-envelope"></i> <?php echo $data['negocio']['correo']; ?></li>
                                <li>Tienda online</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                                <a href="#"><i class="fa fa-pinterest-p"></i></a>
                            </div>
                            <div class="header__top__right__auth">
                                <?php if (empty($_SESSION['id_usuario'])) { ?>
                                    <a href="<?php echo BASE_URL . 'principal/login'; ?>"><i class="fa fa-user"></i> Login</a>
                                <?php } else {  ?>
                                    <a href="<?php echo BASE_URL . 'profile'; ?>"><i class="fa fa-user"></i> Tu cuenta</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="<?php echo BASE_URL; ?>"><img src="<?php echo BASE_URL; ?>public/img/logo.png" alt="LOGO" width="50"></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>
                            <li class="active"><a href="<?php echo BASE_URL; ?>">Inicio</a></li>
                            <li><a href="<?php echo BASE_URL . 'principal/productos'; ?>">Productos</a></li>
                            <li><a href="<?php echo BASE_URL . 'principal/contactos'; ?>">Contactos</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__cart">
                        <ul>
                            <!-- <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li> -->
                            <li><a href="<?php echo BASE_URL . 'principal/carrito'; ?>"><i class="fa fa-shopping-bag"></i> <span id="numerito1">0</span></a></li>
                        </ul>
                        <!-- <div class="header__cart__price">item: <span>$150.00</span></div> -->
                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->
    <!-- Hero Section Begin -->
    <section class="hero <?php echo ($data['title'] == 'Tu carrito') ? 'hero-normal' : ''; ?>">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>Todas las categorias</span>
                        </div>
                        <ul>
                            <?php foreach ($data['categorias'] as $categoria) { ?>
                                <li><a href="<?php echo BASE_URL . 'principal/categoria/' . $categoria['categoria']; ?>"><?php echo $categoria['categoria']; ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="hero__search">
                        <div class="hero__search__form">
                            <form action="<?php echo BASE_URL . 'principal/productos'; ?>" autocomplete="off">
                                <input type="text" name="search" placeholder="Que estas buscando?">
                                <button type="submit" class="site-btn">BUSCAR</button>
                            </form>
                        </div>
                        <div class="hero__search__phone">
                            <div class="hero__search__phone__icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="hero__search__phone__text">
                                <h5><?php echo $data['negocio']['telefono']; ?></h5>
                                <span><?php echo $data['negocio']['direccion']; ?></span>
                            </div>
                        </div>
                    </div>
                    <?php if ($data['title'] == 'Pagina Principal') { ?>
                        <div class="hero__item set-bg" data-setbg="<?php echo BASE_URL; ?>public/img/hero/banner.jpg">
                            <div class="hero__text">
                                <span>FRUTA FRESCA</span>
                                <h2>Vegetable <br />100% Organicos</h2>
                                <p>Recogida y entrega gratuitas disponibles</p>
                                <a href="<?php echo BASE_URL . 'principal/productos'; ?>" class="primary-btn">Ver productos</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->