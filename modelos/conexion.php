<?php

class Conexion
{

	public $pdo = null;

	function __construct()
	{
		$this->pdo = new PDO(
			"mysql:host=localhost;dbname=bdkonecta",
			"root",
			"",
			array(
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
			)
		);
	}

}
