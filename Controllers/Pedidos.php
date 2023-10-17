<?php
class Pedidos extends Controller
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
        $data['title'] = 'pedidos';
        $this->views->getView('admin/pedidos', "index", $data);
    }
    public function listarPedidos()
    {
        $data = $this->model->getPedidos(1);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['productos'] = '';
            $productos = $this->model->getDetalle($data[$i]['id']);
            for ($j=0; $j < count($productos); $j++) { 
                $data[$i]['productos'] .= '<li class="list-group-item">'.$productos[$j]['cantidad'] . " x " . $productos[$j]['producto'] . " ------ " . $productos[$j]['precio'].'</li>';
            }
            if ($data[$i]['proceso'] == 1) {
                $data[$i]['estado'] =  '<span class="badge badge-warning">PENDIENTE</span>';
            } else {
                $data[$i]['estado'] =  '<span class="badge badge-success">COMPLETADO</span>';
            }
            $data[$i]['accion'] = '<button type="button" onclick="verDireccion('.$data[$i]['id'].')" class="btn btn-primary">Envio</button>';
        }
        echo json_encode($data);
        die();
    }
    public function update($idPedido)
    {
        if (is_numeric($idPedido)) {
            $data = $this->model->actualizarEstado(2, $idPedido);
            if ($data == 1) {
                $respuesta = array('msg' => 'Pedido actualizado', 'icono' => 'success');
            } else {
                $respuesta = array('msg' => 'Error al actualizar', 'icono' => 'error');
            }
            echo json_encode($respuesta);
        }
        die();
    }

}
