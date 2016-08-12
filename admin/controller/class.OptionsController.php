<?php

/**
 *
 * Hackademic-CMS/admin/controller/class.OptionsController.php
 *
 * Hackademic Options Controller
 * Class for the Options page in the backend, the helper functions are all taken from Wordpress.
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
 * @author Wordpress
 * @author Daniel Kvist <daniel[at]danielkvist[dot]net>
 * @license http://www.gnu.org/licenses/gpl.html
 * @copyright 2013 OWASP
 *
 */
require_once(HACKADEMIC_PATH . "admin/model/class.Options.php");
require_once(HACKADEMIC_PATH . "admin/controller/class.HackademicBackendController.php");

class OptionsController extends HackademicBackendController {

    private $active_plugins = array();
    private $active_user_theme = '';
    private static $available_themes = array();

    /**
     * The main controller of the view that controls if data has been submitted or if it's
     * a regular page view. Then builds the view and generates it.
     */
    public function go() {
        if (isset($_POST['submit'])) {
            $this->handleFormData();
        } else {
            $this->setDefaultTemplateVars();
        }

        $this->buildView($this->active_plugins, $this->active_user_theme);
        $this->generateView();
    }

    /**
     * Saves the chosen active theme and plugins to the database and notifies enabled and disabled
     * plugins.
     */
    private function handleFormData() {
        // Handle plugins
        foreach ($_POST as $key => $value) {
            if (substr($key, 0, 7) == 'plugin_') {
                array_push($this->active_plugins, $value);
            }
        }
        $this->notifyEnabledPlugins(array_diff($this->active_plugins, Options::getOption('active_plugins')->value));
        $this->notifyDisabledPlugins(array_diff(Options::getOption('active_plugins')->value, $this->active_plugins));

        // Handle theme
        $new_user_theme_path = $_POST['active_user_theme'];
        if (array_key_exists($new_user_theme_path, $this->getUserThemes())) {
            if ($this->active_user_theme != $new_user_theme_path) {
                $this->smarty->clear_all_cache();
                Plugin::do_action_ref_array('enable_user_theme', array($new_user_theme_path));
                Plugin::do_action_ref_array('disable_user_theme', array($this->active_user_theme));
            }
            $this->active_user_theme = $new_user_theme_path;
        }else{
            error_log("theme doesn't exist");
            $this->addErrorMessage("Theme ".$new_user_theme_path." doesn't exist");
        }
        // Update options in database
        Options::updateOption('active_plugins', $this->active_plugins);
        Options::updateOption('active_user_theme', $this->active_user_theme);
        Options::updateOption('active_admin_theme', $this->active_user_theme);
    }

    /**
     * Notifies actions that a plugin has been enabled for each plugin in the array.
     *
     * @param $enabled_plugins
     */
    private function notifyEnabledPlugins($enabled_plugins) {
        foreach ($enabled_plugins as $plugin) {
            require_once(HACKADEMIC_PLUGIN_PATH . $plugin);
            Plugin::do_action_ref_array('enable_plugin', array($plugin));
        }
    }

    /**
     * Notifies actions that a plugin has been disabled for each plugin in the array.
     *
     * @param $disabled_plugins
     */
    private function notifyDisabledPlugins($disabled_plugins) {
        foreach ($disabled_plugins as $plugin) {
            Plugin::do_action_ref_array('disable_plugin', array($plugin));
        }
    }

    /**
     * Fetches the options for active plugins and themes from the database and sets
     * these values.
     */
    private function setDefaultTemplateVars() {
        $this->active_plugins = Options::getOption('active_plugins')->value;
        $this->active_user_theme = Options::getOption('active_user_theme')->value;
    }

    /**
     * Sets the view vars and template.
     */
    private function buildView() {
        $this->setViewTemplate('options.tpl');
        $this->addToView('plugins', $this->get_plugins());
        $this->addToView('user_themes', $this->getUserThemes());
        $this->addToView('active_plugins', $this->active_plugins);
        $this->addToView('active_user_theme', $this->active_user_theme);
        $this->addToView('system_theme', '');
    }

    /**
     * Gets the theme files and adds the site root based theme path to theme folder
     * to use as directory.
     *
     * @return array of themes with the key as the path
     */
    private function getUserThemes() {
        $themes = $this->get_plugins(HACKADEMIC_THEME_PATH);
        foreach ($themes as $path => $theme) {
            $dir = dirname($path) . '/';
            $themes['user/themes/' . $dir] = $theme;
            unset($themes[$path]);
        }
        return $themes;
    }

    /**
     * Check the plugins directory and retrieve all plugin files with plugin data.
     *
     * Hackademic only supports plugin files in the base plugins directory
     * (user/plugins) and in one directory above the plugins directory
     * (user/plugins/my-plugin). The file it looks for has the plugin data and
     * must be found in those two locations. It is recommended that do keep your
     * plugin files in directories and that the data file is named as the plugin
     * with a .php extension.
     *
     * The file with the plugin data is the file that will be included and therefore
     * needs to have the main execution for the plugin. This does not mean
     * everything must be contained in the file and it is recommended that the file
     * be split for maintainability. Keep everything in one file for extreme
     * optimization purposes.
     *
     * @param string $path to look for plugins in
     * @return array Key is the plugin file path and the value is an array of the plugin data.
     */
    private function get_plugins($path = HACKADEMIC_PLUGIN_PATH) {
        $hc_plugins = array();
        $plugins_dir = @opendir($path);

        $plugin_files = array();
        if ($plugins_dir) {
            while (($file = readdir($plugins_dir)) !== false) {
                if (substr($file, 0, 1) == '.') {
                    continue;
                }
                if (is_dir($path . $file)) {
                    $plugins_subdir = @opendir($path . $file);
                    if ($plugins_subdir) {
                        while (($subfile = readdir($plugins_subdir)) !== false) {
                            if (substr($subfile, 0, 1) == '.') {
                                continue;
                            }
                            if (substr($subfile, -4) == '.php') {
                                $plugin_files[] = "$file/$subfile";
                            }
                        }
                        closedir($plugins_subdir);
                    }
                } else {
                    if (substr($file, -4) == '.php') {
                        $plugin_files[] = $file;
                    }
                }
            }
            closedir($plugins_dir);
        }

        if (empty($plugin_files)) {
            return $hc_plugins;
        }

        foreach ($plugin_files as $plugin_file) {
            if (!is_readable($path . $plugin_file)) {
                continue;
            }

            $plugin_data = self::get_plugin_data($path . $plugin_file);

            if (empty($plugin_data['Name'])) {
                continue;
            }

            $hc_plugins[self::plugin_basename($plugin_file)] = $plugin_data;
        }

        return $hc_plugins;
    }

    /**
     * Gets the basename of a plugin.
     *
     * This method extracts the name of a plugin from its filename.
     *
     * @param string $file The filename of plugin.
     * @return string The name of a plugin.
     */
    private function plugin_basename($file) {
        $file = str_replace('\\', '/', $file); // sanitize for Win32 installs
        $file = preg_replace('|/+|', '/', $file); // remove any duplicate slash
        $plugin_dir = str_replace('\\', '/', HACKADEMIC_PLUGIN_PATH); // sanitize for Win32 installs
        $plugin_dir = preg_replace('|/+|', '/', $plugin_dir); // remove any duplicate slash
        $file = preg_replace('#^' . preg_quote($plugin_dir, '#') . '/|^' . '/#', '', $file); // get relative path from plugins dir
        $file = trim($file, '/');
        return $file;
    }

    /**
     * Parse the plugin contents to retrieve plugin's metadata.
     *
     * The metadata of the plugin's data searches for the following in the plugin's
     * header. All plugin data must be on its own line. For plugin description, it
     * must not have any newlines or only parts of the description will be displayed
     * and the same goes for the plugin data. The below is formatted for printing.
     *
     * <code>
     * /*
     * Plugin Name: Name of Plugin
     * Plugin URI: Link to plugin information
     * Description: Plugin Description
     * Author: Plugin author's name
     * Author URI: Link to the author's web site
     * Version: Must be set in the plugin for WordPress 2.3+
     * </code>
     *
     * Plugin data returned array contains the following:
     * 		'Name' - Name of the plugin, must be unique.
     * 		'Title' - Title of the plugin and the link to the plugin's web site.
     * 		'Description' - Description of what the plugin does and/or notes
     * 		from the author.
     * 		'Author' - The author's name
     * 		'AuthorURI' - The authors web site address.
     * 		'Version' - The plugin version number.
     * 		'PluginURI' - Plugin web site address.
     *
     * Some users have issues with opening large files and manipulating the contents
     * for want is usually the first 1kiB or 2kiB. This function stops pulling in
     * the plugin contents when it has all of the required plugin data.
     *
     * The first 8kiB of the file will be pulled in and if the plugin data is not
     * within that first 8kiB, then the plugin author should correct their plugin
     * and move the plugin data headers to the top.
     *
     * The plugin file is assumed to have permissions to allow for scripts to read
     * the file. This is not checked however and the file is only opened for
     * reading.
     *
     * @param string $plugin_file Path to the plugin file
     * @return array See above for description.
     */
    private function get_plugin_data($plugin_file) {
        $default_headers = array(
            'Name' => 'Plugin Name',
            'PluginURI' => 'Plugin URI',
            'Version' => 'Version',
            'Description' => 'Description',
            'Author' => 'Author',
            'AuthorURI' => 'Author URI',
        );

        $plugin_data = self::get_file_data($plugin_file, $default_headers, 'plugin');
        $plugin_data['Title'] = $plugin_data['Name'];
        $plugin_data['AuthorName'] = $plugin_data['Author'];

        return $plugin_data;
    }

    /**
     * Retrieve metadata from a file.
     *
     * Searches for metadata in the first 8kiB of a file, such as a plugin or theme.
     * Each piece of metadata must be on its own line. Fields can not span multiple
     * lines, the value will get cut at the end of the first line.
     *
     * If the file data is not within that first 8kiB, then the author should correct
     * their plugin file and move the data headers to the top.
     *
     * @param string $file Path to the file
     * @param array $default_headers List of headers, in the format array('HeaderKey' => 'Header Name')
     * @param string $context If specified adds filter hook "extra_{$context}_headers"
     * @return all headers
     */
    private function get_file_data($file, $default_headers, $context = '') {
        // We don't need to write to the file, so just open for reading.
        $fp = fopen($file, 'r');

        // Pull only the first 8kiB of the file in.
        $file_data = fread($fp, 8192);

        // PHP will close file handle, but we are good citizens.
        fclose($fp);

        // Make sure we catch CR-only line endings.
        $file_data = str_replace("\r", "\n", $file_data);

        $all_headers = $default_headers;
        foreach ($all_headers as $field => $regex) {
            if (preg_match('/^[ \t\/*#@]*' . preg_quote($regex, '/') . ':(.*)$/mi', $file_data, $match) && $match[1]) {
                $all_headers[$field] = strip_tags(self::cleanup_header_comment($match[1]));
            } else {
                $all_headers[$field] = '';
            }
        }

        return $all_headers;
    }

    /**
     * Strip close comment and close php tags from file headers used by Hackademic.
     *
     * @param string $str
     * @return string
     */
    private function cleanup_header_comment($str) {
        return trim(preg_replace("/\s*(?:\*\/|\?>).*/", '', $str));
    }

}
