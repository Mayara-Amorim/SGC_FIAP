<?php
final class ConnectionFactory
{
    public static function getConection()
    {

        return new PDO('mysql:host=localhost;dbname=sgc_fiap', MYSQL_USER, MYSQL_PASSWORD, array(
            PDO::ATTR_PERSISTENT => true
        ));
    }
}
