<?php

require "common.php";
require __DIR__."/../bl/UserManager.php";
$properties = array('username' =>'');

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
if($userManager->isUsernameAvailable($properties['username']))
{

$res = array('success' =>true);

}else

{

$res = array('success' =>false);

}
print json_encode($res);

}catch(BLException $e)
{
	print "{";
	print "\"success\":false,";
	print "\"message\":\"".$e->getMessage()."\"";
	print "}";
}




?>