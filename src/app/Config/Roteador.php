<?php


class Roteador
{
    public static function handle($rotas)
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        $rotaEncontrada = false;

        foreach ($rotas as $rota) {
            [$pattern, $controllerAction, $expectedMethod] = $rota;

            if ($method === $expectedMethod && preg_match("#^$pattern$#", $uri, $matches)) {
                [$controllerName, $action] = explode('@', $controllerAction);
                $fullController = __DIR__ . '/../' . $controllerName;
                $controllerName = explode("/", $controllerName)[1];
                if (class_exists($controllerName)) {
                    $controller = new $controllerName();

                    if (method_exists($controller, $action)) {
                        array_shift($matches);
                        $params = self::extrairParametros($method, $matches);

                        call_user_func_array([$controller, $action], $params);
                        $rotaEncontrada = true;
                        break;
                    }
                }
            }
        }

        if (!$rotaEncontrada) {
            http_response_code(404);
            echo "404 - Página não encontrada";
        }
    }

    private static function extrairParametros($method, $matches)
    {
        if ($method === 'POST' || $method === 'PUT') {
            $contentType = $_SERVER["CONTENT_TYPE"] ?? '';
            if (strpos($contentType, 'application/json') !== false) {
                $input = file_get_contents("php://input");
                $bodyParams = json_decode($input, true);
            } else {
                $bodyParams = $_POST;
            }

            return array_values($bodyParams);
        }

        return $matches;
    }
}
