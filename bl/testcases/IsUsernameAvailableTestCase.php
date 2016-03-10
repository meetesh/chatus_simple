<?php

require('../UserManager.php');
require('../BLException.php');
try
{
	$usermanager = new UserManager();
	if($usermanager->isUsernameAvailable("meeteshroack"))
	{
		print "Available";
	}else
	{
		print "not available";
	}
	
	
}catch(BLException $bl)
{
	print $bl->getMessage();
}


?>
