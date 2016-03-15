<?php 
/* Helper script to mass add challenges, it assumes all the challenges are extracted in the challenges folder and their package names are ch0$challenge_id
 * */

require_once('model/common/class.Loader.php');
require_once('config.inc.php');
require_once('model/common/class.HackademicDB.php');

$db = new HackademicDb();
Loader::init();

require_once(HACKADEMIC_PATH."admin/model/class.ChallengeBackend.php");
require_once(HACKADEMIC_PATH."/model/common/class.Challenge.php");


for($i = 11;$i<=40;$i++){
	if($i == 19)continue;
	$ch = Challenge::getChallengeByPkgName("ch0$i");
	if($ch)
		ChallengeBackend::deleteChallenge($ch->id);

	$target = HACKADEMIC_PATH."challenges/ch0$i";
	$xml = simplexml_load_file("$target/ch0$i.xml");
	if($xml == false) {
		error_log("xml is false");
		$errors = libxml_get_errors();
		foreach($errors as $err){
			var_dump($err);
			error_log($err);
		}
		die();
	}
//	echo "<p>xml =";var_dump($xml);echo "</p>";
	$a = array(
		'title' => $xml->title,
		'author' => $xml->author,
		'description' => $xml->description,
		'category' => $xml->category,
		'level' => $xml->level,
		'duration' =>$xml->duration
	);
	$pkg_name = "ch0$i";
	$challenge = new Challenge();
	$challenge->title = $a['title'];
	$challenge->pkg_name = $pkg_name;
	$challenge->description = $a['description'];
	$challenge->author = $a['author'];
	$challenge->category = $a['category'];
	$challenge->date_posted = date("Y-m-d H-i-s");
	$challenge->level = $a['level'];
	$challenge->duration = $a['duration'];
	echo "Challenge $pkg_name added <p>";var_dump(ChallengeBackend::addChallenge($challenge));echo"</p>";
	$ch = Challenge::getChallengeByPkgName($pkg_name);
	if($ch == false){
		error_log("couldn't find challenge $pkg_name after adding"); die();
	}
	$challenge->id = $ch->id; 
	$challenge->visibility= 'public';
	$challenge->availability='public';
	$challenge->publish = 1;
	echo "Challenge $pkg_name updated<p>";var_dump(ChallengeBackend::updateChallenge($challenge));echo"</p>";
}
?>
