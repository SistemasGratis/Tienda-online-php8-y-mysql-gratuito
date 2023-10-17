<?php
class Negocio extends Controller
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
        $data['title'] = 'Datos del negocio';
        $data['negocio'] = $this->model->getDato();
        $this->views->getView('admin/administracion', 'negocio', $data);
    }
    public function modificar()
    {
        if (isset($_POST['nombre']) && isset($_POST['telefono'])) {
            $id = strClean($_POST['id']);
            $nombre = strClean($_POST['nombre']);
            $telefono = strClean($_POST['telefono']);
            $correo = strClean($_POST['correo']);
            $whatsapp = strClean($_POST['whatsapp']);
            $direccion = strClean($_POST['direccion']);
            $host_smtp = strClean($_POST['host_smtp']);
            $user_smtp = strClean($_POST['user_smtp']);
            $puerto_smtp = strClean($_POST['puerto_smtp']);
            $pass_smtp = strClean($_POST['pass_smtp']);
            if (empty($nombre) || empty($telefono) || empty($whatsapp) || empty($direccion) || empty($host_smtp) || empty($user_smtp) || empty($puerto_smtp) || empty($pass_smtp)) {
                $res = array('msg' => 'TODO LOS CAMPOS SON REQUERIDOS', 'type' => 'warning');
            } else {
                $data = $this->model->actualizar(
                    $nombre,
                    $telefono,
                    $correo,
                    $whatsapp,
                    $direccion,
                    $host_smtp,
                    $user_smtp,
                    $puerto_smtp,
                    $pass_smtp,
                    $id
                );
                if ($data > 0) {
                    $res = array('msg' => 'DATO MODIFICADO', 'type' => 'success');
                } else {
                    $res = array('msg' => 'ERROR AL MODIFICAR', 'type' => 'error');
                }
            }
        } else {
            $res = array('msg' => 'ERROR DESCONOCIDO', 'type' => 'error');
        }
        echo json_encode($res);
        die();
    }
}
