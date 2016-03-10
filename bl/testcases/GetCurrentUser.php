<?php

require('../UserManager.php');
//require('../BLException.php');
try
{
	$usermanager = new UserManager();
	$user = $usermanager->getCurrentUser();
	print json_encode($user);
	
}catch(BLException $bl)
{
	print $bl->getMessage();
}


?>
