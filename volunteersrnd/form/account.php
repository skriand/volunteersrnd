<?php 
if ($Module == 'logout' and $_SESSION['USER_LOGIN_IN'] == 1) {
	if ($_COOKIE['user']) {
		setcookie('user', '', strtotime('-30 days'), '/');
		unset($_COOKIE['user']);
	}
	if ($_COOKIE['theme']) {
		setcookie('theme', '', strtotime('-30 days'), '/');
		unset($_COOKIE['theme']);
	}
	session_unset();
	exit(header('Location: /login'));
}


if ($Module == 'edit' and $_POST['enter']) {
	ULogin(1);
	$_POST['opassword'] = FormChars($_POST['opassword']);
	$_POST['npassword'] = FormChars($_POST['npassword']);
	$_POST['name'] = FormChars($_POST['name']);
	$_POST['surname'] = FormChars($_POST['surname']);
	$_POST['patronymic'] = FormChars($_POST['patronymic']);
	$_POST['work'] = FormChars($_POST['work']);

	if ($_POST['opassword'] or $_POST['npassword']) {
		if (!$_POST['opassword']) MessageSend(2, 'Не указан старый пароль.');
		if (!$_POST['npassword']) MessageSend(2, 'Не указан новый пароль.');
		if ($_SESSION['USER_PASSWORD'] != GenPass($_POST['opassword'], $_SESSION['USER_LOGIN'])) MessageSend(2, 'Старый пароль указан не верно.');
		$Password = GenPass($_POST['npassword'], $_SESSION['USER_LOGIN']);
		mysqli_query($CONNECT, "UPDATE `users`  SET `password` = '$Password' WHERE `id` = $_SESSION[USER_ID]");
		$_SESSION['USER_PASSWORD'] = $Password;
	}


	if ($_POST['name'] != $_SESSION['USER_NAME']) {
		mysqli_query($CONNECT, "UPDATE `users`  SET `name` = '$_POST[name]' WHERE `id` = $_SESSION[USER_ID]");
		$_SESSION['USER_NAME'] = $_POST['name'];
	}


	if ($_POST['surname'] != $_SESSION['USER_SURNAME']) {
		mysqli_query($CONNECT, "UPDATE `users`  SET `surname` = '$_POST[surname]' WHERE `id` = $_SESSION[USER_ID]");
		$_SESSION['USER_SURNAME'] = $_POST['surname'];
	}

	if ($_POST['patronymic'] != $_SESSION['USER_PATRONYMIC']) {
		mysqli_query($CONNECT, "UPDATE `users`  SET `patronymic` = '$_POST[patronymic]' WHERE `id` = $_SESSION[USER_ID]");
		$_SESSION['USER_PATRONYMIC'] = $_POST['patronymic'];
	}

	if ($_POST['work'] != $_SESSION['USER_WORK']) {
		mysqli_query($CONNECT, "UPDATE `users`  SET `work` = '$_POST[work]' WHERE `id` = $_SESSION[USER_ID]");
		$_SESSION['USER_WORK'] = $_POST['work'];
	}


	if ($_FILES['avatar']['tmp_name']) {
		
		$upload_photo= $_FILES['avatar']['name']; // загружаемый из формы из поля upload_photo файл
		
		
		
		
		if ($_FILES['avatar']['size'] > 4194304) MessageSend(2, 'Размер файла не должен превышать 4MB.');
    
		if(preg_match('/[.](JPG)|(jpg)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['avatar']['name'])){//проверка формата исходного изображения    
            
			if ($_SESSION['USER_AVATAR'] == 0) {
			$Files = glob('resource/avatars/*', GLOB_ONLYDIR);
			foreach($Files as $num => $Dir) {
				$Num ++;
				$Count = sizeof(glob($Dir.'/*.*'));
				if ($Count < 250) {
					$Download = $Dir.'/';
					$_SESSION['USER_AVATAR'] = $Num;
					mysqli_query($CONNECT, "UPDATE `users`  SET `avatar` = $Num WHERE `id` = $_SESSION[USER_ID]");
					break;
				}
			}
			}
			else $Download = 'resource/avatars/'.$_SESSION['USER_AVATAR'].'/';
		
		
			$path_to_90_directory = $Download;//папка, куда будет загружаться начальная картинка и ее сжатая копия
			
			$filename = $_FILES['avatar']['name'];
			$source = $_FILES['avatar']['tmp_name'];    
			$target = $path_to_90_directory.$filename;
			move_uploaded_file($source, $target);//загрузка оригинала в папку $path_to_90_directory
		}else MessageSend(2, 'Неверный формат файла, поддерживаются только изображения в jpg(jpeg), png и gif.');
		if(preg_match('/[.](GIF)|(gif)$/', $filename)) {
			$im = imagecreatefromgif($path_to_90_directory.$filename) ; //если оригинал был в формате gif, то создаем изображение в этом же формате. Необходимо для последующего сжатия
		}
		if(preg_match('/[.](PNG)|(png)$/', $filename)) {
			$im = imagecreatefrompng($path_to_90_directory.$filename) ;//если оригинал был в формате png, то создаем изображение в этом же формате. Необходимо для последующего сжатия
		}
    
		if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/', $filename)) {
			$im = imagecreatefromjpeg($path_to_90_directory.$filename); //если оригинал был в формате jpg, то создаем изображение в этом же формате. Необходимо для последующего сжатия
		}

		$w = 800;  // квадратная 800x800. Можно поставить и другой размер.

// создаём исходное изображение на основе 
// исходного файла и определяем его размеры 
		$w_src = imagesx($im); // определяем ширину
		$h_src = imagesy($im); // определяем высоту изображения

         // создаём пустую квадратную картинку 
         // важно именно truecolor!, иначе будем иметь 8-битный результат 
        $dest = imagecreatetruecolor($w,$w); 

         // вырезаем квадратную серединку по x, если фото горизонтальное 
        if ($w_src>$h_src) 
			imagecopyresampled($dest, $im, 0, 0,
							round((max($w_src,$h_src)-min($w_src,$h_src))/2),
							0, $w, $w, min($w_src,$h_src), min($w_src,$h_src)); 

         // вырезаем квадратную верхушку по y, 
         // если фото вертикальное (хотя можно тоже серединку) 
         if ($w_src<$h_src)
			imagecopyresized($dest, $im, 0, 0, 0,
							round((max($w_src,$h_src)-min($w_src,$h_src))/2),
							$w, $w, min($w_src,$h_src), min($w_src,$h_src)); 

         // квадратная картинка масштабируется без вырезок 
        if ($w_src==$h_src) imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w, $w_src, $w_src); 
         

//$date=time(); //вычисляем время в настоящий момент.


		imagejpeg($dest, $path_to_90_directory.$_SESSION['USER_ID'].".jpg"); //сохраняем изображение формата jpg в нужную папку, именем будет текущее время. Сделано, чтобы у изображений не было одинаковых названий.

//почему именно jpg? Он занимает очень мало места + уничтожается анимирование gif изображения, которое отвлекает пользователя. Не очень приятно читать его комментарий, когда краем глаза замечаешь какое-то движение.

		$avatar = $path_to_90_directory.$_SESSION['USER_ID'].".jpg"; //заносим в переменную путь до аватара.

		$delfull = $path_to_90_directory.$filename; // получаем адрес исходника
		unlink ($delfull); //удаляем оригинал загруженного изображения, он нам больше не нужен. Задачей было - получить миниатюру.
		
		/*if ($_FILES['avatar']['size'] > 4194304) MessageSend(2, 'Размер изображения слишком большой.');
		if ($_FILES['avatar']['type'] != 'image/jpeg') MessageSend(2, 'Не верный тип изображения.');
		if (getimagesize($_FILES['avatar']['tmp_name']) == 0) MessageSend(2, 'Не верный тип изображения.');
		$Image = imagecreatefromjpeg($_FILES['avatar']['tmp_name']);
		$Size = getimagesize($_FILES['avatar']['tmp_name']);
		$Tmp = imagecreatetruecolor(800, 800);
		imagecopyresampled($Tmp, $Image, 0, 0, 0, 0, 800, 800, $Size[0], $Size[1]);
		if ($_SESSION['USER_AVATAR'] == 0) {
			$Files = glob('resource/avatars/*', GLOB_ONLYDIR);
			foreach($Files as $num => $Dir) {
				$Num ++;
				$Count = sizeof(glob($Dir.'/*.*'));
				if ($Count < 250) {
					$Download = $Dir.'/'.$_SESSION['USER_ID'];
					$_SESSION['USER_AVATAR'] = $Num;
					mysqli_query($CONNECT, "UPDATE `users`  SET `avatar` = $Num WHERE `id` = $_SESSION[USER_ID]");
					break;
				}
			}
		}
		else $Download = 'resource/avatars/'.$_SESSION['USER_AVATAR'].'/'.$_SESSION['USER_ID'];
		imagejpeg($Tmp, $Download.'.jpg');
		imagedestroy($Image);
		imagedestroy($Tmp);*/
	}


	MessageSend(3, 'Данные изменены.');
}


if ($Module == 'settings' and $_POST['enter']) {
	ULogin(1);
	if(isset($_POST['theme']) && $_POST['theme'] == 1) {
		setcookie("theme", 1, strtotime('+30 days'), '/');
	} else {
		setcookie("theme", 0, strtotime('+30 days'), '/');
	}
	MessageSend(3, 'Изменения сохранены.');
}


ULogin(0);

if ($Module == 'restore' and !$Param['code'] and substr($_SESSION['RESTORE'], 0, 4) == 'wait') MessageSend(2, 'Вы уже отправили заявку на восстановление пароля. Проверьте ваш E-mail адрес <b>'.substr($_SESSION['RESTORE'], 5).'</b>');
if ($Module == 'restore' and $_SESSION['RESTORE'] and substr($_SESSION['RESTORE'], 0, 4) != 'wait') MessageSend(2, 'Ваш пароль ранее уже был изменён. Для входа используйте новый пароль <b>'.$_SESSION['RESTORE'].'</b>', '/login');


if ($Module == 'restore' and $Param['code']) {
	$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, 'SELECT `login` FROM `users` WHERE `id` = '.str_replace(md5(substr($_SESSION['RESTORE'], 5)), '', $Param['code'])));
	if (!$Row['login']) MessageSend(1, 'Невозможно восстановить пароль.', '/login');
	$Random = RandomString(15);
	$_SESSION['RESTORE'] = $Random;
	mysqli_query($CONNECT, "UPDATE `users` SET `password` = '".GenPass($Random, $Row['login'])."' WHERE `login` = '$Row[login]'");
	MessageSend(2, 'Пароль успешно изменён, для входа используйте новый пароль <b>'.$Random.'</b>', '/login');
}


if ($Module == 'restore' and $_POST['enter']) {
	$_POST['email'] = FormChars($_POST['email']);
	$_POST['captcha'] = FormChars($_POST['captcha']);
	if (!$_POST['email'] or !$_POST['captcha']) MessageSend(1, 'Невозможно обработать форму.');
	if ($_SESSION['captcha'] != md5($_POST['captcha'])) MessageSend(1, 'Код введён не верно.');
	$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id`, `email` FROM `users` WHERE `email` = '$_POST[email]'"));
	if (!$Row['email']) MessageSend(1, 'Пользователь не найден.');
	mail($Row['email'], 'Волонтёрский корпус РнД', 'Ссылка для восстановления: http://volunteersrnd.esy.es/account/restore/code/'.md5($Row['email']).$Row['id'], 'From: наш e-mail');
	$_SESSION['RESTORE'] = 'wait_'.$Row['email'];
	MessageSend(2, 'На ваш E-mail адрес <b>'.$Row['email'].'</b> отправлено подтерждение смены пароля.');
}

if ($Module == 'register' and $_POST['enter']) {
	$_POST['login'] = FormChars($_POST['login']);
	$_POST['email'] = FormChars($_POST['email']);
	$_POST['password'] = GenPass(FormChars($_POST['password']), $_POST['login']);
	$_POST['name'] = FormChars($_POST['name']);
	$_POST['surname'] = FormChars($_POST['surname']);
	$_POST['patronymic'] = FormChars($_POST['patronymic']);
	$_POST['work'] = FormChars($_POST['work']);
	$_POST['captcha'] = FormChars($_POST['captcha']);
	if (!$_POST['login'] or !$_POST['email'] or !$_POST['password'] or !$_POST['name'] or !$_POST['surname'] or !$_POST['patronymic'] or !$_POST['work'] or !$_POST['captcha']) MessageSend(1, 'Невозможно обработать форму.');
	if ($_SESSION['captcha'] != md5($_POST['captcha'])) MessageSend(1, 'Код введён не верно.');
	$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `login` FROM `users` WHERE `login` = '$_POST[login]'"));
	if ($Row['login']) exit(MessageSend(1, 'Логин <b>'.$_POST['login'].'</b> уже используется.'));
	$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `email` FROM `users` WHERE `email` = '$_POST[email]'"));
	if ($Row['email']) exit(MessageSend(1, 'E-mail <b>'.$_POST['email'].'</b> уже используется.'));
	mysqli_query($CONNECT, "INSERT INTO `users`  VALUES ('', '$_POST[login]', '$_POST[password]', '$_POST[name]', '$_POST[surname]', '$_POST[patronymic]', '$_POST[work]', '$_POST[email]', NOW(), 0, 0, 0)");
	$Code = str_replace('=', '', base64_encode($_POST['email']));
	mail($_POST['email'], 'Регистрация на сайте Волонтёрский корпус РнД', 'Ссылка для активации: http://volunteersrnd.esy.es/account/activate/code/'.substr($Code, -5).substr($Code, 0, -5), 'From: наш e-mail');
	MessageSend(3, 'Регистрация аккаунта успешно завершена, на указанный e-mail адрес <b>'.$_POST['email'].'</b> отправлено письмо для подтверждения регистрации.');
}

else if ($Module == 'activate' and $Param['code']) {
	if (!$_SESSION['USER_ACTIVE_EMAIL']) {
		$Email = base64_decode(substr($Param['code'], 5).substr($Param['code'], 0, 5));
		if (strpos($Email, '@') !== false) {
			mysqli_query($CONNECT, "UPDATE `users`  SET `active` = 1 WHERE `email` = '$Email'");
			$_SESSION['USER_ACTIVE_EMAIL'] = $Email;
			MessageSend(3, 'E-mail <b>'.$Email.'</b> подтверждён.', '/login');
		}
		else MessageSend(1, 'E-mail адрес не подтверждён.', '/login');
	}
	else MessageSend(1, 'E-mail адрес <b>'.$_SESSION['USER_ACTIVE_EMAIL'].'</b> уже подтверждён.', '/login');
}

else if ($Module == 'login' and $_POST['enter']) {
	$_POST['login'] = FormChars($_POST['login']);
	$_POST['password'] = GenPass(FormChars($_POST['password']), $_POST['login']);
	$_POST['captcha'] = FormChars($_POST['captcha']);
	if (!$_POST['login'] or !$_POST['password'] or !$_POST['captcha']) MessageSend(1, 'Невозможно обработать форму.');
	if ($_SESSION['captcha'] != md5($_POST['captcha'])) MessageSend(1, 'Код введён не верно.');
	$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `password`, `active` FROM `users` WHERE `login` = '$_POST[login]'"));
	if ($Row['password'] != $_POST['password']) MessageSend(1, 'Не верный логин или пароль.');
	if ($Row['active'] == 0) MessageSend(1, 'Аккаунт пользователя <b>'.$_POST['login'].'</b> не подтверждён.');
	$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id`, `login`, `name`, `surname`, `patronymic`, `work`, `email`, `regdate`, `avatar`, `group` FROM `users` WHERE `login` = '$_POST[login]'"));
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
	if ($_REQUEST['remember']) setcookie('user', $_POST['password'], strtotime('+30 days'), '/');
	exit(header('Location: /user/'.$_SESSION['USER_LOGIN'].''));
}
?>