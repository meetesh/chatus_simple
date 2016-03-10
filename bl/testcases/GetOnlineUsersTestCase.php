<?php

require('../UserManager.php');
require('../BLException.php');
try
{
	$usermanager = new UserManager();
	$users = $usermanager->getOnlineUsers();
	print json_encode($users);
	
	
}catch(BLException $bl)
{
	print $bl->getMessage();
}


?>
