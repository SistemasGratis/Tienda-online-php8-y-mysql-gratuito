<?php
class PrincipalModel extends Query{
 
    public function __construct()
    {
        parent::__construct();
    }
    public function getCategoria($nombre)
    {
        $sql = "SELECT * FROM categorias WHERE categoria = '$nombre' AND estado = 1";
        return $this->select($sql);
    }
    public function getCategorias()
    {
        $sql = "SELECT * FROM categorias WHERE estado = 1";
        return $this->selectAll($sql);
    }
    public function getProductosDestacados()
    {
        $sql = "SELECT p.id, p.nombre, p.precio, p.cantidad, p.imagen, p.id_categoria, c.categoria FROM productos p INNER JOIN categorias c ON p.id_categoria = c.id WHERE p.estado = 1 ORDER BY p.id DESC LIMIT 10";      
        return $this->selectAll($sql);
    }
    //paginacion
    public function getProductos($valor, $categoria, $desde, $porPagina)
    {
        if(is_numeric($categoria)){
            $sql = "SELECT p.id, p.nombre, p.precio, p.cantidad, p.imagen, p.id_categoria, c.categoria FROM productos p INNER JOIN categorias c ON p.id_categoria = c.id WHERE p.nombre LIKE '%".$valor."%' AND p.id_categoria = $categoria AND p.estado = 1 ORDER BY p.id DESC LIMIT $desde, $porPagina";
        }else{
            $sql = "SELECT p.id, p.nombre, p.precio, p.cantidad, p.imagen, p.id_categoria, c.categoria FROM productos p INNER JOIN categorias c ON p.id_categoria = c.id WHERE p.nombre LIKE '%".$valor."%' AND p.estado = 1 ORDER BY p.id DESC LIMIT $desde, $porPagina";
        }        
        return $this->selectAll($sql);
    }

    public function getTotalProductos($busqueda, $categoria)
    {
        if(!is_numeric($categoria)){
            if (empty($busqueda)) {
                $sql = "SELECT COUNT(*) AS total FROM productos WHERE estado = 1";
            } else {
                $sql = "SELECT COUNT(*) AS total FROM productos WHERE nombre LIKE '%".$busqueda."%' AND estado = 1";
            }          
        }else{
            if (empty($busqueda)) {
                $sql = "SELECT COUNT(*) AS total FROM productos WHERE id_categoria = $categoria AND estado = 1";
            } else {
                $sql = "SELECT COUNT(*) AS total FROM productos WHERE nombre LIKE '%".$busqueda."%' AND id_categoria = $categoria AND estado = 1";
            }
            
        }
        return $this->select($sql);
    }

    public function getFiltroProductos($busqueda, $categorias, $desde, $hasta)
    {
        if (empty($categorias)) {
            $sql = "SELECT * FROM productos WHERE nombre LIKE '%".$busqueda."%' AND precio >= $desde
            AND precio <= $hasta";
        }else{
            $sql = "SELECT * FROM productos WHERE nombre LIKE '%".$busqueda."%' AND id_categoria IN ($categorias)
        AND precio >= $desde
        AND precio <= $hasta";
        }
        
        return $this->selectAll($sql);
    }

    public function getProductosCategoria($valor, $categoria)
    {
        if(is_numeric($categoria)){
            $sql = "SELECT p.id, p.nombre, p.precio, p.cantidad, p.imagen, p.id_categoria, c.categoria FROM productos p INNER JOIN categorias c ON p.id_categoria = c.id WHERE p.nombre LIKE '%".$valor."%' AND p.id_categoria = $categoria AND p.estado = 1 ORDER BY p.id DESC";
        }else{
            $sql = "SELECT p.id, p.nombre, p.precio, p.cantidad, p.imagen, p.id_categoria, c.categoria FROM productos p INNER JOIN categorias c ON p.id_categoria = c.id WHERE p.nombre LIKE '%".$valor."%' AND p.estado = 1 ORDER BY p.id DESC";
        }  
        return $this->selectAll($sql);      
    }

    public function getProducto($id)
    {
        $sql = "SELECT * FROM productos WHERE id = $id";      
        return $this->select($sql);
    }

    public function topProductos()
    {
        $sql = "SELECT * FROM productos ORDER BY ventas DESC LIMIT 6";
        return $this->selectAll($sql);
    }

    public function agotadosProductos()
    {
        $sql = "SELECT * FROM productos WHERE cantidad = 0 ORDER BY RAND() DESC LIMIT 6";
        return $this->selectAll($sql);
    }

    public function getPrecio($tipo)
    {
        $sql = "SELECT $tipo AS total FROM productos WHERE estado = 1";
        return $this->select($sql);
    }
    
    public function getNegocio()
    {
        return $this->select("SELECT * FROM configuracion");
    }

    public function verificarCorreo($correo, $tipo)
    {
        return $this->select("SELECT * FROM usuarios WHERE correo = '$correo' AND estado = 1");
    }

    public function verificarToken($token)
    {
        return $this->select("SELECT * FROM usuarios WHERE token = '$token' AND estado = 1");
    }

    public function registrarToken($token, $correo){
        $sql = "UPDATE usuarios SET token=? WHERE correo=?";
        return $this->save($sql, [$token, $correo]);
    }

    public function modificarClave($clave, $token){
        $sql = "UPDATE usuarios SET clave=?, token=? WHERE token=?";
        return $this->save($sql, [$clave, null, $token]);
    }

}
 
?>