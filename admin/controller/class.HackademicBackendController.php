<?php
/**
 * Hackademic-CMS/admin/controller/class.HackademicBackendController.php
 *
 * Hackademic Backend Controller
 * The parent class of all Hackademic Backend controllers.
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
require_once HACKADEMIC_PATH."model/common/class.Session.php";
require_once HACKADEMIC_PATH."admin/controller/class.MenuController.php";
require_once HACKADEMIC_PATH."controller/class.HackademicController.php";
require_once HACKADEMIC_PATH."extlib/NoCSRF/nocsrf.php";

class HackademicBackendController extends HackademicController
{

    public function __construct()
    {
        HackademicController::__construct();

        $token = $_SESSION['token'];
        $this->addToView('token', $token);

        if (isset($_POST['submit']) ) {
            try {
                //this is only for post requests and for testing purposes
             //   var_dump($_POST);
                NoCSRF::check('csrf_token', $_POST, true, 60*10, true);
            }
            catch ( Exception $e ) {
                // CSRF attack detected
                die('Invalid CSRF token');
            }
        }

        // Login Controller, do nothing
        if (get_class($this) == 'LoginController') {
            return;
        }
        if (!self::isLoggedIn()) {
            header('Location: '.SOURCE_ROOT_PATH."?url=admin/login");
            die();
        } elseif (self::isLoggedIn()) {
            if ((self::isAdmin() || (self::isTeacher()))) {
                // If is Admin or Teacher, go to Admin Dashboard
                $menu=MenuController::go();
                $this->addToView("main_menu_admin", $menu);
            } else {
                header('Location: '.SOURCE_ROOT_PATH);
                die();
            }
            // Else go to main site
        }
    }


    /**
     * Function to set view template
     *
     * @param string $tmp1 Template name
     *
     * @return Nothing.
     */
    public function setViewTemplate($tmp1)
    {
        $admin_path = $this->smarty->admin_theme_path . $tmp1;
        $path = Plugin::apply_filters_ref_array('set_admin_view_template', array($admin_path));
        if ($path == "") {
            $path = $admin_path;
        }
        $this->view_template = HACKADEMIC_PATH . $path;
    }

}
