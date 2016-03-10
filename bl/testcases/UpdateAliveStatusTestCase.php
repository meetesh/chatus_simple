<?php

require('../UserManager.php');
require('../BLException.php');
try
{
	$usermanager = new UserManager();
	$usermanager->updateAliveStatus("ronaldo");
	print "updated";
	
	
}catch(BLException $bl)
{
	print $bl->getMessage();
}


?>
