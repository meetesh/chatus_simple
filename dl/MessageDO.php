<?php

require_once('DOConnection.php');
require_once('DOException.php');
require_once('Message.php');

class MessageDO
{
	public function add($message)
	{
		try
		{
			$c = DOConnection::getConnection();
			$ps = $c->prepare("insert into message (message,sender_user_id,receiver_user_id,seen,hide_from_sender,hide_from_receiver,date_sent) values(?,?,?,?,?,?,?)");
			$ps->bindParam(1,$message->message);
			$ps->bindParam(2,$message->senderUserId);
			$ps->bindParam(3,$message->receiverUserId);
			$ps->bindParam(4,$message->seen);
			$ps->bindParam(5,$message->hideFromSender);
			$ps->bindParam(6,$message->hideFromReceiver);
			$ps->bindParam(7,$message->dateSent);
			$ps->execute();
			$message->code = $c->lastInsertId();
			$c = null;			
			
		}catch(Exception $e)
		{
			throw new DOException($e);
		}
		
	}
	
	
	public function update($message)
	{
		try
		{
			$c = DOConnection::getConnection();
			$ps = $c->prepare("update message set message=?,sender_user_id=?,receiver_user_id=?,seen=?,hide_from_sender=?,hide_from_receiver=?,date_sent=? where code=?");
			$ps->bindParam(1,$message->message);
			$ps->bindParam(2,$message->senderUserId);
			$ps->bindParam(3,$message->receiverUserId);
			$ps->bindParam(4,$message->seen);
			$ps->bindParam(5,$message->hideFromSender);
			$ps->bindParam(6,$message->hideFromReceiver);
			$ps->bindParam(7,$message->dateSent);
			$ps->bindParam(8,$message->code);
			$ps->execute();
			$c = null;			
			
		}catch(Exception $e)
		{
			throw new DOException($e);
		}
		
	}
	
	
	public function get($code)
	{
		try
		{
			$c = DOConnection::getConnection();
			$ps = $c->prepare("select * from message where code=?");
			$ps->bindParam(1,$code);
			$ps->execute();
			$row = $ps->fetch();
			if($row)
			{
				$message = new Message();
				$message->code = $code;
				$message->message = $row['message'];
				$message->senderUserId = $row['sender_user_id'];
				$message->receiverUserId=$row['receiver_user_id'];
				$message->seen= $row['seen'];
				$message->hideFromSender = $row['hide_from_sender'];
				$message->hideFromReceiver = $row['hide_from_receiver'];
				$message->dateSent= $row['date_sent'];
				$c = null;
				return $message;
				
			}
			$c = null;
			throw new DOException("invalid message code $code");
			
		}catch(Exception $e)
		{
			throw new DOException($e);
		}
	}
	
	
	public function getByReceiverAndSender($receiverUserId,$senderUserId)
	{
		try
		{
			$c = DOConnection::getConnection();
			$ps = $c->prepare("select * from message where sender_user_id=? and receiver_user_id=? order by date_sent desc");
			$ps->bindParam(1,$senderUserId);
			$ps->bindParam(2,$receiverUserId);
			$ps->execute();
			$row = $ps->fetch();
			if(!$row)
			{
				$c = null;
				throw new DOException("no records");
			}
			$x = 0;
			$messages = array();
			do
			{
				$message = new Message();
				$message->code = $row['code'];
				$message->message = $row['message'];
				$message->senderUserId = $row['sender_user_id'];
				$message->receiverUserId=$row['receiver_user_id'];
				$message->seen= $row['seen'];
				$message->hideFromSender = $row['hide_from_sender'];
				$message->hideFromReceiver = $row['hide_from_receiver'];
				$message->dateSent= $row['date_sent'];
				$messages[$x]= $message;
				$x++;

			}while($row = $ps->fetch());
			$c = null;
			return $messages;
		}catch(Exception $e)
		{
			throw new DOException($e);
		}
	}
	
	
	public function getByReceiverAndSeen($receiverUserId,$seen)
	{
		try
		{
			$c = DOConnection::getConnection();
			$ps = $c->prepare("select * from message where receiver_user_id=? and seen=? order by date_sent desc");
			$ps->bindParam(1,$receiverUserId);
			$ps->bindParam(2,$seen);
			$ps->execute();
			$row = $ps->fetch();
			if(!$row)
			{
				$c = null;
				throw new DOException("no records");
			}
			$x = 0;
			$messages = array();
			do
			{
				$message = new Message();
				$message->code = $row['code'];
				$message->message = $row['message'];
				$message->senderUserId = $row['sender_user_id'];
				$message->receiverUserId=$row['receiver_user_id'];
				$message->seen= $row['seen'];
				$message->hideFromSender = $row['hide_from_sender'];
				$message->hideFromReceiver = $row['hide_from_receiver'];
				$message->dateSent= $row['date_sent'];
				$messages[$x]= $message;
				$x++;

			}while($row = $ps->fetch());
			$c = null;
			return $messages;
		}catch(Exception $e)
		{
			throw new DOException($e);
		}
	}
	
	
	public function getByConversation($senderUserId,$receiverUserId)
	{
		try
		{
			$c = DOConnection::getConnection();
			$ps = $c->prepare("select * from message where (receiver_user_id=? and sender_user_id=?) OR (receiver_user_id=? and sender_user_id=?) order by date_sent desc");
			$ps->bindParam(1,$receiverUserId);
			$ps->bindParam(2,$senderUserId);
			$ps->bindParam(3,$senderUserId);
			$ps->bindParam(4,$receiverUserId);
			$ps->execute();
			$row = $ps->fetch();
			if(!$row)
			{
				$c = null;
				throw new DOException("no records");
			}
			$x = 0;
			$messages = array();
			do
			{
				$message = new Message();
				$message->code = $row['code'];
				$message->message = $row['message'];
				$message->senderUserId = $row['sender_user_id'];
				$message->receiverUserId=$row['receiver_user_id'];
				$message->seen= $row['seen'];
				$message->hideFromSender = $row['hide_from_sender'];
				$message->hideFromReceiver = $row['hide_from_receiver'];
				$message->dateSent= $row['date_sent'];
				$messages[$x]= $message;
				$x++;

			}while($row = $ps->fetch());
			$c = null;
			return $messages;
			
		}catch(Exception $e)
		{
			throw new DOException($e);
		}
	}


	public function getByConversationAndSeen($senderUserId,$receiverUserId,$seen)
	{
		try
		{
			$c = DOConnection::getConnection();
			$ps = $c->prepare("select * from message where ((receiver_user_id=? and sender_user_id=?) OR (receiver_user_id=? and sender_user_id=?)) AND seen=? order by date_sent desc");
			$ps->bindParam(1,$receiverUserId);
			$ps->bindParam(2,$senderUserId);
			$ps->bindParam(3,$senderUserId);
			$ps->bindParam(4,$receiverUserId);
			$ps->bindParam(5,$seen);
			$ps->execute();
			$row = $ps->fetch();
			if(!$row)
			{
				$c = null;
				throw new DOException("no records");
			}
			$x = 0;
			$messages = array();
			do
			{
				$message = new Message();
				$message->code = $row['code'];
				$message->message = $row['message'];
				$message->senderUserId = $row['sender_user_id'];
				$message->receiverUserId=$row['receiver_user_id'];
				$message->seen= $row['seen'];
				$message->hideFromSender = $row['hide_from_sender'];
				$message->hideFromReceiver = $row['hide_from_receiver'];
				$message->dateSent= $row['date_sent'];
				$messages[$x]= $message;
				$x++;

			}while($row = $ps->fetch());
			$c = null;
			return $messages;
			
		}catch(Exception $e)
		{
			throw new DOException($e);
		}
	}

	
}
	


?>