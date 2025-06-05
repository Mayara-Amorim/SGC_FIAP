<?php
require_once __DIR__ . '/../Service/UsuarioService.php';
require_once __DIR__ . '/../Model/UsuarioModel.php';
class UsuarioCrontrollerController
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
        return $this->uS->cadastrarUsuario($email, $senha);
    }
}
