<?php
require_once __DIR__ . '/../Model/TurmaModel.php';
require_once __DIR__ . '/../Model/MatriculaModel.php';
require_once __DIR__ . '/../Constants/Tipo.php';
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../Service/Validation/ValidarNome.php';
require_once __DIR__ . '/../Service/Validation/ValidarTipo.php';
require_once __DIR__ . '/../Service/Validation/ValidarDescricao.php';
class TurmaController extends BaseController
{
    private $tM;
    private  $validadores;

    public function __construct()
    {
        $this->tM = new TurmaModel();
        $this->validadores = [
            new ValidarNome(),
            new ValidarDescricao(),
            new ValidarTipo(),

        ];
    }

    public function createTurma()
    {
        $dados = [
            'nome' => [$_POST["nome"], new ValidarNome()],
            'descricao' => [$_POST["descricao"], new ValidarDescricao()],
            'tipo' => [$_POST["tipo"],  new ValidarTipo()],
        ];

        try {
            foreach ($dados as $validador => $data) {
                $data[1]->validar($data[0]);
            }
            return $this->tM->createTurma($dados['nome'][0], $dados['descricao'][0], $dados['tipo'][0]);
        } catch (\Throwable $th) {
            return $this->sendJson(["error" => $th->getMessage()], 400);
        }
    }

    public function getAllTurmas()
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
        $estudantes = $this->tM->getAllTurmas($offset, $limit, $search, $order);
        return $this->sendJSON([
            "data" => $estudantes["data"],
            "draw" => $_GET["draw"],
            "recordsTotal" => $estudantes["total"],
            "recordsFiltered" => $estudantes["total"]
        ]);
    }


    public function getByIdTurma($id)
    {
        return $this->sendJson($this->tM->getByIdTurma($id));
    }


    public function editTurma($id)
    {
        $dados = [
            'nome' => [$_POST["nome"], new ValidarNome()],
            'descricao' => [$_POST["descricao"], new ValidarDescricao()],
            'tipo' => [$_POST["tipo"],  new ValidarTipo()],
        ];
        try {
            foreach ($dados as $validador => $data) {
                $data[1]->validar($data[0]);
            }
            if (!empty($this->tM->editTurma($id, $dados['nome'][0], $dados['descricao'][0], $dados['tipo'][0]))) {
                $this->sendJson(["error" => false]);
                return;
            }
        } catch (\Throwable $th) {
            return $this->sendJson(["error" => $th->getMessage()], 400);
        }
    }


    public function delete($id)
    {
        if (!empty($this->tM->softDeleteTurma($id))) {
            (new MatriculaModel())->deleteByTurma($id);
            return json_encode([
                'erro' => false
            ]);
        }
        return json_encode([
            'erro' => true
        ]);
    }


    public function getByAtivoTurmas()
    {
        return json_encode($this->tM->getByAtivoTurmas());
    }


    public function getByNome($nome)
    {
        return json_encode($this->tM->getByNome($nome));
    }
}
