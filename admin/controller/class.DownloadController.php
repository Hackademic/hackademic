<?php
/**
 *
 * Hackademic-CMS/controller/class.ShowChallengeController.php
 *
 * Hackademic Show Challenge Controller
 * Class for the Show Challenge page in Frontend
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
require_once(HACKADEMIC_PATH."admin/controller/class.HackademicBackendController.php");

class DownloadController extends HackademicBackendController {

	public function go() {
		if(isset($_GET['ch'])) {
			$folder = $_GET['ch'];
			$source = HACKADEMIC_PATH."challenges/".$folder;
			$dest = HACKADEMIC_PATH."view/compiled_view/".$folder.".zip";
			self::Zip($source, $dest);
			header("Content-Type: archive/zip");
			
			// filename for the browser to save the zip file
			header("Content-Disposition: attachment; filename=$folder".".zip");
			$filesize = filesize($dest);
			header("Content-Length: $filesize");
			$fp = fopen("$dest","r");
			echo fpassthru($fp);
			fcloae($fp);
			unlink($dest);
		}
	}

	private static function Zip($source, $destination) {
		if (!extension_loaded('zip') || !file_exists($source)) {
			return false;
		}
		$zip = new ZipArchive();
		if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
			return false;
		}
		$source = str_replace('\\', '/', realpath($source));
		if (is_dir($source) === true) {
			$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
			foreach ($files as $file)
			{
				$file = str_replace('\\', '/', realpath($file));
				if (is_dir($file) === true) {
					$zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
				}
				else if (is_file($file) === true) {
					$zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
				}
			}
		} else if (is_file($source) === true) {
			$zip->addFromString(basename($source), file_get_contents($source));
		}
		return $zip->close();
	}
}
