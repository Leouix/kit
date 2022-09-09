<?php
include ROOT . '/views/templates/header.php';
?>
<div class="container">
    <h1>Вход</h1>
    <form id="form-login" method="POST" action="/login">
        <div class="row">
            <label for="email">Email:</label>
            <input name="email" id="email" autocomplete="off" />
        </div>
        <div class="row">
            <label for="pass">Пароль:</label>
            <input type="password" name="password" id="pass" />
        </div>
        <div class="row">
            <a href="/register">Регистрация</a>
        </div>
        <div class="row">
            <input type="submit" />
        </div>
    </form>
</div>


<?php
include ROOT . '/views/templates/footer.php';
?>
