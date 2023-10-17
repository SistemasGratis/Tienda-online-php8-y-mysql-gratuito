<?php
class ProfileModel extends Query{
 
    public function __construct()
    {
        parent::__construct();
    }

    public function getUsuario($correo)
    {
        $sql = "SELECT * FROM usuarios WHERE correo = '$correo' AND estado = 1";
        return $this->select($sql);
    }
    public function getCategorias()
    {
        $sql = "SELECT * FROM categorias WHERE estado = 1";
        return $this->selectAll($sql);
    }
    public function getNegocio()
    {
        return $this->select("SELECT * FROM configuracion");
    }
    public function getPedidos($id_usuario)
    {
        $sql = "SELECT * FROM ventas WHERE id_usuario = $id_usuario";
        return $this->selectAll($sql);
    }
    public function getDetalle($id_venta)
    {
        $sql = "SELECT * FROM detalle_ventas WHERE id_venta = $id_venta";
        return $this->selectAll($sql);
    }

    public function getPedido($id)
    {
        $sql = "SELECT * FROM ventas WHERE id = $id";
        return $this->select($sql);
    }
    
}
 
?>