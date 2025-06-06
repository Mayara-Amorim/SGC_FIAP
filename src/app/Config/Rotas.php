<?php

class Rotas
{
    public static function getTodas()
    {
        return array_merge(
            self::estudantes(),
            self::turmas(),
            self::matriculas(),
            self::usuarios()

        );
    }

    public static function estudantes()
    {
        return [
            ['/estudantes/createEstudante', 'Controller/EstudanteController@createEstudante', 'POST'],
            ['/estudantes/getAllEstudantes/(\d+)', 'Controller/EstudanteController@getAllEstudantes', 'GET'],
            ['/estudantes/getByIdEstudante/(\d+)', 'Controller/EstudanteController@getByIdEstudante', 'GET'],
            ['/estudantes/editEstudante', 'Controller/EstudanteController@editEstudante', 'POST'],
            ['/estudantes/delete/(\d+)', 'Controller/EstudanteController@deletete', 'DELETE'],
            ['/estudantes/getByAtivoEstudantes', 'Controller/EstudanteController@getByAtivoEstudantes', 'GET'],
            ['/estudantes/getByNome', 'Controller/EstudanteController@getByNome', 'GET'],

        ];
    }

    public static function turmas()
    {
        return [
            ['/turmas/createTurma', 'Controller/TurmaController@createTurma', 'POST'],
            ['/turmas/getAllTurmas/(\d+)', 'Controller/TurmaController@getAllTurmas', 'GET'],
            ['/turmas/getByIdTurma/(\d+)', 'Controller/TurmaController@getByIdTurma', 'GET'],
            ['/turmas/editTurma', 'Controller/TurmaController@editTurma', 'POST'],
            ['/turmas/delete/(\d+)', 'Controller/TurmaController@deletete', 'DELETE'],
            ['/turmas/getByAtivoTurmas', 'Controller/TurmaController@getByAtivoTurmas', 'GET'],
            ['/turmas/getByNome', 'Controller/TurmaController@getByNome', 'GET'],

        ];
    }


    public static function matriculas()
    {
        return [
            ['/matriculas/createMatricula', 'Controller/MatriculaController@createMatricula', 'POST'],
            ['/matriculas/getAllMatriculas', 'Controller/MatriculaController@getAllMatriculas', 'GET'],
            ['/matriculas/getByIdMatricula/(\d+)', 'Controller/MatriculaController@getByIdMatricula', 'GET'],
            ['/matriculas/editmatricula', 'Controller/MatriculaController@editmatricula', 'POST'],
            ['/matriculas/delete/(\d+)', 'Controller/MatriculaController@delete', 'DELETE'],

        ];
    }

    public static function usuarios()
    {
        return [
            ['/usuarios/cadastrarUsuario', 'Controller/UsuarioController@cadastrarUsuario', 'POST'],
            ['/usuarios/logout', 'Controller/UsuarioController@', 'GET'],
            ['/usuarios/login', 'Controller/UsuarioController@login', 'POST'],


        ];
    }
}
