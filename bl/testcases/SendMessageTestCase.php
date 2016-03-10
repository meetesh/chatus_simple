<?php

require('../MessageManager.php');
require('../BLException.php');
try
{
	$messageManager = new MessageManager();
	$messageManager->send("I m fine thank u","yash","itsmeetesh");
	
	print "Message Sent";
	
}catch(BLException $bl)
{
	print $bl->getMessage();
}


?>
