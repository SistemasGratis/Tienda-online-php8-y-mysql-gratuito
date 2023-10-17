<?php
class AdminModel extends Query{
 
    public function __construct()
    {
        parent::__construct();
    }
    public function getUsuario($correo)
    {
        $sql = "SELECT * FROM usuarios WHERE correo = '$correo' AND estado = 1";
        return $this->select($sql);
    }

    public function getPedidos($proceso, $year)
    {
        $sql = "SELECT SUM(total) AS total FROM ventas WHERE YEAR(fecha) = $year AND proceso = $proceso AND tipo = 1";
        return $this->select($sql);
    }

    public function getPedidosGrafico($year)
    {
        $sql = "SELECT SUM(total) AS total FROM ventas WHERE YEAR(fecha) = $year AND tipo = 1";
        return $this->select($sql);
    }

    public function topProductos()
    {
        $sql = "SELECT nombre, ventas FROM productos ORDER BY ventas DESC LIMIT 5";
        return $this->selectAll($sql);
    }

    public function comprasMes($desde, $hasta)
    {
        $sql = "SELECT SUM(IF(MONTH(fecha) = 1, total, 0)) AS ene,
        SUM(IF(MONTH(fecha) = 2, total, 0)) AS feb,
        SUM(IF(MONTH(fecha) = 3, total, 0)) AS mar,
        SUM(IF(MONTH(fecha) = 4, total, 0)) AS abr,
        SUM(IF(MONTH(fecha) = 5, total, 0)) AS may,
        SUM(IF(MONTH(fecha) = 6, total, 0)) AS jun,
        SUM(IF(MONTH(fecha) = 7, total, 0)) AS jul,
        SUM(IF(MONTH(fecha) = 8, total, 0)) AS ago,
        SUM(IF(MONTH(fecha) = 9, total, 0)) AS sep,
        SUM(IF(MONTH(fecha) = 10, total, 0)) AS oct,
        SUM(IF(MONTH(fecha) = 11, total, 0)) AS nov,
        SUM(IF(MONTH(fecha) = 12, total, 0)) AS dic 
        FROM ventas WHERE fecha BETWEEN '$desde' AND '$hasta' AND tipo = 1 AND estado = 1";
        return $this->select($sql);
    }

    public function ventasMes($desde, $hasta)
    {
        $sql = "SELECT SUM(IF(MONTH(fecha) = 1, total, 0)) AS ene,
        SUM(IF(MONTH(fecha) = 2, total, 0)) AS feb,
        SUM(IF(MONTH(fecha) = 3, total, 0)) AS mar,
        SUM(IF(MONTH(fecha) = 4, total, 0)) AS abr,
        SUM(IF(MONTH(fecha) = 5, total, 0)) AS may,
        SUM(IF(MONTH(fecha) = 6, total, 0)) AS jun,
        SUM(IF(MONTH(fecha) = 7, total, 0)) AS jul,
        SUM(IF(MONTH(fecha) = 8, total, 0)) AS ago,
        SUM(IF(MONTH(fecha) = 9, total, 0)) AS sep,
        SUM(IF(MONTH(fecha) = 10, total, 0)) AS oct,
        SUM(IF(MONTH(fecha) = 11, total, 0)) AS nov,
        SUM(IF(MONTH(fecha) = 12, total, 0)) AS dic 
        FROM ventas WHERE fecha BETWEEN '$desde' AND '$hasta' AND tipo = 2 AND estado = 1";
        return $this->select($sql);
    }
    
}
 
?>