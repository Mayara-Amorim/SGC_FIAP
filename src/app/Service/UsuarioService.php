<?php
require_once __DIR__ . '/../Model/EstudanteModel.php';
class UsuarioService
{
    private $db;
    private $uM;

    public function __construct()
    {
        $this->db = ConnectionFactory::getConection();
        $this->uM = new UsuarioModel();
    }



    public function cadastrarUsuario($email, $senha)
    {
        $email = $this->uM->getByEmail($email);
        if (empty($email)) {
            $senha = $this->criptografarSenha($senha);
            $this->uM->createUsuario($email, $senha);
            return true;
        }
        return false;
    }
    public function autenticarUsuario($email, $senha)
    {
        $usuario = $this->uM->getByEmail($email);

        if (!empty($usuario)) {
            if ($this->compararSenhas($senha, $usuario["senha"])) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_email'] = $usuario['email'];

                return true;
            }
        }

        return false;
    }


    function criptografarSenha($senha)
    {
        return password_hash($senha, PASSWORD_DEFAULT);
    }

    function compararSenhas($senhaDigitada, $senhaBanco): bool
    {
        return password_verify($senhaDigitada, $senhaBanco);
    }
}
