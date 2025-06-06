<?php
require_once __DIR__ . '/../Model/TurmaModel.php';
require_once __DIR__ . '/../Constants/Tipo.php';
class TurmaController
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

    public function createTurma($nome, $descricao, $tipo)
    {
        $dados = [
            'nome' => $nome,
            'descricao' => $descricao,
            'tipo' => $tipo,
        ];
        try {
            foreach ($this->validadores as $validador) {
                $validador->validar($dados);
            }
        } catch (\Throwable $th) {
            http_response_code(400);
            return json_encode([
                'erro' => true,
                'mensagem' => $th->getMessage()
            ]);
        }
        $this->tM->createTurma($nome, $descricao, $tipo);
        http_response_code(201);
        return  json_encode([
            'erro' => false,
            'mensagem' => "Turma criada com sucesso"
        ]);
    }

    public function getAllTurmas()
    {
        return json_encode($this->tM->getAllTurmas());
    }


    public function getByIdTurma($id)
    {
        return json_encode($this->tM->getByIdTurma($id));
    }


    public function editTurma($id, $nome, $descricao, $tipo)
    {
        if (!empty($this->tM->editTurma($id, $nome, $descricao, $tipo))) {
            json_encode([
                'error' => false
            ]);
        }
        return json_encode([
            'erro' => true
        ]);
    }


    public function delete($id)
    {
        if (!empty($this->tM->softDeleteTurma($id))) {
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
