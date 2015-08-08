<?php
/**
 * Hackademic-CMS/model/common/class.Challenge.php
 *
 * Hackademic Challenge Class
 * Class for Hackademic's Challenge Object
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

class Debug
{

	public static function show($vars,$level='all',$class = " ", $function = " ")
	{
		if ('all' == $level) {
			self::sqlShowQuery($vars[0]);
			self::sqlShow_Result($vars);
			self::varShowEmpty($vars, get_class($class), $function);
			}
	}

	public static function sqlShowQuery($query)
	{
		if ("dev" ==ENVIRONMENT) {
			if (true === SHOW_SQL_QUERIES) {
				echo "<p>".var_dump($query)."</p>";
			}
		}

	}

	public static function sqlShowResult($result_array)
	{
		if ("dev" ==ENVIRONMENT) {
			if (true === SHOW_SQL_RESULTS) {
				foreach ($result_array as $res) {
					echo "<p>".var_dump($res)."</p>";
				}
			}
		}

	}

	public static function varShowEmpty($vars, $class_name, $function_name)
	{
		if ("dev" ==ENVIRONMENT && true === SHOW_EMPTY_VAR_ERRORS) {
			if (is_array($vars)) {
				foreach ($vars as $name=>$value) {
					echo "<p> error: {$class_name}.{$function_name}() {$name} == ".$value."</p>";
				}
			} else {
				echo "<p> error: {$class_name}.{$function_name}() {$vars} is empty </p>";
			}
		}
	}

	public static function varsGetValue($vars)
	{
		if ("dev" ==ENVIRONMENT) {
			if (true === SHOW_VAR_VALUES) {
				if (is_array($vars)) {
					foreach ($vars as $name=>$var) {
					echo "<p>".var_dump($var)."</p>";
					}
				} else {
					echo "<p>".var_dump($vars)."</p>";
				}
			}
		}


	}
	public static function prettyPrint($arr, $callback = false)
	{
    $retStr = '<ul>';
    if (is_array($arr)) {
        foreach ($arr as $key=>$val) {
            if (is_array($val)) {
                $retStr .= '<li>' . $key . ' => ' . self::prettyPrint($val) . '</li>';
            } else {
								if ($callback != false) {
									$retStr .= '<li>' . $key . ' => ' . call_user_func($callback, $val)  . '</li>';
								} else {
									$retStr .= '<li>' . $key . ' => ' . $val  . '</li>';
								}
            }
        }
    }
    $retStr .= '</ul>';
    return $retStr;
	}
}
