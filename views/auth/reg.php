<?php
include ROOT . '/views/templates/header.php';
?>
<div class="container">
    <h1>Регистрация</h1>
    <form id="form-reg" method="POST" action="/register">
        <div class="row">
            <label for="email">Email:</label>
            <input name="email" id="email" autocomplete="off" />
        </div>
        <div class="row">
            <label for="pass1">Пароль:</label>
            <input type="password" name="pass1" id="pass1" />
        </div>
        <div class="row">
            <label for="pass2">Повтор пароля:</label>
            <input type="password" name="pass2" id="pass2" />
        </div>
        <div class="row">
            <a href="/login">Вход</a>
        </div>
        <div class="row">
            <input type="submit" name="form_submit" value="Зарегистрирваться">
        </div>
    </form>
</div>


<?php
include ROOT . '/views/templates/footer.php';
?>
