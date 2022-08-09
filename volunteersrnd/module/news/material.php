<?php 
$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id`, `name`, `added`, `date`, `text`, `address`, `cat`, `read` FROM `news` WHERE `address` = '$Module'"));
if (!$Row['address']) { 
	include('page/404.php');
}
else {
	include('module/comments/main.php');
	include('module/news/post.php');	
}
?>