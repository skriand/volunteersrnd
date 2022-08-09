<?php
function COMMENTS() {
global $CONNECT, $Module, $Page, $Param;
	if ($_SESSION['USER_LOGIN_IN'] != 1) echo '<div class="chat"><div class="chat-nologin">Оставлять комменатрии могут только зарегистрированные пользователи.<div><a href="/register" class="chat-a">Зарегистрироваться</a> <a href="/login" class="chat-a">Войти</a></div></div>';
	else echo '
		<div class="chat">
			<div class="chat-title">
				<style>.chat-avatar {background-image: url(/resource/avatars/'.$_SESSION['USER_AVATAR'].'/'.$_SESSION['USER_ID'].'.jpg);}</style>
				<div class="chat-logo1"><div class="chat-avatar"></div></div>
				<div class="chat-text1">	
					<a href="/user/'.$_SESSION['USER_LOGIN'].'" class="chat-name">'.$_SESSION['USER_SURNAME'].' '.$_SESSION['USER_NAME'].'</a>
				</div>
			</div>
			<form method="POST" action="/comments/add/module/'.$Page.'/address/'.$Module.'" class="chat-form">
				<textarea class="chat-message" name="text" placeholder="Введите текст комментария..." required></textarea>
				<br><input type="submit" name="enter" id="submit-img"><label for="submit-img"><img src="/resource/img/submit_img.png" class="submit-label-img"></label>
			</form>';

	$ID = ModuleID($Page);
	$Count = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT COUNT(`id`) FROM `comments` WHERE `module` = $ID AND `address` = '$Module' AND `response` = 0"));

	if (!$Param['page']) {
		$Param['page'] = 1;
		$Result = mysqli_query($CONNECT, "SELECT `id`, `added`, `date`, `text` FROM `comments` WHERE `module` = $ID AND `address` = '$Module' AND `response` = 0 ORDER BY `id` DESC LIMIT 0, 5");
	} else {
		$Start = ($Param['page'] - 1) * 5;
		$Result = mysqli_query($CONNECT, str_replace('START', $Start, "SELECT `id`, `added`, `date`, `text` FROM `comments` WHERE `module` = $ID AND `address` = '$Module' AND `response` = 0 ORDER BY `id` DESC LIMIT START, 5"));
	}

	PageSelector("/".$Page."/".$Module."/page/", $Param['page'], $Count, 5);
	
	function CommentsR(){
		while ($Row = mysqli_fetch_assoc($Result)) {
		
			$Row1 = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `login`, `name`, `surname`, `avatar`, `group` FROM `users` WHERE `login` = '$Row[added]'"));
			$Row2 = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT `added` FROM `news` WHERE `added` = '$Row1[login]'"));
		
			if ($Row2[0]) $Added = ', автор поста';
			
			echo '<div class="post-comments"><span><a href="/user/'.$Row1['login'].'">'.$Row1['surname'].' '.$Row1['name'].'</a> '.UserGroup($Row1['group']).$Added.' | '.new_date($Row['date']).'</span><br>'.$Row['text'].'</div>';
		}
	}
	
	while ($Row = mysqli_fetch_assoc($Result)) {
	
		$Row1 = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id`, `login`, `name`, `surname`, `avatar`, `group` FROM `users` WHERE `login` = '$Row[added]'"));
		$Row2 = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT `added` FROM `news` WHERE `added` = '$Row1[login]'"));
		
		if (!$Row1['avatar']) $Avatar = 0;
		else $Avatar = "$Row1[avatar]/$Row1[id]";
	
		if ($Row2[0]) $Added = ', автор поста';
		
		if ($_SESSION['USER_GROUP'] >= 1) $EditC = '<div class="chat-buttons"><a href="/comments/control/action/edit/id/'.$Row['id'].'">Изменить</a> <a href="/comments/control/action/delete/id/'.$Row['id'].'">Удалить</a></div>';
		else if ($_SESSION['USER_GROUP'] == 0 and $Row1['login'] == $_SESSION['USER_LOGIN']) $EditC = '<div class="chat-buttons"><a href="/comments/control/action/edit/id/'.$Row['id'].'">Изменить</a></div>';
		
		if ($Row['id'] == $_SESSION['COMMENTS_EDIT']) $Row['text'] = '<form method="POST" action="/comments/control" class="chat-form"><textarea class="chat-message" name="text" placeholder="Введите текст комментария..." required>'.$Row['text'].'</textarea><br><input type="submit" name="save" value="Сохранить" class="submit-1"><input type="submit" name="cancel" value="Отменить" class="submit-1"></form>';
		
		echo '
				<style>#chat-avatar-'.$Row1['id'].' {background-image: url(/resource/avatars/'.$Avatar.'.jpg);}</style>
				<div class="chat-comments">
					<div class="chat-logo"><div class="chat-avatar" id="chat-avatar-'.$Row1['id'].'"></div></div>
					<div class="chat-text">	
						<div><a href="/user/'.$Row1['login'].'"  class="chat-name">'.$Row1['surname'].' '.$Row1['name'].'</a> <div class="chat-subtitle">'.UserGroup($Row1['group']).$Added.' | '.new_date($Row['date']).'</div></div>
						<br><div>'.$Row['text'].'</div>
						'.$EditC.'
					</div>
				</div>';
	}
	echo '</div>';
}
?>