<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <title><?php echo TITLE . ' - Pagina no encontrada'; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/bootstrap.min.css">
</head>
 
<body class="d-flex h-100 text-center text-white bg-dark">
 
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
 
        <main class="px-3">
            <h1>Not Found.</h1>
            <p class="lead">La página que buscas no existe</p>
            <p class="lead">
                <a href="<?php echo BASE_URL; ?>" class="btn btn-lg btn-secondary fw-bold border-white bg-white text-dark"><?php echo TITLE; ?></a>
            </p>
        </main>
    </div>
 
</body>
 
</html>