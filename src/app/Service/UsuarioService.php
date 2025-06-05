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
            return $error = ["false"];
        } else {
            return $error = [
                "error" => "true",
                "msg" => "Usuario já existe"
            ];
        }
    }
    public function autenticarUsuario($email)
    {

        $usuario = $this->uM->getByEmail($email);

        if (!empty($usuario)) {

            if ($this->compararSenhas($email, $usuario["senha"])) {
                //setar dados sessão
                // $usuarioLogin . get() . setId(usuario . get() . getId());
                // $usuarioLogin . get() . setNome(usuario . get() . getNome());
                // return $usuarioLogin;
            }
        }

        return null;
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
