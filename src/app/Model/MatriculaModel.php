<?php

final class MatriculaModel
{
    public $db;

    public function __construct()
    {
        $this->db = ConnectionFactory::getConection();
    }

    public function createMatricula($idEstudante, $idTurma)
    {
        $st = $this->db->prepare('INSERT INTO tb_matriculas ( estudante_id,  turma_id) VALUES(?,?)');
        $st->bindParam(1, $idEstudante, PDO::PARAM_INT);
        $st->bindParam(2, $idTurma, PDO::PARAM_INT);
        $st->execute();
        return $this->db->lastInsertId();
    }

    public function softDeleteMatricula($id)
    {
        $st = $this->db->prepare('UPDATE tb_matriculas SET ativo = 0, deletado_em = CURRENT_DATE WHERE id = ?');
        $st->bindParam(1, $id, PDO::PARAM_INT);
        $st->execute();
    }
    public function deleteByTurma($idTurma)
    {
        $st = $this->db->prepare('DELETE FROM tb_matriculas where turma_id = ?');
        $st->bindParam(1, $idTurma, PDO::PARAM_INT);
        $st->execute();
    }

    public function getAllMatriculas()
    {
        $st = $this->db->query('
        SELECT  MAT.DATA_MATRICULA, ESTUDANTES.ID, ESTUDANTES.NOME, TURMAS.ID, TURMAS.NOME FROM tb_matriculas as MAT
        JOIN tb_estudantes as ESTUDANTES
        ON  ESTUDANTES.ID = MAT.estudante_id
        JOIN tb_turmas AS TURMAS
        ON TURMAS.ID = MAT.TURMA_ID
    ');
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByIdMatricula($id)
    {
        $st = $this->db->prepare('SELECT * FROM tb_matriculas WHERE id= ?');
        $st->bindParam(1, $id, PDO::PARAM_INT);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getByEstudantesInTurma($idTurma)
    {
        $st = $this->db->prepare('
        SELECT  MAT.DATA_MATRICULA, ESTUDANTES.ID, ESTUDANTES.NOME FROM tb_matriculas as MAT
        JOIN tb_estudantes as ESTUDANTES
        ON  ESTUDANTES.ID = MAT.estudante_id
        where MAT.TURMA_ID = ?');
        $st->bindParam(1, $idTurma, PDO::PARAM_STR);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
}
