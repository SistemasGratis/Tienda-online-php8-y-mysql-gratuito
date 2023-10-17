<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Ecommerce</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>public/img/logo.png">

    <!-- morris css -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/admin/plugins/morris/morris.css">

    <link href="<?php echo BASE_URL; ?>public/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo BASE_URL; ?>public/admin/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?php echo BASE_URL . 'public/admin/DataTables/datatables.min.css'; ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo BASE_URL; ?>public/admin/css/jquery-ui.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo BASE_URL; ?>public/admin/css/style.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>public/css/toastify.min.css" />

</head>


<body class="fixed-left">

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner">
                <div class="rect1"></div>
                <div class="rect2"></div>
                <div class="rect3"></div>
                <div class="rect4"></div>
                <div class="rect5"></div>
            </div>
        </div>
    </div>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- ========== Left Sidebar Start ========== -->
        <div class="left side-menu">
            <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
                <i class="mdi mdi-close"></i>
            </button>

            <div class="left-side-logo d-block d-lg-none">
                <div class="text-center">
                    <a href="index.html" class="logo"><img src="<?php echo BASE_URL; ?>public/img/logo.png" height="20" alt="logo"></a>
                </div>
            </div>

            <div class="sidebar-inner slimscrollleft">

                <div id="sidebar-menu">
                    <ul>
                        <li class="menu-title">Main</li>

                        <li>
                            <a href="<?php echo BASE_URL . 'admin/home'; ?>" class="waves-effect">
                                <i class="fas fa-chart-pie mr-3"></i>
                                <span> Dashboard</span>
                            </a>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fas fa-tags mr-3"></i> <span> Productos </span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="<?php echo BASE_URL . 'categorias'; ?>">Categorias</a></li>
                                <li><a href="<?php echo BASE_URL . 'productos'; ?>">Productos</a></li>
                            </ul>
                        </li>

                        <li class="">
                            <a href="<?php echo BASE_URL . 'negocio'; ?>" class="waves-effect"><i class="fas fa-home mr-3"></i> <span> Negocio </span> </a>
                        </li>

                        <li class="">
                            <a href="<?php echo BASE_URL . 'usuarios'; ?>" class="waves-effect"><i class="fas fa-user mr-3"></i> <span> Usuarios </span> </a>
                        </li>

                        <li class="">
                            <a href="<?php echo BASE_URL . 'clientes'; ?>" class="waves-effect"><i class="fas fa-users mr-3"></i> <span> Clientes </span> </a>
                        </li>

                        <li class="">
                            <a href="<?php echo BASE_URL . 'pedidos'; ?>" class="waves-effect"><i class="fas fa-list-alt mr-3"></i> <span> Pedidos </span> </a>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fas fa-shopping-cart mr-3"></i> <span> Ventas </span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="<?php echo BASE_URL . 'ventas'; ?>">Nueva</a></li>
                                <li><a href="<?php echo BASE_URL . 'ventas/historial'; ?>">Historial</a></li>
                            </ul>
                        </li>

                    </ul>
                </div>
                <div class="clearfix"></div>
            </div> <!-- end sidebarinner -->
        </div>
        <!-- Left Sidebar End -->

        <!-- Start right Content here -->

        <div class="content-page">
            <!-- Start content -->
            <div class="content">

                <!-- Top Bar Start -->
                <div class="topbar">

                    <div class="topbar-left	d-none d-lg-block">
                        <div class="text-center">
                            <a href="<?php echo BASE_URL; ?>" class="logo"><img src="<?php echo BASE_URL; ?>public/img/logo.png" height="22" alt="logo"></a>
                        </div>
                    </div>

                    <nav class="navbar-custom">

                        <ul class="list-inline float-right mb-0">

                            <li class="list-inline-item dropdown notification-list nav-user">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <img src="<?php echo BASE_URL; ?>public/admin/images/users/avatar-6.jpg" alt="user" class="rounded-circle">
                                    <span class="d-none d-md-inline-block ml-1"><?php echo $_SESSION['nombre_usuario']; ?><i class="mdi mdi-chevron-down"></i> </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                                    <a class="dropdown-item" href="<?php echo BASE_URL . 'usuarios/perfil'; ?>"><i class="fas fa-user"></i> Perfil</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo BASE_URL . 'admin/salir'; ?>"><i class="fas fa-power-off"></i> Logout</a>
                                </div>
                            </li>

                        </ul>

                        <ul class="list-inline menu-left mb-0">
                            <li class="list-inline-item">
                                <button type="button" class="button-menu-mobile open-left waves-effect">
                                    <i class="mdi mdi-menu"></i>
                                </button>
                            </li>
                        </ul>


                    </nav>

                </div>
                <!-- Top Bar End -->

                <div class="page-content-wrapper ">

                    <div class="container-fluid">