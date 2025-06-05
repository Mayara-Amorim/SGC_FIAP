<?php
require_once __DIR__ . '/../Model/MatriculaModel.php';
class MatriculaController
{
    private $mM;

    public function __construct()
    {
        $this->mM = new MatriculaModel();
    }

    public function createMatricula($idEstudante, $idTurma)
    {

        return $this->mM->createMatricula($idEstudante, $idTurma);
    }

    public function getAllMatriculas()
    {
        return $this->mM->getAllMatriculas();
    }

    public function getByIdMatricula($id)
    {
        return $this->mM->getByIdMatricula($id);
    }

    public function delete($id)
    {
        return $this->mM->softDeleteMatricula($id);
    }
}
