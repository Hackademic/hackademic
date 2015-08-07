<?php
/**
 * Licensed to the Apache Software Foundation (ASF) under one or more
 * contributor license agreements.  See the NOTICE file distributed with
 * this work for additional information regarding copyright ownership.
 * The ASF licenses this file to You under the Apache License, Version 2.0
 * (the "License"); you may not use this file except in compliance with
 * the License.  You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * PHP Version 5.
 */

/**
 * Appends log events to a db table using PDO
 *
 * <p>This appender uses a table in a database to log events.</p>
 * <p>Parameters are {@link $host}, {@link $_user}, {@link $_password},
 * {@link $database}, {@link $_createTable}, {@link $_table} and {@link $_sql}.</p>
 *
 * @package    log4php
 * @subpackage appenders
 * @since      2.0
 */
class LoggerAppenderPDO extends LoggerAppender
{
    //Create the log table if it does not exists (optional).
	private $_createTable = true;
    
    // Database user name
    private $_user = '';
    
    // Database password
    private $_password = '';
    
	// DSN string for enabling a connection
    private $_dsn;
    
	// A {@link LoggerPatternLayout} string used to format a valid insert
	// query (mandatory)
    private $_sql;
    
    // Table name to write events. Used only if {@link $_createTable} is true.
    private $_table = 'log4php_log';
    
	// The instance

    private $_db = null;
    
    // boolean used to check if all conditions to append are true
    private $_canAppend = true;
    
    /**
     * Constructor.
	 * This apender doesn't require a layout.
	 *
	 * @param string $name appender name
	 *
	 * @return Nothing.
     */
	public function __construct($name = '')
	{
        parent::__construct($name);
        $this->requiresLayout = false;
    }
    
	public function __destruct()
	{
       $this->close();
   	}
   	
    /**
     * Setup db connection.
     * Based on defined options, this method connects to db defined in {@link $_dsn}
	 * and creates a {@link $_table} table if {@link $_createTable} is true.
	 *
     * @return boolean true if all ok.
	 * @throws a PDOException if the attempt to connect to the requested database
	 *           fails.
     */
	public function activateOptions()
	{
        try {
        	if ($this->_user === null) {
	           	$this->_db = new PDO($this->_dsn);
    	   } else if ($this->_password === null) {
    	       $this->_db = new PDO($this->_dsn, $this->_user);
    	   } else {
    	       $this->_db = new PDO($this->_dsn, $this->_user, $this->_password);
    	   }
    	   $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	
            // test if log table exists
            try {
                $result = $this->_db->query('select * from ' . $this->_table . ' where 1 = 0');
            } catch (PDOException $e) {
				// It could be something else but a "no such table" is the most
				// likely
                $result = false;
            }
            
            // create table if necessary
            if ($result == false and $this->_createTable) {
        	   // TODO mysql syntax?
                $query = "CREATE TABLE {$this->_table} (	 timestamp varchar(32)," .
            										"logger varchar(32)," .
            										"level varchar(32)," .
            										"message varchar(64)," .
            										"thread varchar(32)," .
            										"file varchar(64)," .
            										"line varchar(4) );";
                $result = $this->_db->query($query);
            }
        } catch (PDOException $e) {
            $this->_canAppend = false;
            throw new LoggerException($e);
        }
        
        if ($this->_sql == '' || $this->_sql == null) {
            $this->_sql = "INSERT INTO $this->_table ( timestamp, " .
            										"logger, " .
            										"level, " .
            										"message, " .
            										"thread, " .
            										"file, " .
            										"line" .
						 ") VALUES ('%d','%c','%p','%m','%t','%F','%L')";
        }
        
		$this->layout = LoggerReflectionUtils::createObject('LoggerLayoutPattern');
        $this->layout->setConversionPattern($this->_sql);
        $this->_canAppend = true;
        return true;
    }
    
    /**
	 * Appends a new event to the database using the sql format.
	 *
	 * @param Event $event New event.
	 *
	 * @return Nothing.
	 */
     // TODO:should work with prepared statement
	public function append($event)
	{
        if ($this->_canAppend) {
            $query = $this->layout->format($event);
            try {
                $this->_db->exec($query);
            } catch (Exception $e) {
                throw new LoggerException($e);
            }
        }
    }
    
    /**
	 * Closes the connection to the logging database
	 *
	 * @return Nothing.
     */
	public function close()
	{
    	if ($this->closed != true) {
        	if ($this->_db !== null) {
            	$_db = null;
        	}
        	$this->closed = true;
    	}
    }
    
    /**
     * Indicator if the logging table should be created on startup,
	 * if its not existing.
	 *
	 * @param Flag $flag Flag
	 *
	 * @return Nothing.
     */
	public function setCreateTable($flag)
	{
        $this->_createTable = LoggerOptionConverter::toBoolean($flag, true);
    }
   
   	/**
     * Sets the SQL string into which the event should be transformed.
     * Defaults to:
     * 
     * INSERT INTO $this->_table 
     * ( timestamp, logger, level, message, thread, file, line) 
     * VALUES 
     * ('%d','%c','%p','%m','%t','%F','%L')
     * 
	 * It's not necessary to change this except you have customized logging'
	 *
	 * @param string $sql SQL string.
	 *
	 * @return Nothing.
     */
	public function setSql($_sql)
	{
        $this->_sql = $_sql;    
    }
    
    /**
     * Sets the tablename to which this appender should log.
	 * Defaults to log4php_log
	 *
	 * @param string $_table Table name.
	 *
	 * @return Nothing.
     */
	public function setTable($_table)
	{
        $this->_table = $_table;
    }
    
    /**
     * Sets the DSN string for this connection. In case of
	 * SQLite it could look like this: 'sqlite:appenders/pdotest.sqlite'
	 *
	 * @param string $_dsn DSN string for connection.
	 *
	 * @return Nothing.
     */
	public function setDSN($_dsn)
	{
        $this->_dsn = $_dsn;
    }
    
    /**
     * Sometimes databases allow only one connection to themselves in one thread.
     * SQLite has this behaviour. In that case this handle is needed if the database
	 * must be checked for eventsi
	 *
	 * @return Current DB.
     */
	public function getDatabaseHandle()
	{
        return $this->_db;
    }
}

