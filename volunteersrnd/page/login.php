<?php ULogin(0); Head('Вход')?>
<?php Menu()?>
<?php MenuSelect('login-box')?>
<div class="entire-form">
    <div class="head-block">
        <h2>ВХОД</h2>
		<h4>У вас нет аккаунта?<br>Зарегистрируйтесь!</h4>
		<a href="/register">+</a>
    </div>
    <div class="form-block">
        <form method="POST" action="/account/login">
            <input class="input-form" type="text" name="login" placeholder="Логин (псевдоним)" maxlength="10" pattern="[A-Za-z-0-9]{3,10}" title="Не менее 3 и не более 10 латинских символов или цифр" required>
            <input class="input-form" type="password" name="password" placeholder="Пароль" maxlength="15" pattern="[A-Za-z-0-9]{6,15}" title="Не менее 6 и не более 15 латинских символов или цифр" required>
			<img class="captcha" src="/resource/captcha.php" alt="Каптча">
           <input class="input-form" type="number" name="captcha" autocomplete="off" placeholder="Код" maxlength="5" max="99999" required>
			<div class="check"><input type="checkbox" id="remember" name="remember"><label class="remember" for="remember">Запомнить меня</label></div>
            <input class="submit-1" type="submit" name="enter" value="Войти">
			<button type="reset" class="button-1"><div class="broom"></div></button>
			<br><a class="a-remember" href="restore">Забыли пароль?</a>
		</form>
    </div>
</div>
<?php MessageShow()?>
<?php Footer()?>