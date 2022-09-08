<?php

// CREATE TABLE `kit`.`users` ( `id` INT NOT NULL AUTO_INCREMENT ,  `email` VARCHAR(255) NOT NULL ,  `password` VARCHAR(255) NOT NULL ,    PRIMARY KEY  (`id`),    UNIQUE  (`email`)) ENGINE = InnoDB;

class User {

    public static function save($email, $password) {
        echo __CLASS__ . ': ' . __FUNCTION__ . ': ' . '$email';
        echo "<pre>";
        print_r( $email );
        echo "</pre>";

        echo __CLASS__ . ': ' . __FUNCTION__ . ': ' . '$password';
        echo "<pre>";
        print_r( $password );
        echo "</pre>";

        try {
            $db = DB::getConnection();
            $sql = "INSERT INTO `users` (`email`, `password`) VALUES ( ?, ? )";
            $stmt= $db->prepare($sql);
            $stmt->execute([$email, $password ]);

            $_SESSION['username'] = $email;
            header('Location: /');

        } catch (PDOException $e) {
            return "Database error: " . $e->getMessage();
        }
    }
}
