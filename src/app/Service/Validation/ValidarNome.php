<?php
require_once __DIR__ . '/ValidationInterface.php';
class ValidarNome implements ValidationInterface
{
    public function validar($dados): void
    {
        $nome = htmlspecialchars(trim($dados ?? ''), ENT_QUOTES, 'UTF-8');

        if (empty($nome)) {
            throw new InvalidArgumentException("O nome é obrigatório.");
        }

        if (strlen($nome) < 8) {
            throw new InvalidArgumentException("O nome deve ter pelo menos 8 caracteres.");
        }

        if (!preg_match('/^[\p{L}\p{N}\s]+$/u', $nome)) {
            throw new InvalidArgumentException("O nome deve conter apenas letras.");
        }
    }
}
