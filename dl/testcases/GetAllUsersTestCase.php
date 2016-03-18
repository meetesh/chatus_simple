<?php

require('../User.php');
require('../UserDO.php');

$userDO = new UserDO();
try
{
$user = $userDO->getAllUsers();
print json_encode($user);
}catch(Exception $e)
{
print $e->getMessage();
}