The OWASP Hackademic Challenges Plugin API allows developers to extend the system by adding pages, menus and menu items. The system makes use of the Smarty templating engine so if you are not familiar with Smarty it is a good idea to read up on how it works. This basic tutorial simply covers the Hackademic Challenges implementation of the Smarty templating engine.

#### Adding a page
To add a page you need to first create a php file that will print the HTML that is to be displayed. In the system classes, this php file simply creates an instance of a HackademicController which then assembles a view through the Smarty templating system. A typical page file can look like this:


  ```php
  // HACKADEMIC_PLUGIN_PATH points to the system plugin folder
  require_once(HACKADEMIC_PLUGIN_PATH . "my-plugin/class.MyPluginController.php");

  $controller = new MyPluginController();
  echo $controller->go();
  ```

You are not required by the system to create such a file but it follows the rest of the system structure and will guarantee forward compatability if used.

It is recommended to extend your controller from the `HackademicController` or `HackademicBackendController`. This controllers make sure that you have access to a Smarty instance that can send your data to a template. A typical stub of a controller class can look like this:


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
  ```

The file my_custom_template.tpl which is used as the Smarty template for the controller will contain the HTML code and Smarty template tags.

For the system to recognise your new page it needs to be inserted into the database. You can do this with the `Plugin::add_page($url, $file);` call. The URL should be the user visible path to your page. Note that this needs to be unique. It is also recommended that you give it a path that suits the current menu structure of the system.\n\nSome example page mappings from the Hackademic core are: 

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
  ```

Note that all paths are relative.#### Adding a menu and menu items
To add a new menu in the Hackademic database you can use the Plugin API. You can also add menu items to external or internal pages. If you are linking to an internal page, don't forget to add it to the pages table if it's not already there.

#### API methods
The API has the following methods that allows you to work with pages and menus:

```php
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
  ```

You call the methods using the static call for the Plugin class for example: `Plugin::add_menu($name);`\n\nNote that you can't create a menu item unless you have a menu. If you are not linking to an external URL you also need to add a page for that menu item before you can create it.

***

##### Overview

* [Install a plugin or theme](./Plugin-API-Install)
* [Develop a plugin](./Plugin-API-Plugin)
* [Develop a theme](./Plugin-API-Theme)
* [Plugin API Actions](./Plugin-API-Actions)
* [Plugin API Pages and Menus](./Plugin-API-Pages-and-Menus)
