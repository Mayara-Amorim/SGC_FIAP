<?php
require_once 'src\app\Database\ConnectionFactory.php';
class EstudanteModel
{
    public $db;

    public function __construct()
    {
        $this->db = ConnectionFactory::getConection();
    }

    public function createEstudante($nome, $data_nascimeto, $email)
    {
        $st = $this->db->prepare('INSERT INTO TB_ESTUDANTES (nome, data_nascimento, email) VALUES(?,?,?)');
        $st->bindParam(1, $nome, PDO::PARAM_STR);
        $st->bindParam(2, $data_nascimeto, PDO::PARAM_STR);
        $st->bindParam(3, $email, PDO::PARAM_STR);

        $st->execute();
        return $this->db->lastInsertId();
    }
    public function editEstudante($id, $nome, $data_nascimeto, $email)
    {
        $st = $this->db->prepare('UPDATE TB_ESTUDANTES SET nome=?, data_nascimento=?, email=? WHERE id= ?');
        $st->bindParam(1, $nome, PDO::PARAM_STR);
        $st->bindParam(2, $data_nascimeto, PDO::PARAM_STR);
        $st->bindParam(3, $email, PDO::PARAM_STR);
        $st->bindParam(4, $id, PDO::PARAM_INT);
        $st->execute();
    }
    public function softDeleteEstudante($id)
    {
        $st = $this->db->prepare('UPDATE TB_ESTUDANTES SET ativo = 0, desativado_em = CURRENT_DATE WHERE id = ?');
        $st->bindParam(1, $id, PDO::PARAM_INT);
        $st->execute();
    }
    public function getAllEstudantes($offset = 0, $limit = 15, $search = '', $order = null)
    {
        $sql = "SELECT * FROM TB_ESTUDANTES where ativo=1";
        $sqlCount = "SELECT COUNT(*) FROM TB_ESTUDANTES  where ativo=1";
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

    public function getByAtivoEstudantes()
    {
        $st = $this->db->query('SELECT * FROM TB_ESTUDANTES WHERE ATIVO=1');
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getByIdEstudante($id)
    {
        $st = $this->db->prepare('SELECT * FROM TB_ESTUDANTES WHERE id= ?');
        $st->bindParam(1, $id, PDO::PARAM_INT);
        $st->execute();
        return $st->fetch(PDO::FETCH_ASSOC);
    }
    public function getByNome($nome)
    {
        $st = $this->db->prepare('SELECT * FROM TB_ESTUDANTES  where nome like = ?');
        $st->execute(['%' . $nome . '%']);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
}
