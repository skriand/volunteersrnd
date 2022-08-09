<?php 
ULogin(1);
if ($Module) {
$Module = FormChars($Module);
$Info = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id`, `login`, `name`, `surname`, `patronymic`, `work`, `email`, `regdate`, `avatar`, `group` FROM `users` WHERE `login` = '$Module'"));
}
if (!$Info['id']) MessageSend(1, 'Волонтёр не найден.', '/');

if (!$Info['avatar']) $Avatar = 0;
else $Avatar = "$Info[avatar]/$Info[id]";

Head($Info['surname'].' '.$Info['name']) ?>
<?php Menu();

if ($_SESSION['USER_GROUP'] == 2) {
	$ButtonProfile = '<div class="info-buttons"><a href="" class="ar"><div>Изменить</div></a></div>';
	$InfoUser = 
'<div class="subtitle">
	<div>СВЕДЕНИЯ</div>
</div>
<div class="info">
	<div class="info-content">
	<div class="info-black">
		<div>E-mail</div>
		<div>Дата регистрации</div>
		<div>Место работы/учёбы</div>
	</div>
	<div class="info-white">
		<div>'.$Info['email'].'</div>
		<div>'.new_date($Info['regdate']).'</div>
		<div>'.$Info['work'].'</div>
	</div>
	</div>
</div>';
}
echo '
<div class="info-head">						
	<img class="profile-background" src="/resource/avatars/'.$Avatar.'.jpg">
	<div class="profile-box">
		<div>'.UserGroup($Info['group']).'</div>
			<div><img class="profile-foto" src="/resource/avatars/'.$Avatar.'.jpg"></div>
			<div>'.$Info['login'].'</div>
		</div>
	</div>
	<div class="info-profile">
		<a href="/user/'.$Info['login'].'"><div class="info-initials">'.$Info['surname'].' '.$Info['name'].' '.$Info['patronymic'].'</div></a>
		'.$ButtonProfile.'
	</div>
<style>
.info-content {
	display: flex;
	flex-wrap: wrap;
}
</style>
<div class="info-background">
'.$InfoUser.'
<div class="subtitle">
	<div>АКТИВНОСТЬ</div>
</div>
<div class="development">В разработке...</div>
</div>
';
?>

<?php MessageShow()?>
<?php Footer()?>