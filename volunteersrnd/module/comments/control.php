<?php
if ($_SESSION['USER_GROUP'] >= 1 or ($_SESSION['USER_GROUP'] == 0 and $Row1['login'] == $_SESSION['USER_LOGIN'])) {

	if ($Param['action'] == 'delete' and $_SESSION['USER_GROUP'] >= 1) {
		mysqli_query($CONNECT, "DELETE FROM `comments` WHERE `id` = $Param[id]");
		MessageSend(3, 'Комментарий удален.');

	} else if ($Param['action'] == 'edit') {
		$_SESSION['COMMENTS_EDIT'] = $Param['id'];
		exit(header('location: '.$_SERVER['HTTP_REFERER']));

	} else if ($_POST['save']) {
		mysqli_query($CONNECT, "UPDATE `comments` SET `text` = '$_POST[text]' WHERE `id` = $_SESSION[COMMENTS_EDIT]");
		unset($_SESSION['COMMENTS_EDIT']);
		MessageSend(3, 'Коментарий изменён.');	
	
	} else if ($_POST['cancel']) {
		unset($_SESSION['COMMENTS_EDIT']);
		MessageSend(3, 'Изменение отмененно.');
	}

} else MessageSend(1, 'У вас нет прав доступа для просмотра данной страницы.', '/');
?>