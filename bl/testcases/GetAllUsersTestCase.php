<?php

require('../UserManager.php');
try
{
	$usermanager = new UserManager();
	$users = $usermanager->getAllUsers();
	print json_encode($users);
	
	
}catch(BLException $bl)
{
	print $bl->getMessage();
}


?>
