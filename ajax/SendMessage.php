<?php

require "common.php";
require __DIR__."/../bl/MessageManager.php";

//specify the required parameters which are supposed to be arrive in request

$properties = array('message' => '','senderUsername' =>'','receiverUsername'=>'' );

foreach ($request as $key => $value) 
{

	if(array_key_exists($key, $properties))
	{
		$properties[$key]  = $value;	
	}

}
/*
foreach ($_POST as $key => $value) 
{

	if(array_key_exists($key, $properties))
	{
		$properties[$key]  = $value;	
	}

}
*/

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
$messageManager->send($properties['message'],$properties['senderUsername'],$properties['receiverUsername']);
$res = array('success' =>true);
print json_encode($res);

}catch(BLException $e)
{
	print "{";
	print "\"success\":false,";
	print "\"message\":\"".$e->getMessage()."\"";
	print "}";
}




?>