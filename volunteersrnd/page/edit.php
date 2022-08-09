<?php
	ULogin(1);
	Head('Редактирование')?>
	
<?php Menu()?>
<?php Profile(2)?>
<?php 
echo '
<style>
.info {margin-bottom: 75px;}
.profile-box {
	flex-direction: initial;
	align-items: center;
}
.profile-foto{
	height: 55px;
}
.profile-box div {
	width: auto;
	font-size: 0;
}
.profile-background {
	height: 232px;
}
#form1 {
	display: flex;
	flex-wrap: wrap;
}
.button-block {
	flex-basis: 100%;
}
</style>
<div class="info-background">
<div class="subtitle">
	<div>РЕДАКТИРОВАНИЕ</div>
	<a href="/settings">НАСТРОЙКИ</a>
</div>
<div class="info">
	<div class="info-content">
		<form method="POST" id="form1" action="/account/edit" enctype="multipart/form-data">
			<div class="info-black1">
				<div>Загрузка аватара</div>
				<div>Старый пароль</div>
				<div>Новый пароль</div>
				<div>Имя</div>
				<div>Фамилия</div>
				<div>Отчество</div>
				<div>Место работы/учёбы</div>
			</div>
			<div class="info-white1">
				<input type="file" name="avatar" class="upload">
				<input class="input-form" type="password" name="opassword" placeholder="старый пароль" maxlength="15" pattern="[A-Za-z-0-9]{6,15}" title="Не менее 6 и не более 15 латинских символов или цифр">
				<input class="input-form" type="password" name="npassword" placeholder="новый пароль" maxlength="15" pattern="[A-Za-z-0-9]{6,15}" title="Не менее 6 и не более 15 латинских символов или цифр">
				<input class="input-form" type="text" name="name" placeholder="имя" maxlength="10" pattern="[А-Яа-яЁё]{3,10}" title="Не менее 3 и не более 10 русских символов" value="'.$_SESSION['USER_NAME'].'" required>
				<input class="input-form" type="text" name="surname" placeholder="фамилия" maxlength="20" pattern="[А-Яа-яЁё]{3,20}" title="Не менее 3 и не более 20 русских символов" value="'.$_SESSION['USER_SURNAME'].'" required>
				<input class="input-form" type="text" name="patronymic" placeholder="отчество" maxlength="20" pattern="[А-Яа-яЁё]{3,20}" title="Не менее 3 и не более 20 русских символов" value="'.$_SESSION['USER_PATRONYMIC'].'" required>
				<input class="input-form" type="text" name="work" placeholder="место работы/учёбы" maxlength="30" pattern="[А-Яа-яЁё-0-9]{3,30}" title="Не менее 3 и не более 30 русских символов или цыфр" value="'.$_SESSION['USER_WORK'].'" required>	
			</div>
			<div class="button-block">
				<input type="submit" name="enter" value="Сохранить" class="submit-1">
				<button type="reset" class="button-1"><div class="broom"></div></button>
			</div>
		</form>
	</div>
</div>
</div>
';
?>

<?php MessageShow()?>
<?php Footer()?>