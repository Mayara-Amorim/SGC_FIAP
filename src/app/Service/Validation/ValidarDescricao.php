<?php
require_once __DIR__ . '/ValidationInterface.php';
class ValidarDescricao implements ValidationInterface
{
    public function validar(array $dados): void
    {
        $descricao = htmlspecialchars(trim($dados['descricao'] ?? ''), ENT_QUOTES, 'UTF-8');

        if (empty($descricao)) {
            throw new InvalidArgumentException("A descricao é obrigatória.");
        }

        if (strlen($descricao) < 10) {
            throw new InvalidArgumentException("O descricao deve ter pelo menos 10 caracteres.");
        }

        if (!preg_match('/^[\p{L}\s]+$/u', $descricao)) {
            throw new InvalidArgumentException("O descricao deve conter apenas letras.");
        }
    }
}
