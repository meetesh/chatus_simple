<?php

require('../User.php');
require('../UserDO.php');

$user = new User();
$user->name = "Rajkumar soni";
$user->username = "raju";
$user->password = "soni";
$user->dateOfBirth = '1995-08-31';
$user->lastUpdated = date('Y-m-d H:i:s',time());
$userDO = new UserDO();
try
{
$userDO->add($user);
print "Added with id ".$user->id;
}catch(Exception $e)
{
print $e->getMessage();
}