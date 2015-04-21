<?php

/**
 *
 * Hackademic-CMS/controller/class.HackademicController.php
 *
 * Hackademic Controller
 * The parent class of all Hackademic CMS controllers
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
require_once(HACKADEMIC_PATH . "model/common/class.SmartyHackademic.php");
require_once(HACKADEMIC_PATH . "model/common/class.Session.php");
//require_once(HACKADEMIC_PATH."controller/class.FrontendMenuController.php");
require_once(HACKADEMIC_PATH . "controller/class.ChallengeMenuController.php");
require_once(HACKADEMIC_PATH . "controller/class.UserMenuController.php");
require_once(HACKADEMIC_PATH . "/esapi/class.Esapi_Utils.php");

abstract class HackademicController {

    /**
     * @var Smarty Object
     */
    protected $smarty;

    /**
     * @var template path
     */
    protected $tmpl;

    /**
     * @var view template
     */
    protected $view_template;

    /**
     * @var array
     */
    protected $header_scripts = array();

    /**
     * @var session_exists
     */
    private static $session_exists;

    /**
     * @var app_session
     */
    private $app_session;

    /**
     * Constructor to initialize the Main Controller
     */
    public function __construct() {
        if (!self::$session_exists) {
            self::$session_exists = 1;
            Session::start(SESS_EXP_ABS);
            //var_dump("no session");
            //die("no session");
        }
        //TODO: move the locale settings somewhere where they  get executed only once
        // I18N support information here
        $language = LANG;
        putenv("LANG=" . $language);
        setlocale(LC_ALL, $language);
        // Set the text domain as "messages"
        $domain = "messages";
        bindtextdomain($domain, "locale");
        bind_textdomain_codeset($domain, 'UTF-8');
        textdomain($domain);

        if (isset($_SESSION['hackademic_user']) && !Session::isValid()) {
            //die(" session but not valid");
            //error_log("session but not valid", 0);
            Session::logout();
            header('Location:' . SOURCE_ROOT_PATH . "?url=home");
            die();
        }
        //var_dump($_SESSION);
        $this->smarty = new SmartyHackademic();
        $this->app_session = new Session();
        if (self::isLoggedIn()) {
            $this->addToView('is_logged_in', true);
            $this->addToView('logged_in_user', self::getLoggedInUser());
        }
        if (self::isAdmin()) {
            $this->addToView('user_type', true);
        }
        /* 			$menu=FrontendMenuController::go();
          $this->addToView('main_menu',$menu); */

        $challenge_menu = ChallengeMenuController::go();
        $this->addToView('challenge_menu', $challenge_menu);

        if (self::isLoggedIn()) {
            $usermenu = UserMenuController::go();
            $this->addToView('user_menu', $usermenu);
        }
    }

    /**
     * Add javascript to header
     *
     * @param str javascript path
     */
    public function addHeaderJavaScript($script) {
        array_push($this->header_scripts, $script);
    }

    /**
     * Set Page Title
     * @param $title str Page Title
     */
    public function addPageTitle($title) {
        $this->addToView('controller_title', $title);
    }

    /**
     * Function to set view template
     * @param $tmpl str Template name
     */
    public function setViewTemplate($tmpl) {
        $path = $this->smarty->user_theme_path . $tmpl;
        $new_path = Plugin::apply_filters_ref_array('set_view_template', array($path));
        if ($new_path != '') {
            $path = $new_path;
        }
        $this->view_template = HACKADEMIC_PATH . $path;
    }

    /**
     * Generate View In Smarty
     * @param string $type the type of view that is being generated. The type is used to trigger
     * an action of the form 'show_[type]' i.e. 'show_article_manager'
     */
    public function generateView($type = 'view') {
        $view_path = $this->view_template;
        $this->addToView('header_scripts', $this->header_scripts);
        Plugin::do_action_ref_array('show_' . $type, array($this->smarty));
        return $this->smarty->display($view_path);
    }

    /**
     * Add error message to view
     * @param str $msg
     */
    public function addErrorMessage($msg) {
        $this->disableCaching();
        $this->addToView('errormsg', $msg);
    }

    /**
     * Add success message to view
     * @param str $msg
     */
    public function addSuccessMessage($msg) {
        $this->disableCaching();
        $this->addToView('successmsg', $msg);
    }

    /**
     * Disable Caching
     */
    protected function disableCaching() {
        $this->smarty->disableCaching();
    }

    /**
     * Returns whether or not Hackademic user is logged in
     *
     * @return bool whether or not user is logged in
     */
    protected static function isLoggedIn() {
        return Session::isLoggedIn();
    }

    /**
     * Function to add data to Smarty Template
     * @param $key str Variable name in Smarty
     * @param $value str Variable value in Smarty
     */
    public function addToView($key, $value) {
        $this->smarty->assign($key, $value);
    }

    /**
     * Returns whether or not a logged-in Hackademic user is an admin
     *
     * @return bool whether or not logged-in user is an admin
     */
    protected static function isAdmin() {
        return Session::isAdmin();
    }

    /**
     * Returns whether or not a logged-in Hackademic user is a teacher
     *
     * @return bool whether or not logged-in user is an admin
     */
    protected static function isTeacher() {
        return Session::isTeacher();
    }

    /**
     * Return username of logged-in user
     *
     * @return str username
     */
    public static function getLoggedInUser() {
        return Session::getLoggedInUser();
    }

}
