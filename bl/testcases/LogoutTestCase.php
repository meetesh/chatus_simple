<?php

require('../UserManager.php');
require('../BLException.php');
try
{
	$usermanager = new UserManager();
	$usermanager->logout();
	print "Success";
	print $_SESSION['username'];
	
	
}catch(BLException $bl)
{
	print $bl->getMessage();
}


?>
