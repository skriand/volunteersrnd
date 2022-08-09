<?php
	ULogin(1);
	Head('Настройки')?>
	
<?php Menu()?>
<?php Profile(2)?>
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
</style>
<div class="info-background">
<div class="subtitle">
	<a href="/edit">РЕДАКТИРОВАНИЕ</a>
	<div>НАСТРОЙКИ</div>
</div>
<div class="info">
	<div class="info-content">
		<form method="POST" action="/account/settings">
			<div class="info-checkbox"><div>Ночной режим (Тёмная тема оформления)</div><div class="info-checkbox-subtitle">Ночной режим будет включен только в этом браузере, пока вы не выйдете из аккаунта.</div><input type="checkbox" id="payt" name="theme" value="1"<?php if ($_COOKIE['theme'] == 1) echo ' checked'?>/><label for="payt"></label></div>
			<div class="button-block">
				<input type="submit" name="enter" value="Сохранить" class="submit-1">
			</div>
		</form>
	</div>
</div>
</div>

<?php MessageShow()?>
<?php Footer()?>