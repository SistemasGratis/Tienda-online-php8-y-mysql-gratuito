<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte</title>
    <link rel="stylesheet" href="<?php echo BASE_URL . 'public/admin/css/ticket.css'; ?>">
</head>

<body>
    <img src="<?php echo BASE_URL . 'public/img/logo.png'; ?>" alt="">
    <div class="datos-empresa">
        <p><?php echo $data['empresa']['nombre']; ?></p>
        <p><?php echo $data['empresa']['telefono']; ?></p>
        <p><?php echo $data['empresa']['direccion']; ?></p>
    </div>
    <h5 class="title">Datos del Cliente</h5>
    <div class="datos-info">
        <p><strong>Cliente: </strong> <?php echo $data['venta']['nombre']; ?></p>
        <p><strong>Fecha: </strong> <?php echo $data['venta']['fecha']; ?></p>
    </div>
    <h5 class="title">Detalle de los Productos</h5>
    <table>
        <thead>
            <tr>
                <th>Cant</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>SubTotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data['detalle'] as $producto) { ?>
                <tr>
                    <td><?php echo $producto['cantidad']; ?></td>
                    <td><?php echo $producto['producto']; ?></td>
                    <td><?php echo number_format($producto['precio'], 2); ?></td>
                    <td><?php echo number_format($producto['cantidad'] * $producto['precio'], 2); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td class="text-right" colspan="3">Pago con</td>
                <td class="text-right"><?php echo number_format($data['venta']['pago'], 2); ?></td>
            </tr>
            <tr>
                <td class="text-right" colspan="3">Cambio</td>
                <td class="text-right"><?php echo number_format($data['venta']['pago'] - $data['venta']['total'], 2); ?></td>
            </tr>
            <tr>
                <td class="text-right" colspan="3">Total</td>
                <td class="text-right"><?php echo number_format($data['venta']['total'], 2); ?></td>
            </tr>
        </tbody>
    </table>
</body>

</html>