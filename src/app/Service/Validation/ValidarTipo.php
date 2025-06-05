<?php
require_once __DIR__ . '/../Service/Validation\ValidationInterface.php';
require_once __DIR__ . '/../Constants/Tipo.php';
class ValidarTipo  implements ValidationInterface
{

    public function validar(array $dados): void
    {
        $data = trim($dados['tipo'] ?? '');

        if (empty($data)) {
            throw new InvalidArgumentException("O tipo é obrigatório.");
        }
        if (!in_array($data, TIPO)) {
            throw new InvalidArgumentException("Tipo não reconhecido!");
        }

        if (strlen($data) < 1) {
            throw new InvalidArgumentException("O tipo deve contem pelo menos 1 caracter");
        }

        if (!preg_match('/^[\p{L}\s]+$/u', $data)) {
            throw new InvalidArgumentException("O tipo deve conter apenas letras.");
        }
    }
}
