<?php 
ULogin(1);
Head(''.$_SESSION['USER_SURNAME'].' '.$_SESSION['USER_NAME'].'') ?>
<?php Menu()?>
<?php Profile(1)?>
<?php 
echo '
<style>
.info-content {
	display: flex;
	flex-wrap: wrap;
}
</style>
<div class="info-background">
<div class="subtitle">
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
		<div>'.$_SESSION['USER_EMAIL'].'</div>
		<div>'.new_date($_SESSION['USER_REGDATE']).'</div>
		<div>'.$_SESSION['USER_WORK'].'</div>
	</div>
	</div>
</div>
<div class="subtitle">
	<div>АКТИВНОСТЬ</div>
</div>
<div class="development">В разработке...</div>
</div>
';
?>

<?php MessageShow()?>
<?php Footer() ?>