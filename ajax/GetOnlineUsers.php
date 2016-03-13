<?php

require "common.php";
require __DIR__."/../bl/UserManager.php";
$userManager = new UserManager();
try
{
$users = $userManager->getOnlineUsers();
foreach($users as $user)
{
	foreach($user as $key=>$value)
	{
		$user->$key = htmlentities($value, ENT_QUOTES, 'UTF-8');
	}
}

$res = array('success' => true,'users'=> $users );
print json_encode($res);


}catch(BLException $e)
{
	print "{";
	print "\"success\":false,";
	print "\"message\":\"".$e->getMessage()."\"";
	print "}";
}




?>