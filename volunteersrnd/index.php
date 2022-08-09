<?php include_once 'setting.php';
session_start();
$CONNECT = mysqli_connect(HOST, USER, PASS, DB);
if ($_SESSION['USER_LOGIN_IN'] != 1 and $_COOKIE['user']) {
	$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id`, `login`, `name`, `surname`, `patronymic`, `work`, `email`, `regdate`, `avatar`, `group` FROM `users` WHERE `password` = '$_COOKIE[user]'"));
	$_SESSION['USER_ID'] = $Row['id'];
	$_SESSION['USER_NAME'] = $Row['name'];
	$_SESSION['USER_SURNAME'] = $Row['surname'];
	$_SESSION['USER_PATRONYMIC'] = $Row['patronymic'];
	$_SESSION['USER_WORK'] = $Row['work'];
	$_SESSION['USER_EMAIL'] = $Row['email'];
	$_SESSION['USER_REGDATE'] = $Row['regdate'];
	$_SESSION['USER_AVATAR'] = $Row['avatar'];
	$_SESSION['USER_LOGIN'] = $Row['login'];
	$_SESSION['USER_GROUP'] = $Row['group'];
	$_SESSION['USER_LOGIN_IN'] = 1;
}
if ($_SERVER['REQUEST_URI'] == '/') {
	$Page = 'news';
} else {	$URL_Path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$URL_Parts = explode('/', trim($URL_Path, ' /'));
	$Page = array_shift($URL_Parts);
	$Module = array_shift($URL_Parts);
	if (!empty($Module)) {
		$Param = array();
		for ($i = 0; $i < count($URL_Parts); $i++) {
			$Param[$URL_Parts[$i]] = $URL_Parts[++$i];
		}
	}
}
	
if ($Page == 'index') include('page/index.php');
else if ($Page == 'login' and !$Module) include('page/login.php');
else if ($Page == 'register' and !$Module) include('page/register.php');
else if ($Page == 'account') include('form/account.php');
else if ($Page == 'user' and $Module == $_SESSION['USER_LOGIN'] and !$Param) include('page/profile.php');
else if ($Page == 'user' and !$Param) include('page/user.php');
else if ($Page == 'restore' and !$Module) include('page/restore.php');
else if ($Page == 'edit' and !$Module) include('page/edit.php');
else if ($Page == 'settings' and !$Module) include('page/settings.php');
else if ($Page == 'news') include('module/news/main.php');
else if ($Page == 'category') include('module/news/main.php');
else if ($Page == 'post' and $Module != '') include('module/news/material.php');
else if ($Page == 'edit' and $Module == 'post') include('module/news/edit.php');
else if ($Page == 'control' and $Module == 'post') include('module/news/control.php');
else if ($Page == 'events') include('module/events/main.php');
else if ($Page == 'event' and $Module != '') include('module/events/material.php');
else if ($Page == 'edit' and $Module == 'event') include('module/events/edit.php');
else if ($Page == 'comments') {
	if ($Module == 'add') include('module/comments/add.php');
	else if ($Module == 'control') include('module/comments/control.php');
}
else include('page/404.php');

function ULogin($p1) {
	if ($p1 <= 0 and $_SESSION['USER_LOGIN_IN'] != $p1) MessageSend(1, 'Данная страница доступна только для гостей.', '/');
	else if ($_SESSION['USER_LOGIN_IN'] != $p1) MessageSend(1, 'Данная станица доступна только для пользователей.', '/');
}
	
function MessageSend($p1, $p2, $p3 = '') {
	if ($p1 == 1) $p1 = 'Ошибка';
	else if ($p1 == 2) $p1 = 'Подсказка';
	else if ($p1 == 3) $p1 = 'Информация';
	$_SESSION['message'] = '<div class="parent"><div class="messageBlock"><b>'.$p1.'</b><br>'.$p2.'</div></div>';
	if ($p3) $_SERVER['HTTP_REFERER']  = $p3;
	exit(header('Location: '.$_SERVER['HTTP_REFERER']));
}

function Category($p1) {
	if ($p1 == 1) return 'ВАЖНО';
	else if ($p1 == 2) return 'МЕРОПРИЯТИЯ';
	else if ($p1 == 3) return 'ПРОЧЕЕ';
}

function RandomString($p1) {
	$Char = '0123456789abcdefghijklmnopqrstuvwxyz';
	for ($i = 0; $i < $p1; $i ++) $String .= $Char[rand(0, strlen($Char) - 1)];
	return $String;}

function MessageShow() {
	if ($_SESSION['message'])$Message = $_SESSION['message'];
	echo $Message;
	$_SESSION['message'] = array();
}

function UserGroup($p1) {
	if ($p1 == 0) return 'Волонтёр';
		else if ($p1 == 1) return 'Редактор';
			else if ($p1 == 2) return 'Администратор';
				else if ($p1 == -1) return 'Заблокирован';
}

function translit($s) {
  $s = (string) $s; // преобразуем в строковое значение
  $s = strip_tags($s); // убираем HTML-теги
  $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
  $s = preg_replace("/\s+/", ' ', $s); // удаляем повторяющие пробелы
  $s = trim($s); // убираем пробелы в начале и конце строки
  $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
  $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
  $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s); // очищаем строку от недопустимых символов
  $s = str_replace(" ", "-", $s); // заменяем пробелы знаком минус
  return $s; // возвращаем результат
}

function UAccess($p1) {
	if ($_SESSION['USER_GROUP'] < 0 and $_SESSION['USER_LOGIN'] == '') MessageSend(1, 'У вас нет прав доступа для просмотра данной страницы.', '/');
}

function FormChars ($p1) {
	return nl2br(htmlspecialchars(trim($p1), ENT_QUOTES), false);
}

function GenPass ($p1, $p2) {
	return md5('MRSHIFT'.md5('321'.$p1.'123').md5('678'.$p2.'890'));
}
	
function PageSelector($p1, $p2, $p3, $p4) {
/*
$p1 - URL (Например: /news/main/page)
$p2 - Текущая страница (из $Param['page'])
$p3 - Кол-во новостей
$p4 - Кол-во записей на странице
*/
	$Page = ceil($p3[0] / $p4); //делим кол-во новостей на кол-во записей на странице.
	if ($Page > 1) { //А нужен ли переключатель?
		echo '<div class="PageSelector">';
		for($i = ($p2 - 3); $i < ($Page + 1); $i++) {
			if ($i > 0 and $i <= ($p2 + 3)) {
				if ($p2 == $i) $Swch = 'SwchItemCur';
				else $Swch = 'SwchItem';
				echo '<a class="'.$Swch.'" href="'.$p1.$i.'">'.$i.'</a>';
			}
		}
		echo '</div>';
	}
}

function MenuSelect($p1) {
	if ($_COOKIE['theme'] == 0) echo '<style type="text/css">.'.$p1.' {background: #F2F2F2;}</style>';
	else echo '<style type="text/css">.'.$p1.' {background: #181818;}</style>';
}	

function NewsImg($p1) {
	(bool)preg_match('#<img[^>]+src=[\'"]([^\'"]+)[\'"]#', $p1, $matches);
	if ($matches[1] == '') $matches[1] = '/resource/img/not_img.png';
	return $matches[1];
}

function NewsText($p1) {
	$p1 = preg_replace("'<table[^>]*?>.*?</table>'si","",$p1); 
	$p1 = strip_tags($p1);
	if (mb_strlen($p1) > 250) $p1 = mb_substr($p1, 0, (250 - mb_strlen($p1))).'...';
	return $p1;
}

function ModuleID($p1) {
	if ($p1 == 'post') return 1;
	else if ($p1 == 'event') return 2;
	else MessageSend(1, 'Модуль не найден.', '/');
}
	
function new_date($a) {
	date_default_timezone_set('Europe/Moscow');
	$a = strtotime($a);
	$ndate = date('d.m.Y', $a);
	$ndate_time = date('H:i', $a);
	$ndate_exp = explode('.', $ndate);
	$nmonth = array(
		1 => 'января',
		2 => 'февраля',
		3 => 'марта',
		4 => 'апреля',
		5 => 'мая',
		6 => 'июня',
		7 => 'июля',
		8 => 'августа',
		9 => 'сентября',
		10 => 'октября',
		11 => 'ноября',
		12 => 'декабря'
	);

	foreach ($nmonth as $key => $value) {
		if($key == intval($ndate_exp[1])) $nmonth_name = $value;
	}

	if($ndate == date('d.m.Y')) return 'сегодня в '.$ndate_time;
	else if($ndate == date('d.m.Y', strtotime('-1 day'))) return 'вчера в '.$ndate_time;
	else if($ndate == date('d.m.Y', strtotime('+1 day'))) return 'завтра в '.$ndate_time;
	else return $ndate_exp[0].' '.$nmonth_name.' '.$ndate_exp[2].' в '.$ndate_time;
}	
	
function Head($p1, $p2 = 0) {
	if ($_COOKIE['theme'] == 1) $HeadCSS = '<link rel="stylesheet" type="text/css" href="/resource/css/style_black.css"><link rel="stylesheet" type="text/css" href="/resource/css/form_black.css">';
	if ($p2 == 1) $TinyMCE = '<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=i7fcnjh8m65gmoa5s8z958vu2r3hgz4fvxtbanlgzfwemjwx"></script>
								<script type="text/javascript" src="/resource/js/tinymce.js"></script>	';
	if ($p2 == 2) {
		$Map = '<script async type="text/javascript" src="/resource/js/map.js"></script>';
		$Yandex = '<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>';
	}
	if ($p2 == 3) {
		$TinyMCE = '<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=i7fcnjh8m65gmoa5s8z958vu2r3hgz4fvxtbanlgzfwemjwx"></script>
								<script type="text/javascript" src="/resource/js/tinymce.js"></script>	';
		$Map = '<script async type="text/javascript" src="/resource/js/map.js"></script>';
		$Yandex = '<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>';
	}
	echo '<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8" />
			<title>'.$p1.'</title>
			<meta name="keywords" content="" />
			<meta name="description" content="" />
			<link rel="stylesheet" type="text/css" href="/resource/css/style.css">
			<link rel="stylesheet" type="text/css" href="/resource/css/form.css">
			'.$HeadCSS.'
			<link rel="shortcut icon" href="/resource/img/favicon.png" type="image/png">
			<meta name="viewport" content="width=device-width" />
			<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
			'.$TinyMCE.'
			'.$Yandex.'
			<script async src="/resource/js/onclick.js"></script>
			<script async type="text/javascript" src="/resource/js/up.js"></script>
			<script async type="text/javascript" src="/resource/js/menu.js"></script>
			<script async type="text/javascript" src="/resource/js/slider.js"></script>
			<script async type="text/javascript" src="/resource/js/share.js"></script>	
			'.$Map.'				
		</head>';
}
function Menu($p1 = 0, $p2 = '') {
	if ($_SESSION['USER_AVATAR'] == 0) $Avatar = 0;
	else $Avatar = $_SESSION['USER_AVATAR'].'/'.$_SESSION['USER_ID'];
	if ($_SESSION['USER_LOGIN_IN'] != 1) { 
		$Menu = '<a href="/login"><div class="login-box">ВХОД</div></a><a href="/register"><div class="register-box">РЕГИСТРАЦИЯ</div></a>';
		$MenuName = '<div class="menu-name"><div id="menu-avatar"></div><div>ВОЛОНТЁР?</div></div>
				<a href="/login" class="menu-name-a">Войти</a>
				<a href="/register" class="menu-name-a">Зарегистрироваться</a>';
	}
	else {
		$Menu = '<style>.logo-profile{background-image: url(/resource/avatars/'.$Avatar.'.jpg);}</style>
				<a href="/user/'.$_SESSION['USER_LOGIN'].'"><div class="logo-box1"><div class="logo1">
					<div class="logo-profile"></div>
				</div>
				<div class="logo-text" id="logo-text-2">'.$_SESSION['USER_NAME'].'</div>
				</div></a>';	
		$MenuName = '<a href="/user/'.$_SESSION['USER_LOGIN'].'" class="menu-name"><div id="menu-avatar"></div><div>'.mb_strtoupper($_SESSION['USER_SURNAME']).'<br>'.mb_strtoupper($_SESSION['USER_NAME']).'</div></a>
				<a href="/edit" class="menu-name-a">Редактировать</a>
				<a href="/settings" class="menu-name-a">Настройки</a>
				<a href="/account/logout" class="menu-name-a">Выйти</a>';
	}
	if ($p1 == 1) $ButtonsBottom = '<a href="'.$p2.'" class="button_bottom"><img src="/resource/img/edit.png"></a><a href="" class="button_bottom"><img src="/resource/img/mistake.png"></a>';
	else if ($p1 == 3) $ButtonsBottom = '<a href="" class="button_bottom"><img src="/resource/img/mistake.png"></a>';
	else if ($p1 == 2 and $_SESSION['USER_GROUP'] >= 0 and $_SESSION['USER_LOGIN'] != '') $ButtonsBottom = '<div class="button_bottom" onclick="add_news_button()"><img src="/resource/img/plus.png"></div>';
	
	echo '<body>
			<div class="nav">
				<div class="menu-open" onclick="menu_open()"><img src="/resource/img/menu.png"></div>
				<div class="inside-nav">
					<div class="nav-center">
						<a class="n-nav" href="/"><div class="news-box"><img class="news-box-img" src="/resource/img/news_shadow.png"></div></a>
						<a class="n-nav" href="/events"><div class="events-box"><img class="news-box-img" src="/resource/img/events_shadow2.png"></div></a>
						'.$Menu.'
					</div>
				</div>
				<div class="under-nav"></div>
			</div>
			<div class="nav-name"><p>ВОЛОНТЁРСКИЙ КОРПУС Г. РОСТОВА-НА-ДОНУ</p></div>
			<div class="buttons_bottom">
				<div class="buttons_bottom2">'.$ButtonsBottom.'<a href="#" class="scrollup"><div><img src="/resource/img/up.png"></div></a></div>
			</div>
			<div id="menu">
				<div class="menu">
					<div class="from_menu">
						<p class="menu-subtitle">Вы</p>
						<style>#menu-avatar{background-image: url(/resource/avatars/'.$Avatar.'.jpg);}</style>
						'.$MenuName.'
						<p class="version">beta 0.4.54</p>
					</div>
					<div class="from_menu">
						<p class="menu-subtitle">Список волонтёров</p>
					</div>
				</div>
			</div>
			<div id="menu-under" onclick="menu_open()"></div>
            <div class="container">
			';
}
function Profile($p1) {
	if ($p1 == 1) $ButtonProfile = '<a href="/edit" class="ar"><div>Изменить</div></a>';
	else if ($p1 == 2) $ButtonProfile = '<a href="#" onclick="history.back();"><div>Вернуться</div></a>';
	if ($_SESSION['USER_AVATAR'] == 0) $Avatar = 0;	else $Avatar = $_SESSION['USER_AVATAR'].'/'.$_SESSION['USER_ID'];
	echo 		'		'.MenuSelect('logo-box1').'
						<div class="info-head">						
							<img class="profile-background" src="/resource/avatars/'.$Avatar.'.jpg">
							<div class="profile-box">
								<div>'.UserGroup($_SESSION['USER_GROUP']).'</div>
								<div><img class="profile-foto" src="/resource/avatars/'.$Avatar.'.jpg"></div>
								<div>'.$_SESSION['USER_LOGIN'].'</div>
							</div>
						</div>
						<div class="info-profile">
							<a href="/user/'.$_SESSION['USER_LOGIN'].'"><div class="info-initials">'.$_SESSION['USER_SURNAME'].' '.$_SESSION['USER_NAME'].' '.$_SESSION['USER_PATRONYMIC'].'</div></a>
							<div class="info-buttons">
								'.$ButtonProfile.'<a href="/account/logout"><div>Выйти</div></a>
							</div>
						</div>';
}

function LogBlock() {
	if ($_SESSION['USER_LOGIN_IN'] != 1) echo '<div class="logBlock-div"></div><div class="logBlock"><div><div class="t-block">Хотите стать волонтёром?<br>Зарегистрируйтесь!</div><div class="a-block"><a href="/register">Регистрация</a><a href="/login">Вход</a></div></div></div>';
}
function Footer () {
    echo '		</div>
				<footer>	
						<div class="footer-block"> 		
							<img class="volkorp-img" src="/resource/img/favicon.png">		
							<div class="volkorp-text"><div class="vt1">ВОЛОНТЁРСКИЙ КОРПУС   </div><div class="vt5">Г.РОСТОВА-НА-ДОНУ</div><div class="vt6">РНД</div><div class="vt2">© ВКРНД 2017</div></div>
							<a href="https://vk.com/volunteersrnd" target="_blank"><img class="vk-img" src="/resource/img/vk.png"></a>
							<div class="volkorp-text1"><a href="https://vk.com/design.skri" target="_blank" class="volkorp-text1"><div class="vt3">СОЗДАНИЕ САЙТА</div><div class="vt4">АНДРЕЙ СКРИПКИН</div></a></div>
						</div>
				</footer>
				<div class="footer-buttons">
					<a><div>Что нового?</div></a>
					<a><div>Обратная связь</div></a>
				</div>
			</body>
		</html>';
} ?>