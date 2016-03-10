<?php

require('../User.php');
require('../UserDO.php');

$user = new User();
$user->id = 4;
$user->name = "Shivam soni";
$user->username = "shivam";
$user->password = "soni";
$user->dateOfBirth = '1999-08-31';
$user->lastUpdated = date('Y-m-d H:i:s',time());
$userDO = new UserDO();
try
{
$userDO->update($user);
print "updated";
}catch(Exception $e)
{
print $e->getMessage();
}