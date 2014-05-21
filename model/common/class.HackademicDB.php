<?php
/**
 *
 * Hackademic-CMS/model/common/class.HackademicDB.php
 *
 * Hackademic HackademicDB Class
 * Class for Hackademic's DB Object
 * 
 * Copyright (c) 2012 OWASP
 *
 * LICENSE:
 *
 * This file is part of Hackademic CMS (https://www.owasp.org/index.php/OWASP_Hackademic_Challenges_Project).
 *
 * Hackademic CMS is free software: you can redistribute it and/or modify it under the terms of the GNU General Public
 * License as published by the Free Software Foundation, either version 2 of the License, or (at your option) any
 * later version.
 *
 * Hackademic CMS is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with Hackademic CMS.  If not, see
 * <http://www.gnu.org/licenses/>.
 *
 *
 * @author Pragya Gupta <pragya18nsit[at]gmail[dot]com>
 * @author Konstantinos Papapanagiotou <conpap[at]gmail[dot]com>
 * @license http://www.gnu.org/licenses/gpl.html
 * @copyright 2012 OWASP
 *
 */

class HackademicDB {

	private $connection;

	public function openConnection() {
		$host = DB_HOST;
		$dbname = DB_NAME;
		$user = DB_USER;
		$pass = DB_PASSWORD;
		try {
			$this->connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
		$this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$php_ver = explode(".", phpversion());
		if ( ($php_ver[0] < 5) || ($php_ver[0]==5 && $php_ver[1]<=3) ) {
			/* if php < 5.3.6, charset=utf8 in the connection string is ignored */
			$this->connection->exec("set names utf8");
		}
	}

	public function __construct() {
		$this->openConnection();
	}

	public function query($sql, $params = NULL) {

		if ("dev" ==ENVIRONMENT && TRUE === SHOW_SQL_QUERIES)
			echo "<p>sql query == ".$sql."</p>";
		
		$statement_handle = $this->connection->prepare($sql);
		$statement_handle->execute($params);
		return $statement_handle;
	}

	public function fetchArray($statement_handle) {
		$statement_handle->setFetchMode(PDO::FETCH_ASSOC);
		$row = $statement_handle->fetch();
		return $row;
	}		  

	public function numRows($statement_handle) {
		return $statement_handle->rowCount();
	}              							   		  

	public function insertId() {
		return $this->connection->lastInsertId();
	}

	public function affectedRows($statement_handle) {
		return $this->numRows($statement_handle);
	}						 

	public function closeConnection() {
		if(isset($this->connection)) {
			$this->connection = null;
		}
	}
}
