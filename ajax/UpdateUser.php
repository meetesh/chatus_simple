<?php

require "common.php";
require __DIR__."/../bl/UserManager.php";
$properties = array('name' => '','currentUsername' =>'','username'=>'','dateOfBirth'=>'' );

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


$userManager = new UserManager();

try
{
$userManager->update($properties['name'],$properties['currentUsername'],$properties['username'],$properties['dateOfBirth']);
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