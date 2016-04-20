<?php

global $connection;

error_reporting(E_ALL); 
ini_set('display_errors', 1);

function buildActionsOutput() {
  $handle = query("select * from actions");
  $preface = "This page contains a list of all the actions that are triggered by the Plugin API in OWASP Hackademic Challenges. You can click each link in the list to see the specifics for each action.";
  $links = '### Actions' . "\n";
  $output = '';
  while($row = fetchArray($handle)) {
    $links .= "* [" . $row['action'] . "](#" . $row['action'] . ")\n";
    $output .= buildActionsBody($row);
  }
  return $links . "\n" . $output;
}

function write($filename, $output) {
  $fh = fopen($filename, 'w');
  fwrite($fh, $output);
  fclose($fh);
}

function connect() {
  global $connection;
  try {
  	$connection = new PDO("mysql:host=localhost;dbname=plugindocs", 'root', '');
  } catch(PDOException $e) {
  	echo $e->getMessage();
  }
  $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

function query($sql, $params = NULL) {
  global $connection;
	$statement_handle = $connection->prepare($sql);
	$statement_handle->execute($params);
	return $statement_handle;
}
  
function fetchArray($statement_handle) {
	$statement_handle->setFetchMode(PDO::FETCH_ASSOC);
	$row = $statement_handle->fetch();
  return $row;
}

function buildActionsBody($m) {
  $output = '#### <a name="' . $m['action'] .'"></a>Action: ' . $m['action'] . "\n";
  $output .= $m['description'] . "\n\n";
  $output .= '##### Parameters' . "\n";
  $output .= '```php' . "\n" . $m['parameters'] . "\n" . '```' . "\n\n";
  $output .= '##### Usage' . "\n";
  $output .= buildActionsUsage($m);
  return $output;
}

function buildActionsUsage($m) {
  $output = '```php' . "\n";
  $output .= "Plugin::add_action('" . $m['action'] . "', '[plugin]_" . $m['action'] . "', 10, 1);\n\n";
  $output .= "function [plugin]_" . $m['action'];
  $output .= "([parameters]) {\n";
  $output .= "  // do something\n";
  $output .= "}\n";
  $output .= '```' . "\n\n";
  return $output;
}

function buildActionsPage() {
  $output = buildActionsOutput();
  $links = "***\n\n##### Overview\n\n" . buildOverviewLinks();
  
  write('Plugin-API-Actions.md', $output . $links);
}

function buildOverviewPage() {
  $intro = "The OWASP Hackademic Challenges Plugin API allows developers to build plugins and themes to customise the functionality of the system. To learn more about how to extend Hackademic Challenges you can read about: \n\n";
  $output = $intro . buildOverviewLinks();
  write('Plugin-API-Overview.md', $output);
}

function buildOverviewLinks() {
  $link1 = "* [Install a plugin or theme](./Plugin-API-Install)\n";
  $link2 = "* [Develop a plugin](./Plugin-API-Plugin)\n";
  $link3 = "* [Develop a theme](./Plugin-API-Theme)\n";
  $link4 = "* [Plugin API Actions](./Plugin-API-Actions)\n";
  $link5 = "* [Plugin API Pages and Menus](./Plugin-API-Pages-and-Menus)\n";
  return $link1 . $link2 . $link3 . $link4 . $link5;
}

function buildInstallPage() {
  $intro = "The OWASP Hackademic Challenges Plugin API allows developers to extend the system by installing plugins and themes.\n\n";
  
  $plugin = "#### Install a plugin\n";
  $plugin .= "To install a plugin, do the following:\n\n";
  $plugin .= "* Upload the folder containing the plugin to `/user/plugins/[plugin]`\n";
  $plugin .= "* Navigate to the options page (defaultpath : `/?url=admin/options`)\n";
  $plugin .= "* Locate the plugin in the plugins list and select the checkbox\n";
  $plugin .= "* Click `Submit` to save\n\n";
 
  $theme = "#### Install a theme\n";
  $theme .= "To install a theme, do the following:\n\n";
  $theme .= "* Upload the folder containing the theme to `/user/themes/[theme]`\n";
  $theme .= "* Navigate to the options page (default path: `/?url=admin/options`)\n";
  $theme .= "* Locate the theme in the themes list and select the radio button to choose the active theme\n";
  $theme .= "* Click `Submit` to save\n\n";
  
  $links = "***\n\n##### Overview\n\n" . buildOverviewLinks();
  
  $output = $intro . $plugin . $theme . $links;
  write('Plugin-API-Install.md', $output);
}

function buildMenuPage() {
  $intro = "The OWASP Hackademic Challenges Plugin API allows developers to extend the system by adding pages, menus and menu items. The system makes use of the Smarty templating engine so if you are not familiar with Smarty it is a good idea to read up on how it works. This basic tutorial simply covers the Hackademic Challenges implementation of the Smarty templating engine.\n\n";
  
  $body = "#### Adding a page\n";
  $body .= "To add a page you need to first create a php file that will print the HTML that is to be displayed. In the system classes, this php file simply creates an instance of a HackademicController which then assembles a view through the Smarty templating system. A typical page file can look like this:\n\n";
  $body .= '
  ```php
  // HACKADEMIC_PLUGIN_PATH points to the system plugin folder
  require_once(HACKADEMIC_PLUGIN_PATH . "my-plugin/class.MyPluginController.php");

  $controller = new MyPluginController();
  echo $controller->go();
  ```';
  $body .= "\n\n";
  $body .= "You are not required by the system to create such a file but it follows the rest of the system structure and will guarantee forward compatability if used.\n\n";
  $body .= "It is recommended to extend your controller from the `HackademicController` or `HackademicBackendController`. This controllers make sure that you have access to a Smarty instance that can send your data to a template. A typical stub of a controller class can look like this:\n\n";
  $body .= '
  ```php
  require_once(HACKADEMIC_PATH . "controller/class.HackademicController.php");
  class MyPluginController extends HackademicController {

    // Used to generate API actions
    private static $action_type = "my_custom";

    // Called from the custom php file that represents the page
    // It is recommended to follow this naming pattern to keep forward compability in the future
    public function go() {
      $my_custom_var_1 = "some data";
      $my_custom_var_2 = "some more data";
      $this->addToView("my_custom_var_1", $my_custom_var_1);
      $this->addToView("my_custom_var_2", $my_custom_var_2);
      $this->setViewTemplate("my_custom_template.tpl");
      $this->generateView(self::$action_type);
    }
  }
  ```';
  $body .= "\n\n";
  $body .= "The file my_custom_template.tpl which is used as the Smarty template for the controller will contain the HTML code and Smarty template tags.\n\n";
  $body .= 'For the system to recognise your new page it needs to be inserted into the database. You can do this with the `Plugin::add_page($url, $file);` call. The URL should be the user visible path to your page. Note that this needs to be unique. It is also recommended that you give it a path that suits the current menu structure of the system.\n\n';
  $body .= "Some example page mappings from the Hackademic core are: \n";
  $body .= "
  ```
  +------------------------+----------------------------------+
  | url                    | file                             |
  +------------------------+----------------------------------+
  | admin                  | admin/index.php                  |
  | admin/addarticle       | admin/pages/addarticle.php       |
  | admin/addchallenge     | admin/pages/addchallenge.php     |
  | forgotpassword         | pages/forgotpassword.php         |
  | home                   | pages/home.php                   |
  | login                  | pages/login.php                  |
  | logout                 | pages/logout.php                 |
  +------------------------+----------------------------------+
  ```";
  $body .= "\n\n";
  $body .= "Note that all paths are relative.";

 
  $body .= "#### Adding a menu and menu items\n";
  $body .= "To add a new menu in the Hackademic database you can use the Plugin API. You can also add menu items to external or internal pages. If you are linking to an internal page, don't forget to add it to the pages table if it's not already there.\n\n";
  $body .= "#### API methods\n";
  $body .= "The API has the following methods that allows you to work with pages and menus:\n\n";
  $body .= '```php
  /**
   * Adds a menu with the given name.
   *
   * @param the name of the menu such as "My menu"
   * @return true if added
   */
  public static function add_menu($name)
  
  /**
   * Retrives the menu for the given menu id
   * 
   * @param the id of the menu to load
   * @return an array with the menu items
   */
  public static function get_menu($mid)
  
  /**
   * Updates the menu with the given menu id to the given name.
   *
   * @param menu id of the menu to update
   * @param the new name of the menu such as "My new menu"
   * @return true if updated
   */
  public static function update_menu($mid, $name)
  
  /**
   * Deletes the menu with the given menu id.
   *
   * @param menu id of the menu to delete
   * @return true if deleted
   */  
  public static function delete_menu($mid)

  /**
   * Adds a page mapping from the given url to the file.
   *
   * @param the url to map
   * @param the path to the file that generates the page view. The path should be relative
   * to the HACKADEMIC_PATH variable which is the web root as default.
   * @return true if added
   */
  public static function add_page($url, $file)

  /**
   * Retrives the file for the given url
   * 
   * @param the $url to load the file for
   * @return the path to the file
   */
  public static function get_file_for_page($url)

  /**
   * Updates a page mapping from the given url to the new file.
   *
   * @param the url to update the mapping for
   * @param the new path to the file that generates the page view. The path should be relative
   * to the HACKADEMIC_PATH variable which is the web root as default.
   * @return true if updated
   */
  public static function update_page($url, $file)

  /**
   * Deletes a page mapping for the given url.
   *
   * @param the url to delete the page mapping for.
   * @return true if deleted
   */
  public static function delete_page($url)
  
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
  public static function add_menu_item($url, $mid, $label, $parent, $sort)
  
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
  public static function update_menu_item($url, $mid, $label, $parent, $sort)
  
  /**
   * Deletes a menu item to the menu with the given menu id.
   *
   * @param the url for the menu item
   * @param the menu id that the menu item belongs to
   * @return true if deleted
   */
  public static function delete_menu_item($url, $mid)
  ```';
  $body .= "\n\n";
  $body .= 'You call the methods using the static call for the Plugin class for example: `Plugin::add_menu($name);`\n\n'; 

  $body .= "Note that you can't create a menu item unless you have a menu. If you are not linking to an external URL you also need to add a page for that menu item before you can create it.\n\n";

  
  $links = "***\n\n##### Overview\n\n" . buildOverviewLinks();
  
  $output = $intro . $body . $links;
  write('Plugin-API-Pages-and-Menus.md', $output);
}

function buildPluginPage() {
  $intro = "This tutorial will show you how to build a plugin for the OWASP Hackademic Challenges. We will use the example plugin as a base and explain what it does, how and why so if you want to, you can download it and follow along in the real code.\n\n";
  $body = "#### Set up\n\n";
  $body .= "The OWASP Hackademic Challenges follows the same guidelines as the [Drupal Coding Standards](https://drupal.org/coding-standards) for formatting and writing code. We recommend that your plugin also adheres to this standard to make it easier for other developers in the project to work with your code. If you don't want to read the full document here is the quick version: \n\n";
  $body .= "* Use spaces instead of tabs\n\n";
  $body .= "* Use 2 spaces, not 4\n\n";
  $body .= "* Use capital letters for constants such as `TRUE` and `NULL`\n\n";
  $body .= "* Always use curly braces `{}` around if/else/for etc. statements to increase readability\n\n";
  $body .= "#### Being recognised\n\n";
  $body .= "Before the nitty gritty coding begins you need to choose a name for your plugin. It should be as short and descriptive as possible. Once a name has been chosen, create a folder with the same name as your plugin. The folder name should be in lower case and use dashes instead of spaces. The name of the example plugin is `article-challenge-connect`.\n\n";
  $body .= "When the folder has been created we can create our first file for the plugin, it should have the exact same name as the folder but with the `.php` extension. The filename for the example plugin is `article-challenge-connect.php`. This file is a bit special in that it should contain some information about your plugin. To define this information we use a block style comment together with some keywords. The metadata for the example plugin looks like this: \n\n";
  $body .= "```\n";
  $body .= "
    /**
     *
     * Plugin Name: Article Challenge Connect
     * Plugin URI: http://example.com/article-challenge-connect
     * Description: This plugin connects articles to challenges. It is solely meant as a demonstration on how a plugin could be created using the Hackademic Challenges API and should not be used in a production environment since it lacks proper testing, security and quality assurances. You are encouraged to use it as a base for developing your own custom plugins.
     * Version: 1.1
     * Author: Daniel Kvist
     * Author URI: http://danielkvist.net
     * License: GPL2
     *
     */\n";
  $body .= "```\n\n";
  $body .= "The metadata you enter here will be displayed in the OWASP Hackademic Challenges options page so make it descriptive so your user understands what it does. Once you have entered this information, place your folder in the `user/plugins/` folder and navigate to the options page to make sure your plugin is shown. You can enable it now if you wish but since it doesn't do anything yet that seems unneccessary ;)\n\n";
  $body .= "#### Adding listeners\n\n";
  $body .= "Now that we are recognised by the system as a plugin we can start to add listeners to the actions that the system perform. Since we want to connect articles with challenges when a new article is created we need to do a couple of things. We need to:\n\n";
  $body .= "* Add a custom field with challenges to the 'add article' and 'edit article' form(s)\n\n";
  $body .= "* Add a listener to the action that tells us that an article has been saved, updated or deleted in the database\n\n";
  $body .= "* Add a custom column to the article manager so an administrator can see which article is connectect to which challenge\n\n";
  $body .= "To add custom fields and columns, we need to change the template (view) for the page(s). This can be done with the `set_admin_view_template` action. Since we also need to add data to that we can use in the template file we will listen to the `show_add_article`, `show_edit_article` and `show_article_manager` actions. Listening to database interactions is also neccessary and the actions we are interested in are `after_create_article`, `after_update_article` and `before_delete_article`.\n\n";
  $body .= "These actions are all well and good and gives us the hooks into the system we need to modify the system. We also need to save the data somehow though! To save the data we can use the database abstraction layer that is provided in the file `/model/common/class.HackademicDB.php`. Using the global variable `" . '$db' . "` we can `create, read, update and delete` information in the database while at the same time triggering an action for other developers to use. Using the `query` function will allow us to send sql queries to the database without triggering actions.\n\n";
  $body .= "Adding the listeners is easy with the static methods available. The standard format is like this:\n\n";
  $body .= "```Plugin::add_action('[action]', '[plugin_action]', [priority], [number of arguments]);```\n\n";
  $body .= "```";
  $body .= "
    // Add 'show' actions
    Plugin::add_action('show_add_article', 'custom_uni_show_add_article', 10, 1);
    Plugin::add_action('show_edit_article', 'custom_uni_show_edit_article', 10, 1);
    Plugin::add_action('show_article_manager', 'custom_uni_show_article_manager', 10, 1);

    // Add 'CRUD' actions
    Plugin::add_action('after_create_article', 'custom_uni_after_create_article', 10, 2);
    Plugin::add_action('after_update_article', 'custom_uni_after_update_article', 10, 1);
    Plugin::add_action('before_delete_article', 'custom_uni_before_delete_article', 10, 2);

    // Add action for enabling plugin
    Plugin::add_action('enable_plugin', 'custom_uni_enable_plugin', 10, 1);

    // Add filter to set custom form template
    Plugin::add_filter('set_admin_view_template', 'custom_uni_set_admin_view_template', 10, 1);\n";
  $body .= "```\n\n";
  $body .= "Great, we are now listening to the system actions and we have mapped each listener no a uniquely named function. Now, lets write the functions!\n\n";
  $body .= "#### Adding functions\n\n";
  $body .= "Functions need to have unique name across the scope of the system. To make sure this is the case each function should be named with the plugin name to start with and then the specific action that the function is handling. The functions of the example plugin are pretty self explanatory and well documented in the source so I suggest you check that out. Here I will only give a brief explanation on what each function does.\n\n";
  $body .= "* `custom_uni_show_add_article` finds challenges that the current user is allowed to see and sends them to the add article page\n\n";
  $body .= "* `custom_uni_show_edit_article` finds challenges that the current user is allowed to see and sends them to the edit article page together with the currently chosen challenge\n\n";
  $body .= "* `custom_uni_show_article_manager` adds challenges to the template that shows the article overview\n\n";
  $body .= "* `custom_uni_after_create_article` adds a challenge reference to the article if a challenge is selected when an article is created\n\n";
  $body .= "* `custom_uni_after_update_article` updates the challenge reference with the article if a challenge is selected when an article is updated\n\n";
  $body .= "* `custom_uni_before_delete_article` deletes the challenge reference with the article if an article is delete\n\n";
  $body .= "* `custom_uni_enable_plugin` executed when the plugin is enabled and creates a database table to store article and challenge connections\n\n";
  $body .= "* `custom_uni_set_admin_view_template` changes the templates for the view we need to modify so that we can add things such as extra form fields etc.\n\n";
  $body .= "#### Wrapping up\n\n";
  $body .= "As you can see the main file of the plugin uses a model class that also belongs to the plugin to do the heavy database interaction code. It is recommended to keep your code well structured and object oriented to make it easier to maintain and understand. We hope that you now have a basic understanding on how the Plugin API can be used to add functionality to the system. Note that the example plugin developed in this tutorial by no means fulfill all the wished for functionality when it comes to connecting articles and challenges. It simply serves as an example to help you get started so use it as a base for your own awesome plugins.\n\n";
  
  $links = "***\n\n##### Overview\n\n" . buildOverviewLinks();
  
  $output = $intro . $body . $links;
  write('Plugin-API-Plugin.md', $output);
}

function buildThemePage() {
  $intro = "OWASP Hackademic Challenges uses the Smarty Template Engine to present content. To build a theme for the OWASP Hackademic Challenges you need to create a set of template files that correspond to the system templates but with different content of course.\n\n";
  $body = "#### Being recognised\n\n";
  $body .= "For the system to be able to detect your theme it must be placed in the `/user/themes` folder. Your theme should be contained in its own folder with a unique name that suits your theme. The system will be looking for a specific file which must contain some mandatory metadata about your theme. This file should be placed in your theme folder and it should be named the same as the folder but with a `.php` extension. So if your theme name is 'my dark theme' your file should be named 'my_dark_theme.php'.\n\n";
  $body .= "Do not worry about the php extension, it doesn't have to contain any php. It will however need to contain the information the system requires to regognise your theme. This information must be formatted like this at the top of the file:\n\n";
  $body .= "
    <?php
    /**
     *
     * Plugin Name: Custom theme
     * Plugin URI: http://example.com/article-challenge-connect
     * Description: A brief description of the theme.
     * Version: 1.0
     * Author: Daniel Kvist
     * Author URI: http://danielkvist.net
     * License: GPL2
     */\n\n";
  $body .= "#### Building a theme\n\n";
  $body .= "To build a theme it is recommended to copy the current system theme folder located in `/view` to make sure that all templates (tpl files) that are required are included in your new theme. You will also need the administration pages template files that are located in `/admin/view`. Note that you need to keep this directory structure within your theme folder so that the system can separate the the files and folders from each other. See the example theme for an example of this.\n\n";
  
  $links = "***\n\n##### Overview\n\n" . buildOverviewLinks();
  
  $output = $intro . $body . $links;
  write('Plugin-API-Theme.md', $output);
}

print 'Connecting' . '<br/>';
connect();
print 'Building actions page' . '<br/>';
buildActionsPage();
print 'Building overview page' . '<br/>';
buildOverviewPage();
print 'Building install page' . '<br/>';
buildInstallPage();
print 'Building plugin page' . '<br/>';
buildPluginPage();
print 'Building menu page' . '<br/>';
buildMenuPage();
print 'Building theme page' . '<br/>';
buildThemePage();
print 'Success!';