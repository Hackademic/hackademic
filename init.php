<?php
/**
 *
 * Hackademic-CMS/init.php
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

require_once("config.inc.php");
require_once("model/common/class.Loader.php");
require_once("model/common/class.HackademicDB.php");

if (defined('ENVIRONMENT') && ENVIRONMENT == "dev") {
    ini_set('display_errors', true);
} else {
    ini_set('display_errors', false);
}

$db = new HackademicDB();
Loader::init();


require_once("esapi/class.Esapi_Utils.php");

if(!isset($ESAPI_utils)){
			// error_log("Esapi not inited in init", 0);
			$ESAPI_utils = new Esapi_Utils();
}

function removeDirectory($path) {
		$files = glob($path . '/*');
		foreach ($files as $file) {
			is_dir($file) ? removeDirectory($file) : unlink($file);
		}
		rmdir($path);
		return;
	}
if(file_exists (HACKADEMIC_PATH."/installation") && defined('ENVIRONMENT') && ENVIRONMENT != "dev")
	removeDirectory(HACKADEMIC_PATH."/installation");
?>
