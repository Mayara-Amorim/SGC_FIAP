<?php

class AuthMiddleware
{
    public function handle($request, $next)
    {


        if (!isset($_SESSION['usuario_id'])) {
            http_response_code(401);
            echo json_encode(['erro' => 'Usuário não autenticado']);
            exit;
        }

        return $next($request);
    }
}
