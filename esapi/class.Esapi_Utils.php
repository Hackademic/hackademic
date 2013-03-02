<?php 

require_once(HACKADEMIC_PATH."esapi/impl/class.HTTPUtilities.php");
require_once(HACKADEMIC_PATH."esapi/src/ESAPI.php");
class Esapi_Utils{
	private $HTTPUtilities;
	
	public function __construct(){
		Global $ESAPI;
		if(!isset($ESAPI))
		$ESAPI = new ESAPI(HACKADEMIC_PATH."esapi/ESAPI.xml");
		}
	
	public function setHttpUtilities(){
		$this->HTTPUtilities = new HTTPUtilities_impl();
	}
	public function getHttpUtilities(){
		if(!isset($this->HTTPUtilities))
			$this->setHttpUtilities();
		return $this->HTTPUtilities;
	}

}

?>
