<?php
class TurmaModel
{
    public $db;

    public function __construct()
    {
        $this->db = ConnectionFactory::getConection();
    }

    public function createTurma($nome, $descricao, $tipo)
    {
        $st = $this->db->prepare('INSERT INTO TB_TURMAS (nome, descricao, tipo) VALUES(?,?,?)');
        $st->bindParam(1, $nome, PDO::PARAM_STR);
        $st->bindParam(2, $descricao, PDO::PARAM_STR);
        $st->bindParam(3, $tipo, PDO::PARAM_STR);

        $st->execute();
        return $this->db->lastInsertId();
    }
    public function editTurma($id, $nome, $descricao, $tipo)
    {
        $st = $this->db->prepare('UPDATE TB_TURMAS SET nome=? descricao=?, tipo=? WHERE id= ?');
        $st->bindParam(1, $nome, PDO::PARAM_STR);
        $st->bindParam(2, $descricao, PDO::PARAM_STR);
        $st->bindParam(3, $tipo, PDO::PARAM_STR);
        $st->bindParam(4, $id, PDO::PARAM_INT);
        $st->execute();
    }
    public function softDeleteTurma($id)
    {
        $st = $this->db->prepare('UPDATE TB_TURMAS SET ativo = 0, deletado_em = CURRENT_DATE WHERE id = ?');
        $st->bindParam(1, $id, PDO::PARAM_INT);
        $st->execute();
    }
    public function getAllTurmas()
    {
        $st = $this->db->query('SELECT * FROM TB_TURMAS');
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getByAtivoTurmas()
    {
        $st = $this->db->query('SELECT * FROM TB_TURMAS WHERE ATIVO=1');
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getByIdTurma($id)
    {
        $st = $this->db->prepare('SELECT * FROM TB_TURMAS WHERE id= ?');
        $st->bindParam(1, $id, PDO::PARAM_INT);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getByNome($nome)
    {
        $st = $this->db->prepare('SELECT * FROM TB_TURMAS where nome=?');
        $st->bindParam(1, $nome, PDO::PARAM_STR);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
}
