<?php
class Productos extends Controller
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
        $data['title'] = 'productos';
        $data['categorias'] = $this->model->getDatos('categorias');
        $this->views->getView('admin/productos', "index", $data);
    }
    public function listar()
    {
        $data = $this->model->getProductos(1);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['imagen'] = '<img class="img-thumbnail" src="' . BASE_URL . 'public/img/productos/' . $data[$i]['imagen'] . '" alt="' . $data[$i]['nombre'] . '" width="50">';
            $data[$i]['accion'] = '
            <a class="btn btn-info" href="#" onclick="editPro(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i> Editar</a>
            <a class="btn btn-danger" href="#" onclick="eliminarPro(' . $data[$i]['id'] . ')"><i class="fas fa-trash"></i> Eliminar</a>';
        }
        echo json_encode($data);
        die();
    }

    public function registrar()
    {
        if (isset($_POST['nombre']) && isset($_POST['precio'])) {
            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];
            $cantidad = (!empty($_POST['cantidad'])) ? $_POST['cantidad'] : 0;
            $descripcion = $_POST['descripcion'];
            $categoria = $_POST['categoria'];
            $fotoActual = $_POST['imagen_actual'];
            $imagen = $_FILES['imagen'];
            $tmp_name = $imagen['tmp_name'];
            $id = $_POST['id'];
            $nombreImg = date('YmdHis');
            if (empty($nombre) || empty($precio)) {
                $respuesta = array('msg' => 'todo los campos son requeridos', 'icono' => 'warning');
            } else {
                ##### VERIFICAR IMG ACTUAL #####
                $destino = null;
                if (!empty($imagen['name'])) {
                    $fecha = date('YmdHis');
                    $destino = $fecha . '.jpg';
                } else if (!empty($fotoActual) && empty($imagen['name'])) {
                    $destino = $fotoActual;
                }

                ##### VERIFICAR SI EXISTE ID ######
                if (empty($id)) {
                    if (empty($imagen['name'])) {
                        $respuesta = array('msg' => 'seleccionar una imagen', 'icono' => 'error');
                    } else {
                        #### REGISTRAR PRODUCTO #####
                        $data = $this->model->registrar($nombre, $descripcion, $precio, $cantidad, $destino, $categoria);
                        if ($data > 0) {
                            #### ACORTAR IMAGEN #####
                            if (!empty($imagen['name'])) {
                                $destino = 'public/img/productos/' . $nombreImg . '.jpg';
                                move_uploaded_file($tmp_name, $destino);
                            }
                            $respuesta = array('msg' => 'producto registrado', 'icono' => 'success');
                        } else {
                            $respuesta = array('msg' => 'error al registrar', 'icono' => 'error');
                        }
                    }
                } else {
                    if (empty($destino)) {
                        $respuesta = array('msg' => 'seleccionar una imagen', 'icono' => 'error');
                    } else {
                        ##temporal
                        $temp = $this->model->getProducto($id);
                        #### MODIFICAR PRODUCTO #####
                        $data = $this->model->modificar($nombre, $descripcion, $precio, $cantidad, $destino, $categoria, $id);
                        if ($data == 1) {
                            if (!empty($imagen['name'])) {
                                if (file_exists('public/img/productos/' . $temp['imagen'])) {
                                    unlink('public/img/productos/' . $temp['imagen']);
                                }
                                $destino = 'public/img/productos/' . $nombreImg . '.jpg';
                                move_uploaded_file($tmp_name, $destino);
                            }
                            $respuesta = array('msg' => 'producto modificado', 'icono' => 'success');
                        } else {
                            $respuesta = array('msg' => 'error al modificar', 'icono' => 'error');
                        }
                    }
                }
            }
            echo json_encode($respuesta);
        }
        die();
    }
    //eliminar pro
    public function delete($idPro)
    {
        if (is_numeric($idPro)) {
            $data = $this->model->eliminar($idPro);
            if ($data == 1) {
                $respuesta = array('msg' => 'producto dado de baja', 'icono' => 'success');
            } else {
                $respuesta = array('msg' => 'error al eliminar', 'icono' => 'error');
            }
        } else {
            $respuesta = array('msg' => 'error desconocido', 'icono' => 'error');
        }
        echo json_encode($respuesta);
        die();
    }
    //editar pro
    public function edit($idPro)
    {
        if (is_numeric($idPro)) {
            $data = $this->model->getProducto($idPro);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
