<?php
require_once 'src\app\Controller\EstudanteController.php';
require_once 'src\app\Config\Rotas.php';
require_once 'src\app\Config\Roteador.php';
define("MYSQL_USER", getenv('db_user'));
define("MYSQL_HOST", getenv('db_host'));
define("MYSQL_PASSWORD", getenv('db_key'));


spl_autoload_register(function ($class) {
    $baseDir = __DIR__ . '/src/app/';
    $classPath = str_replace('\\', '/', $class) . '.php';

    $file = $baseDir . $classPath;
    if (file_exists($file)) {
        require_once $file;
    }
});

$qwe = class_exists("EstudanteController");

$rotas = Rotas::getTodas();
Roteador::handle($rotas);
