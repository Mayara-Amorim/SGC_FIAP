<?php
final class ConnectionFactory
{
    public static function getConection()
    {
        $dbHost = getenv('DB_HOST');
        $dbUser = getenv('DB_USER');
        $dbPassword = getenv('DB_KEY');
        $dsn = $dbHost;
        return new PDO($dsn, $dbUser, $dbPassword, array(
            PDO::ATTR_PERSISTENT => true
        ));
    }
}
