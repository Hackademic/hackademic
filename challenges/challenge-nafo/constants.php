<?php

// Class Message to transmit and display error, warning and success messages.
class Message {
	const SUCCESS = 0;
	const ERROR = 2;
	const WARNING = 1;
	private $message;
	private $level;
	
	public function __construct($message = '', $level = self::SUCCESS) {
		$this->message = $message;
		$this->level = $level;
	}
	
	public function toString() {
		return $this->message;
	}
	
	public function getLevel() {
		switch($this->level) {
			case self::SUCCESS:
				return 'success';
			break;
			case self::WARNING:
				return 'warning';
			break;
			default:
				return 'error';
			break;
		}
	}
	
	public function merge($message) {
		if($this->level<$message->level) {
			$this->level = $message->level;
		}
		if($this->message=='') {
			$this->message = $message->message;
		} else {
			$this->message .= '<br/>'.$message->message;
		}
	}
	
	public function newLine() {
		$this->message .= '<br/>';
	}
}
	
?>