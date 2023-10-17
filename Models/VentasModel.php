<?php
class VentasModel extends Query{
 
    public function __construct()
    {
        parent::__construct();
    }
    public function getVentas($tipo)
    {
        $sql = "SELECT * FROM ventas WHERE tipo = $tipo";
        return $this->selectAll($sql);
    }
    public function getDetalle($id_venta)
    {
        $sql = "SELECT * FROM detalle_ventas WHERE id_venta = $id_venta";
        return $this->selectAll($sql);
    }

    public function buscarProducto($valor)
    {
        $sql = "SELECT id, nombre, cantidad, precio FROM productos WHERE nombre LIKE '%".$valor."%' AND estado = 1 LIMIT 10";
        return $this->selectAll($sql);
    }
    public function getProducto($id_producto)
    {
        $sql = "SELECT * FROM productos WHERE id = $id_producto";
        return $this->select($sql);
    }

    public function getCliente($id_cliente)
    {
        $sql = "SELECT * FROM usuarios WHERE id = $id_cliente";
        return $this->select($sql);
    }

    public function buscarCliente($valor)
    {
        $sql = "SELECT * FROM usuarios WHERE nombre LIKE '%".$valor."%' AND tipo = 2 AND estado = 1 LIMIT 10";
        return $this->selectAll($sql);
    }

    public function registrarVenta($total, $fecha, $cliente, $pago, $idusuario)
    {
        $sql = "INSERT INTO ventas (total, fecha, nombre, pago, tipo, id_usuario) VALUES (?,?,?,?,?,?)";
        return $this->insertar($sql, [$total, $fecha, $cliente, $pago, 2, $idusuario]);
    }

    public function registraDetalle($cantidad, $precio, $producto, $id_producto, $id_venta)
    {
        $sql = "INSERT INTO detalle_ventas (cantidad, precio, producto, id_producto, id_venta) VALUES (?,?,?,?,?)";
        return $this->insertar($sql, [$cantidad, $precio, $producto, $id_producto, $id_venta]);
    }

    public function actualizarStock($cantidad, $ventas, $idProducto)
    {
        $sql = "UPDATE productos SET cantidad = ?, ventas=? WHERE id = ?";
        return $this->save($sql, [$cantidad, $ventas, $idProducto]);
    }

    public function anular($idVenta)
    {
        $sql = "UPDATE ventas SET estado = ? WHERE id = ?";
        return $this->save($sql, [0, $idVenta]);
    }

    public function getVenta($id)
    {
        $sql = "SELECT * FROM ventas WHERE id = $id";
        return $this->select($sql);
    }

    public function getNegocio()
    {
        $sql = "SELECT * FROM configuracion";
        return $this->select($sql);
    }

    public function getDetalleVenta($id)
    {
        $sql = "SELECT * FROM detalle_ventas WHERE id_venta = $id";
        return $this->selectAll($sql);
    }
    
}
 
?>