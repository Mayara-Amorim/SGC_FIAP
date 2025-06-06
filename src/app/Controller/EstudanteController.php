<?php
require_once __DIR__ . '/../Model/EstudanteModel.php';
require_once __DIR__ . '/../Service/Validation/ValidarDataNascimento.php';
require_once __DIR__ . '/../Service/Validation/ValidarEmail.php';
require_once __DIR__ . '/../Service/Validation/ValidarNome.php';
require_once __DIR__ . '/BaseController.php';

class EstudanteController extends BaseController
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
        $offset = $_GET["start"] ?? 0;
        $limit = $_GET["length"] ?? 25;
        $search = $_GET["search"];
        $columns = $_GET["columns"];
        $order = $_GET["order"];
        if (!empty($search)) {
            $search = $search["value"];
        }
        if (!empty($order)) {
            $order = $order[0];
            $order = [$columns[$order["column"]]["name"], $order["dir"]];
        } else {
            $order = ["nome", "ASC"];
        }

        if ($limit == -1) {
            $limit = null;
        }
        $estudantes = $this->eM->getAllEstudantes($offset, $limit, $search, $order);
        return $this->sendJSON([
            "data" => $estudantes["data"],
            "draw" => $_GET["draw"],
            "recordsTotal" => $estudantes["total"],
            "recordsFiltered" => $estudantes["total"]
        ]);
    }


    public function getByIdEstudante($id)
    {
        $data = $this->eM->getByIdEstudante($id);
        if (empty($data)) {
            http_response_code(404);
            return false;
        }
        header("Content-type: application/json");
        echo json_encode($data);
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
