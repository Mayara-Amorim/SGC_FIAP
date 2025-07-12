<?php
final class ConnectionFactory
{
    public static function getConection()
    {
        $dbHost = getenv('DB_HOST');
        $dbUser = getenv('DB_USER');
        $dbPassword = getenv('DB_KEY');
        $dsn = $dbHost;
        error_log(sprintf("dsn: %s - user: %s - pwd: %s", $dsn, $dbUser, $dbPassword));
        $conn = new PDO($dsn, $dbUser, $dbPassword, array(
            PDO::ATTR_PERSISTENT => true
        ));


        return $conn;
    }
}
