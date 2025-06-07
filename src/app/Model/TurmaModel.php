<?php
require_once __DIR__ . "/../Database/ConnectionFactory.php";
class TurmaModel
{
    public $db;

    public function __construct()
    {
        $this->db = ConnectionFactory::getConection();
    }

    public function createTurma($nome, $descricao, $tipo)
    {
        $st = $this->db->prepare('INSERT INTO TB_TURMAS (nome, descricao, tipo) VALUES(?,?,?)');
        $st->bindParam(1, $nome, PDO::PARAM_STR);
        $st->bindParam(2, $descricao, PDO::PARAM_STR);
        $st->bindParam(3, $tipo, PDO::PARAM_STR);

        $st->execute();
        return $this->db->lastInsertId();
    }
    public function editTurma($id, $nome, $descricao, $tipo)
    {
        $st = $this->db->prepare('UPDATE TB_TURMAS SET nome=?, descricao=?, tipo=? WHERE id= ?');
        $st->bindParam(1, $nome, PDO::PARAM_STR);
        $st->bindParam(2, $descricao, PDO::PARAM_STR);
        $st->bindParam(3, $tipo, PDO::PARAM_STR);
        $st->bindParam(4, $id, PDO::PARAM_INT);
        $st->execute();
    }
    public function softDeleteTurma($id)
    {
        $st = $this->db->prepare('UPDATE TB_TURMAS SET ativa = 0, desativado_em = CURRENT_DATE WHERE id = ?');
        $st->bindParam(1, $id, PDO::PARAM_INT);
        return $st->execute();
    }
    public function getAllTurmas($offset = 0, $limit = 15, $search = '', $order = null)
    {
        $sql = "SELECT * FROM TB_TURMAS where ativa=1";
        $sqlCount = "SELECT COUNT(*) FROM TB_TURMAS  where ativa=1";
        $params = [];

        if (!empty($search)) {
            $sql .= " and nome LIKE :search";
            $sqlCount .= " and nome LIKE :search";
            $params[':search'] = "%$search%";
        }
        if (!empty($order)) {
            $coluna = preg_replace('/[^a-zA-Z0-9_]/', '', $order[0]);
            $direcao = strtoupper($order[1]) === 'DESC' ? 'DESC' : 'ASC';
            $sql .= " ORDER BY $coluna $direcao";
        }
        if ($limit && $offset > -1) {
            $sql .= " LIMIT :limit OFFSET :offset";
            $params[':limit'] = (int) $limit;
            $params[':offset'] = (int) $offset;
        }

        // Preparar e executar SELECT
        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $value) {
            $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue($key, $value, $type);
        }
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $countStmt = $this->db->prepare($sqlCount);
        if (!empty($search)) {
            $countStmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        }
        $countStmt->execute();
        $count = $countStmt->fetchColumn();

        return [
            'data' => $data,
            'total' => $count,
        ];
    }
    public function getByAtivoTurmas()
    {
        $st = $this->db->query('SELECT * FROM TB_TURMAS WHERE ativa=1');
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getByIdTurma($id)
    {
        $st = $this->db->prepare('SELECT * FROM TB_TURMAS WHERE id= ?');
        $st->bindParam(1, $id, PDO::PARAM_INT);
        $st->execute();
        return $st->fetch(PDO::FETCH_ASSOC);
    }
    public function getByNome($nome)
    {
        $st = $this->db->prepare('SELECT * FROM TB_TURMAS where nome=?');
        $st->bindParam(1, $nome, PDO::PARAM_STR);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
}
