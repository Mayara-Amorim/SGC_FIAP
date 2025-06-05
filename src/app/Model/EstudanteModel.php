<?php
require_once 'src\app\Database\ConnectionFactory.php';
class EstudanteModel
{
    public $db;

    public function __construct()
    {
        $this->db = ConnectionFactory::getConection();
    }

    public function createEstudante($nome, $data_nascimeto, $email)
    {
        $st = $this->db->prepare('INSERT INTO TB_ESTUDANTES (nome, data_nascimento, email) VALUES(?,?,?)');
        $st->bindParam(1, $nome, PDO::PARAM_STR);
        $st->bindParam(2, $data_nascimeto, PDO::PARAM_STR);
        $st->bindParam(3, $email, PDO::PARAM_STR);

        $st->execute();
        return $this->db->lastInsertId();
    }
    public function editEstudante($id, $nome, $data_nascimeto, $email)
    {
        $st = $this->db->prepare('UPDATE TB_ESTUDANTES SET nome=? data_nascimento=?, email=? WHERE id= ?');
        $st->bindParam(1, $nome, PDO::PARAM_STR);
        $st->bindParam(2, $data_nascimeto, PDO::PARAM_STR);
        $st->bindParam(3, $email, PDO::PARAM_STR);
        $st->bindParam(4, $id, PDO::PARAM_INT);

        $st->execute();
    }
    public function softDeleteEstudante($id)
    {
        $st = $this->db->prepare('UPDATE TB_ESTUDANTES SET ativo = 0, deletado_em = CURRENT_DATE WHERE id = ?');
        $st->bindParam(1, $id, PDO::PARAM_INT);
        $st->execute();
    }
    public function getAllEstudantes()
    {
        $st = $this->db->query('SELECT * FROM TB_ESTUDANTES');
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getByAtivoEstudantes()
    {
        $st = $this->db->query('SELECT * FROM TB_ESTUDANTES WHERE ATIVO=1');
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getByIdEstudante($id)
    {
        $st = $this->db->prepare('SELECT * FROM TB_ESTUDANTES WHERE id= ?');
        $st->bindParam(1, $id, PDO::PARAM_INT);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getByNome($nome)
    {
        $st = $this->db->prepare('SELECT * FROM TB_ESTUDANTES where nome=?');
        $st->bindParam(1, $nome, PDO::PARAM_STR);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
}
