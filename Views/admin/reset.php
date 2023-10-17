<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Login</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>public/admin/images/favicon.ico">

    <link href="<?php echo BASE_URL; ?>public/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo BASE_URL; ?>public/admin/css/icons.css" rel="stylesheet" type="text/css">
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

    <div class="account-pages">

        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 offset-lg-1 mx-auto">
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="p-2">
                                <h4 class="text-muted float-right font-18 mt-4">Sign In</h4>
                                <div>
                                    <a href="<?php echo BASE_URL; ?>" class="logo logo-admin"><img src="<?php echo BASE_URL; ?>public/img/logo.png" height="50" alt="logo"></a>
                                </div>
                            </div>

                            <div class="p-2">
                                <form class="form-horizontal m-t-20" id="formulario" autocomplete="off">
                                    <input type="hidden" id="token" name="token" value="<?php echo $data['seguridad']['token']; ?>">
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <input class="form-control" id="nueva" name="nueva" type="password" required="" placeholder="Nueva clave">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-12">
                                            <input class="form-control" id="confirmar" name="confirmar" type="password" required="" placeholder="Confirmar clave">
                                        </div>
                                    </div>


                                    <div class="form-group text-center row m-t-20">
                                        <div class="col-12">
                                            <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Restablecer</button>
                                        </div>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
    </div>



    <!-- jQuery  -->
    <script src="<?php echo BASE_URL; ?>public/admin/js/jquery.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/admin/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/admin/js/modernizr.min.js"></script>
    <script src="<?php echo BASE_URL; ?>public/admin/js/jquery.slimscroll.js"></script>
    <script src="<?php echo BASE_URL; ?>public/admin/js/jquery.nicescroll.js"></script>
    <script src="<?php echo BASE_URL; ?>public/admin/js/jquery.scrollTo.min.js"></script>

    <!-- App js -->
    <script>
        const base_url = '<?php echo BASE_URL; ?>';
    </script>
    <!--app JS-->
    <script src="<?php echo BASE_URL; ?>public/admin/js/app.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>public/js/toastify-js.js"></script>
    <script src="<?php echo BASE_URL; ?>public/admin/js/page/reset.js"></script>

</body>

</html>