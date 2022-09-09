<?php

require_once ROOT . '/components/DB.php';
require_once ROOT . '/models/User.php';

class Auth {

    public static function login() {

        if(!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if(self::verifyCredits($email, $password)) {
                $_SESSION['username'] = $email;
                header('Location: /admin' );
                exit;
            } else {
                $_SESSION['message'] = 'Вы ввели неверные учетные данные';
                header('Location: /login');
                exit;
            }
        }
        include ROOT . '/views/auth/login.php';
    }

    protected static function verifyCredits($email, $password) {
        $passDB = self::getUserPasswordDB($email);
        if( password_verify($password, $passDB)  ){
           return true;
        }
        return false;
    }

    protected static function getUserPasswordDB($email)
    {
        try {
            $db = DB::getConnection();
            $sql = "SELECT password FROM users WHERE email = '$email'";
            $stm = $db->query($sql);
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            if ($result) {
                return $result[0]['password'];
            }
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
        return false;
    }

    public static function register() {

        if(isset($_POST['form_submit']) && $credits = self::validateFormReg() ) {

            $pass1 = $credits['pass1'];
            $email = $credits['email'];

            $password = password_hash($pass1, PASSWORD_BCRYPT, ['cost' => 12,]);
            User::save($email, $password);
        }
        include ROOT . '/views/auth/reg.php';
    }

    protected static function validateFormReg() {

        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

        if( !$email ) {
            $_SESSION['message'] = 'Задайте корректный емейл';
            header('Location: /register');
            exit;
        }

        $pass1 = filter_input(INPUT_POST, 'pass1');
        $pass2 = filter_input(INPUT_POST, 'pass2');

        if(empty($pass1)) {
            $_SESSION['message'] = 'Укажите пароль';
            header('Location: /register');
            exit();
        }

        if($pass1 !== $pass2) {
            $_SESSION['message'] = 'Пароли не совпадают';
            header('Location: /register');
            exit();
        }

        return array(
            'email' => $email,
            'pass1' => $pass1
        );
    }

    public static function logout() {
        session_regenerate_id();
        session_destroy();
        header('Location: /');
        exit;
    }

}
