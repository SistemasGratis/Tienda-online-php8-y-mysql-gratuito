<?php
class UsuariosModel extends Query{
 
    public function __construct()
    {
        parent::__construct();
    }
    public function getUsuarios($tipo, $estado)
    {
        $sql = "SELECT id, correo, nombre, apellido, direccion FROM usuarios WHERE tipo = $tipo AND estado = $estado";
        return $this->selectAll($sql);
    }
    public function registrar($correo, $nombre, $apellido, $hash, $direccion, $tipo)
    {
        $sql = "INSERT INTO usuarios (correo, nombre, apellido, clave, direccion, tipo) VALUES (?,?,?,?,?,?)";
        $array = array($correo, $nombre, $apellido, $hash, $direccion, $tipo);
        return $this->insertar($sql, $array);
    }
    public function verificarCampo($item, $valor, $id)
    {
        if ($id == 0) {
            $sql = "SELECT id FROM usuarios WHERE $item = '$valor' AND $item != null AND estado = 1";
        } else {
            $sql = "SELECT id FROM usuarios WHERE $item = '$valor' AND id != $id AND $item != null AND estado = 1";
        }
        
        return $this->select($sql);
    }

    public function eliminar($idUser)
    {
        $sql = "UPDATE usuarios SET estado = ? WHERE id = ?";
        $array = array(0, $idUser);
        return $this->save($sql, $array);
    }

    public function getUsuario($idUser)
    {
        $sql = "SELECT id, correo, nombre, apellido, direccion, clave FROM usuarios WHERE id = $idUser";
        return $this->select($sql);
    }

    public function modificar($correo, $nombre, $apellido, $direccion, $id)
    {
        $sql = "UPDATE usuarios SET correo=?, nombre=?, apellido=?, direccion=? WHERE id = ?";
        $array = array($correo, $nombre, $apellido, $direccion, $id);
        return $this->save($sql, $array);
    }

    public function modificarClave($clave, $id)
    {
        $sql = "UPDATE usuarios SET clave=? WHERE id = ?";
        $array = array($clave, $id);
        return $this->save($sql, $array);
    }
}
 
?>