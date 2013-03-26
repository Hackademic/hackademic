<?php 

require_once(HACKADEMIC_PATH."esapi/impl/class.HTTPUtilities.php");
require_once(HACKADEMIC_PATH."esapi/impl/class.Encoder.php");
require_once(HACKADEMIC_PATH."esapi/impl/class.Randomizer.php");
require_once(HACKADEMIC_PATH."esapi/src/ESAPI.php");
class Esapi_Utils{
	private $HTTPUtilities;
	private $ESAPI;
	public function __construct(){
		Global $ESAPI;
		if(!isset($ESAPI))
		$ESAPI = new ESAPI(HACKADEMIC_PATH."esapi/ESAPI.xml");
		$this->ESAPI = $ESAPI;
		}
	
	public function setHttpUtilities(){
		$this->ESAPI->setHttpUtilities(new HTTPUtilities_impl());
	}
	public function setEncoder(){
		$this->ESAPI->setEncoder(new Encoder_impl());
	}
	public function setRandomizer(){
		$this->ESAPI->setRandomizer(new Randomizer_impl());
	}
	public function getHttpUtilities(){
		return $this->ESAPI->getHttpUtilities();
	}
	public function getEncoder(){
		return $this->ESAPI->getEncoder();
	}
	public function getRandomizer(){
		return $this->ESAPI->getRandomizer();
	}

}

?>
