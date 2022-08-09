<?php ULogin(0); Head('Восстановление пароля', 1) ?>
<?php Menu() ?>
<div class="entire-form">
    <div class="head-block">
        <h2>ВОССТАНОВЛЕНИЕ<br>ПАРОЛЯ</h2>
    </div>
    <div class="form-block">
		<form method="POST" action="/account/restore">
			<input class="input-form" type="email" name="email" placeholder="E-mail" required>
			<img class="captcha" src="/resource/captcha.php" alt="Каптча">
            <input class="input-form" type="number" name="captcha" autocomplete="off" placeholder="Код" maxlength="5" max="99999" required>
			<input class="submit-1" type="submit" name="enter" value="Восстановить">
			<button type="reset" class="button-1"><div class="broom"></div></button>
		</form>
    </div>
</div>
<?php MessageShow()?>
<?php Footer() ?>