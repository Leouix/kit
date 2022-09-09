<?php

class User {

    public static function save($email, $password) {

        try {
            $db = DB::getConnection();
            $sql = "INSERT INTO `users` (`email`, `password`) VALUES ( ?, ? )";
            $stmt= $db->prepare($sql);
            $stmt->execute([$email, $password ]);

            $_SESSION['username'] = $email;
            header('Location: /admin');

        } catch (PDOException $e) {
            return "Database error: " . $e->getMessage();
        }
    }
}
