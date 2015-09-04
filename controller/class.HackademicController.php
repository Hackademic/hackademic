<?php
/**
 * Hackademic-CMS/controller/class.HackademicController.php
 *
 * Hackademic Controller
 * The parent class of all Hackademic CMS controllers
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
require_once HACKADEMIC_PATH . "model/common/class.SmartyHackademic.php";
require_once HACKADEMIC_PATH . "model/common/class.Session.php";
require_once HACKADEMIC_PATH . "controller/class.ChallengeMenuController.php";
require_once HACKADEMIC_PATH . "controller/class.UserMenuController.php";
require_once HACKADEMIC_PATH . "/esapi/class.Esapi_Utils.php";

abstract class HackademicController
{

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
     * @var _session_exists
     */
    private static $_session_exists;

    /**
     * @var _app_session
     */
    private $_app_session;

    /**
     * Constructor to initialize the Main Controller
     */
    public function __construct()
    {
        if (!self::$_session_exists) {
            self::$_session_exists = 1;
            Session::start(SESS_EXP_ABS);
           }
        if (isset($_SESSION['hackademic_user']) && !Session::isValid()) {
            Session::logout();
            header('Location:' . SOURCE_ROOT_PATH . "?url=home");
            die();
           }
        $this->smarty = new SmartyHackademic();
        $this->_app_session = new Session();
        if (self::isLoggedIn()) {
            $this->addToView('is_logged_in', true);
            $this->addToView('logged_in_user', self::getLoggedInUser());
           }
        if (self::isAdmin()) {
            $this->addToView('user_type', true);
           }

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
     * @param str $script javascript path
     *
     * @return Nothing.
     */
    public function addHeaderJavaScript($script)
    {
        array_push($this->header_scripts, $script);
 }

    /**
     * Set Page Title
     *
     * @param $title str Page Title
     *
     * @return Nothing.
     */
    public function addPageTitle($title)
    {
        $this->addToView('controller_title', $title);
 }

    /**
     * Function to set view template
     *
     * @param $tmpl str Template name
     *
     * @return Nothing.
     */
    public function setViewTemplate($tmpl)
    {
        $path = $this->smarty->user_theme_path . $tmpl;
        $new_path = Plugin::apply_filters_ref_array('set_view_template', array($path));
        if ($new_path != '') {
            $path = $new_path;
           }
        $this->view_template = HACKADEMIC_PATH . $path;
 }

    /**
     * Generate View In Smarty
     *
     * @param string $type the type of view that is being generated. The type is used
     *                     to trigger an action of the form 'show_[type]'
     *                     i.e. 'show_article_manager'
     *
     * @return Nothing.
     */
    public function generateView($type = 'view')
    {
        $view_path = $this->view_template;
        $this->addToView('header_scripts', $this->header_scripts);
        Plugin::do_action_ref_array('show_' . $type, array($this->smarty));
        return $this->smarty->display($view_path);
 }

    /**
     * Add error message to view
     *
     * @param str $msg Error Message.
     *
     * @return Nothing.
     */
    public function addErrorMessage($msg)
    {
        $this->disableCaching();
        $this->addToView('errormsg', $msg);
 }

    /**
     * Add success message to view
     *
     * @param str $msg Success Message.
     *
     * @return Nothing.
     */
    public function addSuccessMessage($msg)
    {
        $this->disableCaching();
        $this->addToView('successmsg', $msg);
 }

    /**
     * Disable Caching
     */
    protected function disableCaching()
    {
        $this->smarty->disableCaching();
 }

    /**
     * Returns whether or not Hackademic user is logged in
     *
     * @return bool whether or not user is logged in
     */
    protected static function isLoggedIn()
    {
        return Session::isLoggedIn();
 }

    /**
     * Function to add data to Smarty Template
     *
     * @param str $key   Variable name in Smarty
     * @param str $value Variable value in Smarty
     *
     * @return Nothing.
     */
    public function addToView($key, $value)
    {
        $this->smarty->assign($key, $value);
 }

    /**
     * Returns whether or not a logged-in Hackademic user is an admin
     *
     * @return bool whether or not logged-in user is an admin
     */
    protected static function isAdmin()
    {
        return Session::isAdmin();
 }

    /**
     * Returns whether or not a logged-in Hackademic user is a teacher
     *
     * @return bool whether or not logged-in user is an admin
     */
    protected static function isTeacher()
    {
        return Session::isTeacher();
 }

    /**
     * Return username of logged-in user
     *
     * @return str username
     */
    public static function getLoggedInUser()
    {
        return Session::getLoggedInUser();
 }

}
