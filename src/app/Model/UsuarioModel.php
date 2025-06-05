<?php
class UsuarioModel
{
    public $db;

    public function __construct()
    {
        $this->db = ConnectionFactory::getConection();
    }

    public function createUsuario($email, $senha, $idUsuario)
    {
        $st = $this->db->prepare('INSERT INTO TB_USUARIOS (email, senha, idUsuario) VALUES(?,?,?)');
        $st->bindParam(1, $email, PDO::PARAM_STR);
        $st->bindParam(2, $senha, PDO::PARAM_STR);
        $st->bindParam(3, $idUsuario, PDO::PARAM_INT);

        $st->execute();
        return $this->db->lastInsertId();
    }

    public function deletarUsuario($idUsuario)
    {
        $st = $this->db->query('DELETE TB_USUARIOS WHERE id=?');
        $st->bindParam(1, $idUsuario, PDO::PARAM_INT);
        $st->execute();
    }
    public function login($email, $senha)
    {
        $st = $this->db->query('SELECT * FROM TB_USUARIOS WHERE email=? AND senha=?');
        $st->bindParam(1, $email, PDO::PARAM_STR);
        $st->bindParam(1, $senha, PDO::PARAM_STR);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    public function logout() {}
}
