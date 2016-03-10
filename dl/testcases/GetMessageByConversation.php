<?php

require('../Message.php');
require('../MessageDO.php');

$messageDO = new MessageDO();
try
{
$message = $messageDO->getByConversation(1,2);
print json_encode($message);
}catch(Exception $e)
{
print $e->getMessage();
}