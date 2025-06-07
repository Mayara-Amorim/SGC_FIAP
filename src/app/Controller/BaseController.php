<?php
class BaseController
{
    function sendJson($array, $status_code = 200)
    {
        header('Content-type:application/json');
        http_response_code($status_code);
        echo json_encode($array);
    }
}
