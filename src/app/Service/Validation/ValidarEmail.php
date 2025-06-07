<?php
require_once __DIR__ . '/ValidationInterface.php';
class ValidarEmail  implements ValidationInterface
{
    public function validar($dados): void
    {
        $email = htmlspecialchars(trim($dados ?? ''), ENT_QUOTES, 'UTF-8');

        if (empty($email)) {
            throw new InvalidArgumentException("O e-mail é obrigatório.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Formato de e-mail inválido.");
        }
    }
}
