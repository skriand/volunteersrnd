<?php 
$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id`, `name`, `added`, `date`, `text`, `address`, `cat`, `read`, `active` FROM `news` WHERE `address` = '$Module'"));
if ($Row['active'] <= 1 and ($_SESSION['USER_GROUP'] < 1 or $Row['added'] != $_SESSION['USER_LOGIN'])) MessageSend(1, 'Новость ожидает проверки.', '/');
if (($_SESSION['USER_GROUP'] >= 1 and $_SESSION['USER_LOGIN'] != '') or ($Row['active'] == 0 and $_SESSION['USER_LOGIN'] == $Row['added'])) $ParamMenu = 1;
else $ParamMenu = 3;

if ($_COOKIE['views']) {
	$array = json_decode($_COOKIE['views'], true);
	if (!isset($array[$Row['id']])) {
		$array[$Row['id']] = true;
		$json = json_encode($array);
		setcookie ("views", $json, strtotime('+30 days'));
		$Row['read'] = $Row['read'] + 1;
		mysqli_query($CONNECT, "UPDATE `news` SET `read` = $Row[read] WHERE `id` = $Row[id]");
	}
} else {
	$array = [
		$Row['id'] => true,
	];
	$json = json_encode($array);
	setcookie ("views", $json, strtotime('+30 days'));
	$Row['read'] = $Row['read'] + 1;
	mysqli_query($CONNECT, "UPDATE `news` SET `read` = $Row[read] WHERE `id` = $Row[id]");
}

if ($Row['active'] == 1) $Row['name'] = '[Ожидает проверки]<br>'.$Row['name'];
else if ($Row['active'] == 0) $Row['name'] = '[Не отправлена]<br>'.$Row['name'];
	
Head(str_replace('<br>', ' ', $Row['name']).' - Волонтёрский корпус РнД');
Menu($ParamMenu, '/edit/post/address/'.$Row['address']);

MenuSelect('news-box');

echo '
	<style>
		table {
			border:1px solid #BBB;
			width: 100%;
			margin: 10px 0;
			font-size: 14px;
			color: #626262;
		}
		table, td, th, caption {
			border:1px dashed #BBB;
			border-collapse: collapse;
		}
		th {
			padding: 15px 10px;
		}
		td {
			padding: 15px 10px;
		}
		tr:nth-child(2n) {background: #FAFAFA;}
	</style>
';
?>
	
<?php	

	$Row1 = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `login`, `name`, `surname`, `avatar`, `group` FROM `users` WHERE `login` = '$Row[added]'"));
	$Count = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT COUNT(`id`) FROM `comments` WHERE `address` = '$Module'"));

	echo '<style>.post-img {background-image: url('.NewsImg($Row['text']).');}</style>
		<div class="page-post-head">
			<div class="post-img"><a href="/category/'.$Row['cat'].'">'.Category($Row['cat']).'</a>'.$Row['name'].'<a href="/user/'.$Row['added'].'">'.$Row1['surname'].' '.$Row1['name'].'</a></div>
			<div class="page-post-title"><a href="/category/'.$Row['cat'].'">'.Category($Row['cat']).'</a>'.$Row['name'].'<a href="/user/'.$Row['added'].'">'.$Row1['surname'].' '.$Row1['name'].'</a></div>
		</div>
		<div class="page-post-block">
			<ul class="post-info">
				<li>Просмотры '.$Row['read'].'</li>
				<li>Комментарии '.$Count[0].'</li>
			</ul>
			<div class="post-date">'.new_date($Row['date']).'</div>
			<div class="post-text">'.$Row['text'].'</div>';
	if ($Row['active'] == 2){ echo '<div class="post-line"></div>
			<div class="post-share-text">Поделиться в социальных сетях</div>
			<div class="share">
				<div data-share-data=\'{"url": "http://volunteersrnd.esy.es/post/'.$Module.'", "img": "'.NewsImg($Row['text']).'", "title": "'.$Row['name'].'", "text": "'.$Row['name'].' - Волонтёрский корпус РнД"}\'>
					<div onclick="share.twitter($(this))" class="twitter"></div>
					<div onclick="share.vk($(this))" class="vk"></div>
					<div onclick="share.facebook($(this))" class="facebook"></div>
				</div>
			</div>
			<div class="post-comments-title">Комментарии</div>';
			COMMENTS();
			//echo '<div class="development">В разработке...</div>';
		echo '</div>';
	}
		
	MessageShow();
	Footer();
?>