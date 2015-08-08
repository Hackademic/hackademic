<?php
/**
 * Hackademic-CMS/model/common/class.SmartyHackademic.php
 *
 * Hackademic Smarty Class
 * Configures and initalizes Smarty per Hackademic's configuration.
 *
 * Copyright (c) 2012 OWASP
 *
 * LICENSE:
 *
 * This file is part of Hackademic CMS
 * (https://www.owasp.org/index.php/OWASP_Hackademic_Challenges_Project).
 *
 * Hackademic CMS is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 2 of the License, or (at your option) any later
 * version.
 *
 * Hackademic CMS is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE.  See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Hackademic CMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * PHP Version 5.
 *
 * @author    Pragya Gupta <pragya18nsit@gmail.com>
 * @author    Konstantinos Papapanagiotou <conpap@gmail.com>
 * @copyright 2012 OWASP
 * @license   GNU General Public License http://www.gnu.org/licenses/gpl.html
 */
require_once HACKADEMIC_PATH . "config.inc.php";
require_once HACKADEMIC_PATH . "extlib/Smarty-3.1.21/libs/Smarty.class.php";
require_once HACKADEMIC_PATH . "model/common/class.Utils.php";
require_once HACKADEMIC_PATH . "admin/model/class.Options.php";

class SmartyHackademic extends Smarty
{

    /**
     * @var boolean
     */
    private $_debug = false;

    /**
     * @var array
     */
    private $_template_data = array();

    /**
   * @var string the path to the user theme
   */
    public $user_theme_path = '';

    /**
   * @var string the path to the admin theme
   */
    public $admin_theme_path = '';

    /**
   * @var string of the smarty version
   */
    private $_smarty_version = '3.1.21';

    /**
     * Constructor to initialize SmartyHackademic
     *
     * @param array $config_array Defaults to null;
     *
     * @return Nothing.
     */
    public function __construct()
    {
        $src_root_path = SOURCE_ROOT_PATH;
        $site_root_path = SITE_ROOT_PATH;

        $app_title = APP_TITLE;
        $_debug = DEBUG;
        $cache_pages = CACHE_PAGES;

        Smarty::__construct();
        $this->user_theme_path = Options::getOption('active_user_theme')->value . 'view/';
        $this->admin_theme_path = Options::getOption('active_admin_theme')->value . 'admin/view/';
        //$this->template_dir = array( HACKADEMIC_PATH . $this->user_theme_path, HACKADEMIC_PATH . $this->admin_theme_path);
        $this->setTemplateDir(
            array(
            HACKADEMIC_PATH . $this->user_theme_path,
            HACKADEMIC_PATH . $this->admin_theme_path)
        );

        $this->smarty->setPluginsDir(
            array(HACKADEMIC_PATH."extlib/Smarty-".$this->_smarty_version."/libs/plugins/",
            HACKADEMIC_PATH."vendor/smarty-gettext/smarty-gettext/")
        );
        $this->compile_dir = HACKADEMIC_PATH.'/view/compiled_view';
        $this->cache_dir =HACKADEMIC_PATH.'cache';
        $this->caching = ($cache_pages)?1:0;
        $this->cache_lifetime = 300;
        $this->_debug = $_debug;
        $this->assign('app_title', $app_title);
        $this->assign('site_root_path', $site_root_path);
    }

    /**
     * Assigns data to a template variable.
     * If debug is true, stores it for access by tests or developer.
     *
     * @param string  $key     Key
     * @param mixed   $value   Value
     * @param boolean $nocache No Cache.
     *
     * @return Nothing.
     */
    public function assign($key, $value = null, $nocache = false)
    {
        parent::assign($key, $value, $nocache);
        if ($this->_debug) {
            $this->_template_data[$key] = $value;
        }
    }

    /**
     * For use only by tests.
     *
     * @param string $key Key
     *
     * @return Template data value by key.
     */
    public function getTemplateDataItem($key)
    {
        return isset($this->_template_data[$key]) ? $this->_template_data[$key]:null;
    }

    /**
     * Check if caching is enabled
     *
     * @return bool
     */
    public function isViewCached()
    {
        return ($this->caching==1)?true:false;
    }

    /**
     * Turn off caching
     *
     * @return Nothing.
     */
    public function disableCaching()
    {
        $this->caching=0;
    }

    /**
     * Override the parent's clear_all_cache method to check if caching is on to
     * begin with. We do this to prevent the cache/MAKETHISDIRWRITABLE.txt from being
     * deleted during test runs; this file needs to exist in order for the cache
     * directory to remain in the git repository.
     *
     * @param int $expire_time Expire Time.
     *
     * @return Nothing.
     */
    public function clear_all_cache($exp_time = null)
    {
        if ($this->caching == 1) {
            parent::clear_all_cache($exp_time);
        }
    }

}
