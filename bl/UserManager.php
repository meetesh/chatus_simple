<?php

$APP_PATH = realpath(dirname(__DIR__));
require_once $APP_PATH."../dl/User.php";
require_once $APP_PATH."../dl/UserDO.php";
require_once "BLException.php";
class UserManager 
{
	public function signup($name,$username,$password,$dateOfBirth)
	{
		try
		{
			$userDO = new UserDO();
			try
			{
				$userDO->getUserByUsername($username);
				throw new BLException("Username $username already exists.");
			}catch(DOException $do)
			{
			}
			$user = new User();
			
			$user->name = $name;
			$user->username = $username;
			$user->password = $password;
			$user->dateOfBirth = $dateOfBirth;
			$user->lastUpdated = date('Y-m-d H:i:s',time());
			$userDO->add($user);
			if(session_status()==PHP_SESSION_NONE)
			{
				session_start();
			}
			$_SESSION['username'] = $username;
			
			
		}catch(DOException $do)
		{
			throw new BLException($do->getMessage());
		}
	}
	
	public function authenticateAndLogin($username,$password)
	{
		try
		{
			$userDO = new UserDO();
			$user = $userDO->getUserByUsername($username);
			if(strcmp($user->password,md5($password))!=0)
			{
				throw new BLException("Invalid Password");
			}
			if(session_status()==PHP_SESSION_NONE)
			{
				session_start();
			}
			$_SESSION['username'] = $username;
				
		}catch(DOException $doException)
		{
			throw new BLException("Invalid Username $username");
		}
	}
	
	public function logout()
	{
		if(session_status()==PHP_SESSION_NONE)
		{
			session_start();
		}
		$_SESSION['username'] = null;		
	}
	
	public function isUsernameAvailable($username)
	{
		try
		{
			$userDO = new UserDO();
			$user = $userDO->getUserByUsername($username);
			return false;
			
		}catch(DOException $doException)
		{
			return true;
		}
	}
	
	public function updateAliveStatus($username)
	{
		try
		{
			$userDO = new UserDO();
			$user = $userDO->getUserByUsername($username);
			$user->lastUpdated = date('Y-m-d H:i:s' , time());
			$userDO->update($user);
			
		}catch(DOException $doException)
		{
			throw new BLException($doException->getMessage());
		}
	}
	
	public function update($name,$currentUsername,$username,$dateOfBirth)
	{
		try
		{
			$userDO = new UserDO();
			try
			{
				$userDO->getUserByUsername($username);
				throw new BLException("Username : $username is not available.");
				
			}catch(DOException $do)
			{

			}
			$user = $userDO->getUserByUsername($currentUsername);
			$user->name = $name;
			$user->username = $username;
			$user->dateOfBirth = $dateOfBirth;
			$user->lastUpdated = date('Y-m-d H:i:s' , time());
			$userDO->update($user);
			
		}catch(DOException $doException)
		{
			throw new BLException($doException->getMessage());
		}
	}
	
	public function getOnlineUsers()
	{
		try
		{
			$userDO = new UserDO();
			$onlineUsers = $userDO->getOnlineUsers();
			return $onlineUsers;
		}catch(DOException $doException)
		{
			throw new BLException("No records");
		}
	}
	
	public function getAllUsers()
	{
		try
		{
			$userDO = new UserDO();
			$users = $userDO->getAllUsers();
			return $users;
		}catch(DOException $doException)
		{
			throw new BLException("No records");
		}
	}

	
	public function updatePassword($username,$password)
	{
		try
		{
			$userDO = new UserDO();
			$userDO->updatePassword($username,$password);
		}catch(DOException $doException)
		{
			throw new BLException("No records");			
		}
	}

	public function getCurrentUser()
	{
		try
		{
			if(session_status()==PHP_SESSION_NONE) session_start();
			if($_SESSION['username'] != null)
			{
				$username = $_SESSION['username'];
				$userDO = new UserDO();
				$user = $userDO->getUserByUsername($username);
				return $user;
			}
			throw new BLException("No user logged in");
		}catch(DOException $doException)
		{
			throw new BLException($doException->getMessage());
		}
	}
	
}