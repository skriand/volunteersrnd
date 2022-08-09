<?php 
$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id`, `name`, `added`, `place`, `text`, `date_start`, `date_end`, `address`, `active` FROM `events` WHERE `address` = '$Module'"));
if ($Row['active'] <= 1 and ($_SESSION['USER_GROUP'] < 1 or $Row['added'] != $_SESSION['USER_LOGIN'])) MessageSend(1, 'Событие ожидает проверки.', '/');
if (($_SESSION['USER_GROUP'] >= 1 and $_SESSION['USER_LOGIN'] != '') or ($Row['active'] == 0 and $_SESSION['USER_LOGIN'] == $Row['added'])) $ParamMenu = 1;
else $ParamMenu = 3;

if ($Row['active'] == 1) $Row['name'] = '[Ожидает проверки]<br>'.$Row['name'];
else if ($Row['active'] == 0) $Row['name'] = '[Не отправлено]<br>'.$Row['name'];
	
if ($_POST['enter']) {
	mysqli_query($CONNECT, "INSERT INTO `participants`  VALUES ('', '$_SESSION[USER_LOGIN]', '$Row[address]', NOW(), 0)");
	MessageSend(3, 'Вы записаны на событие: '.$Row['name'].'.', '/event/'.$Row['address']);
} else if ($_POST['delete']) {
	mysqli_query($CONNECT, "DELETE FROM `participants` WHERE `user` = '$_SESSION[USER_LOGIN]'");
	MessageSend(3, 'Вы больше не участник события: '.$Row['name'].'.', '/event/'.$Row['address']);
}
	
Head(str_replace('<br>', ' ', $Row['name']).' - Волонтёрский корпус РнД', 2);
Menu($ParamMenu, '/edit/event/address/'.$Row['address']);

MenuSelect('events-box');

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
<?php	

	$Row1 = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `login`, `name`, `surname`, `avatar`, `group` FROM `users` WHERE `login` = '$Row[added]'"));
	$Count = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT COUNT(`id`) FROM `comments` WHERE `address` = '$Module'"));
	$RowE = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `user`, `active` FROM `participants` WHERE `user` = '$_SESSION[USER_LOGIN]' AND `address` = '$Module'"));
	$CountE = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT COUNT(`id`) FROM `participants` WHERE `address` = '$Module'"));

	echo '<style>.post-img {
					background-image: url('.NewsImg($Row['text']).');
				}
				.page-post-title, .post-img {
					padding: 50px 20px;
				}
		</style>';
		
		date_default_timezone_set('Europe/Moscow');
		$sdate = date('d.m.Y', strtotime($Row['date_start']));
		$odate = date('d.m.Y', strtotime($Row['date_start']));
		$zdate = date('d.m.Y', strtotime('+1 day'));
		$ndate = date('d.m.Y');
		
		if ($odate > $ndate and (!$RowE['user'] or $RowE['active'] == 0)) {
			$Cursor = 'auto';
			$Color = '#ED5555';
			$Transform = 'transform: rotate(45deg);';
			$A1 = '<div';
			$A2 = 'div>';
			$Icon = '<div class="d24"></div>';
			$Text1 = 'ЗАВЕРШЕНО!';
			$Text2 = 'Вы не участвовали в данном событие.';
		}
		else if ($sdate == $zdate and (!$RowE['user'] or $RowE['active'] == 0)) {
				$Cursor = 'auto';
				$Color = '#ED5555';
				$Transform = 'transform: rotate(45deg);';
				$A1 = '<div';
				$A2 = 'div>';
				$Icon = '<div class="d24"></div>';
				$Text1 = 'ЗАПИСЬ ЗАКОНЧЕНА,';
				$Text2 = 'так как до начала остался один день.';
			}
			else if ($sdate <= $ndate and $odate >= $ndate and (!$RowE['user'] or $RowE['active'] == 0)) {
					$Cursor = 'auto';
					$Color = '#ED5555';
					$Transform = 'transform: rotate(45deg);';
					$A1 = '<div';
					$A2 = 'div>';
					$Icon = '<div class="d24"></div>';
					$Text1 = 'ЗАПИСЬ ЗАКОНЧЕНА,';
					$Text2 = 'так как событие началось.';
				}
				else if (!$RowE['user'] and !$_SESSION['USER_LOGIN_IN']) {
						$Cursor = 'pointer';
						$Color = '#ED5555';
						$Transform = '';
						$A1 = '<a href="/login"';
						$A2 = 'a>';
						$Icon = '';
						$Text1 = 'ВОЙДИТЕ!';
						$Text2 = 'Если нет аккаунта, зарегистрируйтесь, чтобы принять участие.';
					}
					else if (!$RowE['user']) {
							$Cursor = 'pointer';
							$Color = '#ED5555';
							$Transform = '';
							$A1 = '<form method="POST"><input type="submit" name="enter" id="submit-event"><label for="submit-event"';
							$A2 = 'label></form>';
							$Icon = '<div class="d24"></div>';
							$Text1 = 'ЗАПИСАТЬСЯ,';
							$Text2 = 'как '.$_SESSION['USER_SURNAME'].' '.$_SESSION['USER_NAME'].'.';
						}
						else if ($RowE['active'] == 0) {
								$Cursor = 'auto';
								$Color = '#EEB500';
								$Transform = '';
								$A1 = '<div';
								$A2 = 'div>';
								$Icon = '<div class="d1"></div>';
								$Text1 = 'ВЫ ЗАПИСАНЫ,';
								$Text2 = 'как '.$_SESSION['USER_SURNAME'].' '.$_SESSION['USER_NAME'].'. Ожидайте разрешения на участие.';
							}
							else if ($ndate < $sdate) {
									$Cursor = 'auto';
									$Color = '#00B050';
									$Transform = '';
									$A1 = '<div';
									$A2 = 'div>';
									$Icon = '<div class="d1"></div>';
									$Text1 = 'ВЫ УЧАСТВУЕТЕ,';
									$Text2 = 'ждите старта события.';
								}
								else if ($sdate <= $ndate and $odate >= $ndate) {
										$Cursor = 'auto';
										$Color = '#00B050';
										$Transform = '';
										$A1 = '<div';
										$A2 = 'div>';
										$Icon = '<div class="d1"></div>';
										$Text1 = 'ВЫ УЧАСТВУЕТЕ,';
										$Text2 = 'событие началось.';
									}
									else if ($RowE['active'] == 1) {
											$Cursor = 'auto';
											$Color = '#EEB500';
											$Transform = '';
											$A1 = '<div';
											$A2 = 'div>';
											$Icon = '<div class="d1"></div>';
											$Text1 = 'ПРИСУТСТВОВАЛИ?';
											$Text2 = 'Ожидайте подтверждения.';
										}
										else if ($RowE['active'] == 2) {
												$Cursor = 'pointer';
												$Color = '#00B050';
												$Transform = '';
												$A1 = '<a href="/'.$_SESSION['USER_LOGIN'].'"';
												$A2 = 'a>';
												$Icon = '';
												$Text1 = 'ВЫ УЧАСТНИК!';
												$Text2 = 'Событие завершилось и теперь отображается в вашей ленте.';
											}
											else {
													$Cursor = 'pointer';
													$Color = '#E82B2B';
													$Transform = '';
													$A1 = '<a href="/'.$_SESSION['USER_LOGIN'].'"';
													$A2 = 'a>';
													$Icon = '';
													$Text1 = 'ВЫ ПРОГУЛЬШИК!';
													$Text2 = 'Событие завершилось и теперь отображается в вашей ленте.';
												}
		
		echo '
			<style>
				.event-button{cursor: '.$Cursor.';}
				.event-button-text {background-color: '.$Color.';}
				.d24 {
					background: '.$Color.';
					'.$Transform.'
				}
				.d24:after {background: '.$Color.';}
				.d1 {border-color: '.$Color.';}				
			</style>
			'.$A1.' class="event-button"><div class="event-button-text"><p>'.$Text1.'</p>'.$Text2.'</div><div class="event-button-img">'.$Icon.'</div></'.$A2
			;
			
		if ($_SESSION['USER_GROUP'] == 2)
		echo '<div class="participants-title" onclick="participants()"><div>Участники '.$CountE[0].'</div><p><img class="participants-arrow" src="/resource/img/arrow.png"></p></div><div class="participants-block">';
		else echo '<div class="participants-title"><div>Участники '.$CountE[0].'</div><p></p></div><div class="participants-block">';
		
		if ($_SESSION['USER_GROUP'] == 2){
			
			$Result = mysqli_query($CONNECT, "SELECT `user`, `active` FROM `participants` WHERE `address` = '$Module'");
			while ($RowL = mysqli_fetch_assoc($Result)) {
				$RowL2 = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id`, `login`, `name`, `surname`, `avatar` FROM `users` WHERE `login` = '$RowL[user]'"));
				if (!$RowL2['avatar']) $Avatar = 0;
				else $Avatar = "$RowL2[avatar]/$RowL2[id]";
				echo 
				'<style>#participants-avatar-'.$RowL2['id'].' {background-image: url(/resource/avatars/'.$Avatar.'.jpg);}</style>
				<div class="participants-list">
					<p>
						<div class="participants-logo"><div class="participants-avatar" id="participants-avatar-'.$RowL2['id'].'"></div></div>
						<div class="participants-text">	
							<a href="/user/'.$RowL2['login'].'" class="participants-name">'.$RowL2['surname'].' '.$RowL2['name'].'</a>
						</div>
					</p>
				</div>';
			}
		}
		
		echo
		'</div><div class="page-post-head">
			<div class="post-img">'.$Row['name'].'</div>
			<div class="page-post-title">'.$Row['name'].'</div>
		</div>
		<div class="page-post-block">
			<ul class="post-info">
				<li><a href="/user/'.$Row['added'].'">'.$Row1['surname'].' '.$Row1['name'].'</a></li>
				<li>Участники '.$CountE[0].'</li>
				<li>Комментарии '.$Count[0].'</li>
			</ul>
			<div class="post-date">Дата начала: '.new_date($Row['date_start']).'</div>
			<div class="post-date">Дата окончания: '.new_date($Row['date_end']).'</div>
			<div class="post-date">Место проведения: '.$Row['place'].'</div>
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
		echo '</div></div></div>';
	}
		
	MessageShow();
	Footer();
?>