<?php
class Clientes extends Controller
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
    //registrar pedidos
    public function registrarPedido()
    {
        $datos = file_get_contents('php://input');
        $json = json_decode($datos, true);
        $pedidos = $json['pedidos'];
        $productos = $json['productos'];
        if (is_array($pedidos) && is_array($productos)) {
            $id_transaccion = $pedidos['id'];
            $monto = $pedidos['purchase_units'][0]['amount']['value'];
            $estado = $pedidos['status'];
            $fecha = date('Y-m-d H:i:s');
            $email = $pedidos['payer']['email_address'];
            $nombre = $pedidos['payer']['name']['given_name'];
            $apellido = $pedidos['payer']['name']['surname'];
            $direccion = $pedidos['purchase_units'][0]['shipping']['address']['address_line_1'];
            $ciudad = $pedidos['purchase_units'][0]['shipping']['address']['admin_area_2'];
            $id_cliente = $_SESSION['idCliente'];
            $data = $this->model->registrarPedido(
                $id_transaccion,
                'PAYPAL',
                $monto,
                $estado,
                $fecha,
                $email,
                $nombre,
                $apellido,
                $direccion,
                $ciudad,
                $id_cliente
            );
            if ($data > 0) {
                foreach ($productos as $producto) {
                    $temp = $this->model->getProducto($producto['idProducto']);
                    if ($producto['size'] > 0 && $producto['color'] > 0) {
                        $result = $this->model->getAtributos($producto['size'], $producto['color'], $producto['idProducto']);
                        $datos = array(
                            'id_size' => $producto['size'],
                            'id_color' => $producto['color'],
                            'size' => $result['size'],
                            'color' => $result['nombre'],
                            'hexa' => $result['color'],
                        );
                        $precio = $result['precio'];
                        $atributos = json_encode($datos);
                    } else {
                        $atributos = null;
                        $precio = $temp['precio'];
                    }
                    $this->model->registrarDetalle($temp['nombre'], $precio, $producto['cantidad'], $atributos, $data, $producto['idProducto']);
                    if ($producto['size'] > 0 && $producto['color'] > 0) {
                        $stock = $result['cantidad'] - $producto['cantidad'];
                        $this->model->actualizarStockDetalle($stock, $producto['size'], $producto['color'], $producto['idProducto']);

                        $total = 0;
                        if ($producto['idProducto'] == $temp['id']) {
                            $total += $producto['cantidad'];
                        }
                        $totalVentas = $temp['ventas'] + $total;
                        $totalStock = $temp['cantidad'] - $total;
                        $this->model->actualizarStockProducto($totalStock, $totalVentas, $temp['id']);
                    }
                }
                unset($_SESSION['productos']);
                $mensaje = array('msg' => 'pedido registrado', 'type' => 'success');
            } else {
                $mensaje = array('msg' => 'error al registrar el pedido', 'type' => 'error');
            }
        } else {
            $mensaje = array('msg' => 'error fatal con los datos', 'type' => 'error');
        }
        echo json_encode($mensaje);
        die();
    }

    ###### ADMIN CLIENTES #####
    public function index()
    {
        $data['title'] = 'Clientes';
        $this->views->getView('admin/clientes', 'index', $data);
    }
    public function listar()
    {
        $data = $this->model->getClientes(2, 1);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['item'] = $i + 1;
            $data[$i]['acciones'] = '<div>
            <button class="btn btn-danger" type="button" onclick="eliminarCliente(' . $data[$i]['id'] . ')"><i class="fas fa-trash"></i></button>
            <button class="btn btn-info" type="button" onclick="editarCliente(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['direccion'])) {
            $nombre = strClean($_POST['nombre']);
            $apellido = strClean($_POST['apellido']);
            $correo = (!empty($_POST['correo'])) ? strClean($_POST['correo']) : null;
            $direccion = strClean($_POST['direccion']);
            $tipo = 2;
            $id = strClean($_POST['id']);
            if (
                empty($nombre) || empty($apellido) || empty($direccion)
            ) {
                $respuesta = array('msg' => 'Todo los campos son requeridos', 'type' => 'warning');
            } else {
                if (empty($id)) {
                    $data = $this->model->registrar($correo, $nombre, $apellido, $direccion, $tipo);
                    if ($data > 0) {
                        $respuesta = array('msg' => 'Cliente registrado', 'type' => 'success');
                    } else {
                        $respuesta = array('msg' => 'Error al registrar', 'type' => 'error');
                    }
                } else {
                    $data = $this->model->modificar($correo, $nombre, $apellido, $direccion, $id);
                    if ($data == 1) {
                        $respuesta = array('msg' => 'Cliente modificado', 'type' => 'success');
                    } else {
                        $respuesta = array('msg' => 'Error al modificar', 'type' => 'error');
                    }
                }
            }
            echo json_encode($respuesta);
        }
        die();
    }

    public function eliminar($idCliente)
    {
        if (isset($_GET) && is_numeric($idCliente)) {
            $data = $this->model->eliminar(0, $idCliente);
            if ($data > 0) {
                $res = array('msg' => 'CLIENTE DADO DE BAJA', 'type' => 'success');
            } else {
                $res = array('msg' => 'ERROR AL ELIMINAR', 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'ERROR DESCONOCIDO', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar($idCliente)
    {
        $data = $this->model->editar($idCliente);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}
