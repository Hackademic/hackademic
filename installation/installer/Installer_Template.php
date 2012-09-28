<?php

/**
 * 
 * Please read the LICENSE file
 * @author Vadim V. Gabriel <vadimg88@gmail.com> http://www.vadimg.co.il/
 * @package Class Installer
 * @version 1.0.0a
 * @license GNU Lesser General Public License
 * 
 */

/** load installer class **/
require_once(INSTALLER_PATH . '/Installer.php');


/**
 * Installer Template class
 *
 */
class Installer_Template
{

	/**
	 * Html property
	 *
	 * @var string
	 */
	protected $html;

	/**
	 * Varibles Array
	 *
	 * @var array
	 */
	public $vars = array();

	/**
	 * Constructor
	 *
	 */
	public function __construct($lang)
	{
		$this->lang = $lang;
	}

	/**
	 * Render a template
	 *
	 * @param string $template_name
	 */
	public function render($template_name)
	{
		$path = TMPL_PATH . DIRECTORY_SEPARATOR . $template_name . '.phtml';
		if(!file_exists($path))
		{
			$this->error(sprintf($this->lang['L-11'], $template_name, TMPL_PATH));
		}

# Require the template
		$contents = file_get_contents($path);

# Pass it on
		$this->html .= $contents;

		return $contents;

	}

	/**
	 * Print the error screen with the error page
	 *
	 * @param string $error_string
	 */
	public function error($error_string)
	{
		if ($_POST['step'] == "dbdone") {
			$template_name = "error_db";
		} else {
			$template_name = 'error';          
		}
		$path = TMPL_PATH . DIRECTORY_SEPARATOR . $template_name . '.phtml';
		if(!file_exists($path))
		{
			die(sprintf($this->lang['L-11'], $template_name, TMPL_PATH));
		}

# Require the template
		$contents = file_get_contents($path);
		$contents = str_replace("{#ERROR#}", $error_string, $contents);

# Pass it on
		$this->html .= $contents;

		$this->display();
		exit;
	}

	/**
	 * Print out the entire page
	 *
	 */
	public function display()
	{
		$template_name = 'layout';
		$path = TMPL_PATH . DIRECTORY_SEPARATOR . $template_name . '.phtml';
		if(!file_exists($path))
		{
			$this->error(sprintf($this->lang['L-11'], $template_name, TMPL_PATH));
		}

# Require the template
		$contents = file_get_contents($path);

# Replace the data
		$contents = $this->replaceVars($contents);

# Print it
		print $contents;
		exit;

	}

	/**
	 * Replace vars with there values
	 *
	 */
	protected function replaceVars($contents)
	{
		if(!is_array($this->vars) && !count($this->vars))
		{
			return;
		}

		$this->vars['url'] = BASE_URL;

# Vars
		foreach ($this->vars as $key => $value)
		{
			$contents = preg_replace("/{#{$key}#}/i", $value, $contents);
			$this->html = preg_replace("/{#{$key}#}/i", $value, $this->html);
		}

# Langs
		if(is_array($this->lang) && count($this->lang))
		{
# Langs
			foreach($this->lang as $key => $value)
			{
				$contents = preg_replace("/{#{$key}#}/i", $value, $contents);
				$this->html = preg_replace("/{#{$key}#}/i", $value, $this->html);
			}
		}

# Links
		$links = array('index' => 1, 'admin' => 2, 'db' => 3, 'dbdone' => 3, 'cfg' => 4, 'finish' => 5);
		foreach ($links as $step => $link_number)
		{
			if($_POST['step'] == $step)
			{
				$contents = preg_replace("/{#LINK{$link_number}#}/i", "class='current'", $contents);
			}
		}
		$contents = preg_replace("/{#LINK\d+#}/i", '', $contents);

# Html
		$contents = str_replace("{#DATA#}", $this->html, $contents);

		$rtl_css = '';
# We will load a CSS just for RTL languages
		if($this->lang['direction'] == 'rtl')
		{
			$rtl_css = '<link rel="stylesheet" type="text/css" href="installer/data/templates/rtl.css" />';
			$contents = str_replace("<!--RTL-->", $rtl_css, $contents);
		}

# Empty
		$this->vars = array();

		return $contents;
	}
}
