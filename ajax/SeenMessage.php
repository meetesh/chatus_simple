<?php

require "common.php";
require __DIR__."/../bl/MessageManager.php";

//specify the required parameters which are supposed to be arrive in request

$properties = array('codes' =>'' );

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

if(count($properties['codes'])==0)
{
	$res = array('success' =>false,'message'=>"codes required");
	print json_encode($res);
	die();

}


$messageManager = new MessageManager();

try
{


$messageManager->seen($properties['codes']);
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