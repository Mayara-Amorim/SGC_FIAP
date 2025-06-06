<?php

class Rotas
{
    public static function getTodas()
    {
        return array_merge(
            self::estudantes(),
            self::turmas(),
            self::matriculas(),
            self::usuarios(),

        );
    }

    public static function estudantes()
    {
        return [
            ['/estudantes/createEstudante', 'Controller/EstudanteController@createEstudante', 'POST', [AuthMiddleware::class]],
            ['/estudantes/getAllEstudantes', 'Controller/EstudanteController@getAllEstudantes', 'GET', [AuthMiddleware::class]],
            ['/estudantes/getByIdEstudante/(\d+)', 'Controller/EstudanteController@getByIdEstudante', 'GET', [AuthMiddleware::class]],
            ['/estudantes/editEstudante/(\d+)', 'Controller/EstudanteController@editEstudante', 'POST', [AuthMiddleware::class]],
            ['/estudantes/delete/(\d+)', 'Controller/EstudanteController@delete', 'POST', [AuthMiddleware::class]],
            ['/estudantes/getByAtivoEstudantes', 'Controller/EstudanteController@getByAtivoEstudantes', 'GET', [AuthMiddleware::class]],
            ['/estudantes/getByNome', 'Controller/EstudanteController@getByNome', 'GET', [AuthMiddleware::class]],

        ];
    }

    public static function turmas()
    {
        return [
            ['/turmas/createTurma', 'Controller/TurmaController@createTurma', 'POST', [AuthMiddleware::class]],
            ['/turmas/getAllTurmas', 'Controller/TurmaController@getAllTurmas', 'GET', [AuthMiddleware::class]],
            ['/turmas/getByIdTurma/(\d+)', 'Controller/TurmaController@getByIdTurma', 'GET', [AuthMiddleware::class]],
            ['/turmas/editTurma/(\d+)', 'Controller/TurmaController@editTurma', 'POST', [AuthMiddleware::class]],
            ['/turmas/delete/(\d+)', 'Controller/TurmaController@delete', 'POST', [AuthMiddleware::class]],
            ['/turmas/getByAtivoTurmas', 'Controller/TurmaController@getByAtivoTurmas', 'GET', [AuthMiddleware::class]],
            ['/turmas/getByNome', 'Controller/TurmaController@getByNome', 'GET', [AuthMiddleware::class]],

        ];
    }


    public static function matriculas()
    {
        return [
            ['/matriculas/createMatricula', 'Controller/MatriculaController@createMatricula', 'POST', [AuthMiddleware::class]],
            ['/matriculas/getAllMatriculas', 'Controller/MatriculaController@getAllMatriculas', 'GET', [AuthMiddleware::class]],
            ['/matriculas/getByEstudantesInTurma/(\d+)', 'Controller/MatriculaController@getByEstudantesInTurma', 'GET', [AuthMiddleware::class]],
            ['/matriculas/getByIdMatricula/(\d+)', 'Controller/MatriculaController@getByIdMatricula', 'GET', [AuthMiddleware::class]],
            ['/matriculas/editmatricula', 'Controller/MatriculaController@editmatricula', 'POST', [AuthMiddleware::class]],
            ['/matriculas/delete/(\d+)', 'Controller/MatriculaController@delete', 'POST', [AuthMiddleware::class]],

        ];
    }

    public static function usuarios()
    {
        return [
            ['/usuarios/cadastrarUsuario', 'Controller/UsuarioController@cadastrarUsuario', 'POST', [AuthMiddleware::class]],
            ['/usuarios/logout', 'Controller/UsuarioController@logout', 'GET'],
            ['/usuarios/login', 'Controller/UsuarioController@login', 'POST'],
            ['/login', 'Controller/UsuarioController@viewLogin', 'GET'],
            ['/dashboard', 'Controller/UsuarioController@dashboard', 'GET',  [AuthMiddleware::class]],
            ['/', 'Controller/UsuarioController@index', 'GET']

        ];
    }
}
