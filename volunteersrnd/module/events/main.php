<?php 
$Param['page'] += 0;
?>
<?php
if ($_POST['enter'] and $_POST['name']) {
	$_POST['name'] = FormChars($_POST['name']);
	$Param1 = translit($_POST['name']);
	$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `address` FROM `events` WHERE `address` = '$Param1'"));
	$i = 1;
	if ($Row['address'] == $Param1){
		$Param3 = $Param1;
		while ($Row['address'] == $Param1) {
			if ($i-1 >= 0) {
				$istr = (string) $i;
				$Param1 = $Param3.$istr;
			}
			$i++;
			$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `address` FROM `events` WHERE `address` = '$Param1'"));
		}	
	}
	$MaxID = mysqli_fetch_row(mysqli_query($CONNECT,"SELECT MAX(`id`) FROM `events`"));
	$MaxID[0]++;
	mysqli_query($CONNECT, "INSERT INTO `events`  VALUES ('$MaxID[0]', '$_POST[name]', '$_SESSION[USER_LOGIN]', '', '<p></p>', NOW(), NOW(), '$Param1', 0)");
	MessageSend(2, 'Событие создано.', '/edit/event/address/'.$Param1);
}
?>
<?php Head('События - Волонтёрский корпус РнД', 2)?>
<?php Menu(2)?>
<?php MenuSelect('events-box')?>
<?php if ($_SESSION['USER_LOGIN_IN'] == 1)
echo '<div class="add-news-pop">
	<div class="add-news-div">
		<div class="add-news-close" onclick="add_news_button()"><img src="/resource/img/close.png"></div>
		<div class="add-news-title">Создание события</div>
		<div class="add-news-subtitle">Введите название события:</div>
		<form method="POST">
			<input class="input-form" type="text" name="name" required>
			<div class="add-news-subtitle">*На основе введённого Вами заглавия, будет сформирована НЕИЗМЕНЯЕМАЯ ссылка на событие</div>
			<input type="submit" name="enter" value="Создать и перейти к редактированию" class="add-news-send">
		</form>
	</div>
</div>';?>
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
		<div class="events-block-title">СОБЫТИЯ</div>
		<div class="events-block-list">
			<?php 
		if ($Page == 'events') {
			if ($_SESSION['USER_GROUP'] < 1) $Active = 'WHERE `active` = 2';
			else $Active = 'WHERE `active` != 0';
			$Param1 = "SELECT `id`, `name`, `added`, `place`, `text`, `date_start`, `date_end`, `address`, `active` FROM `events` ".$Active." OR `added` = '$_SESSION[USER_LOGIN]' ORDER BY `id` DESC LIMIT 0, 16";
			$Param2 = "SELECT `id`, `name`, `added`, `place`, `text`, `date_start`, `date_end`, `address`, `active` FROM `events` ".$Active." OR `added` = '$_SESSION[USER_LOGIN]' ORDER BY `id` DESC LIMIT START, 16";
			$Param3 = "SELECT COUNT(`id`) FROM `events` ".$Active." OR `added` = '$_SESSION[USER_LOGIN]'";
			$Param4 = '/events/all/page/';
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
				$Number1 = '<div class="event-blocks"><div class="outside-event-block">';
				$Number2 = '<div class="outside-event-block">';
			}
			else {
				$Number1 = '';
				$Number2 = '</div>';	
			}
			
			echo '
				'.$Number1.'
					<style>#event-block-img-'.$Row['id'].'{background-image: url('.NewsImg($Row['text']).');}</style>
					<div class="post-line"></div>
					<div class="event-block">
						<a href="/event/'.$Row['address'].'" class="event-block-img" id="event-block-img-'.$Row['id'].'">				
							<p>'.$Row['name'].'</p>
						</a>
						'.mb_substr(new_date($Row['date_start']),0,-8).' | '.$Row['place'].'
					</div>
				</div>'.$Number2.'
			';
		}
		
		if (($i % 2) == 0)  echo '</div></div>';
		
		PageSelector($Param4, $Param['page'], $Count, 16);
	?>
		</div>
	</div>
</div>


<?php MessageShow()?>
<?php Footer() ?>