<?php

require_once('DOConnection.php');
require_once('DOException.php');
require_once('User.php');

class UserDO
{
	public function add($user)
	{
		try
		{
			$c = DOConnection::getConnection();
			$ps = $c->prepare("insert into user (name,username,password,date_of_birth,last_updated) values(?,?,md5(?),?,?)");
			$ps->bindParam(1,$user->name);
			$ps->bindParam(2,$user->username);
			$ps->bindParam(3,$user->password);
			$ps->bindParam(4,$user->dateOfBirth);
			$ps->bindParam(5,$user->lastUpdated);
			$ps->execute();
			$user->id = $c->lastInsertId();
			$c = null;			
			
		}catch(Exception $e)
		{
			throw new DOException($e);
		}
		
	}
	
	public function update($user)
	{
		try
		{
			$c = DOConnection::getConnection();
			$ps = $c->prepare("update user set name=?,username=?,date_of_birth=?,last_updated=? where id=?");
			$ps->bindParam(1,$user->name);
			$ps->bindParam(2,$user->username);
			$ps->bindParam(3,$user->dateOfBirth);
			$ps->bindParam(4,$user->lastUpdated);
			$ps->bindParam(5,$user->id);
			$ps->execute();
			$c = null;			
			
		}catch(Exception $e)
		{
			throw new DOException($e);
		}
		
	}
	
	public function updatePassword($username,$password)
	{
		try
		{
			$c = DOConnection::getConnection();
			$ps = $c->prepare("update user set password=md5(?) where username=?");
			$ps->bindParam(1,$password);
			$ps->bindParam(2,$username);
			$ps->execute();
			$c = null;			
			
		}catch(Exception $e)
		{
			throw new DOException($e);
		}
		
	}
	
	public function getUser($id)
	{
		try
		{
			$c = DOConnection::getConnection();
			$ps = $c->prepare("select * from user where id=?");
			$ps->bindParam(1,$id);
			$ps->execute();
			$row = $ps->fetch();
			if($row)
			{
				$user = new User();
				$user->id = $id;
				$user->name = $row['name'];
				$user->username=$row['username'];
				$user->password = $row['password'];
				$user->lastUpdated = $row['last_updated'];
				$user->dateOfBirth = $row['date_of_birth'];
				$c = null;
				return $user;
				
			}
			$c = null;
			throw new DOException("invalid user id $id");
			
		}catch(Exception $e)
		{
			throw new DOException($e);
		}
	}
	
	
	public function getUserByUsername($username)
	{
		try
		{
			$c = DOConnection::getConnection();
			$ps = $c->prepare("select * from user where username=?");
			$ps->bindParam(1,$username);
			$ps->execute();
			$row = $ps->fetch();
			if($row)
			{
				$user = new User();
				$user->id = $row['id'];
				$user->name = $row['name'];
				$user->username=$row['username'];
				$user->password = $row['password'];
				$user->lastUpdated = $row['last_updated'];
				$user->dateOfBirth = $row['date_of_birth'];
				$c = null;
				return $user;
				
			}
			$c = null;
			throw new DOException("invalid username $username");
			
		}catch(Exception $e)
		{
			throw new DOException($e);
		}
	}
	
	
	public function getOnlineUsers()
	{
		try
		{
			$c = DOConnection::getConnection();
			$ps = $c->prepare("select * from user where last_updated>? order by name");
			$oneMinute = date('Y-m-d H:i:s',time()-60);
			$ps->bindParam(1,$oneMinute);
			$ps->execute();
			$row = $ps->fetch();
			if(!$row)
			{
				$c = null;
				throw new DOException("no records");
			}
			$x = 0;
			$users = array();
			do
			{
				$user = new User();
				$user->id = $row['id'];
				$user->name = $row['name'];
				$user->username=$row['username'];
				$user->password = $row['password'];
				$user->lastUpdated = $row['last_updated'];
				$user->dateOfBirth = $row['date_of_birth'];
				$users[$x]= $user;
				$x++;

			}while($row = $ps->fetch());
			$c = null;
			return $users;
		}catch(Exception $e)
		{
			throw new DOException($e);
		}
	}
}
	


?>