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


        if(!self::tableUsersExists()) {
            self::tableUsersCreate();

            if(!self::tableItemsExists()) {
                self::tableItemsCreate();
            }

        }

        return self::$db;

    }

    protected static function tableItemsExists() {
        $sql = "SHOW TABLES LIKE 'items'";
        $stm = self::$db->query($sql);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    protected static function tableUsersExists() {
        $sql = "SHOW TABLES LIKE 'users'";
        $stm = self::$db->query($sql);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    protected static function tableItemsCreate() {

        try {
            $sql = " CREATE TABLE `items` (
            `id` INT NOT NULL AUTO_INCREMENT ,
            `title` VARCHAR(255) NOT NULL ,
            `description` TEXT NULL ,
            `parent` INT NULL ,
            `childs` VARCHAR(255) NULL ,
            PRIMARY KEY (`id`)) ENGINE = InnoDB;";
            self::$db->exec($sql);
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    protected static function tableUsersCreate() {
        try {
            $sql = "CREATE TABLE `users` ( 
                `id` INT NOT NULL AUTO_INCREMENT ,  
                `email` VARCHAR(255) NOT NULL ,  
                `password` VARCHAR(255) NOT NULL ,    
                PRIMARY KEY  (`id`),    
                UNIQUE  (`email`)) ENGINE = InnoDB;";
            self::$db->exec($sql);
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

}
