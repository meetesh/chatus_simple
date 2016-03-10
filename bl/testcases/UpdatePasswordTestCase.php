<?php

require('../UserManager.php');
require('../BLException.php');
try
{
	$usermanager = new UserManager();
	$usermanager->updatePassword("ronaldo","123456");
	print "Success";
	
}catch(BLException $bl)
{
	print $bl->getMessage();
}


?>
