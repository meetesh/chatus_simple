<?php

$APP_PATH = realpath(dirname(__DIR__));
require_once $APP_PATH."../dl/Message.php";
require_once $APP_PATH."../dl/MessageDO.php";
require_once $APP_PATH."../dl/User.php";
require_once $APP_PATH."../dl/UserDO.php";
require_once "BLException.php";
class MessageManager 
{
	public function send($vMessage,$senderUsername,$receiverUsername)
	{
		try
		{
			$userDO = new UserDO();
			$sender = $userDO->getUserByUsername($senderUsername);
			$receiver = $userDO->getUserByUsername($receiverUsername);
			$message = new Message();
			$messageDO = new MessageDO();
			$message->message = $vMessage;
			$message->senderUserId = $sender->id;
			$message->receiverUserId = $receiver->id;
			$message->seen = 0;
			$message->hideFromSender = 0;
			$message->hideFromReceiver = 0;
			$message->dateSent = date('Y-m-d H:i:s',time());
			$messageDO->add($message);
			
		}catch(DOException $doException)
		{
			throw new BLException($doException->getMessage());
		}
	}
	
	public function getNewMessages($receiverUsername)
	{
		try
		{
			$userDO = new UserDO();
			$receiver = $userDO->getUserByUsername($receiverUsername);
			$messageDO = new MessageDO();
			$messages = $messageDO->getByReceiverAndSeen($receiver->id,0);
			return $messages;
		}catch(DOException $doException)
		{
			throw new BLException($doException->getMessage());
		}
	}
	
	public function getOldMessages($receiverUsername,$senderUsername)
	{
		try
		{
			$userDO = new UserDO();
			$receiver = $userDO->getUserByUsername($receiverUsername);
			$sender = $userDO->getUserByUsername($senderUsername);
			$messageDO = new MessageDO();
			$messages = $messageDO->getByConversation($sender->id,$receiver->id);
			return $messages;
		}catch(DOException $doException)
		{
			throw new BLException($doException->getMessage());
		}
	}
	
	public function seen($codes)
	{
		try
		{
			$messageDO = new MessageDO();
			foreach ($codes as $value) 
			{
				$message = $messageDO->get($value->code);
				$message->seen = 1;
				$messageDO->update($message);
			}
		}catch(DOException $doException)
		{
			throw new BLException($doException->getMessage());
			
		}
	}
}

?>