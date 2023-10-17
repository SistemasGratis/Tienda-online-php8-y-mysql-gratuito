<?php
class Registro extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    public function save()
    {
        if (isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['clave'])) {
            if (empty($_POST['email']) || empty($_POST['email']) || empty($_POST['clave'])) {
                $respuesta = array('msg' => 'todo los campos son requeridos', 'icono' => 'warning');
            } else {
                $email = strClean($_POST['email']);
                $nombre = strClean($_POST['nombre']);
                $tipo = 2;
                $clave = password_hash(strClean($_POST['clave']), PASSWORD_DEFAULT);
                $consulta = $this->model->getUsuario($email);
                if (empty($consulta)) {
                    $data = $this->model->registrar($email, $nombre, $clave, $tipo);
                    if ($data > 0) {
                        $_SESSION['id_usuario'] = $data;
                        $_SESSION['email'] = $email;
                        $_SESSION['nombre_usuario'] = $nombre;
                        $respuesta = array('msg' => 'Usuario registrado', 'icono' => 'success');
                    } else {
                        $respuesta = array('msg' => 'Error al registrarse', 'icono' => 'error');
                    }
                } else {
                    $respuesta = array('msg' => 'El correo ya existe', 'icono' => 'warning');
                }
            }
        } else {
            $respuesta = array('msg' => 'error desconocido', 'icono' => 'error');
        }
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        die();
    }
    //registrar pedidos
    public function registrarPedido()
    {
        if (!empty($_SESSION['address'])) {
            $datos = file_get_contents('php://input');
            $json = json_decode($datos, true);
            $productos = $json['productos'];
            $pedidos = $json['pedidos'];
            if (is_array($productos)) {
                $transaccion = $pedidos['id'];
                $monto = $pedidos['purchase_units'][0]['amount']['value'];
                $cliente = $_SESSION['address'];
                $envio = 0;
                $data = $this->model->registrarPedido(
                    $transaccion,
                    $monto,
                    $cliente['nombre'],
                    $cliente['apellido'],
                    $cliente['direccion'],
                    $cliente['ciudad'],
                    $cliente['cod'],
                    $cliente['pais'],
                    $cliente['telefono'],
                    $envio,
                    $_SESSION['id_usuario'],
                );
                if ($data > 0) {
                    foreach ($productos as $producto) {
                        $temp = $this->model->getProducto($producto['id']);
                        $this->model->registrarDetalle($temp['nombre'], $temp['precio'], $producto['cantidad'], $producto['id'], $data);
                        //actualizar stock
                        $nuevaCantidad = $temp['cantidad'] - $producto['cantidad'];
                        $nuevaVenta = $temp['ventas'] + $producto['cantidad'];
                        $this->model->actualizarStock($nuevaCantidad, $nuevaVenta, $temp['id']);
                    }
                    $mensaje = array('msg' => 'Pedido registrado', 'icono' => 'success');
                    unset($_SESSION['address']);
                } else {
                    $mensaje = array('msg' => 'Error al registrar el pedido', 'icono' => 'error');
                }
            } else {
                $mensaje = array('msg' => 'Error fatal con los datos', 'icono' => 'error');
            }
        } else {
            $mensaje = array('msg' => 'Datos de envio no encontrado', 'icono' => 'error');
        }
        echo json_encode($mensaje);
        die();
    }
}
