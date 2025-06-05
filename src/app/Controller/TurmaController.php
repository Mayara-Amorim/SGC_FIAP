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
