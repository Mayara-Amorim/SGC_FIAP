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
        $st = $this->db->prepare('INSERT INTO TB_MATRICULAS ( estudante_id,  turma_id) VALUES(?,?)');
        $st->bindParam(1, $idEstudante, PDO::PARAM_INT);
        $st->bindParam(2, $idTurma, PDO::PARAM_INT);
        $st->execute();
        return $this->db->lastInsertId();
    }

    public function softDeleteMatricula($id)
    {
        $st = $this->db->prepare('UPDATE TB_MATRICULAS SET ativo = 0, deletado_em = CURRENT_DATE WHERE id = ?');
        $st->bindParam(1, $id, PDO::PARAM_INT);
        $st->execute();
    }
    public function getAllMatriculas()
    {
        $st = $this->db->query('
        SELECT MAT.ID, MAT.DATA_MATRICULA, ESTUDANTES.ID, ESTUDANTES.NOME, TURMAS.ID, TURMAS.NOME FROM TB_MATRICULAS as MAT
        JOIN TB_ESTUDANTES as ESTUDANTES
        ON  ESTUDANTES.ID = MAT.estudante_id
        JOIN TB_TURMAS AS TURMAS
        ON TURMAS.ID = MAT.TURMA_ID
    ');
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByIdMatricula($id)
    {
        $st = $this->db->prepare('SELECT * FROM TB_MATRICULAS WHERE id= ?');
        $st->bindParam(1, $id, PDO::PARAM_INT);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getByEstudantesInTurma($idTurma)
    {
        $st = $this->db->query('
        SELECT MAT.ID, MAT.DATA_MATRICULA, ESTUDANTES.ID, ESTUDANTES.NOME FROM TB_MATRICULAS as MAT
        JOIN TB_ESTUDANTES as ESTUDANTES
        ON  ESTUDANTES.ID = MAT.estudante_id
        where MAT.TURMA_ID = ?');
        $st->bindParam(1, $idTurma, PDO::PARAM_STR);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
}
