<?php
require_once __DIR__ . '/../Service/UsuarioService.php';
require_once __DIR__ . '/../Model/UsuarioModel.php';
require_once __DIR__ . '/BaseController.php';
class UsuarioController extends BaseController
{
    private $uS;
    //private $uM;

    public function __construct()
    {
        $this->uS = new UsuarioService();
        //$this->uM = new UsuarioService();
    }

    public function cadastrarUsuario($email, $senha)
    {
        if ($this->uS->cadastrarUsuario($email, $senha)) {
            http_response_code(201);
            return json_encode(["error" => false]);
        }
        http_response_code(400);
        return json_encode(["error" => true]);
    }
    public function logout()
    {
        session_destroy();
        header("Location: /");
    }
    public function login()
    {
        $email =  $_POST['email'];
        $senha = $_POST['senha'];
        if ($this->uS->autenticarUsuario($email, $senha)) {
            return $this->sendJson(["error" => false]);
        }
        $this->sendJson(["error" => true], 401);
    }
    public function viewLogin()
    {
        echo file_get_contents("src/app/View/login.html");
    }

    public function dashboard()
    {
        include_once __DIR__ . "/../View/dashboard.php";
    }

    public function index()
    {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: /login");
            return;
        }

        header("Location: /dashboard");
    }
}
