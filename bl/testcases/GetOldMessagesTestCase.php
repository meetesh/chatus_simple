<?php

require('../MessageManager.php');
require('../BLException.php');
try
{

	$messageManager = new MessageManager();
	$messages = $messageManager->getOldMessages("itsmeetesh","yash");
	
	print json_encode($messages);
	
}catch(BLException $bl)
{
	print $bl->getMessage();
}


?>
