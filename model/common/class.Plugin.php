<?php
/**
 * Hackademic-CMS/model/common/class.Plugin.php
 *
 * Hackademic Plugin Class
 * Class for Hackademic's Plugin API
 *
 * This class contains the plugin API that 3rd party plugins can use to add actions and filters
 * that the Hackademic core executes.
 *
 * The whole class is based on the Wordpress Plugin API (http://codex.wordpress.org/Plugin_API/)
 * with very few modifications to suit the Hackademic Challenges Project.
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
 * @author Wordpress <http://codex.wordpress.org/Plugin_API/>
 * @author Daniel Kvist <daniel[at]danielkvist[dot]net>
 * @license http://www.gnu.org/licenses/gpl.html
 * @copyright 2013 OWASP
 *
 */

class Plugin {

  /**
   * Loads the active plugins using include_once so we don't crash the site if
   * a plugin can't be found. Also loads the required files for the rest of the class.
   */
  public static function loadPlugins() {
    require_once(HACKADEMIC_PATH . "admin/model/class.Options.php");
    require_once(HACKADEMIC_PATH . "admin/model/class.MenuBackend.php");
    require_once(HACKADEMIC_PATH . "admin/model/class.PageBackend.php");
    $active_plugins = Options::getOption('active_plugins')->value;
    foreach($active_plugins as $plugin) {
      include_once(HACKADEMIC_PLUGIN_PATH . $plugin);
    }
  }

  /**
   * Hooks a function or method to a specific filter action.
   *
   * Filters are the hooks that Hackademic launches to modify text of various types
   * before adding it to the database or sending it to the browser screen. Plugins
   * can specify that one or more of its PHP functions is executed to
   * modify specific types of text at these times.
   *
   * To use the API, the following code should be used to bind a callback to the
   * filter.
   *
   * <code>
   * function example_hook($example) { echo $example; }
   * add_filter('example_filter', 'example_hook');
   * </code>
   *
   * The $accepted_args allow for calling functions only when the number of args
   * match. Hooked functions can take extra arguments that are set when the
   * matching do_action_ref_array() or apply_filters_ref_array() call is run.
   *
   * <strong>Note:</strong> the function will return TRUE no matter if the
   * function was hooked fails or not. There are no checks for whether the
   * function exists beforehand and no checks to whether the <tt>$function_to_add
   * is even a string. It is up to you to take care and this is done for
   * optimization purposes, so everything is as quick as possible.
   *
   * @global array $hc_filter Stores all of the filters added in the form of
   *	hc_filter['tag']['array of priorities']['array of functions serialized']['array of ['array (functions, accepted_args)']']
   * @global array $merged_filters Tracks the tags that need to be merged for later. If the hook is added, it doesn't need to run through that process.
   *
   * @param string $tag The name of the filter to hook the $function_to_add to.
   * @param callback $function_to_add The name of the function to be called when the filter is applied.
   * @param int $priority optional. Used to specify the order in which the functions associated with a particular action are executed (default: 10). Lower numbers correspond with earlier execution, and functions with the same priority are executed in the order in which they were added to the action.
   * @param int $accepted_args optional. The number of arguments the function accept (default 1).
   * @return boolean TRUE
   */
  public static function add_filter($tag, $function_to_add, $priority = 10, $accepted_args = 1) {
    global $hc_filter, $merged_filters;

    $idx = self::_hc_filter_build_unique_id($tag, $function_to_add, $priority);
    $hc_filter[$tag][$priority][$idx] = array('function' => $function_to_add, 'accepted_args' => $accepted_args);
    unset($merged_filters[$tag]);
    return TRUE;
  }

  /**
   * Execute functions hooked on a specific filter hook, specifying arguments in an array.
   *
   *
   * The callback functions attached to filter hook $tag are invoked by calling
   * this function. This function can be used to create a new filter hook by
   * simply calling this function with the name of the new hook specified using
   * the $tag parameter.
   *
   * @global array $hc_filter Stores all of the filters
   * @global array $merged_filters Merges the filter hooks using this function.
   * @global array $hc_current_filter stores the list of current filters with the current one last
   *
   * @param string $tag The name of the filter hook.
   * @param array $args The arguments supplied to the functions hooked to <tt>$tag</tt>
   * @return mixed The filtered value after all hooked functions are applied to it.
   */
  public static function apply_filters_ref_array($tag, $args) {
    global $hc_filter, $merged_filters, $hc_current_filter;

    if(!isset($hc_filter[$tag])) {
      return $args[0];
    }

    $hc_current_filter[] = $tag;

    // Sort
    if(!isset($merged_filters[$tag])) {
      ksort($hc_filter[$tag]);
      $merged_filters[$tag] = TRUE;
    }

    reset($hc_filter[$tag]);

    do {
      foreach((array) current($hc_filter[$tag]) as $the_) {
        if(!is_null($the_['function'])) {
          $args[0] = call_user_func_array($the_['function'], array_slice($args, 0, (int) $the_['accepted_args']));
        }
      }
    } while (next($hc_filter[$tag]) !== FALSE);

    array_pop($hc_current_filter);

    return $args[0];
  }

  /**
   * Removes a function from a specified filter hook.
   *
   * This function removes a function attached to a specified filter hook. This
   * method can be used to remove default functions attached to a specific filter
   * hook and possibly replace them with a substitute.
   *
   * To remove a hook, the $function_to_remove and $priority arguments must match
   * when the hook was added. This goes for both filters and actions. No warning
   * will be given on removal failure.
   *
   * @param string $tag The filter hook to which the function to be removed is hooked.
   * @param callback $function_to_remove The name of the function which should be removed.
   * @param int $priority optional. The priority of the function (default: 10).
   * @return boolean Whether the function existed before it was removed.
   */
  public static function remove_filter($tag, $function_to_remove, $priority = 10) {
    $function_to_remove = self::_hc_filter_build_unique_id($tag, $function_to_remove, $priority);

    $r = isset($GLOBALS['hc_filter'][$tag][$priority][$function_to_remove]);

    if(TRUE === $r) {
      unset($GLOBALS['hc_filter'][$tag][$priority][$function_to_remove]);
      if(empty($GLOBALS['hc_filter'][$tag][$priority])) {
        unset($GLOBALS['hc_filter'][$tag][$priority]);
      }
      unset($GLOBALS['merged_filters'][$tag]);
    }

    return $r;
  }

  /**
   * Remove all of the hooks from a filter.
   *
   * @param string $tag The filter to remove hooks from.
   * @param bool|int $priority The priority number to remove.
   * @return boolean TRUE when finished.
   */
  public static function remove_all_filters($tag, $priority = FALSE) {
    global $hc_filter, $merged_filters;

    if(isset($hc_filter[$tag])) {
      if(FALSE !== $priority && isset($hc_filter[$tag][$priority])) {
        unset($hc_filter[$tag][$priority]);
      }
      else {
        unset($hc_filter[$tag]);
      }
    }

    if(isset($merged_filters[$tag])) {
      unset($merged_filters[$tag]);
    }

    return TRUE;
  }

  /**
   * Hooks a function on to a specific action.
   *
   * Actions are the hooks that the WordPress core launches at specific points
   * during execution, or when specific events occur. Plugins can specify that
   * one or more of its PHP functions are executed at these points, using the
   * Action API.
   *
   * @uses add_filter() Adds an action. Parameter list and functionality are the same.
   *
   * @param string $tag The name of the action to which the $function_to_add is hooked.
   * @param callback $function_to_add The name of the function you wish to be called.
   * @param int $priority optional. Used to specify the order in which the functions associated with a particular action are executed (default: 10). Lower numbers correspond with earlier execution, and functions with the same priority are executed in the order in which they were added to the action.
   * @param int $accepted_args optional. The number of arguments the function accept (default 1).
   * @return boolean TRUE
   */
  public static function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1) {
    return self::add_filter($tag, $function_to_add, $priority, $accepted_args);
  }

  /**
   * Execute functions hooked on a specific action hook, specifying arguments in an array.
   *
   * @see do_action() This function is identical, but the arguments passed to the
   * functions hooked to <tt>$tag</tt> are supplied using an array.
   *
   * @global array $hc_filter Stores all of the filters
   * @global array $hc_actions Increments the amount of times action was triggered.
   *
   * @param string $tag The name of the action to be executed.
   * @param array $args The arguments supplied to the functions hooked to <tt>$tag</tt>
   * @return NULL Will return NULL if $tag does not exist in $hc_filter array
   */
  public static function do_action_ref_array($tag, $args) {
    global $hc_filter, $hc_actions, $merged_filters, $hc_current_filter;

    if(!isset($hc_actions)) {
      $hc_actions = array();
    }

    if(!isset($hc_actions[$tag])) {
      $hc_actions[$tag] = 1;
    } else {
      ++$hc_actions[$tag];
    }

    if(!isset($hc_filter[$tag])) {
      return;
    }

    $hc_current_filter[] = $tag;

    // Sort
    if(!isset($merged_filters[$tag])) {
      ksort($hc_filter[$tag]);
      $merged_filters[$tag] = TRUE;
    }

    reset($hc_filter[$tag]);

    do {
      foreach((array) current($hc_filter[$tag]) as $the_) {
        if(!is_null($the_['function'])) {
          call_user_func_array($the_['function'], array_slice($args, 0, (int) $the_['accepted_args']));
        }
      }
    } while(next($hc_filter[$tag]) !== FALSE);

    array_pop($hc_current_filter);
  }

  /**
   * Removes a function from a specified action hook.
   *
   * This function removes a function attached to a specified action hook. This
   * method can be used to remove default functions attached to a specific filter
   * hook and possibly replace them with a substitute.
   *
   * @param string $tag The action hook to which the function to be removed is hooked.
   * @param callback $function_to_remove The name of the function which should be removed.
   * @param int $priority optional The priority of the function (default: 10).
   * @return boolean Whether the function is removed.
   */
  public static function remove_action($tag, $function_to_remove, $priority = 10) {
    return self::remove_filter($tag, $function_to_remove, $priority);
  }

  /**
   * Remove all of the hooks from an action.
   *
   * @param string $tag The action to remove hooks from.
   * @param bool|int $priority The priority number to remove them from.
   * @return boolean TRUE when finished.
   */
  public static function remove_all_actions($tag, $priority = FALSE) {
    return self::remove_all_filters($tag, $priority);
  }
  
  /**
   * Adds a menu with the given name.
   *
   * @param the name of the menu such as 'My menu'
   * @return true if added
   */
  public static function add_menu($name) {
    return MenuBackend::addMenu($name);
  }
  
  /**
   * Retrives the menu for the given menu id
   * 
   * @param the id of the menu to load
   * @return an array with the menu items
   */
  public static function get_menu($mid) {
    return MenuBackend::getMenu($mid);
  }
  
  /**
   * Updates the menu with the given menu id to the given name.
   *
   * @param menu id of the menu to update
   * @param the new name of the menu such as 'My new menu'
   * @return true if updated
   */
  public static function update_menu($mid, $name) {
    return MenuBackend::updateMenu($mid, $name);
  }
  
  /**
   * Deletes the menu with the given menu id.
   *
   * @param menu id of the menu to delete
   * @return true if deleted
   */  
  public static function delete_menu($mid) {
    return MenuBackend::deleteMenu($mid);    
  }

  /**
   * Adds a page mapping from the given url to the file.
   *
   * @param the url to map
   * @param the path to the file that generates the page view. The path should be relative
   * to the HACKADEMIC_PATH variable which is the web root as default.
   * @return true if added
   */
  public static function add_page($url, $file) {
    return PageBackend::addPage($url, $file);
  }

  /**
   * Retrives the file for the given url
   * 
   * @param the $url to load the file for
   * @return the path to the file
   */
  public static function get_file_for_page($url) {
    return PageBackend::getFile($url);
  }

  /**
   * Updates a page mapping from the given url to the new file.
   *
   * @param the url to update the mapping for
   * @param the new path to the file that generates the page view. The path should be relative
   * to the HACKADEMIC_PATH variable which is the web root as default.
   * @return true if updated
   */
  public static function update_page($url, $file){
    return PageBackend::updatePage($url, $file);
  }

    /**
   * Deletes a page mapping for the given url.
   *
   * @param the url to delete the page mapping for.
   * @return true if deleted
   */
  public static function delete_page($url){
    return PageBackend::deletePage($url);
  }
  
  /**
   * Adds a menu item to the menu with the given menu id. The menu item
   * needs a url to point to, a label to display and a integer to sort on.
   *
   * @param the url for the menu item
   * @param the menu id that the menu item belongs to
   * @param the label for the menu item that is visible to the user
   * @param the parent menu item id if there is one, otherwise 0 if root item
   * @param the sort integer for the menu item, sort is made ascending  
   * @return true if added
   */
	public static function add_menu_item($url, $mid, $label, $parent, $sort) {
	  return MenuBackend::addMenuItem($url, $mid, $label, $parent, $sort);
	}
  
  /**
   * Updates a menu item to the menu with the given menu id. The menu item
   * needs a url to point to, a label to display and a integer to sort on.
   *
   * @param the url for the menu item
   * @param the menu id that the menu item belongs to
   * @param the new label for the menu item that is visible to the user
   * @param the parent menu item id if there is one, otherwise 0 if root item
   * @param the new sort integer for the menu item, sort is made ascending  
   * @return true if updated
   */
	public static function update_menu_item($url, $mid, $label, $parent, $sort) {
	  return MenuBackend::updateMenuItem($url, $mid, $label, $parent, $sort);
	}
  
  /**
   * Deletes a menu item to the menu with the given menu id.
   *
   * @param the url for the menu item
   * @param the menu id that the menu item belongs to
   * @return true if deleted
   */
	public static function delete_menu_item($url, $mid) {
	  return MenuBackend::deleteMenuItem($url, $mid);
	}

  /**
   * Build Unique ID for storage and retrieval.
   *
   * The old way to serialize the callback caused issues and this function is the
   * solution. It works by checking for objects and creating an a new property in
   * the class to keep track of the object and new objects of the same class that
   * need to be added.
   *
   * It also allows for the removal of actions and filters for objects after they
   * change class properties. It is possible to include the property $hc_filter_id
   * in your class and set it to "NULL" or a number to bypass the workaround.
   * However this will prevent you from adding new classes and any new classes
   * will overwrite the previous hook by the same class.
   *
   * Functions and static method callbacks are just returned as strings and
   * shouldn't have any speed penalty.
   *
   * @global array $hc_filter Storage for all of the filters and actions
   * @param string $tag Used in counting how many hooks were applied
   * @param callback $function Used for creating unique id
   * @param int|bool $priority Used in counting how many hooks were applied. If === FALSE and $function is an object reference, we return the unique id only if it already has one, FALSE otherwise.
   * @return string|bool Unique ID for usage as array key or FALSE if $priority === FALSE and $function is an object reference, and it does not already have a unique id.
   */
  private static function _hc_filter_build_unique_id($tag, $function, $priority) {
    global $hc_filter;
    static $filter_id_count = 0;

    if(is_string($function)) {
      return $function;
    }

    if(is_object($function)) {
      // Closures are currently implemented as objects
      $function = array($function, '');
    } else {
      $function = (array) $function;
    }

    if(is_object($function[0])) {
      // Object Class Calling
      if(function_exists('spl_object_hash')) {
        return spl_object_hash($function[0]) . $function[1];
      } else {
          $obj_idx = get_class($function[0]).$function[1];
          if(!isset($function[0]->hc_filter_id)) {
            if(FALSE === $priority) {
              return FALSE;
            }
            $obj_idx .= isset($hc_filter[$tag][$priority]) ? count((array)$hc_filter[$tag][$priority]) : $filter_id_count;
            $function[0]->hc_filter_id = $filter_id_count;
            ++$filter_id_count;
          } else {
            $obj_idx .= $function[0]->hc_filter_id;
          }

          return $obj_idx;
        }
      } else if(is_string($function[0])) {
        // Static Calling
        return $function[0].$function[1];
    }
  }

}
