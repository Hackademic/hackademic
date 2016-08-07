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

/** Load the template class **/
require_once(INSTALLER_PATH . '/Installer_Template.php');


/**
 * Class installer
 *
 */
class Installer
{
	/**
	 * Options property
	 *
	 * @var array
	 */
	protected $_options = array();

	/**
	 * View object
	 *
	 * @var object
	 */
	protected $view;

	/**
	 * Language array
	 *
	 * @var array
	 */
	protected $lang = array();

	protected $default_lang = 'english';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
# Do we have a cookie
		if(isset($_COOKIE['lang']) && $_COOKIE['lang'] != '')
		{
			$this->default_lang = $_COOKIE['lang'];
		}

# Change language
		if(isset($_POST['lang']) && $_POST['lang'] != '' && $this->default_lang != $_POST['lang'])
		{
			$path = INSTALLER_PATH . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . $_POST['lang'] . '.php';
			if(file_exists($path))
			{
				$this->default_lang = $_POST['lang'];
				@setcookie('lang', $this->default_lang, time() + 60 * 60 * 24);
				$_POST['lang'] = 0;
				$this->nextStep('index');
			}
		}

# Load the language file
		require_once( INSTALLER_PATH . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . $this->default_lang . '.php' );
		$this->lang = $lang;

# Load the template class
		$this->view = new Installer_Template($this->lang);

# Did we run it again?
		if(file_exists(ROOT_PATH . DIRECTORY_SEPARATOR . 'config.inc.php'))
		{
			$this->view->error($this->lang['L-01']);
		}

		$allwed_steps = array('admin'=>'adminAction', 'index' => 'indexAction', 'db' => 'dbAction', 'cfg' => 'configAction', 'database' => 'dbTables', 'config' => 'configWrite', 'finish' => 'finishInstaller');
		if(!in_array($_POST['step'], array_keys($allwed_steps)))
		{
			$this->nextStep('index');
		}

# Display the right step
		switch ($allwed_steps[$_POST['step']]) {
			case "indexAction":
				$this->indexAction();
				break;
			case "adminAction":
				$this->adminAction();
				break;
			case "dbAction":
				$_SESSION['admin_email'] = $_POST['email'];
				$_SESSION['admin_username'] = $_POST['username'];
				$_SESSION['admin_password'] = md5($_POST['password']);
				$this->dbAction();
				break;
			case "configAction":
				$this->configAction();
				break;
			case "dbTables":
				$this->dbTables($_POST);
				break;
			case "configWrite":
				$this->configWrite();
				break;
			case "finishInstaller":
				$this->configWrite();
				break;
		}
	}

	/**
	 * Show welcome message
	 *
	 */
	public function indexAction()
	{

		$options = '';
		foreach($this->buildLangSelect() as $lang)
		{
			$options .= "<option value='{$lang}'>".ucfirst($lang)."</option>";
		}

		$this->view->vars = array('options' => $options);
		$this->view->render('index');
	}

	/**
	 * Show database setup stuff
	 *
	 */
	public function dbAction()
	{
		$this->view->render('db');
	}

	public function adminAction()
	{
		$this->view->vars= array('username'=>"admin");
		$this->view->render('admin');
	}

	public function configAction()
	{
		$this->view->vars = array('app_title'=>"Hackademic CMS",
				'site_root_path' => SITE_ROOT_PATH,
				'source_root_path' => SOURCE_ROOT_PATH
				);
		$this->view->render('config');
	}

	/**
	 * Handle DB table quries
	 *
	 * @param array $options
	 */
	public function dbTables(array $options)
	{
		$_SESSION['dbname']=$options['dbname'];
		$_SESSION['dbuser']=$options['dbuser'];
		$_SESSION['dbpass']=$options['dbpass'];
		$_SESSION['dbhost']=$options['dbhost'];
# Make sure we have an array of options
		if(!is_array($options))
		{
			$this->view->error($this->lang['L-02']);
		}

# Make sure we have everything we need!
		$required_db_options = array('dbname', 'dbuser', 'dbhost');

		foreach ($required_db_options as $required_db_option)
		{
			if(!isset($options[$required_db_option]) || $options[$required_db_option]=='')
			{
				$this->view->error($this->lang['L-03']);
			}
		}


# Pass in to the options property
		$this->_options = $options;

# First test the connection
		$link = mysql_connect($this->_options['dbhost'], $this->_options['dbuser'], $this->_options['dbpass']);
		if(!$link)
		{
			$this->view->error($this->lang['L-04']);
		}

# Select the DB
		$db_selected = mysql_select_db($this->_options['dbname'], $link);
		if(!$db_selected && !$this->_options['create_database'])
		{
			$this->view->error($this->lang['L-05']);
		}
		elseif (!$db_selected && $this->_options['create_database'])
		{
# Create the DB
			$result = mysql_query("CREATE DATABASE {$this->_options['dbname']}", $link);
			if (!$result)
			{
				$this->view->error(sprintf($this->lang['L-06'], $this->_options['dbname'], htmlspecialchars(mysql_error())));
			}
		}

# Load the database stuff
		$path = INSTALLER_PATH . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'database.php' ;
		if(!file_exists($path))
		{
			$this->view->error(sprintf($this->lang['L-07'], $path));
		}

		$SQL = array();
		$SQL[] = "USE {$this->_options['dbname']};";
		require_once($path);

		$count = 0;
		$errors_count = 0;

# Loop if we have any
		if(count($SQL))
		{
# Start the count

			$errors = array();
			foreach ($SQL as $query)
			{
				$result = mysql_query($query, $link);
				if (!$result)
				{
					$errors[] = sprintf($this->lang['L-08'], htmlspecialchars(mysql_error()));
					$errors_count++;
					continue;
				}

# Increase it
				$count++;
			}
		}

		$error_string = '';

# Did we had any errors?
		if(count($errors))
		{
			$error_string = "<br /><br />".sprintf($this->lang['I-14'], implode("<br /><br />", $errors));
		}

# Redirect
		$this->view->vars = array('message' => sprintf($this->lang['L-09'], $count, $errors_count, $error_string), 'button' => $error_string ? $this->lang['I-16'] : $this->lang['I-03']);
		$this->view->render('dbdone');

	}

	/**
	 * Display everything
	 *
	 */
	public function display()
	{
		$this->view->display();
	}

	/**
	 * Write the configuration File
	 *
	 */
	public function configWrite()
	{
# One level up
		$path = ROOT_PATH . DIRECTORY_SEPARATOR . 'config.inc.php';


		$values = array(
				'dbname' => $_SESSION['dbname'],
				'dbuser' => $_SESSION['dbuser'],
				'dbpass' => $_SESSION['dbpass'],
				'dbhost' => $_SESSION['dbhost'],
				'site_root_path' => $_POST['site_root_path'],
				'source_root_path' =>$_POST['source_root_path'],
				'app_title'=>$_POST['app_title']
			       );
		//if (!is_writable(ROOT_PATH.'/config.inc.php'))
		//	die("Config file is not writable please change the files permissions");
		//if(!is_readable(ROOT_PATH.'/config.inc.php'))
		//	die("Config file is not readable please change the files permissions");

		$sample=file_get_contents(ROOT_PATH.'/sample.config.inc.php');
		if( FALSE == $sample || E_WARNING == $sample )
			die("sample file not readable or not existent read function returned: $sample" );

		$sample=str_replace("#YOUR_APP_TITLE_HERE#",$values['app_title'],$sample,$count);
		if($count == 0)
			die("App Title Not set");
		$sample=str_replace("#YOUR_SITE_ROOT_PATH#",$values['site_root_path'],$sample,$count);
		if($count == 0)
			die("Roote Path not set");
		$sample=str_replace("#YOUR_SOURCE_ROOT_PATH#",$values['source_root_path'],$sample,$count);
		if($count == 0)
			die("Source root path not set");
		$sample=str_replace("#YOUR_DBHOST#",$values['dbhost'],$sample,$count);
		if($count == 0)
			die("DB HOst not set");
		$sample=str_replace("#YOUR_DBUSER#",$values['dbuser'],$sample,$count);
		if($count == 0)
			die("DB user not set");
		$sample=str_replace("#YOUR_DBPASS#",$values['dbpass'],$sample,$count);
		if($count == 0)
			die("db pass not set");
		$sample=str_replace("#YOUR_DBNAME#",$values['dbname'],$sample,$count);
		if($count == 0)
			die("db name not set");
		if(FALSE === file_put_contents($path, $sample))
			echo "Could not put the contents {$sample} to file {$path}";
			echo "please create a file named config.inc.php and put the appropriate contents as dictated by the sample";
			die();

		$this->view->vars = array("login_path" => $_POST['source_root_path']);
		$this->view->render('finish');
		unset($_SESSION);
	}

	/**
	 * Redirect to the next step
	 *
	 * @param string $step
	 */
	public function nextStep($step)
	{
		$url = BASE_URL . '?step='.$step;
		if(!headers_sent())
		{
			header('Location: '. $url);
			exit;
		}

		print "<html><body><meta http-equiv='refresh' content='1;url={$url}'></body></html>";
		exit;
	}

	/**
	 * Redirect screen with a message
	 *
	 * @param string $message
	 */
	public function redirectScreen($message, $step)
	{
		$this->view->redirect($message, $step);
	}

	/**
	 * Build the language select box
	 *
	 */
	public function buildLangSelect()
	{
		$path = INSTALLER_PATH . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'lang';
		$dirs = scandir($path);
		$files = array();
		foreach($dirs as $file)
		{
			if ($file == '.' || $file == '..')
			{
				continue;
			}
			elseif (is_dir($path.'/'.$file))
			{
				continue;
			}
			else
			{
				$files[] = str_replace('.php', '', $file);
			}
		}

		return $files;
	}

	/**
	 * Destructor
	 *
	 */
	public function __destruct()
	{


		@mysql_close($this->db);
# Clear
		unset($this);
	}

}
