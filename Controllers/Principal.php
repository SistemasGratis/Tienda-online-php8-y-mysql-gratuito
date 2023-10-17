<?php
//Load Composer's autoloader
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Principal extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    public function index()
    {
        $data['title'] = 'Pagina Principal';
        $data['negocio'] = $this->model->getNegocio();
        $data['categorias'] = $this->model->getCategorias();
        $data['destacados'] = $this->model->getProductosDestacados();
        $data['tops'] = $this->model->topProductos();
        $data['agotados'] = $this->model->agotadosProductos();
        $this->views->getView('home', "index", $data);
    }

    public function productos($page)
    {
        $data['title'] = 'Tu carrito';
        //paginacion
        $pagina = (empty($page)) ? 1 : $page;
        $porPagina = 8;
        $desde = ($pagina - 1) * $porPagina;
        //VERIFICAR SI EXISTE UNA BUSQUEDA
        $search = (!empty($_GET['search'])) ? strClean($_GET['search']) : '';
        $data['maximo'] = $this->model->getPrecio('MAX(precio)');
        $data['minimo'] = $this->model->getPrecio('MIN(precio)');
        $data['categorias'] = $this->model->getCategorias();
        $data['productos'] = $this->model->getProductos($search, '', $desde, $porPagina);
        $totalProducto = $this->model->getTotalProductos($search, '');
        $data['negocio'] = $this->model->getNegocio();
        $data['pagina'] = $pagina;
        $data['total'] = ceil($totalProducto['total'] / $porPagina);
        $this->views->getView('principal', "productos", $data);
    }

    public function filtro()
    {
        $categorias = $_POST['categorias'];
        $precio = explode(';', $_POST['precios']);
        $desde = $precio[0];
        $hasta = $precio[1];
        //VERIFICAR SI EXISTE UNA BUSQUEDA
        $search = (!empty($_GET['search'])) ? strClean($_GET['search']) : '';
        $data['productos'] = $this->model->getFiltroProductos($search, $categorias, $desde, $hasta);
        $data['negocio'] = $this->model->getNegocio();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function categoria($categoria)
    {
        $data['title'] = 'Tu carrito';
        //VERIFICAR SI EXISTE UNA BUSQUEDA
        $search = (!empty($_GET['search'])) ? strClean($_GET['search']) : '';
        $data['categoria'] = $this->model->getCategoria($categoria);
        $data['categorias'] = $this->model->getCategorias();
        $data['productos'] = $this->model->getProductosCategoria($search, $data['categoria']['id']);
        $data['negocio'] = $this->model->getNegocio();
        $this->views->getView('principal', "categorias", $data);
    }

    public function carrito()
    {
        $data['title'] = 'Tu carrito';
        $data['categorias'] = $this->model->getCategorias();
        $data['negocio'] = $this->model->getNegocio();
        $this->views->getView('principal', "carrito", $data);
    }

    public function order()
    {
        $data['title'] = 'Tu carrito';
        $data['categorias'] = $this->model->getCategorias();
        $data['negocio'] = $this->model->getNegocio();
        $this->views->getView('principal', "order", $data);
    }

    public function address()
    {
        $data['title'] = 'Tu carrito';
        $data['categorias'] = $this->model->getCategorias();
        $data['negocio'] = $this->model->getNegocio();
        $this->views->getView('principal', "address", $data);
    }

    public function pagos()
    {
        $data['title'] = 'Tu carrito';
        $data['categorias'] = $this->model->getCategorias();
        $data['negocio'] = $this->model->getNegocio();
        $this->views->getView('principal', "pagos", $data);
    }

    public function complete()
    {
        $data['title'] = 'Tu carrito';
        $data['categorias'] = $this->model->getCategorias();
        $data['negocio'] = $this->model->getNegocio();
        $this->views->getView('principal', "complete", $data);
    }

    public function contactos()
    {
        $data['title'] = 'Tu carrito';
        $data['negocio'] = $this->model->getNegocio();
        $data['categorias'] = $this->model->getCategorias();
        $this->views->getView('principal', "contactos", $data);
    }

    public function listaProductos()
    {
        $datos = file_get_contents('php://input');
        $json = json_decode($datos, true);
        $array['productos'] = array();
        $total = 0.00;
        if (!empty($json)) {
            foreach ($json as $producto) {
                $result = $this->model->getProducto($producto['id']);
                $data['id'] = $result['id'];
                $data['nombre'] = $result['nombre'];
                $data['precio'] = $result['precio'];
                $data['cantidad'] = $producto['cantidad'];
                $data['imagen'] = $result['imagen'];
                $subTotal = $data['precio'] * $producto['cantidad'];
                $data['subTotal'] = number_format($subTotal, 2);
                array_push($array['productos'], $data);
                $total += $subTotal;
            }
        }
        $array['total'] = number_format($total, 2);
        $array['totalPaypal'] = number_format($total, 2, '.', '');
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
        die();
    }

    //reset password
    public function recoverpw()
    {
        $data['title'] = 'Olvidate tu contraseña';
        $this->views->getView('admin', "recoverpw", $data);
    }

    public function reset($token)
    {
        $data['title'] = 'Restablecer Contraseña';
        $data['seguridad'] = $this->model->verificarToken($token);
        if ($data['seguridad']['token'] != $token || empty($token) || $data['seguridad']['token'] == null) {
            header('Location: ' . BASE_URL);
            exit;
        }
        $this->views->getView('admin', 'reset', $data);
    }

    public function enviarMail($correo)
    {
        $verificar = $this->model->verificarCorreo($correo, 1);
        if (!empty($verificar)) {
            $negocio = $this->model->getNegocio();
            $mail = new PHPMailer(true);
            $fecha = date('YmdHis');
            $token = md5($fecha);
            try {
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->SMTPDebug = 0;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = $negocio['host_smtp'];                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = $negocio['user_smtp'];                     //SMTP username
                $mail->Password   = $negocio['pass_smtp'];                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = $negocio['puerto_smtp'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom($negocio['correo'], $negocio['nombre']);
                $mail->addAddress($correo);

                //Content
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';                                  //Set email format to HTML
                $mail->Subject = 'Restablecer Contraseña - ' . TITLE;
                $mail->Body    = 'Has pedido restablecer tu contraseña, si no has sido omite este mensaje <br />
            Para cambiar <a href="' . BASE_URL . 'principal/reset/' . $token . '">CLICK AQUI</a>';

                $mail->send();

                $verificarToken = $this->model->registrarToken($token, $correo);
                if ($verificarToken == 1) {
                    $res = array('msg' => 'CORREO ENVIADO CON UN TOKEN DE SEGURIDAD', 'type' => 'success');
                } else {
                    $res = array('msg' => 'ERROR AL REGISTRAR EL TOKEN', 'type' => 'error');
                }
            } catch (Exception $e) {
                $res = array('msg' => 'ERROR AL ENVIAR EL CORREO: ' . $mail->ErrorInfo, 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'EL CORREO NO ESTA REGISTRADO', 'type' => 'warning');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function cambiarClave()
    {
        $nueva = strClean($_POST['nueva']);
        $confirmar = strClean($_POST['confirmar']);
        $token = strClean($_POST['token']);
        if (empty($nueva) || empty($confirmar) || empty($token)) {
            $res = array('msg' => 'TODO LOS CAMPOS CON * SON REQUERIDOS', 'type' => 'warning');
        } else {
            if ($nueva != $confirmar) {
                $res = array('msg' => 'LAS CONTRASEÑAS NO COINCIDEN', 'type' => 'warning');
            } else {
                $consulta = $this->model->verificarToken($token);
                if (!empty($consulta)) {
                    $hash = password_hash($nueva, PASSWORD_DEFAULT);
                    $data = $this->model->modificarClave($hash, $token);
                    if ($data == 1) {
                        $res = array('msg' => 'CONTRASEÑA MODIFICADA', 'type' => 'success');
                    } else {
                        $res = array('msg' => 'ERROR AL MODIFICAR', 'type' => 'error');
                    }
                } else {
                    $res = array('msg' => 'TOKEN ALTERADO', 'type' => 'error');
                }
            }
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function envio()
    {
        if (
            empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['direccion'])
            || empty($_POST['ciudad']) || empty($_POST['cod']) || empty($_POST['pais'])
            || empty($_POST['telefono'])
        ) {
            $res = array('msg' => 'TODO LOS CAMPOS CON * SON REQUERIDOS', 'icono' => 'warning');
        } else {
            $_SESSION['address'] = [
                'nombre' => strClean($_POST['nombre']),
                'apellido' => strClean($_POST['apellido']),
                'direccion' => strClean($_POST['direccion']),
                'ciudad' => strClean($_POST['ciudad']),
                'cod' => strClean($_POST['cod']),
                'pais' => strClean($_POST['pais']),
                'telefono' => strClean($_POST['telefono'])
            ];
            $res = array('msg' => 'ok', 'icono' => 'success');
        }
        echo json_encode($res);
        die();
    }

    //LOGIN
    public function login()
    {
        $data['title'] = 'Tu carrito';
        $data['negocio'] = $this->model->getNegocio();
        $data['categorias'] = $this->model->getCategorias();
        $this->views->getView('principal', "login", $data);
    }
}
