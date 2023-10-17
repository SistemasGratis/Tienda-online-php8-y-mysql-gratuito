<?php
class Usuarios extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['tipo']) || $_SESSION['tipo'] == 2) {
            header('Location: '. BASE_URL . 'admin');
            exit;
        }
    }
    public function index()
    {
        $data['title'] = 'usuarios';
        $this->views->getView('admin/usuarios', "index", $data);
    }
    public function listar()
    {
        $data = $this->model->getUsuarios(1, 1);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['item'] = $i + 1;
            $data[$i]['accion'] = '<div class="d-flex">
            <button class="btn btn-primary" type="button" onclick="editUser(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger" type="button" onclick="eliminarUser(' . $data[$i]['id'] . ')"><i class="fas fa-trash"></i></button>
        </div>';
        }
        echo json_encode($data);
        die();
    }
    public function registrar()
    {
        if (isset($_POST['nombre']) && isset($_POST['correo']) && isset($_POST['clave'])) {
            $nombre = strClean($_POST['nombre']);
            $apellido = strClean($_POST['apellido']);
            $clave = (empty($_POST['id'])) ? strClean($_POST['clave']) : '0000000';
            $correo = strClean($_POST['correo']);
            $direccion = strClean($_POST['direccion']);
            $tipo = 1;
            $id = strClean($_POST['id']);
            $hash = password_hash($clave, PASSWORD_DEFAULT);
            if (
                empty($nombre) || empty($apellido) || empty($correo)
                || empty($clave) || empty($direccion)
            ) {
                $respuesta = array('msg' => 'todo los campos son requeridos', 'icono' => 'warning');
            } else {
                if (empty($id)) {
                    $result = $this->model->verificarCampo('correo', $correo, 0);
                    if (empty($result)) {
                        $data = $this->model->registrar($correo, $nombre, $apellido, $hash, $direccion, $tipo);
                        if ($data > 0) {
                            $respuesta = array('msg' => 'usuario registrado', 'icono' => 'success');
                        } else {
                            $respuesta = array('msg' => 'error al registrar', 'icono' => 'error');
                        }
                    } else {
                        $respuesta = array('msg' => 'correo ya existe', 'icono' => 'warning');
                    }
                } else {
                    $result = $this->model->verificarCampo('correo', $correo, $id);
                    if (empty($result)) {
                        $data = $this->model->modificar($correo, $nombre, $apellido, $direccion, $id);
                        if ($data == 1) {
                            $respuesta = array('msg' => 'usuario modificado', 'icono' => 'success');
                        } else {
                            $respuesta = array('msg' => 'error al modificar', 'icono' => 'error');
                        }
                    } else {
                        $respuesta = array('msg' => 'correo ya existe', 'icono' => 'warning');
                    }
                }
            }
            echo json_encode($respuesta);
        }
        die();
    }
    //eliminar user
    public function delete($idUser)
    {
        if (is_numeric($idUser)) {
            $data = $this->model->eliminar($idUser);
            if ($data == 1) {
                $respuesta = array('msg' => 'usuario dado de baja', 'icono' => 'success');
            } else {
                $respuesta = array('msg' => 'error al eliminar', 'icono' => 'error');
            }
        } else {
            $respuesta = array('msg' => 'error desconocido', 'icono' => 'error');
        }
        echo json_encode($respuesta);
        die();
    }
    //editar user
    public function editar($idUser)
    {
        if (is_numeric($idUser)) {
            $data = $this->model->getUsuario($idUser);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function perfil()
    {
        $data['title'] = 'Tus datos';
        $data['usuario'] = $this->model->getUsuario($_SESSION['id_usuario']);
        $this->views->getView('admin/usuarios', "perfil", $data);
    }
    public function actualizarPerfil()
    {
        if (isset($_POST['nombre']) && isset($_POST['correo']) && isset($_POST['apellido'])) {
            $nombre = strClean($_POST['nombre']);
            $apellido = strClean($_POST['apellido']);
            $correo = strClean($_POST['correo']);
            $direccion = strClean($_POST['direccion']);
            if (
                empty($nombre) || empty($apellido) || empty($correo)
                || empty($direccion)
            ) {
                $respuesta = array('msg' => 'todo los campos son requeridos', 'icono' => 'warning');
            } else {
                    $result = $this->model->verificarCampo('correo', $correo, $_SESSION['id_usuario']);
                    if (empty($result)) {
                        $data = $this->model->modificar($correo, $nombre, $apellido, $direccion, $_SESSION['id_usuario']);
                        if ($data == 1) {
                            $respuesta = array('msg' => 'datos modificado', 'icono' => 'success');
                        } else {
                            $respuesta = array('msg' => 'error al modificar', 'icono' => 'error');
                        }
                    } else {
                        $respuesta = array('msg' => 'correo ya existe', 'icono' => 'warning');
                    }
            }
            echo json_encode($respuesta);
        }
        die();
    }

    public function actualizarPassword()
    {
        if (isset($_POST['nueva']) && isset($_POST['actual']) && isset($_POST['confirmar'])) {
            $nueva = strClean($_POST['nueva']);
            $confirmar = strClean($_POST['confirmar']);
            $actual = strClean($_POST['actual']);
            if (
                empty($nueva) || empty($confirmar)
                || empty($actual)
            ) {
                $respuesta = array('msg' => 'Todo los campos son requeridos', 'icono' => 'warning');
            } else if ($nueva != $confirmar) {
                $respuesta = array('msg' => 'Las contraseñas no coinciden', 'icono' => 'warning');
            } else {
                $result = $this->model->getUsuario($_SESSION['id_usuario']);
                if (password_verify($actual, $result['clave'])) {
                    $hash = password_hash($nueva, PASSWORD_DEFAULT);
                    $data = $this->model->modificarClave($hash, $_SESSION['id_usuario']);
                    if ($data == 1) {
                        $respuesta = array('msg' => 'Contraseña modificada', 'icono' => 'success');
                    } else {
                        $respuesta = array('msg' => 'error al modificar', 'icono' => 'error');
                    }
                } else {
                    $respuesta = array('msg' => 'contraseña actual incorrecta', 'icono' => 'warning');
                }
            }
            echo json_encode($respuesta);
        }
        die();
    }
}
