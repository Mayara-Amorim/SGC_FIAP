<?php
require_once __DIR__ . '/../Model/TurmaModel.php';
class TurmaController
{
    private $tM;

    public function __construct()
    {
        $this->tM = new TurmaModel();
    }

    public function createTurma($nome, $descricao, $tipo)
    {
        return $this->tM->createTurma($nome, $descricao, $tipo);
    }


    public function getAllTurmas()
    {
        return $this->tM->getAllTurmas();
    }


    public function getByIdTurma($id)
    {
        return $this->tM->getByIdTurma($id);
    }


    public function editTurma($id, $nome, $descricao, $tipo)
    {
        return $this->tM->editTurma($id, $nome, $descricao, $tipo);
    }


    public function delete($id)
    {
        return $this->tM->softDeleteTurma($id);
    }


    public function getByAtivoTurmas()
    {
        return $this->tM->getByAtivoTurmas();
    }


    public function getByNome($nome)
    {
        return $this->tM->getByNome($nome);
    }
}
