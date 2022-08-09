<?php
UAccess(1);

if ($Param['address'] and $Param['command']) {
	
	if ($Param['command'] == 'delete') {
		mysqli_query($CONNECT, "DELETE FROM `events` WHERE `address` = '$Param[address]'");
		MessageSend(3, 'Событие удалено.', '/');
	}

}
?>