<?	$path = 'barfoo.php';


		$values = array(
				'dbname' => "koko",
				'dbuser' => "lala",
				'dbpass' => "1",
				'dbhost' => "local",
				'site_root_path' => "./",
				'source_root_path' =>"./",
				'app_title'=>"test"
			       );
		//if (!is_writable('bar.php'))
		//die("Config file is not writable please change the files permissions");
		
		$sample=file_get_contents('bar.php');
		if( FALSE == $sample || E_WARNING == $sample )
			die("sample file not readable or not existent read function returned: $sample" );
		$sample=str_replace("#YOUR_APP_TITLE_HERE#",$values['app_title'],$sample);
		$sample=str_replace("#YOUR_SITE_ROOT_PATH#",$values['site_root_path'],$sample);
		$sample=str_replace("#YOUR_SOURCE_ROOT_PATH#",$values['source_root_path'],$sample);
		$sample=str_replace("#YOUR_DBHOST#",$values['dbhost'],$sample);
		$sample=str_replace("#YOUR_DBUSER#",$values['dbuser'],$sample);
		$sample=str_replace("#YOUR_DBPASS#",$values['dbpass'],$sample);
		$sample=str_replace("#YOUR_DBNAME#",$values['dbname'],$sample);
		if(FALSE === file_put_contents($path, $sample))
			die("Could not put the contents {$sample} to file {$path}");

?>
