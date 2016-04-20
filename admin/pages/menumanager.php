<?php

/**
 *
 * Hackademic-CMS/admin/pages/menumanager.php
 *
 * The page for managing the menus
 * 
 * Copyright (c) 2013 OWASP
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
 * @author Daniel Kvist <daniel[at]danielkvist[dot]net>
 * @license http://www.gnu.org/licenses/gpl.html
 * @copyright 2013 OWASP
 *
 */

require_once(HACKADEMIC_PATH . "admin/controller/class.MenuManagerController.php");

$controller = new MenuManagerController();
echo $controller->go();
