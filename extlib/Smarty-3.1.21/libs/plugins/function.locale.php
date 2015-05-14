<?php
/**
* ------------------------------------------------------------------------- *
* This library is free software; you can redistribute it and/or *
* modify it under the terms of the GNU Lesser General Public *
* License as published by the Free Software Foundation; either *
* version 2.1 of the License, or (at your option) any later version. *
* *
* This library is distributed in the hope that it will be useful, *
* but WITHOUT ANY WARRANTY; without even the implied warranty of *
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU *
* Lesser General Public License for more details. *
* *
* You should have received a copy of the GNU Lesser General Public *
* License along with this library; if not, write to the Free Software *
* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA *
* ------------------------------------------------------------------------- *
*
* @package smarty-gettext
* @link https://github.com/smarty-gettext/smarty-gettext/
* @author Karlheinz Toni <karlheinz.toni@gmail.com>
* @author Boleslaw Tekielski <bolek@gvault13.pl>
* @author Elan Ruusamäe <glen@delfi.ee>
* @copyright 2012 Karlheinz Toni
* @copyright 2015 Boleslaw Tekielski
* @copyright 2015 Elan Ruusamäe
*/
function smarty_function_locale($params, &$smarty) {
static $stack;
// init stack as array
if ($stack === null) {
$stack = array();
}
$path = $smarty->template_dir . $params['path'];
$domain = isset($params['domain']) ? $params['domain'] : 'messages';
$stack_operation = isset($params['stack']) ? $params['stack'] : 'push';
if (!$path && $stack_operation != 'pop') {
trigger_error("static (file {$smarty->template}): missing 'path' parameter.", E_USER_ERROR);
}
if ($stack_operation == 'push') {
$stack[] = array($domain, $path);
} elseif ($stack_operation == 'pop') {
if (count($stack) > 1) {
array_pop($stack);
}
list($domain, $path) = end($stack);
} else {
trigger_error("Unknown stack operation '{$stack_operation}'", E_USER_ERROR);
}
bind_textdomain_codeset($domain, 'UTF-8');
bindtextdomain($domain, $path);
textdomain($domain);
}