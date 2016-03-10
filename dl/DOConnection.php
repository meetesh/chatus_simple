<?php

require_once('DOException.php');

class DOConnection
{
	public static function getConnection()
	{
		try
		{
			$databaseServerName='localhost';
            $databaseName='chatus_db';
            $databaseUsername='chatus_u';
            $databasePassword='chatus_p';
            $c=new PDO("mysql:host=$databaseServerName;dbname=$databaseName",$databaseUsername,$databasePassword);
            $c->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return $c;
		}catch(Exception $e)
		{
			throw new DOException("Can not connect.");

		}

	}
}

?>