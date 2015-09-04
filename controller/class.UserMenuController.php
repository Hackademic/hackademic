<?php
/**
 * Hackademic-CMS/controller/class.UserMenuController.php
 *
 * Hackademic User Menu Controller
 * Class for creating the frontend Main Menu
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
require_once HACKADEMIC_PATH . 'model/common/class.Menu.php';

class UserMenuController
{

    public static function go()
    {
        $menu = self::createMainMenu();
        return $menu;
    }

    /**
     * Create Main Menu
     */
    protected static function createMainMenu()
    {
        if (Session::isAdmin()) {
            $menu = Menu::getMenu(Menu::ADMIN_MENU)->items;
        } elseif (Session::isTeacher()) {
            $menu = Menu::getMenu(Menu::TEACHER_MENU)->items;
        } else {
            $menu = Menu::getMenu(Menu::STUDENT_MENU)->items;        
        }
        return $menu;
    }
  
}

