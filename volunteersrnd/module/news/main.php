<?php 
$Param['page'] += 0;
?>
<?php
if ($_POST['enter'] and $_POST['name']) {
	$_POST['name'] = FormChars($_POST['name']);
	$Param1 = translit($_POST['name']);
	$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `address` FROM `news` WHERE `address` = '$Param1'"));
	$i = 1;
	if ($Row['address'] == $Param1){
		$Param3 = $Param1;
		while ($Row['address'] == $Param1) {
			if ($i-1 >= 0) {
				$istr = (string) $i;
				$Param1 = $Param3.$istr;
			}
			$i++;
			$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `address` FROM `news` WHERE `address` = '$Param1'"));
		}	
	}
	$MaxID = mysqli_fetch_row(mysqli_query($CONNECT,"SELECT MAX(`id`) FROM `news`"));
	$MaxID[0]++;
	mysqli_query($CONNECT, "INSERT INTO `news`  VALUES ('$MaxID[0]', '$_POST[name]', 0, 0, '$_SESSION[USER_LOGIN]', '<p></p>', NOW(), '$Param1', 0)");
	MessageSend(2, 'Новость создана.', '/edit/post/address/'.$Param1);
}
?>
<?php Head('Волонтёрский корпус РнД')?>
<?php Menu(2)?>
<?php MenuSelect('news-box')?>
<?php if ($_SESSION['USER_LOGIN_IN'] == 1)
echo '<div class="add-news-pop">
	<div class="add-news-div">
		<div class="add-news-close" onclick="add_news_button()"><img src="/resource/img/close.png"></div>
		<div class="add-news-title">Создание новости</div>
		<div class="add-news-subtitle">Введите заголовок новости:</div>
		<form method="POST">
			<input class="input-form" type="text" name="name" required>
			<div class="add-news-subtitle">*На основе введённого Вами заглавия, будет сформирована НЕИЗМЕНЯЕМАЯ ссылка на новость</div>
			<input type="submit" name="enter" value="Создать и перейти к редактированию" class="add-news-send">
		</form>
	</div>
</div>';?>
<div id="block-for-slider">
    <div id="viewport">
        <ul id="slidewrapper">
		<?php
			$Result = mysqli_query($CONNECT, "SELECT `id`, `name`, `address`, `text` FROM `news` WHERE `cat` = 1 AND `active` = 2 ORDER BY `id` DESC LIMIT 0, 4");
			while ($Row = mysqli_fetch_assoc($Result)) {
				echo'<li class="slide"><a href="/post/'.$Row['address'].'"><img src="'.NewsImg($Row['text']).'" alt="1" class="slide-img"><p class="slide-p">'.$Row['name'].'</p></a></li>';
			}
		?>
        </ul>

        <div id="prev-next-btns">
            <div id="prev-btn">&larr;</div>
            <div id="next-btn">&rarr;</div>
        </div>

        <ul id="nav-btns">
            <li class="slide-nav-btn"></li>
            <li class="slide-nav-btn"></li>
            <li class="slide-nav-btn"></li>
            <li class="slide-nav-btn"></li>
        </ul>
    </div>
</div>

<?php if ($Page == 'category') $FirstText = '#cat-a-'.$Module.'{background:#E82B2B;}';
else $FirstText = '#cat-a-0{background:#E82B2B;}';?>
<div class="news-block">
<?php LogBlock()?>
	<div class="categoryHead">
	<?php echo '<style>'.$FirstText.'</style>'?>
	<div>
		<ul class="categoryUL">
			<div>
				<li><a id="cat-a-0" href="/">ВСЕ</a></li>
				<li><a id="cat-a-1" href="/category/1">ВАЖНО</a></li>
			</div>
			<div>
				<li><a id="cat-a-2" href="/category/2">МЕРОПРИЯТИЯ</a></li>
				<li><a id="cat-a-3" href="/category/3">ПРОЧЕЕ</a></li>
			</div>
		</ul>
	</div>
	</div>
	
	<?php 
		if ($Page == 'news') {
			if ($_SESSION['USER_GROUP'] < 1) $Active = 'WHERE `active` = 2';
			else $Active = 'WHERE `active` != 0';
			$Param1 = "SELECT `id`, `name`, `added`, `date`, `cat`, `address`, `text`, `read`, `active` FROM `news` ".$Active." OR `added` = '$_SESSION[USER_LOGIN]' ORDER BY `id` DESC LIMIT 0, 16";
			$Param2 = "SELECT `id`, `name`, `added`, `date`, `cat`, `address`, `text`, `read`, `active` FROM `news` ".$Active." OR `added` = '$_SESSION[USER_LOGIN]' ORDER BY `id` DESC LIMIT START, 16";
			$Param3 = "SELECT COUNT(`id`) FROM `news` ".$Active." OR `added` = '$_SESSION[USER_LOGIN]'";
			$Param4 = '/news/all/page/';
		} else if ($Page == 'category') {
			if ($_SESSION['USER_GROUP'] < 1) $Active = 'AND `active` = 2';
			else $Active = 'AND `active` != 0';
			$Param1 = "SELECT `id`, `name`, `added`, `date`, `cat`, `address`, `text`, `read`, `active` FROM `news` WHERE `cat` = ".$Module." ".$Active." OR `added` = '$_SESSION[USER_LOGIN]' ORDER BY `id` DESC LIMIT 0, 16";
			$Param2 = "SELECT `id`, `name`, `added`, `date`, `cat`, `address`, `text`, `read`, `active` FROM `news` WHERE `cat` = ".$Module." ".$Active." OR `added` = '$_SESSION[USER_LOGIN]' ORDER BY `id` DESC LIMIT START, 16";
			$Param3 = "SELECT COUNT(`id`) FROM `news` WHERE `cat` = ".$Module." ".$Active." OR `added` = '$_SESSION[USER_LOGIN]'";
			$Param4 = '/category/'.$Module.'/page/';
		}

		$Count = mysqli_fetch_row(mysqli_query($CONNECT, $Param3));
		
		if (!$Param['page']) {
			$Param['page'] = 1;
			$Result = mysqli_query($CONNECT, $Param1);
		} else {
			$Start = ($Param['page'] - 1) * 16;
			$Result = mysqli_query($CONNECT, str_replace('START', $Start, $Param2));
		}
		
		$i=1;
		
		while ($Row = mysqli_fetch_assoc($Result)) {	
		
			$i++;
			
			$Count1 = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT COUNT(`id`) FROM `comments` WHERE `address` = '$Row[address]'"));
			
			if ($Row['active'] == 1) $Row['name'] = '[Ожидает проверки] '.$Row['name'];
			else if ($Row['active'] == 0) $Row['name'] = '[Не отправлена] '.$Row['name'];
		
			if (($i % 2) == 0) { 
				$Number1 = '<div class="post-blocks"><div class="outside-post-block">';
				$Number2 = '<div class="outside-post-block">';
			}
			else {
				$Number1 = '';
				$Number2 = '</div>';	
			}
			
			echo '
				'.$Number1.'
				<div class="post-line"></div>
				<div class="post-block">
					<style>#post-block-img-'.$Row['id'].'{background-image: url('.NewsImg($Row['text']).');}</style>
					<a href="/post/'.$Row['address'].'" class="post-img-inside"><div class="post-block-img" id="post-block-img-'.$Row['id'].'"></div></a>
					<div class="post-block-div">
						<a href="/category/'.$Row['cat'].'" class="post-block-a">'.Category($Row['cat']).'</a>
						<br><a href="/post/'.$Row['address'].'" class="post-block-title">'.$Row['name'].'</a>
						<br><a href="/user/'.$_SESSION['USER_LOGIN'].'" class="post-block-a">'.$Row['added'].'</a> | '.mb_substr(new_date($Row['date']),0,-8).' | <img class="views-img" src="/resource/img/views.png"> '.$Row['read'].' | <img class="views-img" src="/resource/img/comments2.png"> '.$Count1[0].'
						<br><div>'.NewsText($Row['text']).'</div>
					</div>
				</div>
				</div>'.$Number2.'
			';
		}
		
		if (($i % 2) == 0)  echo '</div></div>';
		
		PageSelector($Param4, $Param['page'], $Count, 16);
	?>

</div>

<?php MessageShow()?>
<?php Footer() ?>