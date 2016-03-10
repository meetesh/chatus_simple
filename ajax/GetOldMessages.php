<?php

require "common.php";
require __DIR__."/../bl/MessageManager.php";

$properties = array('receiverUsername'=>'','senderUsername'=>'' );

foreach ($_GET as $key => $value) 
{

	if(array_key_exists($key, $properties))
	{
		$properties[$key]  = $value;	
	}

}

foreach ($_POST as $key => $value) 
{

	if(array_key_exists($key, $properties))
	{
		$properties[$key]  = $value;	
	}

}

//filter or validate here in this loop
foreach ($properties as $key => $value)
{
	$properties[$key] = filter_var($value,FILTER_SANITIZE_STRING);
	if(strlen($properties[$key])==0)
	{
		$res = array('success' =>false,'message'=>"$key required");
		print json_encode($res);
		die();
	}
}


$messageManager = new MessageManager();
try
{
$messages = $messageManager->getOldMessages($properties['receiverUsername'],$properties['senderUsername']);
foreach($messages as $message)
{
	foreach($message as $key=>$value)
	{
		$message->$key = htmlentities($value, ENT_QUOTES, 'UTF-8');
	}
}

print json_encode($messages);

}catch(BLException $e)
{
	print "{";
	print "\"success\":false,";
	print "\"message\":\"".$e->getMessage()."\"";
	print "}";
}




?>