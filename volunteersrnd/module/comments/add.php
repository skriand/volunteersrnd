<?php 
ULogin(1);

if ($_POST['enter'] and $_POST['text']) {
	$_POST['text'] = FormChars($_POST['text']);
	$ID = ModuleID($Param['module']);
	if ($ID == 1) $Table = 'news';
	else if ($ID == 2) $Table = 'events';
	$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `address` FROM `$Table` WHERE `address` = '$Param[address]'"));
	if (!$Row['address']) MessageSend(1, 'Материал не найден.', '/');
	mysqli_query($CONNECT, "INSERT INTO `comments`  VALUES ('', '$Row[address]', $ID, '$_SESSION[USER_LOGIN]', '$_POST[text]', NOW(), 0)");
	MessageSend(3, 'Комментарий добавлен.', '/'.$Param['module'].'/'.$Param['address']);
}
?>