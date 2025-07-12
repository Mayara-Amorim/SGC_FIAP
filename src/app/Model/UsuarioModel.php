<?php
class UsuarioModel
{
    public $db;

    public function __construct()
    {
        $this->db = ConnectionFactory::getConection();
    }

    public function createUsuario($email, $senha)
    {
        $st = $this->db->prepare('INSERT INTO tb_usuarios (email, senha) VALUES(?,?)');
        $st->bindParam(1, $email, PDO::PARAM_STR);
        $st->bindParam(2, $senha, PDO::PARAM_STR);

        $st->execute();
        return $this->db->lastInsertId();
    }
    public function getByEmail($email)
    {
        $st = $this->db->prepare('SELECT * FROM tb_usuarios WHERE email= ?');
        $st->bindParam(1, $email, PDO::PARAM_STR);
        $st->execute();
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    public function deletarUsuario($idUsuario)
    {
        $st = $this->db->prepare('DELETE tb_usuarios WHERE id=?');
        $st->bindParam(1, $idUsuario, PDO::PARAM_INT);
        $st->execute();
    }
    public function login($email, $senha)
    {
        $st = $this->db->prepare('SELECT * FROM tb_usuarios WHERE email=? AND senha=?');
        $st->bindParam(1, $email, PDO::PARAM_STR);
        $st->bindParam(1, $senha, PDO::PARAM_STR);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    public function logout() {}
    public function setSenha($str, $id)
    {
        $st = $this->db->prepare('UPDATE tb_usuarios SET senha=? WHERE id= ?');
        $st->bindParam(1, $nome, PDO::PARAM_STR);
        $st->bindParam(2, $data_nascimeto, PDO::PARAM_INT);

        $st->execute();
    }
}
