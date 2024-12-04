<?php
/* @var $this yii\web\View */
$this->title = 'Авторизация';
?>
<div id="form_container">

    <h1>Авторизация</h1>
    <div class="form-header">
        <img src="/img/login_logo.png"/>
    </div>
    <div class="form-main">
        <form id="formlogin" enctype="application/x-www-form-urlencoded">
            <input type="text" name="login" id="login" maxlength="30" data-type="text" class="form-control" placeholder="Пользователь">
            <input type="password" name="pass" id="password" data-type="pass" class="form-control" maxlength="30" placeholder="Пароль">
            <input type="submit" name="submit" id="submit" value="Войти" class="btn btn-block signin btnLogin">
        </form>
    </div>
</div>
