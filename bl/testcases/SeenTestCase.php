<?php

require('../MessageManager.php');
require('../BLException.php');
try
{

	$messageManager = new MessageManager();
	$messageManager->seen(5);
	
	print "DONE";
	
}catch(BLException $bl)
{
	print $bl->getMessage();
}


?>
