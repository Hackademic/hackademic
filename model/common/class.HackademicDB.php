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

  /**
   * Opens a connection to the database using the constants defined for the database
   * interactions. Echoes the PDOException message if a connection can't be
   * established.
   */
  public function openConnection() {
		$host = DB_HOST;
		$dbname = DB_NAME;
		$user = DB_USER;
		$pass = DB_PASSWORD;
		try {
			$this->connection = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
		$this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public function __construct() {
		$this->openConnection();
	}

  /**
   * Runs the query given together with the params. Triggers 'create' actions before and
   * after the query is executed on the database.
   *
   * @param $sql the sql query to use
   * @param null $params the params that can be used as arguments in the sql query
   * @param $type the type of action to trigger (ie article, user, challenge...)
   * @return mixed a statement handle to the results
   */
  public function create($sql, $params = NULL, $type) {
      $this->triggerAction('before_create', $type, array($sql, $params));
      $statement_handle =  $this->query($sql, $params);
      $this->triggerAction('after_create', $type, array($this->insertId(), $params));
      return $statement_handle;
  }

  /**
   * Runs the query given together with the params. Triggers 'read' actions before and
   * after the query is executed on the database.
   *
   * @param $sql the sql query to use
   * @param null $params the params that can be used as arguments in the sql query
   * @param $type the type of action to trigger (ie article, user, challenge...)
   * @return mixed a statement handle to the results
   */
  public function read($sql, $params = NULL, $type) {
      $this->triggerAction('before_read', $type, array($sql, $params));
      $statement_handle =  $this->query($sql, $params);
      $this->triggerAction('after_read', $type, array($params));
      return $statement_handle;
  }

  /**
   * Runs the query given together with the params. Triggers 'update' actions before and
   * after the query is executed on the database.
   *
   * @param $sql the sql query to use
   * @param null $params the params that can be used as arguments in the sql query
   * @param $type the type of action to trigger (ie article, user, challenge...)
   * @return mixed a statement handle to the results
   */
  public function update($sql, $params = NULL, $type) {
      $this->triggerAction('before_update', $type, array($sql, $params));
      $statement_handle =  $this->query($sql, $params);
      $this->triggerAction('after_update', $type, array($params));
      return $statement_handle;
  }

  /**
   * Runs the query given together with the params. Triggers 'delete' actions before and
   * after the query is executed on the database.
   *
   * @param $sql the sql query to use
   * @param null $params the params that can be used as arguments in the sql query
   * @param $type the type of action to trigger (ie article, user, challenge...)
   * @return mixed a statement handle to the results
   */
  public function delete($sql, $params = NULL, $type) {
      $this->triggerAction('before_delete', $type, array($sql, $params));
      $statement_handle =  $this->query($sql, $params);
      $this->triggerAction('after_delete', $type, array($params));
      return $statement_handle;
  }

  /**
   * Runs the query given together with the params.
   *
   * @param $sql the sql query to use
   * @param null $params the params that can be used as arguments in the sql query
   * @return mixed a statement handle to the results
   */
	public function query($sql, $params = NULL) {
		if ("dev" == ENVIRONMENT && TRUE === SHOW_SQL_QUERIES) {
      echo "<p>sql query == " . $sql . "</p>";
    }
		$statement_handle = $this->connection->prepare($sql);
		$statement_handle->execute($params);
		return $statement_handle;
	}

  /**
   * Fetches an array from the statement handle passed in as a parameter.
   *
   * @param $statement_handle the handle from the query statement
   * @return mixed array of rows
   */
  public function fetchArray($statement_handle) {
		$statement_handle->setFetchMode(PDO::FETCH_ASSOC);
		$row = $statement_handle->fetch();
		return $row;
	}

  /**
   * Calculates the number of rows in the query result that is passed in as
   * a statement handle.
   *
   * @param $statement_handle the handle from the query statement
   * @return mixed number of rows
   */
  public function numRows($statement_handle) {
		return $statement_handle->rowCount();
	}

  /**
   * Fetches the id of the lastly inserted item in the database.
   *
   * @return mixed the last insert id
   */
  public function insertId() {
		return $this->connection->lastInsertId();
	}

  /**
   * Fetches the number of affected rows after a database query has been
   * executed and the result passed in as a statement handle.
   *
   * @param $statement_handle the handle from the query statement
   * @return mixed
   */
  public function affectedRows($statement_handle) {
		return $this->numRows($statement_handle);
	}

  /**
   * Closes the database connection if not already closed.
   */
  public function closeConnection() {
		if(isset($this->connection)) {
			$this->connection = NULL;
		}
	}

  /**
   * Triggers an action based on the action and type that are passed in as
   * parameters on the form $action . '_' . $type. The parameter array
   * is used as arguments to the function that the plugin API will call.
   *
   * @param $action the action to trigger (ie before_create, after_update)
   * @param $type the type that makes the action unique (ie article, user, challenge)
   * @param $parameter_array an array of parameters that are passed to the plugin
   */
  private function triggerAction($action, $type, $parameter_array) {
    Plugin::do_action_ref_array($action . '_' . $type, $parameter_array);
  }

}
