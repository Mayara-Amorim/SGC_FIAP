<?php
require_once __DIR__ . '/../Model/MatriculaModel.php';
require_once __DIR__ . '/BaseController.php';
class MatriculaController extends BaseController
{
    private $mM;

    public function __construct()
    {
        $this->mM = new MatriculaModel();
    }

    public function createMatricula()
    {
        $idEstudante = $_POST["estudante"];
        $idTurma = $_POST["turma"];

        try {
            $this->mM->createMatricula($idEstudante, $idTurma);
            $this->sendJson(["error" => false]);
        } catch (\Throwable $th) {
            error_log($th->getMessage(), 0, "/dev/stderr");
            $this->sendJson(["error" => "Não foi possível matricular este estudante nessa turma!"], 400);
        }
    }

    public function getAllMatriculas()
    {
        return $this->mM->getAllMatriculas();
    }

    public function getByEstudantesInTurma($idTurma)
    {
        $this->sendJson($this->mM->getByEstudantesInTurma($idTurma));
    }

    public function getByIdMatricula($id)
    {
        return $this->mM->getByIdMatricula($id);
    }

    public function delete($id)
    {
        try {
            return $this->mM->softDeleteMatricula($id);
        } catch (\Throwable $th) {
            $this->sendJson(["error" => "Não foi deletar"], 400);
        }
    }
}
