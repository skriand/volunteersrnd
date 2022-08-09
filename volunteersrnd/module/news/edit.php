<?php 
UAccess(2);
if (!$Param['address']) MessageSend(1, 'Не указан адрес новости.', '/');
$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `cat`, `name`, `text`, `active` FROM `news` WHERE `address` = '$Param[address]'"));
if (!$Row['name']) MessageSend(1, 'Новость не найдена.', '/');

if (($_POST['enter1'] or $_POST['enter2'] or $_POST['enter3']) and $_POST['text'] and $_POST['name'] and $_POST['cat']) {
	$MaxId = mysqli_fetch_row(mysqli_query($CONNECT,"SELECT MAX(`id`) FROM `news`"));
	$MaxId[0]++;
	if ($_POST['enter1']) ', `active` = 1';
	else if ($_POST['enter2']) $Active = ', `active` = 0';
	else if ($_POST['enter3'] and $Row[active] != 2) $Active = ', `active` = 2';
	if ($Row[active] != 2){
		$MaxID = mysqli_fetch_row(mysqli_query($CONNECT,"SELECT MAX(`id`) FROM `news`"));
		$MaxID[0]++;
		$ResultID = ', `id` = '.$MaxId[0];
		$Date = ', `date` = '.NOW();
	}
	$_POST['name'] = FormChars($_POST['name']);
	$allowed_tags = '<br><div><span><img><ul><li><table><thead><tr><th><tbody><td><p>'; //Перечислите теги которые можно НЕ удалять
	$_POST['text'] = strip_tags($_POST['text'], $allowed_tags);
	$_POST['cat'] += 0;
	mysqli_query($CONNECT, "UPDATE `news` SET `name` = '$_POST[name]', `cat` = $_POST[cat], `text` = '$_POST[text]'".$ResultID.$Date." WHERE `address` = '$Param[address]'");
	MessageSend(2, 'Новость отредактирована.', '/post/'.$Param['address']);
}

Head('Редактирование новости', 1) ?>
<?php Menu()?>
<?php MenuSelect('news-box')?>
    <?php 
    
    echo'
	<div class="post-form">
        <form method="POST" action="/edit/post/address/'.$Param['address'].'">
			<div class="post-form-title">
				<p>ЗАГОЛОВОК'.$MaxId[0].'</p>
				<p><input type="text" name="name" placeholder="Заголовок" value="'.$Row['name'].'" required></p>
			</div>
			<div class="post-form-cat">
				<p>КАТЕГОРИЯ</p>
				<p>'.str_replace('value="'.$Row['cat'], 'checked value="'.$Row['cat'],'
					<div><input type="radio" name="cat" value="1" id="post-radio-1"/><label for="post-radio-1" class="post-form-label">ВАЖНО</label></div>
					<div><input type="radio" name="cat" value="2" id="post-radio-2"/><label for="post-radio-2" class="post-form-label">МЕРОПРИЯТИЯ</label></div>
					<div><input type="radio" name="cat" value="3" id="post-radio-3"/><label for="post-radio-3" class="post-form-label">ПРОЧЕЕ</label>').'</div>
				</p>
			</div>
			<div class="post-form-line"></div>
			<div class="post-form-text"><textarea name="text" required>'.$Row['text'].'</textarea>';
			if ($_SESSION['USER_GROUP'] == 0) echo '<input type="submit" name="enter1" value="Отправить" class="submit-1">';
			if ($_SESSION['USER_GROUP'] >= 1 and $Row[active] != 2) echo '<input type="submit" name="enter2" value="Сохранить" class="submit-1">';
			if ($_SESSION['USER_GROUP'] >= 1) echo '<input type="submit" name="enter3" value="Опубликовать" class="submit-1">';
			echo '<a href="/control/post/address/'.$Param['address'].'/command/delete" class="a-1">Удалить новость</a>
			<button type="reset" class="button-1"><div class="broom"></div></button></div>
		</form>
    </div>';?>
<?php MessageShow()?>
<?php Footer()?>