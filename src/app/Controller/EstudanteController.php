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
        $this->validadores = [];
    }

    public function createEstudante()
    {
        $dados = [
            'nome' => [$_POST["nome"], new ValidarNome()],
            'dataNascimento' => [$_POST["dt_nasc"], new ValidarDataNascimento()],
            'email' => [$_POST["email"],  new ValidarEmail()],
        ];
        try {
            foreach ($dados as $validador => $data) {
                $data[1]->validar($data[0]);
            }
            return $this->eM->createEstudante($dados['nome'][0], $dados['dataNascimento'][0], $dados['email'][0]);
        } catch (\Throwable $th) {
            return $this->sendJson(["error" => $th->getMessage()], 400);
        }
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


    public function editEstudante($id)
    {
        $dados = [
            'nome' => [$_POST["nome"], new ValidarNome()],
            'dataNascimento' => [$_POST["dt_nasc"], new ValidarDataNascimento()],
            'email' => [$_POST["email"],  new ValidarEmail()],
        ];

        try {
            foreach ($dados as $validador => $data) {
                $data[1]->validar($data[0]);
            }
            return $this->eM->editEstudante($id, $dados['nome'][0], $dados['dataNascimento'][0], $dados['email'][0]);
        } catch (\Throwable $th) {
            return $this->sendJson(["error" => $th->getMessage()], 400);
        }
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
