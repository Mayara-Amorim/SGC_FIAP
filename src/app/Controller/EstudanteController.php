<?php
require_once __DIR__ . '/../Model/EstudanteModel.php';
class EstudanteController
{
    private $eM;

    public function __construct()
    {
        $this->eM = new EstudanteModel();
    }

    public function createEstudante($nome, $dataNascimento, $email)
    {
        return $this->eM->createEstudante($nome, $dataNascimento, $email);
    }


    public function getAllEstudantes()
    {
        return $this->eM->getAllEstudantes();
    }


    public function getByIdEstudante($id)
    {
        return $this->eM->getByIdEstudante($id);
    }


    public function editEstudante($id, $nome, $dataNascimento, $email)
    {
        return $this->eM->editEstudante($id, $nome, $dataNascimento, $email);
    }


    public function delete($id)
    {
        return $this->eM->softDeleteEstudante($id);
    }


    public function getByAtivoEstudantes()
    {
        return $this->eM->getByAtivoEstudantes();
    }


    public function getByNome($nome)
    {
        return $this->eM->getByNome($nome);
    }
}
