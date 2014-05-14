OWASP Hackademic Challenges uses the Smarty Template Engine to present content. To build a theme for the OWASP Hackademic Challenges you need to create a set of template files that correspond to the system templates but with different content of course.

#### Being recognised

For the system to be able to detect your theme it must be placed in the `/user/themes` folder. Your theme should be contained in its own folder with a unique name that suits your theme. The system will be looking for a specific file which must contain some mandatory metadata about your theme. This file should be placed in your theme folder and it should be named the same as the folder but with a `.php` extension. So if your theme name is 'my dark theme' your file should be named 'my_dark_theme.php'.

Do not worry about the php extension, it doesn't have to contain any php. It will however need to contain the information the system requires to regognise your theme. This information must be formatted like this at the top of the file:


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
     */

#### Building a theme

To build a theme it is recommended to copy the current system theme folder located in `/view` to make sure that all templates (tpl files) that are required are included in your new theme. You will also need the administration pages template files that are located in `/admin/view`. Note that you need to keep this directory structure within your theme folder so that the system can separate the the files and folders from each other. See the example theme for an example of this.

***

##### Overview

* [Install a plugin or theme](./Plugin-API-Install)
* [Develop a plugin](./Plugin-API-Plugin)
* [Develop a theme](./Plugin-API-Theme)
* [Plugin API Actions](./Plugin-API-Actions)
* [Plugin API Pages and Menus](./Plugin-API-Pages-and-Menus)
