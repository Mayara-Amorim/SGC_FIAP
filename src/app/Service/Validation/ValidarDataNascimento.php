<?php
require_once __DIR__ . '/../Service/Validation\ValidationInterface.php';
class ValidarDataNascimento  implements ValidationInterface
{

    public function validar(array $dados): void
    {
        $data = trim($dados['dataNascimento'] ?? '');

        if (empty($data)) {
            throw new InvalidArgumentException("A data de nascimento é obrigatória.");
        }

        $d = DateTime::createFromFormat('Y-m-d', $data);
        if (!$d || $d->format('Y-m-d') !== $data) {
            throw new InvalidArgumentException("Data de nascimento inválida. Use o formato YYYY-MM-DD.");
        }
    }
}
