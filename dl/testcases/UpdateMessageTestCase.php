<?php

require('../Message.php');
require('../MessageDO.php');

$message = new Message();
$message->code = 1;
$message->seen = 1;
$message->message = "Ahoy!..";
$message->senderUserId= '1';
$message->receiverUserId= '2';
$message->hideFromSender = 0;
$message->hideFromReceiver = 0;
$message->dateSent = date('Y-m-d H:i:s',time());
$messageDO = new MessageDO();
try
{
$messageDO->update($message);
print "Updated..";
}catch(Exception $e)
{
print $e->getMessage();
}