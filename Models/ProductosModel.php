<?php
class ProductosModel extends Query{
 
    public function __construct()
    {
        parent::__construct();
    }
    public function getProductos($estado)
    {
        $sql = "SELECT p.*, c.categoria FROM productos p INNER JOIN categorias c ON p.id_categoria = c.id WHERE p.estado = $estado";
        return $this->selectAll($sql);
    }
    
    public function getDatos($table)
    {
        $sql = "SELECT * FROM $table WHERE estado = 1";
        return $this->selectAll($sql);
    }

    public function registrar($nombre, $descripcion, $precio, $cantidad, $imagen, $categoria)
    {
        $sql = "INSERT INTO productos (nombre, descripcion, precio, cantidad, imagen, id_categoria) VALUES (?,?,?,?,?,?)";
        $array = array($nombre, $descripcion, $precio, $cantidad, $imagen, $categoria);
        return $this->insertar($sql, $array);
    }

    public function eliminar($idPro)
    {
        $sql = "UPDATE productos SET estado = ? WHERE id = ?";
        $array = array(0, $idPro);
        return $this->save($sql, $array);
    }

    public function getProducto($idPro)
    {
        $sql = "SELECT * FROM productos WHERE id = $idPro";
        return $this->select($sql);
    }

    public function modificar($nombre, $descripcion, $precio, $cantidad, $destino, $categoria, $id)
    {
        $sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, cantidad=?, imagen=?, id_categoria=? WHERE id = ?";
        $array = array($nombre, $descripcion, $precio, $cantidad, $destino, $categoria, $id);
        return $this->save($sql, $array);
    }

}
 
?>