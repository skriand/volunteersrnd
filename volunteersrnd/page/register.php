<?php ULogin(0); Head('Регистрация') ?>
<?php Menu()?>
<?php MenuSelect('register-box')?>
	<div class="entire-form">
		<div class="head-block">
			<h2>РЕГИСТРАЦИЯ</h2>
			<h4>*стать волонтёром возможно с 15 лет</h4>
		</div>
    <div class="form-block">
			<form method="POST" action="/account/register" required>
				<input class="input-form" type="text" name="login" placeholder="Логин (псевдоним)"  maxlength="10" pattern="[A-Za-z-0-9]{3,10}" title="Не менее 3 и не более 10 латинских символов или цифр" required>
				<input class="input-form" type="email" name="email" placeholder="E-mail" required>
				<input class="input-form" type="password" name="password" placeholder="Пароль" maxlength="15" pattern="[A-Za-z-0-9]{6,10}" title="Не менее 6 и не более 15 латинских символов или цифр" required>
				<input class="input-form" type="text" name="name" placeholder="Имя" maxlength="10" pattern="[А-Яа-яЁё]{3,10}" title="Не менее 3 и не более 10 русских символов" required>
				<input class="input-form" type="text" name="surname" placeholder="Фамилия" maxlength="20" pattern="[А-Яа-яЁё]{3,20}" title="Не менее 3 и не более 20 русских символов" required>
				<input class="input-form" type="text" name="patronymic" placeholder="Отчество" maxlength="20" pattern="[А-Яа-яЁё]{3,20}" title="Не менее 3 и не более 20 русских символов" required>
				<input class="input-form" type="text" name="work" placeholder="Место работы/учёбы" maxlength="30" pattern="[А-Яа-яЁё]{3,30}" title="Не менее 3 и не более 30 русских символов" required>
				<img class="captcha" src="/resource/captcha.php" alt="Каптча">
				<input class="input-form" type="number" name="captcha" autocomplete="off" placeholder="Код" maxlength="5" max="99999" required>
				<input type="submit" class="submit-1" name="enter" value="Зарегистрироваться">
				<button type="reset" class="button-1"><div class="broom"></div></button>
				<div class="register-text">*Нажимая на кнопку «Зарегистрироваться», Вы даёте согласие на обработку своих персональных данных (включая их получение от Вас и/или от третьих лиц) с учетом требований Федерального закона от 27.07.2006 № 152-ФЗ «О персональных данных» оператору - отделу по делам молодежи Администрации города Ростова-на-Дону.</div>
			</form>
		</div>
	</div>
<?php MessageShow()?>
<?php Footer() ?>
