<?php

require('../Message.php');
require('../MessageDO.php');

$message = new Message();
$message->seen = 0;
$message->message = "Ahoy!..";
$message->senderUserId= '1';
$message->receiverUserId= '2';
$message->hideFromSender = 0;
$message->hideFromReceiver = 0;
$message->dateSent = date('Y-m-d H:i:s',time());
$messageDO = new MessageDO();
try
{
$messageDO->add($message);
print "Added with code ".$message->code;
}catch(Exception $e)
{
print $e->getMessage();
}