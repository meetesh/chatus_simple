<?php

require('../User.php');
require('../UserDO.php');

$userDO = new UserDO();
try
{
$user = $userDO->getUser(1);
print json_encode($user);
}catch(Exception $e)
{
print $e->getMessage();
}