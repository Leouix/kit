<?php

class DB
{

    protected static $db;

    public static function getConnection()
    {

        if( is_null(self::$db)) {
            $db_params = include('config/db_params.php');

            try {

                $dsn = "mysql:host={$db_params['host']};dbname={$db_params['dbname']}";
                $user = $db_params['username'];
                $passwd = $db_params['password'];

                self::$db = new PDO($dsn, $user, $passwd);

            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return self::$db;

    }



}
