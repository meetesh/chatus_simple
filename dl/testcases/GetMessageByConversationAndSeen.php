<?php

require('../Message.php');
require('../MessageDO.php');

$messageDO = new MessageDO();
try
{
$message = $messageDO->getByConversationAndSeen(1,2,1);
print json_encode($message);
}catch(Exception $e)
{
print $e->getMessage();
}