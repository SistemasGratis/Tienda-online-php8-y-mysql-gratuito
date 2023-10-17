<?php
require 'vendor/autoload.php';
require_once 'Librerias/class.Cart.php';

use Dompdf\Dompdf;

class Ventas extends Controller
{
    private $cart, $id_usuario;
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['tipo']) || $_SESSION['tipo'] == 2) {
            header('Location: '. BASE_URL . 'admin');
            exit;
        }
        $this->cart = new Cart();
        $this->id_usuario = $_SESSION['id_usuario'];
    }
    public function index()
    {
        $data['title'] = 'Ventas';
        $this->views->getView('admin/ventas', "index", $data);
    }
    public function historial()
    {
        $data['title'] = 'Hirtorial ventas';
        $this->views->getView('admin/ventas', "historial", $data);
    }
    public function listar()
    {
        $data = $this->model->getVentas(2);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['productos'] = '';
            $data[$i]['status'] = $data[$i]['estado'];
            $productos = $this->model->getDetalle($data[$i]['id']);
            for ($j = 0; $j < count($productos); $j++) {
                $data[$i]['productos'] .= '<li class="list-group-item">' . $productos[$j]['cantidad'] . " x " . $productos[$j]['producto'] . " ------ " . $productos[$j]['precio'] . '</li>';
            }
            if ($data[$i]['estado'] == 0) {
                $data[$i]['estado'] =  '<span class="badge badge-warning">CANCELADO</span>';
            } else {
                $data[$i]['estado'] =  '<span class="badge badge-success">COMPLETADO</span>';
            }
            $data[$i]['accion'] =  '<a class="btn btn-danger" href="#" onclick="verVenta(' . $data[$i]['id'] . ')"><i class="fas fa-print"></i></a>';
        }
        echo json_encode($data);
        die();
    }

    public function buscarProducto()
    {
        $array = array();
        $valor = $_GET['term'];
        $data = $this->model->buscarProducto($valor);
        foreach ($data as $row) {
            $result['id'] = $row['id'];
            $result['label'] = $row['nombre'];
            $result['precio'] = $row['precio'];
            array_push($array, $result);
        }
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function agregarProducto($idProducto)
    {
        if (is_numeric($idProducto)) {
            $producto = $this->model->getProducto($idProducto);
            if (!empty($producto)) {
                $this->agregarCarrito($producto);
            }
        }
    }
    public function agregarCarrito($producto)
    {
        // https://github.com/seikan/Cart

        $insert = 0;

        $existe = $this->cart->isItemExists(
            $producto['id'],
            [
                'price'  => $producto['precio'],
                'nombre'  => $producto['nombre']
            ]
        );
        
        if (!$existe) {
            $agregado = 0;
        } else {
            $agregado = $this->cart->getItem($producto['id'])['quantity'];
        }

        if ($producto['cantidad'] >= ($agregado + 1)) {
            $insert = $this->cart->add($producto['id'], 1, [
                'price'  => $producto['precio'],
                'nombre'  => $producto['nombre']
            ]);
            if ($insert) {
                $res = array('msg' => 'Producto agregado', 'type' => 'success');
            } else {
                $res = array('msg' => 'Error al agregar', 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'Producto agotado', 'type' => 'error');
        }
        echo json_encode($res);
        die();
    }

    public function listarCarrito()
    {
        $array['productos'] = array();
        if (!$this->cart->isEmpty()) {
            $allItems = $this->cart->getItems();
            foreach ($allItems as $items) {
                foreach ($items as $item) {
                    array_push($array['productos'], $item);
                }
            }
            $array['totalF'] = number_format($this->cart->getAttributeTotal('price'), 2, '.', ',');
            $array['totalS'] = number_format($this->cart->getAttributeTotal('price'), 2, '.', '');
        }
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function deleteCarrito($id)
    {
        $result = $this->cart->remove($id);
        if ($result) {
            $res = array('msg' => 'Producto eliminado', 'type' => 'success');
        } else {
            $res = array('msg' => 'Error al eliminar', 'type' => 'error');
        }
        echo json_encode($res);
        die();
    }

    public function vaciarCarrito()
    {
        $this->cart->clear();
        if ($this->cart->isEmpty()) {
            $res = array('msg' => 'Carrito vaciado', 'type' => 'success');
        } else {
            $res = array('msg' => 'Error al vaciar', 'type' => 'error');
        }
        echo json_encode($res);
        die();
    }

    public function buscarCliente()
    {
        $array = array();
        $valor = $_GET['term'];
        $data = $this->model->buscarCliente($valor);
        foreach ($data as $row) {
            $result['id'] = $row['id'];
            $result['label'] = $row['nombre'];
            $result['direccion'] = $row['direccion'];
            array_push($array, $result);
        }
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {
        $json = file_get_contents('php://input');
        $datos = json_decode($json, true);
        $fecha = date('Y-m-d H:i:s');
        if (empty($datos['idCliente'])) {
            $cliente = null;
        } else {
            $consultaCli = $this->model->getCliente($datos['idCliente']);
            $cliente = $consultaCli['nombre'] . ' ' . $consultaCli['apellido'];
        }

        $total = $this->cart->getAttributeTotal('price');
        $pago = (!empty($datos['pago'])) ? $datos['pago'] : $total;
        $venta = $this->model->registrarVenta($total, $fecha, $cliente, $pago, $this->id_usuario);
        if ($venta > 0) {
            $allItems = $this->cart->getItems();
            $array['productos'] = array();
            foreach ($allItems as $items) {
                foreach ($items as $item) {
                    $this->model->registraDetalle(
                        $item['quantity'],
                        $item['attributes']['price'],
                        $item['attributes']['nombre'],
                        $item['id'],
                        $venta
                    );
                    $result = $this->model->getProducto($item['id']);
                    //actualizar stock
                    $nuevaCantidad = $result['cantidad'] - $item['quantity'];
                    $nuevaVenta = $result['ventas'] + $item['quantity'];
                    $this->model->actualizarStock($nuevaCantidad, $nuevaVenta, $result['id']);
                }
            }
            $this->cart->clear();
            $res = array('msg' => 'VENTA GENERADA', 'type' => 'success', 'idVenta' => $venta);
        } else {
            $res = array('msg' => 'ERROR AL GENERAR VENTA', 'type' => 'error');
        }
        echo json_encode($res);
        die();
    }

    public function ticket($idVenta)
    {
        ob_start();

        $data['empresa'] = $this->model->getNegocio();
        $data['venta'] = $this->model->getVenta($idVenta);
        $data['detalle'] = $this->model->getDetalleVenta($idVenta);
        if (empty($data['venta'])) {
            echo 'Pagina no Encontrada';
            exit;
        }
        $this->views->getView('admin/ventas', 'ticket', $data);
        $html = ob_get_clean();
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->set('isJavascriptEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);
        $dompdf->loadHtml($html);

        $dompdf->setPaper(array(0, 0, 130, 841), 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('reporte.pdf', array('Attachment' => false));
    }

    public function anular($idVenta)
    {
        if (isset($_GET) && is_numeric($idVenta)) {
            $data = $this->model->anular($idVenta);
            if ($data == 1) {
                $resultVenta = $this->model->getDetalleVenta($idVenta);
                foreach ($resultVenta as $producto) {
                    $result = $this->model->getProducto($producto['id']);
                    $nuevaCantidad = $result['cantidad'] + $producto['cantidad'];
                    $totalVentas = $result['ventas'] - $producto['cantidad'];
                    $this->model->actualizarStock($nuevaCantidad, $totalVentas, $producto['id']);
                }
                $res = array('msg' => 'VENTA ANULADO', 'type' => 'success');
            } else {
                $res = array('msg' => 'ERROR AL ANULAR', 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'ERROR DESCONOCIDO', 'type' => 'error');
        }
        echo json_encode($res);
        die();
    }
}
