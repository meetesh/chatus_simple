<?php

require "common.php";
require __DIR__."/../bl/UserManager.php";
$userManager = new UserManager();
try
{
$userManager->logout();
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