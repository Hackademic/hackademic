<?php
/**
 *
 * Hackademic-CMS/model/common/class.SmartyHackademic.php
 *
 * Hackademic Smarty Class
 * Configures and initalizes Smarty per Hackademic's configuration.
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
require_once(HACKADEMIC_PATH."config.inc.php");
require_once(HACKADEMIC_PATH."extlib/Smarty-3.1.8/libs/Smarty.class.php");
require_once(HACKADEMIC_PATH."model/common/class.Utils.php");

class SmartyHackademic extends Smarty {

	/**
	 * @var boolean
	 */
	private $debug = false;

	/**
	 * @var array
	 */
	private $template_data = array();

	/**
	 * Constructor to initialize SmartyHackademic
	 *
	 * @param array $config_array Defaults to null;
	 *
	 */
	public function __construct() {
		$src_root_path = SOURCE_ROOT_PATH;
		$site_root_path = SITE_ROOT_PATH;
		$app_title = APP_TITLE;
		$debug=DEBUG;
		$cache_pages=CACHE_PAGES;

		Smarty::__construct();
		$this->template_dir = array( HACKADEMIC_PATH.'view', HACKADEMIC_PATH.'admin/view/');
		$this->compile_dir = HACKADEMIC_PATH.'/view/compiled_view';
		$this->cache_dir =HACKADEMIC_PATH.'cache';
		$this->caching = ($cache_pages)?1:0;
		$this->cache_lifetime = 300;
		$this->debug = $debug;
		$this->assign('app_title', $app_title);
		$this->assign('site_root_path', $site_root_path);
	}   

	/**
	 * Assigns data to a template variable.
	 * If debug is true, stores it for access by tests or developer.
	 * @param string $key
	 * @param mixed $value
	 */
	public function assign($key, $value = null) {
		parent::assign($key, $value);
		if ($this->debug) {
			$this->template_data[$key] = $value;
		}
	}

	/**
	 * For use only by tests: return a template data value by key.
	 * @param string $key
	 */  
	public function getTemplateDataItem($key) {
		return isset($this->template_data[$key]) ? $this->template_data[$key]:null;
	}

	/**
	 * Check if caching is enabled
	 * @return bool
	 */
	public function isViewCached() {
		return ($this->caching==1)?true:false;
	}

	/**
	 * Turn off caching
	 */
	public function disableCaching() {
		$this->caching=0;
	}

	/**
	 * Override the parent's clear_all_cache method to check if caching is on to begin with. We do this to prevent the
	 * cache/MAKETHISDIRWRITABLE.txt from being deleted during test runs; this file needs to exist in order for the
	 * cache directory to remain in the git repository.
	 * @param int $expire_time
	 */
	public function clear_all_cache($exp_time = null) {
		if ($this->caching == 1) {
			parent::clear_all_cache($exp_time);
		}
	}
}
