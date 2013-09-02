This tutorial will show you how to build a plugin for the OWASP Hackademic Challenges. We will use the example plugin as a base and explain what it does, how and why so if you want to, you can download it and follow along in the real code.

#### Set up

The OWASP Hackademic Challenges follows the same guidelines as the [Drupal Coding Standards](https://drupal.org/coding-standards) for formatting and writing code. We recommend that your plugin also adheres to this standard to make it easier for other developers in the project to work with your code. If you don't want to read the full document here is the quick version: 

* Use spaces instead of tabs

* Use 2 spaces, not 4

* Use capital letters for constants such as `TRUE` and `NULL`

* Always use curly braces `{}` around if/else/for etc. statements to increase readability

#### Being recognised

Before the nitty gritty coding begins you need to choose a name for your plugin. It should be as short and descriptive as possible. Once a name has been chosen, create a folder with the same name as your plugin. The folder name should be in lower case and use dashes instead of spaces. The name of the example plugin is `article-challenge-connect`.

When the folder has been created we can create our first file for the plugin, it should have the exact same name as the folder but with the `.php` extension. The filename for the example plugin is `article-challenge-connect.php`. This file is a bit special in that it should contain some information about your plugin. To define this information we use a block style comment together with some keywords. The metadata for the example plugin looks like this: 

```

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
     */
```

The metadata you enter here will be displayed in the OWASP Hackademic Challenges options page so make it descriptive so your user understands what it does. Once you have entered this information, place your folder in the `user/plugins/` folder and navigate to the options page to make sure your plugin is shown. You can enable it now if you wish but since it doesn't do anything yet that seems unneccessary ;)

#### Adding listeners

Now that we are recognised by the system as a plugin we can start to add listeners to the actions that the system perform. Since we want to connect articles with challenges when a new article is created we need to do a couple of things. We need to:

* Add a custom field with challenges to the 'add article' and 'edit article' form(s)

* Add a listener to the action that tells us that an article has been saved, updated or deleted in the database

* Add a custom column to the article manager so an administrator can see which article is connectect to which challenge

To add custom fields and columns, we need to change the template (view) for the page(s). This can be done with the `set_admin_view_template` action. Since we also need to add data to that we can use in the template file we will listen to the `show_add_article`, `show_edit_article` and `show_article_manager` actions. Listening to database interactions is also neccessary and the actions we are interested in are `after_create_article`, `after_update_article` and `before_delete_article`.

These actions are all well and good and gives us the hooks into the system we need to modify the system. We also need to save the data somehow though! To save the data we can use the database abstraction layer that is provided in the file `/model/common/class.HackademicDB.php`. Using the global variable `$db` we can `create, read, update and delete` information in the database while at the same time triggering an action for other developers to use. Using the `query` function will allow us to send sql queries to the database without triggering actions.

Adding the listeners is easy with the static methods available. The standard format is like this:

```Plugin::add_action('[action]', '[plugin_action]', [priority], [number of arguments]);```

```
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
    Plugin::add_filter('set_admin_view_template', 'custom_uni_set_admin_view_template', 10, 1);
```

Great, we are now listening to the system actions and we have mapped each listener no a uniquely named function. Now, lets write the functions!

#### Adding functions

Functions need to have unique name across the scope of the system. To make sure this is the case each function should be named with the plugin name to start with and then the specific action that the function is handling. The functions of the example plugin are pretty self explanatory and well documented in the source so I suggest you check that out. Here I will only give a brief explanation on what each function does.

* `custom_uni_show_add_article` finds challenges that the current user is allowed to see and sends them to the add article page

* `custom_uni_show_edit_article` finds challenges that the current user is allowed to see and sends them to the edit article page together with the currently chosen challenge

* `custom_uni_show_article_manager` adds challenges to the template that shows the article overview

* `custom_uni_after_create_article` adds a challenge reference to the article if a challenge is selected when an article is created

* `custom_uni_after_update_article` updates the challenge reference with the article if a challenge is selected when an article is updated

* `custom_uni_before_delete_article` deletes the challenge reference with the article if an article is delete

* `custom_uni_enable_plugin` executed when the plugin is enabled and creates a database table to store article and challenge connections

* `custom_uni_set_admin_view_template` changes the templates for the view we need to modify so that we can add things such as extra form fields etc.

#### Wrapping up

As you can see the main file of the plugin uses a model class that also belongs to the plugin to do the heavy database interaction code. It is recommended to keep your code well structured and object oriented to make it easier to maintain and understand. We hope that you now have a basic understanding on how the Plugin API can be used to add functionality to the system. Note that the example plugin developed in this tutorial by no means fulfill all the wished for functionality when it comes to connecting articles and challenges. It simply serves as an example to help you get started so use it as a base for your own awesome plugins.

***

##### Overview

* [Install a plugin or theme](./Plugin-API-Install)
* [Develop a plugin](./Plugin-API-Plugin)
* [Develop a theme](./Plugin-API-Theme)
* [Plugin API Actions](./Plugin-API-Actions)
* [Plugin API Pages and Menus](./Plugin-API-Pages-and-Menus)
