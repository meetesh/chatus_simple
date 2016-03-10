<?php

require('../UserManager.php');
require('../BLException.php');
try
{
	$usermanager = new UserManager();
	$usermanager->signup("meetsh","meetesh","kumawat","1995-04-11");
	print "Success";
	
}catch(BLException $bl)
{
	print $bl->getMessage();
}


?>
