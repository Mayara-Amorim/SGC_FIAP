<?php
require_once 'src\app\Controller\EstudanteController.php';
define("MYSQL_USER", getenv('db_user'));
define("MYSQL_HOST", getenv('db_host'));
define("MYSQL_PASSWORD", getenv('db_key'));
$estudante = new EstudanteController();
$estudante->createEstudante('Aluno 001', '1996-06-04', 'aluno001@teste.com');
