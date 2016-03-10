<?php

require('../UserManager.php');
require('../BLException.php');
try
{
	$usermanager = new UserManager();
	$usermanager->update("meetsh","meetesh","ronaldo","1995-05-11");
	print "Success";
	
}catch(BLException $bl)
{
	print $bl->getMessage();
}


?>
