<?php


require_once("config.inc.php");
require_once("model/common/class.ChallengeAttempts.php");
require_once("model/common/class.HackademicDB.php");


class ChallengeAttemptsTest extends PHPUnit_Framework_TestCase {
	
	private $success_user_id = -10;
	private $success_chal_id = -11;
	private $success_class_id = -12;

	private $fail_user_id = -20;
	private $fail_chal_id = -21;
	private $fail_class_id = -22;

	private $time = '2000-01-01 00:00:00';
	private static $action_type = 'challenge_attempt_testing';

	//add a new failed and a new succesfull challenge attempt with unique ids e.t.c.
	private function insert_data($uid = $this->success_user_id,
								$chid = $this->success_chal_id,
								$clid = $this->success_class_id,$status = 1,
								$time = $this->time){
		global $db;
		$params = array();
		$sql = "INSERT INTO challenge_attempts(user_id,challenge_id, class_id,time,status)";
		$sql .= "VALUES (".$uid.",".$chid.",".$clid.", ".$time.",".$status.")";
		$query = $db->create($sql, $params, self::$action_type);

		$sql = "INSERT INTO challenge_attempt_count(user_id, challenge_id, class_id, tries)
				VALUES (".$uid.",".$chid.",".$clid.", 1)ON DUPLICATE KEY UPDATE tries = tries + 1";
		$db->create($sql, $params, self::$action_type);		
	}
	//delete the unique id challenge attempts
	private function delete_data($uid = $this->success_user_id){
		global $db;

		$sql = "DELETE FROM challenge_attempts WHERE user_id=".$uid;
		$query = $db->delete($sql, $params, self::$action_type);
		$sql = "DELETE FROM challenge_attempt_count WHERE user_id=".$uid;
		$query = $db->delete($sql, $params, self::$action_type);
	}
    public function setUp() {
		
    }
    public function tearDown(){ 
		$this->delete_data();
		$this->delete_data($this->fail_user_id);
	}

    /**
     * Adds a challenge attempt 
     */
    public function test_addChallengeAttempt() {
		global $db;
      for( $i = 0; $i < 2; $i++){
		$insert = ChallengeAttempts::addChallengeAttempt($this->fail_user_id,
														  $this->fail_chal_id,
														  $this->fail_class_id,0);
		assert($insert!== false);
		$sql = "SELECT * FROM challenge_attempts WHERE user_id=".$this->fail_user_id;
		$res = $db->read($sql);
		ssert($db->numRows() === $i+1)
		}
	$this->delete_data($this->fail_user_id);
      }
	/*
	 * 
	 */
	public function test_deleteChallengeAttemptByUser(){
		$this->insert_data();
		assert(ChallengeAttempts::deleteChallengeAttemptByUser($this->success_user_id) === true);
		assert(ChallengeAttempts::deleteChallengeAttemptByUser($this->success_user_id) === false);
		$sql2 = "SELECT * FROM challenge_attempts WHERE user_id=".$this->success_user_id;
		$res = $db->read($sql);
		assert($db->numRows() === 0);
		$sql2 = "SELECT * FROM challenge_attempt_count WHERE user_id=".$this->success_user_id;
		$res = $db->read($sql);
		assert($db->numRows() === 0);
		$this->delete_data();
		//get all the challenge attempts by that user and make sure it's 0
	}
	public function test_deleteChallengeAttemptByChallenge(){
		$this->insert_data();
		
		assert(ChallengeAttempts::deleteChallengeAttemptByChallenge($this->success_chal_id) === true);
		assert(ChallengeAttempts::deleteChallengeAttemptByChallenge($this->success_chal_id) === false);
		$sql2 = "SELECT * FROM challenge_attempts WHERE user_id=".$this->success_chal_id;
		$res = $db->read($sql);
		assert($db->numRows() === 0);
		$sql2 = "SELECT * FROM challenge_attempt_count WHERE user_id=".$this->success_chal_id;
		$res = $db->read($sql);
		assert($db->numRows() === 0);
		$this->delete_data();
	}	
	public function test_isChallengeCleared(){
			$this->insert_data(-1,-2,-3,1);
			$this->insert_data(-4,-5,-6,0);

			$no_cleared = ChallengeAttempts::isChallengeCleared(-4,-5,-6);
			$cleared = ChallengeAttempts::isChallengeCleared(-1,-2,-3);
			assert(false === $no_cleared);
			assert(true === $cleared);
			
			$this->delete_data(-1);
			$this->delete_data(-4);
	}
	public function test_getUserProgress(){
		$this->insert_data($this->success_user_id,$this->success_chal_id,$this->success_class_id,1);
		$this->insert_data($this->fail_user_id,$this->fail_chal_id,$this->fail_class_id,0);
	
		$prog_success = ChallengeAttempts::getUserProgress($this->success_user_id,
															$this->success_chal_id,
															$this->success_class_id);
		$prog_no_success = ChallengeAttempts::getUserProgress($this->fail_user_id,
															$this->fail_chal_id,
															$this->fail_class_id);
		$non_existent_user = ChallengeAttempts::getUserProgress(-1,-2,-3);
	
		assert($non_existent_user === false);
		assert(isarray($prog_success));
		assert(isarray($prog_no_success));													
		
		assert(instanceof($prog_success[0],'ChallengeAttempts'));
		assert(instanceof($prog_no_success[0],'ChallengeAttempts'));													

		assert(inarray($this->success_user_id,$prog_success));
		assert(inarray($this->fail_user_id,$prog_no_success));
		assert(!inarray($this->success_user_id,$prog_no_success));
		assert(!inarray($this->fail_user_id,$prog_success));
		
		assert($prog_success[0]->user_id === $this->succes_user_id &&
			   $prog_success[0]->challenge_id === $this->succes_challenge_id &&
			   $prog_success[0]->class_id === $this-> &&
			   $prog_success[0]->time === $this->time &&
			   $prog_success[0]->tries === $prog_success[0]->status === 1 && 
			   )
		
		$this->delete_data($this->success_user_id);
		$this->delete_data($this->fail_user_id);
		//assert no_success is false and success has the correct fields and only one element
	}
	
	/*
	 * 
	 */
	public function test_getUserFirstChallengeAttempt(){
		$this->insert_data();
		$this->insert_data($this->success_user_id,$this->success_chal_id,$this->success_class_id,'2013-02-02 01:01:01');
				
		$ca = ChallengeAttempts::getUserFirstChallengeAttempt($this->success_user_id,$this->success_chal_id,$this->success_class_id);
		assert(false !== $ca);
		assert(instanceof($ca,'ChallengeAttempts');
		assert($ca->user_id === $this->success_user_id &&
				$ca->challenge_id === && $this->succes_challenge_id
				$ca->class_id === && $this->succes_class_id
				$ca->time === $this->time);

		$non_existent_user = ChallengeAttempts::getUserFirstChallengeAttempt(-1,$this->success_chal_id,$this->success_class_id);
		assert(false === $non_existent_user);
		
		$non_existent_challenge = ChallengeAttempts::getUserFirstChallengeAttempt($this->success_user_id,-1,$this->success_class_id);
		assert(false === $non_existent_challenge);
		
		$non_existent_class = ChallengeAttempts::getUserFirstChallengeAttempt($this->success_user_id,$this->success_chal_id,-1);
		assert(false === $non_existent_class);
		
		$this->delete_data($this->success_user_id);
	}
	public function test_getUserLastChallengeAttempt(){
		
		$this->insert_data();
		$this->insert_data($this->success_user_id,$this->success_chal_id,$this->success_class_id,'2013-02-02 01:01:01');
				
		$ca = ChallengeAttempts::getUserLastChallengeAttempt($this->success_user_id,$this->success_chal_id,$this->success_class_id);
		assert(false !== $ca);
		assert(instanceof($ca,'ChallengeAttempts');
		assert($ca->user_id === $this->success_user_id &&
				$ca->challenge_id === && $this->succes_challenge_id
				$ca->class_id === && $this->succes_class_id
				$ca->time === '2013-02-02 01:01:01');

		$non_existent_user = ChallengeAttempts::getUserLastChallengeAttempt(-1,$this->success_chal_id,$this->success_class_id);
		assert(false === $non_existent_user);
		
		$non_existent_challenge = ChallengeAttempts::getUserLastChallengeAttempt($this->success_user_id,-1,$this->success_class_id);
		assert(false === $non_existent_challenge);
		
		$non_existent_class = ChallengeAttempts::getUserLastChallengeAttempt($this->success_user_id,$this->success_chal_id,-1);
		assert(false === $non_existent_class);
		
		
		$this->delete_data($this->success_user_id);
	}

	public function test_getUserTriesForChallenge(){
		$this->insert_data();
		$this->insert_data();
		$ca = ChallengeAttempts::getUserTriesForChallenge($this->success_user_id,$this->success_chal_id,$this->success_class_id);
		assert($ca === 2);
		
		$non_existent_user = ChallengeAttempts::getUserTriesForChallenge(-1,$this->success_chal_id,$this->success_class_id);
		assert(false === $non_existent_user);
		
		$non_existent_challenge = ChallengeAttempts::getUserTriesForChallenge($this->success_user_id,-1,$this->success_class_id);
		assert(false === $non_existent_challenge);
		
		$non_existent_class = ChallengeAttempts::getUserTriesForChallenge($this->success_user_id,$this->success_chal_id,-1);
		assert(false === $non_existent_class);
	}
	
	private function add_users($name,$fname,$email,$pwd,$joined,$activated,$type,$token){
		global $db;
		$params = array(':username' => $username,':full_name' => $full_name,':email' => $email,':password' => $password,':joined' => $joined,':token' => $token);
		$sql = "INSERT INTO users (username, full_name, email, password, joined, is_activated, type, token)";
		$sql .= " VALUES (, :full_name, :email, :password, :joined, :is_activated, :type, :token)";
		$query = $db->create($sql, $params, self::$action_type);
	}
	private function delete_users($id){
	$sql = "DELETE FROM users WHERE id=".$id;
	$db->delete($sql,NULL,self::$action_type);
	}
	private function add_class_challenge($challenge_id,$class_id){
		global $db;
		$date = date("Y-m-d H:i:s");
		$params = array(':challenge_id' => $challenge_id,':class_id' => $class_id,':date_created' => $date);
		$sql = "INSERT INTO class_challenges(challenge_id,class_id,date_created)";
		$sql .= " VALUES ( :challenge_id, :class_id, :date_created)";
		$query = $db->create($sql, $params, self::$action_type);
	}
	private function delete_class_challenge($challenge_id,$class_id){
			$params = array(':challenge_id' => $challenge_id,':class_id' => $class_id);
			$sql = 'DELETE FROM class_challenges WHERE challenge_id = :challenge_id AND class_id = :class_id';
			$query = $db->delete($sql, $params, self::$action_type);
	}
	public function test_getUniversalRankings(){
		$this->add_users("testnameA",'asdf','asdf','asdf',$this->time,'1','0','adsf');
		$this->add_users("testnameB",'asdf','asdf','asdf',$this->time,'1','0','adsf');
		$this->add_class_challenge($this->success_chal_id,$this->succes_class_id);

		$sql = "SELECT * FROM users WHERE username=testnameA LIMIT 1";
		$us = $db->read($sql,NULL,self::$action_type);
		$us = $db->fetchArray($us);
		$id1 = $us['id']
		$sql = "SELECT * FROM users WHERE username=testnameB LIMIT 1";
		$us = $db->read($sql,NULL,self::$action_type);
		$us = $db->fetchArray($us);
		$id2 = $us['id']
		$this->insert_data($id1);
		$this->insert_data($id2);
		
		
		$ca = ChallengeAttempts::getUniversalRankings();
		assert(false!==$ca);
		assert(isarray($ca);
		assert($ca[0] === 1);
		assert(sizeof($ca===2);
		//assert ca  AND ca2 are different
			
		$this->delete_users($id1);
		$this->delete_users($id2);
		$this->delete_data($id1);
		$this->delete_data($id2);
		delete_class_challenge($this->success_chal_id,$this->succes_class_id)
	}

	public function test_getCountOfFirstTrySolves(){
		$this->insert_data();
		$this->insert_data();
		$this->insert_data($this->success_user_id,-1);
		$this->insert_data($this->success_user_id,-2);

		$ca = ChallengeAttempts::getCountOfFirstTrySolves($this->success_user_id,$this->success_class_id);
		assert(instanceof($ca,'ChallengeAttempts');
		assert($ca->tries === 3);
	}	
	public function test_getClasswiseRankings(){
		$this->add_users("testnameA",'asdf','asdf','asdf',$this->time,'1','0','adsf');
		$this->add_users("testnameB",'asdf','asdf','asdf',$this->time,'1','0','adsf');
		$this->add_class_challenge($this->success_chal_id,$this->succes_class_id);

		$sql = "SELECT * FROM users WHERE username=testnameA LIMIT 1";
		$us = $db->read($sql,NULL,self::$action_type);
		$us = $db->fetchArray($us);
		$id1 = $us['id']
		$sql = "SELECT * FROM users WHERE username=testnameB LIMIT 1";
		$us = $db->read($sql,NULL,self::$action_type);
		$us = $db->fetchArray($us);
		$id2 = $us['id']
		$this->insert_data($id1);
		$this->insert_data($id2);
		
		$sql = "INSERT INTO class_memberships(user_id,class_id,date_created)";
		$sql .= " VALUES (".$id1." ,".$this->succes_class_id.",".$this->time.")";
		$query = $db->read($sql, $params, self::$action_type);
		
		$sql = "INSERT INTO class_memberships(user_id,class_id,date_created)";
		$sql .= " VALUES (".$id2." ,".$this->succes_class_id.",".$this->time.")";
		$query = $db->read($sql, $params, self::$action_type);
		
		$ca = ChallengeAttempts::getClasswiseRankings($this->succes_class_id);
		
		assert(isarray($ca);
		/*Todo: make sure that ca has the correct structure*/
	}

	/*
 * TODO: NOTE: we can use the phpunit's data provider directive to get data instead of doing sql queries
 * 				also, try to put different vallues for user_id,chal_id,classid so I know if some function has the arguments in an incorrect order
 */
}
