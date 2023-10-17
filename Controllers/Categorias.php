<?php
class Categorias extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['tipo']) || $_SESSION['tipo'] == 2) {
            header('Location: ' . BASE_URL . 'admin');
            exit;
        }
    }
    public function index()
    {
        $data['title'] = 'categorias';
        $this->views->getView('admin/categorias', "index", $data);
    }
    public function listar()
    {
        $data = $this->model->getCategorias(1);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['imagen'] = '<img class="img-thumbnail" src="' . BASE_URL . 'public/img/categorias/' . $data[$i]['imagen'] . '" alt="' . $data[$i]['categoria'] . '" width="50">';
            $data[$i]['accion'] = '<div class="d-flex">
            <button class="btn btn-primary" type="button" onclick="editCat(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger" type="button" onclick="eliminarCat(' . $data[$i]['id'] . ')"><i class="fas fa-trash"></i></button>
        </div>';
        }
        echo json_encode($data);
        die();
    }

    public function registrar()
    {
        if (isset($_POST['categoria'])) {
            $categoria = strClean($_POST['categoria']);
            $fotoActual = $_POST['imagen_actual'];
            $imagen = $_FILES['imagen'];
            $tmp_name = $imagen['tmp_name'];
            $id = $_POST['id'];
            $nombreImg = date('YmdHis');
            if (empty($_POST['categoria'])) {
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
                if (empty($id)) {
                    if (empty($imagen['name'])) {
                        $respuesta = array('msg' => 'seleccionar una imagen', 'icono' => 'error');
                    } else {
                        $result = $this->model->verificarCategoria($categoria);
                        if (empty($result)) {
                            $data = $this->model->registrar($categoria,$destino,);
                            if ($data > 0) {
                                $destino = 'public/img/categorias/' . $nombreImg . '.jpg';
                                move_uploaded_file($tmp_name, $destino);
                                $respuesta = array('msg' => 'categoria registrado', 'icono' => 'success');
                            } else {
                                $respuesta = array('msg' => 'error al registrar', 'icono' => 'error');
                            }
                        } else {
                            $respuesta = array('msg' => 'la categoria ya existe', 'icono' => 'warning');
                        }
                    }
                } else {
                    if (empty($destino)) {
                        $respuesta = array('msg' => 'seleccionar una imagen', 'icono' => 'error');
                    } else {
                        ##temporal
                        $temp = $this->model->getCatoria($id);
                        $data = $this->model->modificar($categoria, $destino, $id);
                        if ($data == 1) {
                            if (!empty($imagen['name'])) {
                                if (file_exists('public/img/categorias/' . $temp['imagen'])) {
                                    unlink('public/img/categorias/' . $temp['imagen']);
                                }
                                $destino = 'public/img/categorias/' . $nombreImg . '.jpg';
                                move_uploaded_file($tmp_name, $destino);
                            }
                            $respuesta = array('msg' => 'categoria modificado', 'icono' => 'success');
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
    //eliminar cat
    public function delete($idCat)
    {
        if (is_numeric($idCat)) {
            $data = $this->model->eliminar($idCat);
            if ($data == 1) {
                $respuesta = array('msg' => 'categoria dado de baja', 'icono' => 'success');
            } else {
                $respuesta = array('msg' => 'error al eliminar', 'icono' => 'error');
            }
        } else {
            $respuesta = array('msg' => 'error desconocido', 'icono' => 'error');
        }
        echo json_encode($respuesta);
        die();
    }
    //editar cat
    public function edit($idCat)
    {
        if (is_numeric($idCat)) {
            $data = $this->model->getCatoria($idCat);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
