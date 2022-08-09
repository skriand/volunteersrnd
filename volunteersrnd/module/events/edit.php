<?php 
UAccess(2);
if (!$Param['address']) MessageSend(1, 'Не указан адрес события.', '/');
$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `name`, `place`, `text`, `date_start`, `date_end`, `active` FROM `events` WHERE `address` = '$Param[address]'"));
if (!$Row['name']) MessageSend(1, 'Событие не найдено.', '/');

if (($_POST['enter1'] or $_POST['enter2'] or $_POST['enter3']) and $_POST['text'] and $_POST['name'] and $_POST['cat']) {
	$MaxId = mysqli_fetch_row(mysqli_query($CONNECT,"SELECT MAX(`id`) FROM `events`"));
	$MaxId[0]++;
	if ($_POST['enter1']) ', `active` = 1';
	else if ($_POST['enter2']) $Active = ', `active` = 0';
	else if ($_POST['enter3'] and $Row[active] != 2) $Active = ', `active` = 2';
	if ($Row[active] != 2){
		$MaxID = mysqli_fetch_row(mysqli_query($CONNECT,"SELECT MAX(`id`) FROM `events`"));
		$MaxID[0]++;
		$ResultID = ', `id` = '.$MaxId[0];
	}
	$_POST['name'] = FormChars($_POST['name']);
	$allowed_tags = '<br><div><span><img><ul><li><table><thead><tr><th><tbody><td><p>'; //Перечислите теги которые можно НЕ удалять
	$_POST['text'] = strip_tags($_POST['text'], $allowed_tags);
	$_POST['date'] = FormChars($_POST['date']);
	$_POST['place'] = FormChars($_POST['place']);
	mysqli_query($CONNECT, "UPDATE `events` SET `name` = '$_POST[name]', `date_start` = $_POST[date_start], `date_end = $_POST[date_end]`, `place` = $_POST[place], `text` = '$_POST[text]'".$ResultID." WHERE `address` = '$Param[address]'");
	MessageSend(2, 'Событие отредактировано.', '/post/'.$Param['address']);
}

Head('Редактирование события', 3) ?>
<?php Menu()?>
<?php MenuSelect('events-box')?>
    <?php 
    
    echo'
	<script>
ymaps.ready(init);

function init(){     

    var myMap;

    myMap = new ymaps.Map("map", {
        center: [47.222513, 39.718669],
        zoom: 12
    });

}
</script>
	<div class="events-page">
	<div class="map-block"><div id="map"></div></div>
	<div class="events-block">
	<div class="post-form">
        <form method="POST" action="/edit/post/address/'.$Param['address'].'">
			<div class="post-form-title">
				<p>ЗАГОЛОВОК'.$MaxId[0].'</p>
				<p><input type="text" name="name" placeholder="Заголовок" value="'.$Row['name'].'" required></p>
			</div>
			<div class="post-form-cat">
				<p>ДАТА НАЧАЛА</p>
				<p><input type="datetime" name="date_start" placeholder="Дата начала" value="'.$Row['date_start'].'" required></p>
			</div>
			<div class="post-form-cat">
				<p>ДАТА ОКОНЧАНИЯ</p>
				<p><input type="datetime" name="date_end" placeholder="Дата начала" value="'.$Row['date_end'].'" required></p>
			</div>
			<div class="post-form-cat">
				<p>МЕСТО ПРОВЕДЕНИЯ</p>
				<p><input type="text" name="place" placeholder="Место проведения" value="'.$Row['place'].'" required></p>
			</div>
			<div class="post-form-line"></div>
			<div class="post-form-text"><textarea name="text" required>'.$Row['text'].'</textarea>';
			if ($_SESSION['USER_GROUP'] == 0) echo '<input type="submit" name="enter1" value="Отправить" class="submit-1">';
			if ($_SESSION['USER_GROUP'] >= 1 and $Row[active] != 2) echo '<input type="submit" name="enter2" value="Сохранить" class="submit-1">';
			if ($_SESSION['USER_GROUP'] >= 1) echo '<input type="submit" name="enter3" value="Опубликовать" class="submit-1">';
			echo '<a href="/control/post/address/'.$Param['address'].'/command/delete" class="a-1">Удалить событие</a>
			<button type="reset" class="button-1"><div class="broom"></div></button></div>
		</form>
    </div></div></div>';?>
<?php MessageShow()?>
<?php Footer()?>