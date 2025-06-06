<?php
require_once __DIR__ . '/../Service/UsuarioService.php';
require_once __DIR__ . '/../Model/UsuarioModel.php';
class UsuarioController
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
    }
    public function login($email, $senha)
    {
        if ($this->uS->autenticarUsuario($email, $senha)) {
            return json_encode(["error" => false]);
        }
        http_response_code(401);
        return json_encode(["error" => true]);
    }
}
