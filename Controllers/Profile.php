<?php
class profile extends Controller
{
    private $id_usuario;
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    public function index(){
        if (empty($_SESSION['id_usuario'])) {
            header('Location: ' . BASE_URL);
            exit;
        }
        $data['title'] = 'Tu carrito';
        $data['categorias'] = $this->model->getCategorias();
        $data['negocio'] = $this->model->getNegocio();
        $this->views->getView('principal', "profile", $data);
    }

    public function validar()
    {
        if (isset($_POST['email']) && isset($_POST['clave'])) {
            if (empty($_POST['email']) || empty($_POST['clave'])) {
                $respuesta = array('msg' => 'todo los campos son requeridos', 'icono' => 'warning');
            } else {
                $data = $this->model->getUsuario($_POST['email']);
                if (empty($data)) {
                    $respuesta = array('msg' => 'el usuario no existe', 'icono' => 'warning');
                } else {
                    if ($data['tipo'] == 2) {
                        if (password_verify($_POST['clave'], $data['clave'])) {
                            $_SESSION['id_usuario'] = $data['id'];
                            $_SESSION['email'] = $data['correo'];
                            $_SESSION['nombre_usuario'] = $data['nombre'];
                            $_SESSION['tipo'] = $data['tipo'];
                            $respuesta = array('msg' => 'datos correcto', 'icono' => 'success');
                        } else {
                            $respuesta = array('msg' => 'contraseña incorrecta', 'icono' => 'warning');
                        }
                    }else{
                        $respuesta = array('msg' => 'No tienes una cuenta', 'icono' => 'warning'); 
                    }
                    
                }
            }
        } else {
            $respuesta = array('msg' => 'error desconocido', 'icono' => 'error');
        }
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function listarPedidos()
    {
        if (empty($_SESSION['id_usuario'])) {
            header('Location: ' . BASE_URL);
            exit;
        }
        $this->id_usuario = $_SESSION['id_usuario'];
        $data = $this->model->getPedidos($this->id_usuario);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['productos'] = '';
            $productos = $this->model->getDetalle($data[$i]['id']);
            for ($j=0; $j < count($productos); $j++) { 
                $data[$i]['productos'] .= '<li class="list-group-item">'.$productos[$j]['cantidad'] . " x " . $productos[$j]['producto'] . " ------ " . $productos[$j]['precio'].'</li>';
            }
            if ($data[$i]['proceso'] == 1) {
                $data[$i]['estado'] =  '<span class="badge bg-warning">PENDIENTE</span>';
            } else {
                $data[$i]['estado'] =  '<span class="badge bg-success">COMPLETADO</span>';
            }
        }
        echo json_encode($data);
        die();
    }

    public function verPedido($idPedido)
    {
        if (empty($_SESSION['id_usuario'])) {
            header('Location: ' . BASE_URL);
            exit;
        }
        if (is_numeric($idPedido)) {
            $data = $this->model->getPedido($idPedido);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function salir()
    {
        session_destroy();
        header('Location: ' . BASE_URL);
    }
}