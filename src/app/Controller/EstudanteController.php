<?php
require_once __DIR__ . '/../Model/EstudanteModel.php';
require_once __DIR__ . '/../Service/Validation/ValidarDataNascimento.php';
require_once __DIR__ . '/../Service/Validation/ValidarEmail.php';
require_once __DIR__ . '/../Service/Validation/ValidarNome.php';

class EstudanteController
{
    private $eM;
    private  $validadores;

    public function __construct()
    {
        $this->eM = new EstudanteModel();
        $this->validadores = [
            new ValidarNome(),
            new ValidarEmail(),
            new ValidarDataNascimento(),
        ];
    }

    public function createEstudante($nome, $dataNascimento, $email)
    {
        $dados = [
            'nome' => $nome,
            'dataNascimento' => $dataNascimento,
            'email' => $email,
        ];

        foreach ($this->validadores as $validador) {
            $validador->validar($dados);
        }
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
