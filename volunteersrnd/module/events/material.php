<?php 
$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id`, `name`, `added`, `place`, `text`, `date_start`, `date_end`, `address`, `active` FROM `events` WHERE `address` = '$Module'"));
if (!$Row['address']) { 
	include('page/404.php');
}
else {
	include('module/comments/main.php');
	include('module/events/event.php');	
}
?>